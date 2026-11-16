<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Governance\GovernancePolicy;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Field-aware correction orchestration for registry-bound claim versions.
 *
 * This service accepts synthetic fixture references only. It validates the
 * exact immutable definition binding before delegating successor persistence
 * to the existing governance lifecycle and submitting the successor for review.
 */
final class FieldAwareClaimCorrectionService
{
    public function __construct(
        private readonly FieldDefinitionRegistryReader $registry,
        private readonly TypedFieldValueValidator $validator,
        private readonly PersistedGovernanceWorkflowService $workflow,
        private readonly EditorialReviewService $editorial
    )
    {}

    /**
     * @param list<string> $evidenceReferenceIds
     * @param array<string, mixed> $sourceContext
     * @param array<string, mixed> $validationContext
     * @return array{claim_id: string, claim_version_id: string, editorial_review_case_id: string}
     */
    public function correct(
        array $actor,
        string $priorVersionId,
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
            $this->reject('correction', 'A bounded idempotency key and one to twenty unique evidence references are required.');
        }

        if (($sourceContext['purpose'] ?? null) !== 'synthetic_test_only' ||
            ($sourceContext['method'] ?? null) !== 'fixture_reference' ||
            ($sourceContext['territory'] ?? null) !== 'synthetic' || count($sourceContext) !== 3) {
            $this->reject('source_context', 'I5 field-aware correction accepts synthetic fixture processing context only.');
        }

        return DB::transaction(function () use (
            $actor, $priorVersionId, $value, $evidenceReferenceIds, $sourceContext,
            $idempotencyKey, $validFrom, $validTo, $reasonCode, $rationale, $validationContext
        ): array {
            $prior = DB::table('claim_versions')
                ->join('claims', 'claims.id', '=', 'claim_versions.claim_id')
                ->where('claim_versions.id', $priorVersionId)
                ->lockForUpdate()
                ->first([
                    'claim_versions.id',
                    'claim_versions.claim_id',
                    'claim_versions.field_definition_version_id',
                    'claim_versions.disposition',
                    'claims.subject_entity_id',
                    'claims.predicate',
                ]);

            $alreadyCorrected = DB::table('audit_events')
                ->where('action', 'claim_version_corrected')
                ->where('metadata->idempotency_key', $idempotencyKey)
                ->exists();
            if ($prior === null || $prior->field_definition_version_id === null ||
                $prior->disposition === 'withdrawn' ||
                ($alreadyCorrected === false && DB::table('claim_versions')->where('supersedes_version_id', $priorVersionId)->exists())) {
                $this->reject('claim_version', 'A current registry-bound, non-withdrawn predecessor without a successor is required.');
            }

            $entity = DB::table('directory_entities')
                ->where('id', $prior->subject_entity_id)
                ->lockForUpdate()
                ->first(['entity_type']);
            if ($entity === null || $entity->entity_type !== 'institution') {
                $this->reject('subject', 'I5 field-aware correction currently supports institution-level registry claims only.');
            }

            $providerCategory = DB::table('directory_provider_category_assignments')
                ->where('entity_id', $prior->subject_entity_id)
                ->lockForUpdate()
                ->value('provider_category');
            if (is_string($providerCategory) === false || $providerCategory === '') {
                $this->reject('provider_category', 'A current human-governed provider category is required.');
            }

            $binding = DB::table('field_definition_versions as versions')
                ->join('field_definitions as definitions', 'definitions.id', '=', 'versions.field_definition_id')
                ->where('versions.id', $prior->field_definition_version_id)
                ->first(['definitions.field_key', 'versions.version_number']);
            if ($binding === null || $binding->field_key !== $prior->predicate) {
                $this->reject('field_binding', 'The predecessor field key does not match its exact definition-version binding.');
            }

            $applicability = $this->registry->resolveApplicable(
                (string) $binding->field_key,
                (int) $binding->version_number,
                (string) $entity->entity_type,
                $providerCategory
            );
            if ($applicability['allowed'] !== true || $applicability['definition'] === null ||
                $applicability['definition']['field_definition_version_id'] !== $prior->field_definition_version_id) {
                $this->reject('applicability', 'The predecessor exact definition version is no longer active and applicable.');
            }

            $definition = $applicability['definition'];
            $definition['entity_types'] = DB::table('field_definition_version_entity_types')
                ->where('field_definition_version_id', $prior->field_definition_version_id)
                ->pluck('entity_type')->all();
            $definition['provider_categories'] = DB::table('field_definition_version_provider_categories')
                ->where('field_definition_version_id', $prior->field_definition_version_id)
                ->pluck('provider_category')->all();

            $validationContext = array_merge($validationContext, [
                'entity_type' => (string) $entity->entity_type,
                'provider_category' => $providerCategory,
                'scope_key' => (string) $definition['scope_key'],
                'audience' => 'internal',
                'data_classes' => [],
                'contains_sensitive_personal_data' => false,
                'evaluation_at' => now()->toIso8601String(),
            ]);
            $applicabilityResult = $this->validator->validateApplicability($definition, $validationContext);
            $valueResult = $this->validator->validate($definition, $value, $validationContext);
            if ($applicabilityResult['valid'] !== true || $valueResult['valid'] !== true) {
                $this->reject('value', 'Corrected value failed exact-definition typed, privacy or applicability validation.');
            }

            $evidence = DB::table('evidence_references')
                ->whereIn('id', $evidenceReferenceIds)
                ->lockForUpdate()
                ->get();
            if ($evidence->count() !== count($evidenceReferenceIds)) {
                $this->reject('evidence', 'Every correction evidence reference must exist.');
            }

            $policy = new GovernancePolicy;
            foreach ($evidence as $reference) {
                if ($reference->source_type !== 'synthetic' || (bool) $reference->content_included !== false ||
                    $reference->status !== 'eligible_for_review') {
                    $this->reject('evidence', 'I5 accepts eligible metadata-only synthetic evidence references only.');
                }

                $authorization = (array) DB::table('source_authorizations')
                    ->where('id', $reference->source_authorization_id)
                    ->lockForUpdate()
                    ->first();
                $decision = $policy->authorizeSourceAction($authorization, 'processing', $sourceContext);
                if (($decision['allowed'] ?? false) !== true) {
                    $this->reject('authorization', 'Correction evidence is not authorized for this synthetic processing purpose.');
                }

                $acceptedKinds = $definition['evidence_policy']['accepted_reference_kinds'] ?? null;
                if (is_array($acceptedKinds) && $acceptedKinds !== [] &&
                    in_array($reference->reference_kind, $acceptedKinds, true) === false) {
                    $this->reject('evidence', 'Correction evidence kind is not permitted by the exact field definition.');
                }
            }

            if ($alreadyCorrected === false) {
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
                    $this->reject('cardinality', 'Corrected value would violate the exact field cardinality limit.');
                }
            }

            $newVersionId = $this->workflow->correctClaimVersion(
                $actor,
                $priorVersionId,
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
                'i5-field-correction-editorial-'.hash('sha256', $idempotencyKey)
            );

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
            $this->reject('actor', 'A human actor with the required I5 correction capability is required.');
        }
    }

    private function reject(string $field, string $message): never
    {
        throw ValidationException::withMessages([$field => $message]);
    }
}
