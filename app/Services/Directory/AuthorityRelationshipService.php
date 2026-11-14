<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Directory\AuthorityRelationshipPolicy;
use App\Domain\Governance\GovernancePolicy;
use App\Services\Governance\GovernanceCommandService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class AuthorityRelationshipService
{
    public function registerAuthority(array $actor, string $label, string $authorityType, string $idempotencyKey): string
    {
        $policy = new AuthorityRelationshipPolicy;
        $policy->assertAuthorityType($authorityType);
        $this->requireHumanCapability($actor, 'register_directory_entity');
        $label = trim($label);
        if ($label === '' || mb_strlen($label) > 255 || trim($idempotencyKey) === '') {
            throw ValidationException::withMessages(['authority' => 'A label and idempotency key are required.']);
        }

        return DB::transaction(function () use ($actor, $label, $authorityType, $idempotencyKey): string {
            $fingerprint = hash('sha256', json_encode([$actor['actor_id'], $label, $authorityType], JSON_THROW_ON_ERROR));
            $prior = DB::table('audit_events')->where('action', 'authority_identity_registered')->where('metadata->idempotency_key', $idempotencyKey)->first(['target_id', 'metadata']);
            if ($prior !== null) {
                $metadata = json_decode((string) $prior->metadata, true) ?: [];
                if (($metadata['fingerprint'] ?? null) !== $fingerprint || ($metadata['actor_id'] ?? null) !== $actor['actor_id']) {
                    throw ValidationException::withMessages(['idempotency_key' => 'Key reused for a different authority identity.']);
                }
                return (string) $prior->target_id;
            }

            $id = (string) Str::uuid();
            $now = now();
            DB::table('directory_entities')->insert([
                'id' => $id, 'entity_type' => 'authority', 'label' => $label,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('authority_profiles')->insert([
                'entity_id' => $id, 'authority_type' => $authorityType, 'status' => 'active',
                'registered_by_actor_id' => $actor['actor_id'], 'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('audit_events')->insert([
                'id' => (string) Str::uuid(), 'actor_class' => $actor['actor_class'],
                'action' => 'authority_identity_registered', 'target_type' => 'authority',
                'target_id' => $id, 'reason_code' => 'synthetic_authority_identity_registration',
                'occurred_at' => $now, 'metadata' => json_encode([
                    'actor_id' => $actor['actor_id'], 'authority_type' => $authorityType,
                    'idempotency_key' => $idempotencyKey, 'fingerprint' => $fingerprint,
                ], JSON_THROW_ON_ERROR), 'created_at' => $now, 'updated_at' => $now,
            ]);
            return $id;
        });
    }

    public function proposeRelationship(
        array $actor,
        string $subjectEntityId,
        string $targetEntityId,
        string $predicate,
        array $evidenceIds,
        array $context,
        string $idempotencyKey,
        string $scope,
        string $jurisdiction,
        ?string $validFrom = null,
        ?string $validTo = null
    ): string {
        if ($subjectEntityId === $targetEntityId || $evidenceIds === [] || trim($scope) === '' || trim($jurisdiction) === '') {
            throw ValidationException::withMessages(['relationship' => 'Distinct endpoints, evidence, scope and jurisdiction are required.']);
        }
        $policy = new AuthorityRelationshipPolicy;
        $policy->assertDates($validFrom, $validTo);
        $this->assertEndpoints($subjectEntityId, $targetEntityId, $predicate);

        return app(GovernanceCommandService::class)->registerProposedClaim(
            $actor, $subjectEntityId, 'authority_relationship',
            [
                'subject_entity_id' => $subjectEntityId,
                'authority_entity_id' => $targetEntityId,
                'relationship_type' => $predicate,
                'scope' => trim($scope),
                'jurisdiction' => trim($jurisdiction),
            ],
            $evidenceIds, $context, $idempotencyKey, $validFrom, $validTo
        );
    }

    public function materializeAcceptedRelationship(array $actor, string $claimVersionId, string $idempotencyKey): string
    {
        $this->requireHumanCapability($actor, 'materialize_relationship');
        if (trim($idempotencyKey) === '') {
            throw ValidationException::withMessages(['idempotency_key' => 'An idempotency key is required.']);
        }

        return DB::transaction(function () use ($actor, $claimVersionId, $idempotencyKey): string {
            $fingerprint = hash('sha256', json_encode([$actor['actor_id'], $claimVersionId], JSON_THROW_ON_ERROR));
            $prior = DB::table('audit_events')->where('action', 'authority_relationship_materialized')->where('metadata->idempotency_key', $idempotencyKey)->first(['target_id', 'metadata']);
            if ($prior !== null) {
                $metadata = json_decode((string) $prior->metadata, true) ?: [];
                if (($metadata['fingerprint'] ?? null) !== $fingerprint || ($metadata['actor_id'] ?? null) !== $actor['actor_id']) {
                    throw ValidationException::withMessages(['idempotency_key' => 'Key reused for a different authority relationship command.']);
                }
                return (string) $prior->target_id;
            }

            $version = DB::table('claim_versions')->where('id', $claimVersionId)->lockForUpdate()->first();
            if ($version === null || $version->disposition !== 'accepted' || DB::table('claim_versions')->where('supersedes_version_id', $claimVersionId)->exists()) {
                throw ValidationException::withMessages(['claim_version' => 'A current accepted claim version is required.']);
            }
            $claim = DB::table('claims')->where('id', $version->claim_id)->first();
            if ($claim === null || $claim->predicate !== 'authority_relationship') {
                throw ValidationException::withMessages(['claim' => 'Claim is not a P03 authority relationship.']);
            }
            $decision = DB::table('adjudication_decisions')
                ->join('adjudication_cases', 'adjudication_cases.id', '=', 'adjudication_decisions.adjudication_case_id')
                ->where('adjudication_cases.claim_version_id', $claimVersionId)
                ->where('adjudication_decisions.outcome', 'accepted')
                ->where('adjudication_decisions.actor_class', 'human')
                ->orderByDesc('adjudication_decisions.decided_at')
                ->first(['adjudication_decisions.actor_id']);
            if ($decision === null || $decision->actor_id === $actor['actor_id']) {
                throw ValidationException::withMessages(['adjudication' => 'A distinct persisted human adjudicator is required.']);
            }

            $evidence = DB::table('claim_evidence_links')
                ->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')
                ->join('source_authorizations', 'source_authorizations.id', '=', 'evidence_references.source_authorization_id')
                ->where('claim_evidence_links.claim_version_id', $claimVersionId)
                ->get(['evidence_references.id', 'evidence_references.status', 'source_authorizations.status as authorization_status', 'source_authorizations.valid_from', 'source_authorizations.valid_to', 'source_authorizations.revoked_at']);
            if ($evidence->isEmpty()) {
                throw ValidationException::withMessages(['evidence' => 'Admissible evidence is required.']);
            }
            foreach ($evidence as $item) {
                if ($item->status !== 'eligible_for_review' || $item->authorization_status !== 'approved_for_defined_purpose_and_method' || $item->revoked_at !== null || ($item->valid_from !== null && now()->lt($item->valid_from)) || ($item->valid_to !== null && now()->gte($item->valid_to))) {
                    throw ValidationException::withMessages(['evidence' => 'Evidence must remain admissible and source-authorized.']);
                }
                $event = DB::table('audit_events')->where('target_type', 'evidence_reference')->where('target_id', $item->id)->where('action', 'evidence_reference_registered')->value('metadata');
                $evidenceActor = is_string($event) ? (json_decode($event, true)['actor_id'] ?? null) : null;
                if (!is_string($evidenceActor) || $evidenceActor === '' || $evidenceActor === $actor['actor_id'] || $evidenceActor === $decision->actor_id) {
                    throw ValidationException::withMessages(['actor' => 'Evidence submitter, adjudicator and materializer must be distinct.']);
                }
            }

            $value = json_decode((string) $version->value, true);
            if (!is_array($value) || ($claim->subject_entity_id ?? null) !== ($value['subject_entity_id'] ?? null)) {
                throw ValidationException::withMessages(['claim_value' => 'Claim subject must match the explicit relationship subject.']);
            }
            $subject = DB::table('directory_entities')->where('id', $value['subject_entity_id'])->first(['entity_type']);
            $target = DB::table('directory_entities')->where('id', $value['authority_entity_id'])->first(['entity_type']);
            if ($subject === null || $target === null) {
                throw ValidationException::withMessages(['endpoints' => 'Both relationship identities must exist.']);
            }
            $authorityType = $target->entity_type === 'authority'
                ? DB::table('authority_profiles')->where('entity_id', $value['authority_entity_id'])->value('authority_type')
                : null;
            (new AuthorityRelationshipPolicy)->assertRelationship((string) $value['relationship_type'], (string) $subject->entity_type, (string) $target->entity_type, $authorityType);
            $scope = trim((string) ($value['scope'] ?? ''));
            $jurisdiction = trim((string) ($value['jurisdiction'] ?? ''));
            if ($scope === '' || $jurisdiction === '') {
                throw ValidationException::withMessages(['scope' => 'Scope and jurisdiction must be explicit.']);
            }
            (new AuthorityRelationshipPolicy)->assertDates($version->valid_from, $version->valid_to);

            DB::table('directory_entities')->whereIn('id', [$value['subject_entity_id'], $value['authority_entity_id']])->orderBy('id')->lockForUpdate()->get(['id']);
            $query = DB::table('entity_relationships')->where('from_entity_id', $value['subject_entity_id'])
                ->where('to_entity_id', $value['authority_entity_id'])->where('relationship_type', $value['relationship_type'])
                ->where('scope', $scope)->where('jurisdiction', $jurisdiction)->where('status', 'active')->lockForUpdate();
            foreach ($query->get(['valid_from', 'valid_to']) as $existing) {
                $overlapStart = $version->valid_to === null || $existing->valid_from === null || $existing->valid_from <= $version->valid_to;
                $overlapEnd = $existing->valid_to === null || $version->valid_from === null || $existing->valid_to >= $version->valid_from;
                if ($overlapStart && $overlapEnd) {
                    throw ValidationException::withMessages(['relationship' => 'An active assertion with the same predicate, scope and jurisdiction overlaps this valid-time interval.']);
                }
            }

            $id = (string) Str::uuid();
            $now = now();
            DB::table('entity_relationships')->insert([
                'id' => $id, 'from_entity_id' => $value['subject_entity_id'], 'to_entity_id' => $value['authority_entity_id'],
                'relationship_type' => $value['relationship_type'], 'scope' => $scope, 'jurisdiction' => $jurisdiction,
                'valid_from' => $version->valid_from, 'valid_to' => $version->valid_to, 'claim_version_id' => $claimVersionId,
                'status' => 'active', 'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('audit_events')->insert([
                'id' => (string) Str::uuid(), 'actor_class' => $actor['actor_class'],
                'action' => 'authority_relationship_materialized', 'target_type' => 'entity_relationship',
                'target_id' => $id, 'reason_code' => 'accepted_governed_p03_assertion',
                'occurred_at' => $now, 'metadata' => json_encode([
                    'actor_id' => $actor['actor_id'], 'claim_version_id' => $claimVersionId,
                    'idempotency_key' => $idempotencyKey, 'fingerprint' => $fingerprint,
                    'subject_entity_id' => $value['subject_entity_id'], 'authority_entity_id' => $value['authority_entity_id'],
                    'predicate' => $value['relationship_type'], 'scope' => $scope, 'jurisdiction' => $jurisdiction,
                ], JSON_THROW_ON_ERROR), 'created_at' => $now, 'updated_at' => $now,
            ]);
            return $id;
        });
    }

    private function assertEndpoints(string $subjectId, string $targetId, string $predicate): void
    {
        $entities = DB::table('directory_entities')->whereIn('id', [$subjectId, $targetId])->get(['id', 'entity_type'])->keyBy('id');
        if (!$entities->has($subjectId) || !$entities->has($targetId)) {
            throw ValidationException::withMessages(['endpoints' => 'Both relationship endpoints must exist.']);
        }
        $targetType = (string) $entities[$targetId]->entity_type;
        $authorityType = $targetType === 'authority' ? DB::table('authority_profiles')->where('entity_id', $targetId)->value('authority_type') : null;
        (new AuthorityRelationshipPolicy)->assertRelationship($predicate, (string) $entities[$subjectId]->entity_type, $targetType, $authorityType);
    }

    private function requireHumanCapability(array $actor, string $capability): void
    {
        $decision = (new GovernancePolicy)->requireCapability($actor, $capability);
        if ($decision['allowed'] === false || ($actor['actor_class'] ?? null) !== 'human') {
            throw ValidationException::withMessages(['actor' => 'A human actor with the required capability is required.']);
        }
    }
}
