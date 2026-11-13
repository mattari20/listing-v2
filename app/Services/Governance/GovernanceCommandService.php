<?php

declare(strict_types=1);

namespace App\Services\Governance;

use App\Domain\Governance\GovernancePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class GovernanceCommandService
{
    public function __construct(private readonly GovernancePolicy $policy)
    {
    }

    /** @param array<string, mixed> $actor
     *  @param array<string, mixed> $context
     *  @param array<string, mixed> $metadata
     */
    public function registerEvidenceReference(string $authorizationId, array $actor, array $context, string $idempotencyKey, array $metadata): string
    {
        $this->requireActor($actor, 'register_evidence');
        if ($idempotencyKey === '') {
            throw ValidationException::withMessages(['idempotency_key' => 'An idempotency key is required.']);
        }
        if (($metadata['content_included'] ?? false) !== false) {
            throw ValidationException::withMessages(['content' => 'This command accepts metadata only.']);
        }

        return DB::transaction(function () use ($authorizationId, $actor, $context, $idempotencyKey, $metadata): string {
            $fingerprint = hash('sha256', json_encode([$authorizationId, $context, $metadata], JSON_THROW_ON_ERROR));
            $existing = $this->existingIdempotentTarget('evidence_reference_registered', $idempotencyKey, $fingerprint);
            if ($existing !== null) {
                return $existing;
            }

            $authorization = (array) DB::table('source_authorizations')->where('id', $authorizationId)->first();
            if ($authorization === []) {
                throw ValidationException::withMessages(['authorization' => 'Source authorization was not found.']);
            }
            $decision = $this->policy->authorizeSourceAction($authorization, 'acquisition', $context);
            if ($decision['allowed'] === false) {
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
                'idempotency_fingerprint' => $fingerprint,
                'authorization_id' => $authorizationId,
                'status' => 'quarantined',
            ]);

            return $id;
        });
    }

    /** @param array<string, mixed> $actor
     *  @param array<string, mixed> $value
     *  @param list<string> $evidenceReferenceIds
     */
    public function registerProposedClaim(array $actor, string $subjectEntityId, string $predicate, array $value, array $evidenceReferenceIds, string $idempotencyKey): string
    {
        $this->requireActor($actor, 'register_claim');
        if ($idempotencyKey === '' || $predicate === '' || $evidenceReferenceIds === []) {
            throw ValidationException::withMessages(['claim' => 'Predicate, evidence references and idempotency key are required.']);
        }

        return DB::transaction(function () use ($actor, $subjectEntityId, $predicate, $value, $evidenceReferenceIds, $idempotencyKey): string {
            $fingerprint = hash('sha256', json_encode([$subjectEntityId, $predicate, $value, array_values($evidenceReferenceIds)], JSON_THROW_ON_ERROR));
            $existing = $this->existingIdempotentTarget('claim_version_registered', $idempotencyKey, $fingerprint);
            if ($existing !== null) {
                return $existing;
            }
            if (DB::table('directory_entities')->where('id', $subjectEntityId)->exists() === false) {
                throw ValidationException::withMessages(['subject' => 'Claim subject does not exist.']);
            }

            $uniqueEvidenceIds = array_values(array_unique($evidenceReferenceIds));
            $evidence = DB::table('evidence_references')->whereIn('id', $uniqueEvidenceIds)->get();
            if ($evidence->count() !== count($uniqueEvidenceIds)) {
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
            $this->writeAudit($actor, 'claim_version_registered', 'claim_version', $versionId, 'synthetic_claim_registration', [
                'idempotency_key' => $idempotencyKey,
                'idempotency_fingerprint' => $fingerprint,
                'claim_id' => $claimId,
                'disposition' => 'proposed',
                'evidence_reference_ids' => $uniqueEvidenceIds,
            ]);

            return $versionId;
        });
    }

    private function requireActor(array $actor, string $capability): void
    {
        $decision = $this->policy->requireCapability($actor, $capability);
        if (!$decision['allowed']) {
            throw ValidationException::withMessages(['actor' => $decision['reason']]);
        }
    }

    private function existingIdempotentTarget(string $action, string $key, string $fingerprint): ?string
    {
        $event = DB::table('audit_events')
            ->where('action', $action)
            ->where('metadata->idempotency_key', $key)
            ->first(['target_id', 'metadata']);
        if ($event === null) {
            return null;
        }

        $metadata = json_decode((string) $event->metadata, true);
        if (is_array($metadata) === false || hash_equals((string) ($metadata['idempotency_fingerprint'] ?? ''), $fingerprint) === false) {
            throw ValidationException::withMessages(['idempotency_key' => 'The idempotency key was already used for a different command.']);
        }

        return (string) $event->target_id;
    }

    /** @param array<string, mixed> $actor
     *  @param array<string, mixed> $metadata
     */
    private function writeAudit(array $actor, string $action, string $targetType, string $targetId, string $reason, array $metadata): void
    {
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
