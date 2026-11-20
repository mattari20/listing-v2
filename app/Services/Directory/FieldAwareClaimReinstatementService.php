<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Governance\GovernancePolicy;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class FieldAwareClaimReinstatementService
{
    private readonly FieldDefinitionRegistryReader $registry;

    private readonly TypedFieldValueValidator $validator;

    private readonly PersistedGovernanceWorkflowService $workflow;

    private readonly EditorialReviewService $editorial;

    public function __construct(
        FieldDefinitionRegistryReader $registry,
        TypedFieldValueValidator $validator,
        PersistedGovernanceWorkflowService $workflow,
        EditorialReviewService $editorial
    ) {
        $this->registry = $registry;
        $this->validator = $validator;
        $this->workflow = $workflow;
        $this->editorial = $editorial;
    }

    /**
     * Reinstate a withdrawn registry value as a new, unapproved successor version.
     *
     * @param  list<string>  $evidenceReferenceIds
     * @param  array<string, mixed>  $sourceContext
     * @param  array<string, mixed>  $validationContext
     * @return array{claim_id: string, claim_version_id: string, editorial_review_case_id: string}
     */
    public function reinstate(
        array $actor,
        string $withdrawnVersionId,
        mixed $value,
        array $evidenceReferenceIds,
        array $sourceContext,
        string $idempotencyKey,
        string $validFrom,
        ?string $validTo,
        string $reasonCode,
        string $rationale,
        array $validationContext = []
    ): array {
        $this->requireHumanCapability($actor, 'correct_claim');
        $this->requireHumanCapability($actor, 'submit_directory_proposal');

        if ($idempotencyKey === '' || strlen($idempotencyKey) > 140 ||
            $evidenceReferenceIds === [] || count($evidenceReferenceIds) > 20 ||
            count(array_unique($evidenceReferenceIds)) !== count($evidenceReferenceIds)) {
            $this->reject('reinstatement', 'A bounded idempotency key and one to twenty unique fresh evidence references are required.');
        }

        if (($sourceContext['purpose'] ?? null) !== 'synthetic_test_only' ||
            ($sourceContext['method'] ?? null) !== 'fixture_reference' ||
            ($sourceContext['territory'] ?? null) !== 'synthetic' || count($sourceContext) !== 3) {
            $this->reject('source_context', 'I5 reinstatement accepts synthetic fixture processing context only.');
        }

        return DB::transaction(function () use (
            $actor, $withdrawnVersionId, $value, $evidenceReferenceIds, $sourceContext,
            $idempotencyKey, $validFrom, $validTo, $reasonCode, $rationale, $validationContext
        ): array {
            $prior = DB::table('claim_versions')
                ->join('claims', 'claims.id', '=', 'claim_versions.claim_id')
                ->where('claim_versions.id', $withdrawnVersionId)
                ->lockForUpdate()
                ->first([
                    'claim_versions.id',
                    'claim_versions.claim_id',
                    'claim_versions.field_definition_version_id',
                    'claim_versions.disposition',
                    'claims.subject_entity_id',
                    'claims.predicate',
                ]);
            if ($prior === null || $prior->disposition !== 'withdrawn' ||
                $prior->field_definition_version_id === null) {
                $this->reject('claim_version', 'Reinstatement requires a withdrawn registry-bound predecessor.');
            }

            $priorAudit = DB::table('audit_events')
                ->where('action', 'field_aware_claim_reinstated')
                ->where('target_type', 'claim_version')
                ->where('metadata->idempotency_key', $idempotencyKey)
                ->first(['metadata']);
            if ($priorAudit !== null) {
                $metadata = json_decode((string) $priorAudit->metadata, true) ?: [];
                $fingerprint = $this->fingerprint([
                    'actor_id' => $actor['actor_id'],
                    'withdrawn_version_id' => $withdrawnVersionId,
                    'value' => $value,
                    'evidence_reference_ids' => array_values($evidenceReferenceIds),
                    'source_context' => $sourceContext,
                    'validation_context' => $validationContext,
                    'valid_from' => $validFrom,
                    'valid_to' => $validTo,
                    'reason_code' => $reasonCode,
                    'rationale' => $rationale,
                    'field_definition_version_id' => $prior->field_definition_version_id,
                ]);
                if (($metadata['actor_id'] ?? null) !== $actor['actor_id'] ||
                    ($metadata['service_fingerprint'] ?? null) !== $fingerprint) {
                    $this->reject('idempotency_key', 'Reinstatement idempotency key was reused for a different command.');
                }

                $newVersionId = (string) ($metadata['new_version_id'] ?? '');
                $caseId = (string) DB::table('editorial_review_cases')
                    ->where('claim_version_id', $newVersionId)
                    ->value('id');
                if ($newVersionId === '' || $caseId === '') {
                    $this->reject('idempotency_key', 'The original reinstatement record is incomplete and requires reconciliation.');
                }

                return [
                    'claim_id' => (string) $prior->claim_id,
                    'claim_version_id' => $newVersionId,
                    'editorial_review_case_id' => $caseId,
                ];
            }

            if (DB::table('claim_versions')->where('supersedes_version_id', $withdrawnVersionId)->exists()) {
                $this->reject('claim_version', 'This withdrawn version already has a successor.');
            }

            $entity = DB::table('directory_entities')
                ->where('id', $prior->subject_entity_id)
                ->lockForUpdate()
                ->first(['entity_type']);
            if ($entity === null || ! in_array($entity->entity_type, ['institution', 'programme'], true)) {
                $this->reject('subject', 'I5 reinstatement supports explicitly governed institution and programme entities only.');
            }

            $providerCategory = $this->registry->providerCategoryForEntity($prior->subject_entity_id, true);
            if (is_string($providerCategory) === false || $providerCategory === '') {
                $this->reject('provider_category', 'A current human-governed provider category is required.');
            }

            $definitionVersion = DB::table('field_definition_versions')
                ->where('id', $prior->field_definition_version_id)
                ->lockForUpdate()
                ->first(['id', 'lifecycle_state']);
            if ($definitionVersion === null || $definitionVersion->lifecycle_state !== 'active') {
                $this->reject('applicability', 'The exact original field definition version must remain active during reinstatement.');
            }

            $binding = DB::table('field_definition_versions as versions')
                ->join('field_definitions as definitions', 'definitions.id', '=', 'versions.field_definition_id')
                ->where('versions.id', $prior->field_definition_version_id)
                ->first(['definitions.field_key', 'versions.version_number']);
            if ($binding === null || $binding->field_key !== $prior->predicate) {
                $this->reject('field_binding', 'The withdrawn predecessor does not match its exact definition-version binding.');
            }

            $applicability = $this->registry->resolveApplicable(
                (string) $binding->field_key,
                (int) $binding->version_number,
                (string) $entity->entity_type,
                $providerCategory
            );
            if ($applicability['allowed'] !== true || $applicability['definition'] === null ||
                $applicability['definition']['field_definition_version_id'] !== $prior->field_definition_version_id) {
                $this->reject('applicability', 'The exact original definition version must still be active and applicable for reinstatement.');
            }

            $definition = $applicability['definition'];
            $definition['entity_types'] = DB::table('field_definition_version_entity_types')
                ->where('field_definition_version_id', $prior->field_definition_version_id)
                ->pluck('entity_type')->all();
            $definition['provider_categories'] = DB::table('field_definition_version_provider_categories')
                ->where('field_definition_version_id', $prior->field_definition_version_id)
                ->pluck('provider_category')->all();

            $resolvedValidationContext = array_merge($validationContext, [
                'entity_type' => (string) $entity->entity_type,
                'provider_category' => $providerCategory,
                'scope_key' => (string) $definition['scope_key'],
                'audience' => 'internal',
                'data_classes' => [],
                'contains_sensitive_personal_data' => false,
                'evaluation_at' => now()->toIso8601String(),
            ]);
            $applicabilityResult = $this->validator->validateApplicability($definition, $resolvedValidationContext);
            $valueResult = $this->validator->validate($definition, $value, $resolvedValidationContext);
            if ($applicabilityResult['valid'] !== true || $valueResult['valid'] !== true) {
                $this->reject('value', 'Reinstated value failed exact-definition typed, privacy or applicability validation.');
            }

            $oldEvidenceIds = DB::table('claim_versions')
                ->join('claim_evidence_links', 'claim_evidence_links.claim_version_id', '=', 'claim_versions.id')
                ->where('claim_versions.claim_id', $prior->claim_id)
                ->pluck('claim_evidence_links.evidence_reference_id')
                ->all();
            if (array_intersect($oldEvidenceIds, $evidenceReferenceIds) !== []) {
                $this->reject('evidence', 'Reinstatement requires evidence references not previously linked to this claim history.');
            }

            $evidence = DB::table('evidence_references')
                ->whereIn('id', $evidenceReferenceIds)
                ->lockForUpdate()
                ->get();
            if ($evidence->count() !== count($evidenceReferenceIds)) {
                $this->reject('evidence', 'Every fresh reinstatement evidence reference must exist.');
            }

            $policy = new GovernancePolicy;
            foreach ($evidence as $reference) {
                if ($reference->source_type !== 'synthetic' || (bool) $reference->content_included !== false ||
                    $reference->status !== 'eligible_for_review') {
                    $this->reject('evidence', 'I5 reinstatement accepts eligible metadata-only synthetic evidence references only.');
                }

                $authorization = (array) DB::table('source_authorizations')
                    ->where('id', $reference->source_authorization_id)
                    ->lockForUpdate()
                    ->first();
                $decision = $policy->authorizeSourceAction($authorization, 'processing', $sourceContext);
                if (($decision['allowed'] ?? false) !== true) {
                    $this->reject('authorization', 'Reinstatement evidence is not authorized for this synthetic processing purpose.');
                }

                $acceptedKinds = $definition['evidence_policy']['accepted_reference_kinds'] ?? null;
                if (is_array($acceptedKinds) && $acceptedKinds !== [] &&
                    in_array($reference->reference_kind, $acceptedKinds, true) === false) {
                    $this->reject('evidence', 'Reinstatement evidence kind is not permitted by the exact field definition.');
                }
            }

            $otherValueCount = DB::table('claims')
                ->join('claim_versions', 'claim_versions.claim_id', '=', 'claims.id')
                ->where('claims.subject_entity_id', $prior->subject_entity_id)
                ->where('claims.predicate', $prior->predicate)
                ->where('claims.id', '!=', $prior->claim_id)
                ->whereNotIn('claim_versions.disposition', ['rejected', 'withdrawn'])
                ->whereNotExists(function ($query): void {
                    $query->selectRaw('1')
                        ->from('claim_versions as successor')
                        ->whereColumn('successor.supersedes_version_id', 'claim_versions.id');
                })
                ->count();
            $maximum = (int) ($definition['validation_schema']['max_values'] ?? 100);
            $cardinality = $this->validator->validateCardinality(
                (string) $definition['cardinality'],
                (int) $otherValueCount,
                1,
                $maximum
            );
            if ($cardinality['valid'] !== true) {
                $this->reject('cardinality', 'Reinstated value would violate the exact field cardinality limit.');
            }

            $newVersionId = $this->workflow->reinstateWithdrawnClaimVersion(
                $actor,
                $withdrawnVersionId,
                $value,
                $evidenceReferenceIds,
                $validFrom,
                $validTo,
                $reasonCode,
                $rationale,
                $idempotencyKey,
                (string) $prior->field_definition_version_id
            );

            $editorialCaseId = $this->editorial->submit(
                $actor,
                (string) $prior->subject_entity_id,
                $newVersionId,
                'i5-field-reinstatement-editorial-'.hash('sha256', $idempotencyKey)
            );

            $serviceFingerprint = $this->fingerprint([
                'actor_id' => $actor['actor_id'],
                'withdrawn_version_id' => $withdrawnVersionId,
                'value' => $value,
                'evidence_reference_ids' => array_values($evidenceReferenceIds),
                'source_context' => $sourceContext,
                'validation_context' => $validationContext,
                'valid_from' => $validFrom,
                'valid_to' => $validTo,
                'reason_code' => $reasonCode,
                'rationale' => $rationale,
                'field_definition_version_id' => $prior->field_definition_version_id,
            ]);
            DB::table('audit_events')->insert([
                'id' => (string) Str::uuid(),
                'actor_class' => $actor['actor_class'],
                'action' => 'field_aware_claim_reinstated',
                'target_type' => 'claim_version',
                'target_id' => $newVersionId,
                'reason_code' => 'field_aware_claim_reinstatement_submitted',
                'occurred_at' => now(),
                'metadata' => json_encode([
                    'actor_id' => $actor['actor_id'],
                    'withdrawn_version_id' => $withdrawnVersionId,
                    'new_version_id' => $newVersionId,
                    'field_definition_version_id' => $prior->field_definition_version_id,
                    'editorial_review_case_id' => $editorialCaseId,
                    'idempotency_key' => $idempotencyKey,
                    'service_fingerprint' => $serviceFingerprint,
                    'evidence_reference_ids' => array_values($evidenceReferenceIds),
                ], JSON_THROW_ON_ERROR),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('governance_outbox')->insert([
                'id' => (string) Str::uuid(),
                'event_type' => 'field_claim.proposal.submitted',
                'aggregate_type' => 'claim_version',
                'aggregate_id' => $newVersionId,
                'payload' => json_encode([
                    'claim_version_id' => $newVersionId,
                    'field_definition_version_id' => $prior->field_definition_version_id,
                    'editorial_review_case_id' => $editorialCaseId,
                ], JSON_THROW_ON_ERROR),
                'idempotency_key' => 'field-claim-reinstatement:'.hash('sha256', $idempotencyKey),
                'status' => 'pending',
                'attempts' => 0,
                'available_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return [
                'claim_id' => (string) $prior->claim_id,
                'claim_version_id' => $newVersionId,
                'editorial_review_case_id' => $editorialCaseId,
            ];
        });
    }

    private function requireHumanCapability(array $actor, string $capability): void
    {
        $decision = (new GovernancePolicy)->requireCapability($actor, $capability);
        if (($decision['allowed'] ?? false) !== true || ($actor['actor_class'] ?? null) !== 'human') {
            $this->reject('actor', 'A human actor with the required reinstatement capability is required.');
        }
    }

    private function fingerprint(array $command): string
    {
        return hash('sha256', json_encode($command, JSON_THROW_ON_ERROR));
    }

    private function reject(string $field, string $message): never
    {
        throw ValidationException::withMessages([$field => $message]);
    }
}
