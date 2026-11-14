<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Directory\ProviderInstitutionRelationshipPolicy;
use App\Domain\Governance\GovernancePolicy;
use App\Services\Governance\GovernanceCommandService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class ProviderInstitutionRelationshipService
{
    public function propose(array $actor, string $providerId, string $institutionId, string $predicate, array $evidenceIds, array $context, string $idempotencyKey, ?string $scope = null, ?string $jurisdiction = null, ?string $validFrom = null, ?string $validTo = null): string
    {
        (new ProviderInstitutionRelationshipPolicy)->assertPredicate($predicate);
        (new ProviderInstitutionRelationshipPolicy)->assertValidDates($validFrom, $validTo);
        $this->assertEndpoints($providerId, $institutionId, $predicate);
        if ($providerId === $institutionId || $evidenceIds === []) {
            throw ValidationException::withMessages(['relationship' => 'Distinct endpoints and supporting evidence are required.']);
        }
        return app(GovernanceCommandService::class)->registerProposedClaim(
            $actor,
            $providerId,
            'provider_institution_relationship',
            $this->policy->value($providerId, $institutionId, $predicate, $scope, $jurisdiction),
            $evidenceIds,
            $context,
            $idempotencyKey,
            $validFrom,
            $validTo
        );
    }

    public function materializeAcceptedRelationship(array $actor, string $versionId, string $idempotencyKey): string
    {
        $capability = (new GovernancePolicy)->requireCapability($actor, 'materialize_relationship');
        if ($capability['allowed'] === false || ($actor['actor_class'] ?? null) !== 'human') {
            throw ValidationException::withMessages(['actor' => 'A human materialize_relationship capability is required.']);
        }
        if (trim($idempotencyKey) === '') {
            throw ValidationException::withMessages(['idempotency_key' => 'An idempotency key is required.']);
        }
        return DB::transaction(function () use ($actor, $versionId, $idempotencyKey): string {
            $fingerprint = hash('sha256', json_encode([$actor['actor_id'], $versionId], JSON_THROW_ON_ERROR));
            $prior = DB::table('audit_events')->where('action', 'provider_institution_relationship_materialized')->where('metadata->idempotency_key', $idempotencyKey)->first(['target_id', 'metadata']);
            if ($prior !== null) {
                $metadata = json_decode((string) $prior->metadata, true) ?: [];
                if (($metadata['fingerprint'] ?? null) !== $fingerprint || ($metadata['actor_id'] ?? null) !== $actor['actor_id']) {
                    throw ValidationException::withMessages(['idempotency_key' => 'Key reused for a different materialization.']);
                }
                return (string) $prior->target_id;
            }
            $version = DB::table('claim_versions')->where('id', $versionId)->lockForUpdate()->first();
            if ($version === null || $version->disposition !== 'accepted' || DB::table('claim_versions')->where('supersedes_version_id', $versionId)->exists()) {
                throw ValidationException::withMessages(['claim_version' => 'A current accepted claim version is required.']);
            }
            $claim = DB::table('claims')->where('id', $version->claim_id)->first();
            if ($claim === null || $claim->predicate !== 'provider_institution_relationship') {
                throw ValidationException::withMessages(['claim' => 'Not a Provider–Institution assertion.']);
            }
            $accepted = DB::table('adjudication_decisions')->join('adjudication_cases', 'adjudication_cases.id', '=', 'adjudication_decisions.adjudication_case_id')->where('adjudication_cases.claim_version_id', $versionId)->where('adjudication_decisions.outcome', 'accepted')->where('adjudication_decisions.actor_class', 'human')->exists();
            if ($accepted === false) {
                throw ValidationException::withMessages(['adjudication' => 'Persisted human acceptance is required.']);
            }
            $evidence = DB::table('claim_evidence_links')->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')->join('source_authorizations', 'source_authorizations.id', '=', 'evidence_references.source_authorization_id')->where('claim_evidence_links.claim_version_id', $versionId)->get(['evidence_references.status', 'source_authorizations.revoked_at']);
            if ($evidence->isEmpty()) {
                throw ValidationException::withMessages(['evidence' => 'Admissible evidence is required.']);
            }
            foreach ($evidence as $row) {
                if ($row->status !== 'eligible_for_review' || $row->revoked_at !== null) {
                    throw ValidationException::withMessages(['evidence' => 'Evidence must remain admissible and unrevoked.']);
                }
            }
            $value = json_decode((string) $version->value, true);
            if (is_array($value) === false) {
                throw ValidationException::withMessages(['claim_value' => 'Invalid relationship value.']);
            }
            $from = (string) ($value['from_entity_id'] ?? '');
            $to = (string) ($value['to_entity_id'] ?? '');
            $predicate = (string) ($value['relationship_type'] ?? '');
            $scope = $value['scope'] ?? null;
            $jurisdiction = $value['jurisdiction'] ?? null;
            $this->policy->assertPredicate($predicate);
            $this->policy->assertValidDates($version->valid_from, $version->valid_to);
            if ($claim->subject_entity_id !== $from || $from === $to) {
                throw ValidationException::withMessages(['endpoints' => 'Claim subject must be the distinct Provider source.']);
            }
            $this->assertEndpoints($from, $to, $predicate);
            DB::table('directory_entities')->whereIn('id', [$from, $to])->orderBy('id')->lockForUpdate()->get(['id']);
            $duplicate = DB::table('entity_relationships')->where('from_entity_id', $from)->where('to_entity_id', $to)->where('relationship_type', $predicate);
            $scope === null ? $duplicate->whereNull('scope') : $duplicate->where('scope', $scope);
            $jurisdiction === null ? $duplicate->whereNull('jurisdiction') : $duplicate->where('jurisdiction', $jurisdiction);
            $version->valid_from === null ? $duplicate->whereNull('valid_from') : $duplicate->where('valid_from', $version->valid_from);
            $version->valid_to === null ? $duplicate->whereNull('valid_to') : $duplicate->where('valid_to', $version->valid_to);
            if ($duplicate->exists()) {
                throw ValidationException::withMessages(['relationship' => 'An identical relationship assertion already exists.']);
            }
            $id = (string) Str::uuid();
            $now = now();
            DB::table('entity_relationships')->insert([
                'id' => $id, 'from_entity_id' => $from, 'to_entity_id' => $to, 'relationship_type' => $predicate,
                'scope' => $scope, 'jurisdiction' => $jurisdiction, 'valid_from' => $version->valid_from, 'valid_to' => $version->valid_to,
                'claim_version_id' => $versionId, 'status' => 'active', 'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('audit_events')->insert([
                'id' => (string) Str::uuid(), 'actor_class' => $actor['actor_class'], 'action' => 'provider_institution_relationship_materialized',
                'target_type' => 'entity_relationship', 'target_id' => $id, 'reason_code' => 'accepted_governed_assertion_projection',
                'occurred_at' => $now, 'metadata' => json_encode(['actor_id' => $actor['actor_id'], 'claim_version_id' => $versionId, 'idempotency_key' => $idempotencyKey, 'fingerprint' => $fingerprint], JSON_THROW_ON_ERROR),
                'created_at' => $now, 'updated_at' => $now,
            ]);
            return $id;
        });
    }

    private function assertEndpoints(string $providerId, string $institutionId, string $predicate): void
    {
        $entities = DB::table('directory_entities')->whereIn('id', [$providerId, $institutionId])->get(['id', 'entity_type'])->keyBy('id');
        if ($entities->has($providerId) === false || $entities->has($institutionId) === false) {
            throw ValidationException::withMessages(['endpoints' => 'Both endpoints must exist.']);
        }
        $this->policy->assertEndpoints((string) $entities[$providerId]->entity_type, (string) $entities[$institutionId]->entity_type, $predicate);
    }
}
