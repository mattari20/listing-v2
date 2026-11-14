<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Governance\GovernancePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class FieldAwareClaimProposalService
{
    public function __construct(
        private readonly FieldDefinitionRegistryReader $registry,
        private readonly TypedFieldValueValidator $validator,
    ) {
    }

    /**
     * Create one synthetic/local proposal against an exact active field version.
     *
     * @param list<string> $evidenceReferenceIds
     * @param array<string, mixed> $sourceContext
     * @param array<string, mixed> $validationContext
     * @return array{claim_id: string, claim_version_id: string, editorial_review_case_id: string}
     */
    public function propose(
        array $actor,
        string $subjectEntityId,
        string $fieldKey,
        int $definitionVersion,
        mixed $value,
        array $evidenceReferenceIds,
        array $sourceContext,
        string $scopeKey,
        string $idempotencyKey,
        array $validationContext = [],
        ?string $validFrom = null,
        ?string $validTo = null,
    ): array {
        $this->requireHumanCapability($actor, 'propose_field_value');
        $this->requireHumanCapability($actor, 'submit_directory_proposal');

        if ($idempotencyKey === '' || strlen($idempotencyKey) > 140 ||
            $evidenceReferenceIds === [] || $scopeKey === '') {
            $this->reject('proposal', 'Field key, exact version, scope, evidence and bounded idempotency key are required.');
        }

        if (($sourceContext['purpose'] ?? null) !== 'synthetic_test_only' ||
            ($sourceContext['method'] ?? null) !== 'fixture_reference' ||
            ($sourceContext['territory'] ?? null) !== 'synthetic' || count($sourceContext) !== 3) {
            $this->reject('source_context', 'I3 accepts synthetic fixture processing context only.');
        }

        $fingerprint = hash('sha256', json_encode([
            $actor['actor_id'], $actor['actor_class'], $subjectEntityId, $fieldKey,
            $definitionVersion, $value, array_values($evidenceReferenceIds), $sourceContext,
            $scopeKey, $validationContext, $validFrom, $validTo,
        ], JSON_THROW_ON_ERROR));
        $prior = DB::table('audit_events')
            ->where('action', 'field_aware_claim_proposed')
            ->where('metadata->idempotency_key', $idempotencyKey)
            ->first(['target_id', 'metadata']);
        if ($prior !== null) {
            $metadata = json_decode((string) $prior->metadata, true);
            if (! is_array($metadata) ||
                ! hash_equals((string) ($metadata['idempotency_fingerprint'] ?? ''), $fingerprint)) {
                $this->reject('idempotency_key', 'The idempotency key was already used for a different proposal.');
            }

            return [
                'claim_id' => (string) ($metadata['claim_id'] ?? ''),
                'claim_version_id' => (string) $prior->target_id,
                'editorial_review_case_id' => (string) ($metadata['editorial_review_case_id'] ?? ''),
            ];
        }

        $keyResult = $this->validator->validateFieldKey($fieldKey);
        if ($keyResult['valid'] === false) {
            $this->reject('field_key', 'Field key must use the canonical lowercase snake_case format.');
        }

        $entity = DB::table('directory_entities')->where('id', $subjectEntityId)->first(['entity_type']);
        if ($entity === null) {
            $this->reject('subject', 'Claim subject does not exist.');
        }

        $providerCategory = $this->registry->providerCategoryForEntity($subjectEntityId);
        if ($providerCategory === null) {
            $this->reject('provider_category', 'No human-governed provider category is assigned to this institution.');
        }

        $applicability = $this->registry->resolveApplicable(
            $fieldKey,
            $definitionVersion,
            (string) $entity->entity_type,
            $providerCategory
        );
        if ($applicability['allowed'] === false || $applicability['definition'] === null) {
            $this->reject('applicability', 'Field definition is missing, inactive, expired or not applicable.');
        }

        $definition = $applicability['definition'];
        $definition['entity_types'] = DB::table('field_definition_version_entity_types')
            ->where('field_definition_version_id', $definition['field_definition_version_id'])
            ->pluck('entity_type')->all();
        $definition['provider_categories'] = DB::table('field_definition_version_provider_categories')
            ->where('field_definition_version_id', $definition['field_definition_version_id'])
            ->pluck('provider_category')->all();

        $validation = $this->validator->validate($definition, $value, array_merge($validationContext, [
            'entity_type' => (string) $entity->entity_type,
            'provider_category' => $providerCategory,
            'scope_key' => $scopeKey,
            'audience' => 'internal',
            'data_classes' => [],
            'contains_sensitive_personal_data' => false,
            'evaluation_at' => now()->toIso8601String(),
        ]));
        if ($validation['valid'] === false) {
            $this->reject('value', 'Proposed value failed typed, privacy, freshness or applicability validation.');
        }

        $this->assertValidityDates($validFrom, $validTo);
        $uniqueEvidenceIds = array_values(array_unique($evidenceReferenceIds));
        if (count($uniqueEvidenceIds) !== count($evidenceReferenceIds) || count($uniqueEvidenceIds) > 20) {
            $this->reject('evidence', 'Evidence references must be unique and bounded to twenty.');
        }

        return DB::transaction(function () use (
            $actor, $subjectEntityId, $fieldKey, $definitionVersion, $definition, $value,
            $uniqueEvidenceIds, $sourceContext, $idempotencyKey, $validFrom, $validTo, $fingerprint, $providerCategory
        ): array {
            $prior = DB::table('audit_events')
                ->where('action', 'field_aware_claim_proposed')
                ->where('metadata->idempotency_key', $idempotencyKey)
                ->first(['target_id', 'metadata']);
            if ($prior !== null) {
                $metadata = json_decode((string) $prior->metadata, true);
                if (! is_array($metadata) ||
                    ! hash_equals((string) ($metadata['idempotency_fingerprint'] ?? ''), $fingerprint)) {
                    $this->reject('idempotency_key', 'The idempotency key was already used for a different proposal.');
                }

                return [
                    'claim_id' => (string) ($metadata['claim_id'] ?? ''),
                    'claim_version_id' => (string) $prior->target_id,
                    'editorial_review_case_id' => (string) ($metadata['editorial_review_case_id'] ?? ''),
                ];
            }

            $lockedEntity = DB::table('directory_entities')->where('id', $subjectEntityId)->lockForUpdate()->first(['entity_type']);
            $lockedCategory = DB::table('directory_provider_category_assignments')
                ->where('entity_id', $subjectEntityId)->lockForUpdate()->value('provider_category');
            if ($lockedEntity === null || $lockedCategory !== $providerCategory) {
                $this->reject('provider_category', 'Provider category changed during proposal validation; retry against the current governed assignment.');
            }
            $currentApplicability = $this->registry->resolveApplicable(
                $fieldKey, $definitionVersion, (string) $lockedEntity->entity_type, (string) $lockedCategory
            );
            if ($currentApplicability['allowed'] === false ||
                $currentApplicability['definition']['field_definition_version_id'] !== $definition['field_definition_version_id']) {
                $this->reject('applicability', 'Exact field definition is no longer applicable at proposal commit time.');
            }

            $existingCount = DB::table('claims')
                ->join('claim_versions', 'claim_versions.claim_id', '=', 'claims.id')
                ->where('claims.subject_entity_id', $subjectEntityId)
                ->where('claims.predicate', $fieldKey)
                ->whereNotIn('claim_versions.disposition', ['rejected', 'withdrawn'])
                ->count();
            $maximum = (int) ($definition['validation_schema']['max_values'] ?? 100);
            $cardinality = $this->validator->validateCardinality(
                $definition['cardinality'],
                (int) $existingCount,
                1,
                $maximum
            );
            if ($cardinality['valid'] === false) {
                $this->reject('cardinality', 'Field cardinality limit has been reached.');
            }

            $evidence = DB::table('evidence_references')->whereIn('id', $uniqueEvidenceIds)->get();
            if ($evidence->count() !== count($uniqueEvidenceIds)) {
                $this->reject('evidence', 'Every evidence reference must exist.');
            }
            $policy = new GovernancePolicy;
            foreach ($evidence as $reference) {
                if ($reference->source_type !== 'synthetic' || (bool) $reference->content_included !== false) {
                    $this->reject('evidence', 'I3 accepts metadata-only synthetic evidence references only.');
                }
                $authorization = (array) DB::table('source_authorizations')
                    ->where('id', $reference->source_authorization_id)->first();
                $decision = $policy->authorizeSourceAction($authorization, 'processing', $sourceContext);
                if ($decision['allowed'] === false) {
                    $this->reject('authorization', 'Evidence source is not authorized for this processing purpose.');
                }
                $acceptedKinds = $definition['evidence_policy']['accepted_reference_kinds'] ?? null;
                if (is_array($acceptedKinds) && $acceptedKinds !== [] &&
                    in_array($reference->reference_kind, $acceptedKinds, true) === false) {
                    $this->reject('evidence', 'Evidence reference kind is not permitted by this field definition.');
                }
            }

            $claimId = (string) Str::uuid();
            $versionId = (string) Str::uuid();
            $now = now();
            DB::table('claims')->insert([
                'id' => $claimId,
                'subject_entity_id' => $subjectEntityId,
                'predicate' => $fieldKey,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('claim_versions')->insert([
                'id' => $versionId,
                'claim_id' => $claimId,
                'field_definition_version_id' => $definition['field_definition_version_id'],
                'version_number' => 1,
                'value' => json_encode($value, JSON_THROW_ON_ERROR),
                'recorded_at' => $now,
                'valid_from' => $validFrom,
                'valid_to' => $validTo,
                'disposition' => 'proposed',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($uniqueEvidenceIds as $evidenceId) {
                DB::table('claim_evidence_links')->insert([
                    'id' => (string) Str::uuid(),
                    'claim_version_id' => $versionId,
                    'evidence_reference_id' => $evidenceId,
                    'relationship_type' => 'supports',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $editorialCaseId = app(EditorialReviewService::class)->submit(
                $actor,
                $subjectEntityId,
                $versionId,
                'field-proposal-editorial-'.hash('sha256', $idempotencyKey)
            );

            DB::table('audit_events')->insert([
                'id' => (string) Str::uuid(),
                'actor_class' => $actor['actor_class'],
                'action' => 'field_aware_claim_proposed',
                'target_type' => 'claim_version',
                'target_id' => $versionId,
                'reason_code' => 'field_aware_proposal_submitted',
                'occurred_at' => $now,
                'metadata' => json_encode([
                    'actor_id' => $actor['actor_id'],
                    'claim_id' => $claimId,
                    'field_key' => $fieldKey,
                    'field_definition_version_id' => $definition['field_definition_version_id'],
                    'editorial_review_case_id' => $editorialCaseId,
                    'idempotency_key' => $idempotencyKey,
                    'idempotency_fingerprint' => $fingerprint,
                    'evidence_reference_ids' => $uniqueEvidenceIds,
                ], JSON_THROW_ON_ERROR),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('governance_outbox')->insert([
                'id' => (string) Str::uuid(),
                'event_type' => 'field_claim.proposal.submitted',
                'aggregate_type' => 'claim_version',
                'aggregate_id' => $versionId,
                'payload' => json_encode([
                    'claim_version_id' => $versionId,
                    'field_definition_version_id' => $definition['field_definition_version_id'],
                    'editorial_review_case_id' => $editorialCaseId,
                ], JSON_THROW_ON_ERROR),
                'idempotency_key' => 'field-claim-proposal:'.hash('sha256', $idempotencyKey),
                'status' => 'pending',
                'attempts' => 0,
                'available_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return [
                'claim_id' => $claimId,
                'claim_version_id' => $versionId,
                'editorial_review_case_id' => $editorialCaseId,
            ];
        });
    }

    private function requireHumanCapability(array $actor, string $capability): void
    {
        $decision = (new GovernancePolicy)->requireCapability($actor, $capability);
        if ($decision['allowed'] === false || ($actor['actor_class'] ?? null) !== 'human') {
            $this->reject('actor', 'A human actor with the required proposal capability is required.');
        }
    }

    private function assertValidityDates(?string $from, ?string $to): void
    {
        foreach (['valid_from' => $from, 'valid_to' => $to] as $key => $date) {
            if ($date !== null && (preg_match('/^\d{4}-\d{2}-\d{2}$/D', $date) !== 1 ||
                \DateTimeImmutable::createFromFormat('!Y-m-d', $date)?->format('Y-m-d') !== $date)) {
                $this->reject($key, 'Validity dates must be valid ISO calendar dates.');
            }
        }
        if ($from !== null && $to !== null && $to < $from) {
            $this->reject('validity', 'Validity end date cannot precede start date.');
        }
    }

    private function reject(string $field, string $message): never
    {
        throw ValidationException::withMessages([$field => $message]);
    }
}
