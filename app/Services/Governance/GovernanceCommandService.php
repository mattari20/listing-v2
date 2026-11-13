<?php

declare(strict_types=1);

namespace App\Services\Governance;

use App\Domain\Governance\GovernancePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

final class GovernanceCommandService
{
    public function __construct(private readonly GovernancePolicy $policy)
    {
    }

    /**
     * Register metadata only. Evidence content is never accepted by this command.
     *
     * @param array<string, mixed> $actor
     * @param array<string, mixed> $context
     */
    public function registerEvidenceReference(
        string $authorizationId,
        array $actor,
        array $context,
        string $idempotencyKey,
        array $metadata,
    ): string {
        $capability = $this->policy->requireCapability($actor, 'register_evidence');
        if (! $capability['allowed']) {
            throw ValidationException::withMessages(['actor' => $capability['reason']]);
        }

        if ($idempotencyKey === '') {
            throw ValidationException::withMessages(['idempotency_key' => 'An idempotency key is required.']);
        }

        if (($metadata['content_included'] ?? false) !== false) {
            throw ValidationException::withMessages(['content' => 'This command accepts metadata only.']);
        }

        return DB::transaction(function () use ($authorizationId, $actor, $context, $idempotencyKey, $metadata): string {
            $existing = DB::table('audit_events')
                ->where('action', 'evidence_reference_registered')
                ->where('metadata->idempotency_key', $idempotencyKey)
                ->value('target_id');

            if (is_string($existing)) {
                return $existing;
            }

            $authorization = (array) DB::table('source_authorizations')->where('id', $authorizationId)->first();
            if ($authorization === []) {
                throw ValidationException::withMessages(['authorization' => 'Source authorization was not found.']);
            }

            $decision = $this->policy->authorizeSourceAction($authorization, 'acquisition', $context);
            if (! $decision['allowed']) {
                throw ValidationException::withMessages(['authorization' => $decision['reason']]);
            }

            $id = (string) Str::uuid();
            $now = now();

            DB::table('evidence_references')->insert([
                'id' => $id,
                'source_authorization_id' => $authorizationId,
                'reference_kind' => (string) ($metadata['reference_kind'] ?? 'synthetic_fixture'),
                'source_type' => 'synthetic',
                'integrity_digest' => $metadata['integrity_digest'] ?? null,
                'status' => 'quarantined',
                'content_included' => false,
                'observed_at' => $metadata['observed_at'] ?? null,
                'recorded_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->writeAudit($actor, 'evidence_reference_registered', 'evidence_reference', $id, 'synthetic_evidence_intake', [
                'idempotency_key' => $idempotencyKey,
                'authorization_id' => $authorizationId,
                'status' => 'quarantined',
            ]);

            return $id;
        });
    }

    /**
     * Create a proposed claim version. Quarantined evidence may be linked for
     * review but can never be treated as admissible or publication-approved here.
     *
     * @param array<string, mixed> $actor
     * @param list<string> $evidenceReferenceIds
     */
    public function registerProposedClaim(
        array $actor,
        string $subjectEntityId,
        string $predicate,
        array $value,
        array $evidenceReferenceIds,
        string $idempotencyKey,
    ): string {
        $capability = $this->policy->requireCapability($actor, 'register_claim');
        if (! $capability['allowed']) {
            throw ValidationException::withMessages(['actor' => $capability['reason']]);
        }

        if ($idempotencyKey === '' || $predicate === '' || $evidenceReferenceIds === []) {
            throw ValidationException::withMessages(['claim' => 'Predicate, evidence references and idempotency key are required.']);
        }

        return DB::transaction(function () use ($actor, $subjectEntityId, $predicate, $value, $evidenceReferenceIds, $idempotencyKey): string {
            $existing = DB::table('audit_events')
                ->where('action', 'claim_version_registered')
                ->where('metadata->idempotency_key', $idempotencyKey)
                ->value('target_id');

            if (is_string($existing)) {
                return $existing;
            }

            if (! DB::table('directory_entities')->where('id', $subjectEntityId)->exists()) {
                throw ValidationException::withMessages(['subject' => 'Claim subject does not exist.']);
            }

            $evidence = DB::table('evidence_references')->whereIn('id', $evidenceReferenceIds)->get();
            if ($evidence->count() !== count(array_unique($evidenceReferenceIds))) {
                throw ValidationException::withMessages(['evidence' => 'Every evidence reference must exist.']);
            }

            $claimId = (string) Str::uuid();
            $versionId = (string) Str::uuid();
            $now = now();

            DB::table('claims')->insert([
                'id' => $claimId,
                'subject_entity_id' => $subjectEntityId,
                'predicate' => $predicate,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('claim_versions')->insert([
                'id' => $versionId,
                'claim_id' => $claimId,
                'version_number' => 1,
                'value' => json_encode($value, JSON_THROW_ON_ERROR),
                'recorded_at' => $now,
                'disposition' => 'proposed',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($evidenceReferenceIds as $evidenceId) {
                DB::table('claim_evidence_links')->insert([
                    'id' => (string) Str::uuid(),
                    'claim_version_id' => $versionId,
                    'evidence_reference_id' => $evidenceId,
                    'relationship_type' => 'supports',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $this->writeAudit($actor, 'claim_version_registered', 'claim_version', $versionId, 'synthetic_claim_registration', [
                'idempotency_key' => $idempotencyKey,
                'claim_id' => $claimId,
                'disposition' => 'proposed',
                'evidence_reference_ids' => array_values($evidenceReferenceIds),
            ]);

            return $versionId;
        });
    }

    /**
     * Append a material audit event inside the caller's transaction.
     *
     * @param array<string, mixed> $actor
     * @param array<string, mixed> $metadata
     */
    private function writeAudit(
        array $actor,
        string $action,
        string $targetType,
        string $targetId,
        string $reason,
        array $metadata,
    ): void {
        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(),
            'actor_class' => (string) $actor['actor_class'],
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'reason_code' => $reason,
            'occurred_at' => now(),
            'metadata' => json_encode(['actor_id' => $actor['actor_id']] + $metadata, JSON_THROW_ON_ERROR),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
