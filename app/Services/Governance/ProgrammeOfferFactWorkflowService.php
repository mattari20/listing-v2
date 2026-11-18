<?php

declare(strict_types=1);

namespace App\\Services\\Governance;

use App\\Domain\\Governance\\GovernancePolicy;
use Illuminate\\Support\\Facades\\DB;
use Illuminate\\Support\\Str;
use Illuminate\\Validation\\ValidationException;

final class ProgrammeOfferFactWorkflowService
{
    private const CATEGORIES = ['eligibility', 'deadline', 'fee', 'scholarship'];
    private const STATES = ['known', 'unknown', 'not_stated', 'not_applicable', 'conflicting', 'withdrawn'];

    public function approveFreshnessPolicy(array $actor, string $policyKey, string $category, int $freshnessDays, string $policyVersion, string $idempotencyKey): string
    {
        $this->requireHuman($actor, 'manage_offer_fact_freshness_policy');
        if (preg_match('/^[a-z][a-z0-9_.-]{0,99}$/D', $policyKey) !== 1 ||
            in_array($category, self::CATEGORIES, true) === false || $freshnessDays < 1 ||
            trim($policyVersion) === '' || trim($idempotencyKey) === '') {
            $this->reject('freshness_policy', 'A valid policy key, category, positive day limit, version and idempotency key are required.');
        }

        return DB::transaction(function () use ($actor, $policyKey, $category, $freshnessDays, $policyVersion, $idempotencyKey): string {
            $existing = DB::table('programme_offer_fact_freshness_policies')->where('policy_key', $policyKey)->first();
            if ($existing !== null) {
                if ($existing->category !== $category || (int) $existing->freshness_days !== $freshnessDays ||
                    $existing->owner_actor_id !== $actor['actor_id'] || $existing->policy_version !== $policyVersion ||
                    $existing->idempotency_key !== $idempotencyKey) {
                    $this->reject('freshness_policy', 'Freshness policy keys are immutable; use a new key for a changed policy.');
                }

                return (string) $existing->id;
            }
            $id = (string) Str::uuid();
            $now = now();
            DB::table('programme_offer_fact_freshness_policies')->insert([
                'id' => $id, 'policy_key' => $policyKey, 'idempotency_key' => $idempotencyKey, 'category' => $category,
                'freshness_days' => $freshnessDays, 'owner_actor_id' => $actor['actor_id'],
                'policy_version' => $policyVersion, 'status' => 'approved',
                'approved_at' => $now, 'valid_from' => $now, 'valid_to' => null,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $this->audit($actor, 'programme_offer_fact_freshness_policy_approved', 'programme_offer_fact_freshness_policy', $id, 'owner_approval', [
                'policy_key' => $policyKey, 'category' => $category, 'freshness_days' => $freshnessDays,
                'policy_version' => $policyVersion, 'idempotency_key' => $idempotencyKey,
            ]);

            return $id;
        });
    }

    public function submit(
        array $actor,
        string $offerId,
        string $factKey,
        string $category,
        string $factState,
        mixed $value,
        array $evidenceReferenceIds,
        ?string $observedAt,
        ?string $validFrom,
        ?string $validTo,
        ?string $freshnessPolicyKey,
        ?int $freshnessDays,
        string $idempotencyKey,
        ?string $supersedesVersionId = null,
        ?string $correctionReason = null
    ): string {
        $this->requireHuman($actor, 'submit_offer_fact');
        $this->validateFact($factKey, $category, $factState, $value, $observedAt, $validFrom, $validTo, $freshnessPolicyKey, $freshnessDays);
        $evidenceReferenceIds = array_values(array_unique($evidenceReferenceIds));
        if ($evidenceReferenceIds === [] || trim($idempotencyKey) === '') {
            $this->reject('evidence', 'At least one evidence reference and an idempotency key are required.');
        }

        $fingerprint = hash('sha256', json_encode([
            $offerId, $factKey, $category, $factState, $value, $evidenceReferenceIds,
            $observedAt, $validFrom, $validTo, $freshnessPolicyKey, $freshnessDays,
            $supersedesVersionId, $correctionReason,
        ], JSON_THROW_ON_ERROR));

        return DB::transaction(function () use ($actor, $offerId, $factKey, $category, $factState, $value, $evidenceReferenceIds, $observedAt, $validFrom, $validTo, $freshnessPolicyKey, $freshnessDays, $idempotencyKey, $fingerprint, $supersedesVersionId, $correctionReason): string {
            $priorEvents = DB::table('audit_events')
                ->where('action', 'programme_offer_fact_version_submitted')
                ->where('target_type', 'programme_offer_fact_version')
                ->get(['target_id', 'metadata']);
            foreach ($priorEvents as $event) {
                $metadata = json_decode((string) $event->metadata, true) ?: [];
                if (($metadata['idempotency_key'] ?? null) === $idempotencyKey) {
                    if (($metadata['fingerprint'] ?? null) !== $fingerprint || ($metadata['actor_id'] ?? null) !== $actor['actor_id']) {
                        $this->reject('idempotency_key', 'Key reused for a different offer-fact submission.');
                    }

                    return (string) $event->target_id;
                }
            }

            $offer = DB::table('programme_offers')->where('id', $offerId)->lockForUpdate()->first();
            if ($offer === null || $offer->status !== 'active') {
                $this->reject('offer', 'An active, existing programme offer is required.');
            }

            $fact = DB::table('programme_offer_facts')
                ->where('programme_offer_id', $offerId)
                ->where('fact_key', $factKey)
                ->lockForUpdate()
                ->first();
            if ($fact !== null && $fact->category !== $category) {
                $this->reject('fact_key', 'A fact key cannot change category within an offer.');
            }
            if ($fact === null) {
                $factId = (string) Str::uuid();
                $now = now();
                DB::table('programme_offer_facts')->insert([
                    'id' => $factId, 'programme_offer_id' => $offerId, 'fact_key' => $factKey,
                    'category' => $category, 'created_at' => $now, 'updated_at' => $now,
                ]);
            } else {
                $factId = (string) $fact->id;
            }

            if (($supersedesVersionId === null) !== ($correctionReason === null) ||
                ($correctionReason !== null && trim($correctionReason) === '')) {
                $this->reject('correction', 'A superseded version and correction reason must be supplied together.');
            }
            if ($supersedesVersionId !== null) {
                $priorVersion = DB::table('programme_offer_fact_versions')->where('id', $supersedesVersionId)->lockForUpdate()->first();
                if ($priorVersion === null || $priorVersion->programme_offer_fact_id !== $factId ||
                    $priorVersion->disposition !== 'accepted' ||
                    DB::table('programme_offer_fact_versions')->where('supersedes_version_id', $supersedesVersionId)->exists()) {
                    $this->reject('correction', 'Only the current accepted version of this exact offer fact can be superseded.');
                }
            }

            if ($factState === 'known') {
                $approvedPolicy = DB::table('programme_offer_fact_freshness_policies')
                    ->where('policy_key', $freshnessPolicyKey)
                    ->where('category', $category)
                    ->where('freshness_days', $freshnessDays)
                    ->where('status', 'approved')
                    ->where('approved_at', '<=', now())
                    ->where(function ($query): void {
                        $query->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                    })
                    ->where(function ($query): void {
                        $query->whereNull('valid_to')->orWhere('valid_to', '>', now());
                    })
                    ->first();
                if ($approvedPolicy === null) {
                    $this->reject('freshness_policy', 'A matching current owner-approved field-specific freshness policy is required.');
                }
            }

            $evidenceRows = DB::table('evidence_references')
                ->whereIn('id', $evidenceReferenceIds)
                ->get(['id', 'status', 'source_authorization_id']);
            if ($evidenceRows->count() !== count($evidenceReferenceIds) ||
                (new GovernancePolicy)->canAcceptClaim($evidenceRows->pluck('status')->all()) === false) {
                $this->reject('evidence', 'Every evidence reference must exist and be eligible for review.');
            }

            $versionNumber = (int) DB::table('programme_offer_fact_versions')
                ->where('programme_offer_fact_id', $factId)->max('version_number') + 1;
            $versionId = (string) Str::uuid();
            $now = now();
            DB::table('programme_offer_fact_versions')->insert([
                'id' => $versionId, 'programme_offer_fact_id' => $factId,
                'version_number' => $versionNumber,
                'idempotency_key' => $idempotencyKey,
                'value' => $value === null ? null : json_encode($value, JSON_THROW_ON_ERROR),
                'fact_state' => $factState, 'disposition' => 'proposed',
                'observed_at' => $observedAt, 'valid_from' => $validFrom, 'valid_to' => $validTo,
                'freshness_policy_key' => $freshnessPolicyKey, 'freshness_days' => $freshnessDays,
                'recorded_at' => $now, 'supersedes_version_id' => $supersedesVersionId, 'correction_reason' => $correctionReason,
                'created_at' => $now, 'updated_at' => $now,
            ]);

            foreach ($evidenceReferenceIds as $evidenceId) {
                DB::table('programme_offer_fact_evidence_links')->insert([
                    'id' => (string) Str::uuid(), 'fact_version_id' => $versionId,
                    'evidence_reference_id' => $evidenceId, 'relationship_type' => 'supports',
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }

            $this->audit($actor, 'programme_offer_fact_version_submitted', 'programme_offer_fact_version', $versionId, 'offer_fact_submitted', [
                'offer_id' => $offerId, 'fact_id' => $factId, 'idempotency_key' => $idempotencyKey,
                'fingerprint' => $fingerprint, 'evidence_count' => count($evidenceReferenceIds),
            ]);

            return $versionId;
        });
    }

    public function openAdjudicationCase(array $actor, string $factVersionId, string $idempotencyKey): string
    {
        $this->requireHuman($actor, 'open_adjudication');

        return DB::transaction(function () use ($actor, $factVersionId, $idempotencyKey): string {
            $version = DB::table('programme_offer_fact_versions')->where('id', $factVersionId)->first();
            if ($version === null || $version->disposition !== 'proposed' || trim($idempotencyKey) === '') {
                $this->reject('fact_version', 'A proposed offer-fact version and idempotency key are required.');
            }
            $existing = DB::table('programme_offer_fact_adjudication_cases')->where('idempotency_key', $idempotencyKey)->first();
            if ($existing !== null) {
                if ($existing->fact_version_id !== $factVersionId || $existing->opened_by_actor_id !== $actor['actor_id']) {
                    $this->reject('idempotency_key', 'Key reused for a different adjudication command.');
                }

                return (string) $existing->id;
            }
            $submitter = $this->submissionActor($factVersionId);
            if ($submitter === $actor['actor_id']) {
                $this->reject('separation_of_duties', 'The fact submitter cannot open its adjudication case.');
            }
            $id = (string) Str::uuid();
            $now = now();
            DB::table('programme_offer_fact_adjudication_cases')->insert([
                'id' => $id, 'fact_version_id' => $factVersionId, 'status' => 'open',
                'opened_by_actor_id' => $actor['actor_id'], 'idempotency_key' => $idempotencyKey,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $this->audit($actor, 'programme_offer_fact_adjudication_opened', 'programme_offer_fact_adjudication_case', $id, 'case_opened', [
                'fact_version_id' => $factVersionId,
            ]);

            return $id;
        });
    }

    public function decideAdjudication(array $actor, string $caseId, string $outcome, string $rationaleCode, string $rationale, string $policyVersion): string
    {
        $this->requireHuman($actor, 'adjudicate_claim');

        return DB::transaction(function () use ($actor, $caseId, $outcome, $rationaleCode, $rationale, $policyVersion): string {
            $case = DB::table('programme_offer_fact_adjudication_cases')->where('id', $caseId)->lockForUpdate()->first();
            if ($case === null || $case->status !== 'open') {
                $this->reject('case', 'An open offer-fact adjudication case is required.');
            }
            if (! in_array($outcome, ['accepted', 'rejected', 'disputed', 'needs_evidence', 'deferred'], true) ||
                trim($rationaleCode) === '' || trim($rationale) === '' || trim($policyVersion) === '') {
                $this->reject('decision', 'A supported outcome, rationale and policy version are required.');
            }
            if ($case->opened_by_actor_id === $actor['actor_id'] || $this->submissionActor($case->fact_version_id) === $actor['actor_id']) {
                $this->reject('separation_of_duties', 'The submitter and case opener cannot adjudicate this fact.');
            }

            $evidence = $this->evidenceRows($case->fact_version_id);
            if ($outcome === 'accepted' && (new GovernancePolicy)->canAcceptClaim($evidence->pluck('status')->all()) === false) {
                $this->reject('evidence', 'An offer fact cannot be accepted without admissible evidence.');
            }
            foreach ($this->evidenceActorIds($case->fact_version_id) as $evidenceActorId) {
                $authorization = (new GovernancePolicy)->authorizeAdjudication($actor, $evidenceActorId, true);
                if ($authorization['allowed'] === false) {
                    $this->reject('actor', $authorization['reason']);
                }
            }

            $id = (string) Str::uuid();
            $now = now();
            DB::table('programme_offer_fact_adjudication_decisions')->insert([
                'id' => $id, 'adjudication_case_id' => $caseId, 'outcome' => $outcome,
                'actor_id' => $actor['actor_id'], 'actor_class' => 'human',
                'rationale_code' => $rationaleCode, 'rationale' => $rationale,
                'policy_version' => $policyVersion, 'decided_at' => $now,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('programme_offer_fact_adjudication_cases')->where('id', $caseId)->update(['status' => 'decided', 'updated_at' => $now]);
            DB::table('programme_offer_fact_versions')->where('id', $case->fact_version_id)->update([
                'disposition' => $outcome === 'accepted' ? 'accepted' : ($outcome === 'rejected' ? 'rejected' : 'proposed'),
                'updated_at' => $now,
            ]);
            $this->audit($actor, 'programme_offer_fact_adjudication_decided', 'programme_offer_fact_adjudication_decision', $id, $rationaleCode, [
                'outcome' => $outcome, 'case_id' => $caseId, 'fact_version_id' => $case->fact_version_id,
            ]);

            return $id;
        });
    }

    public function authorizePublication(array $actor, string $factVersionId, string $adjudicationDecisionId, string $surface, string $audience, string $policyVersion, string $idempotencyKey): string
    {
        $this->requireHuman($actor, 'authorize_publication');

        return DB::transaction(function () use ($actor, $factVersionId, $adjudicationDecisionId, $surface, $audience, $policyVersion, $idempotencyKey): string {
            $existing = DB::table('programme_offer_fact_publication_decisions')->where('idempotency_key', $idempotencyKey)->first();
            if ($existing !== null) {
                if ($existing->fact_version_id !== $factVersionId || $existing->actor_id !== $actor['actor_id'] ||
                    $existing->adjudication_decision_id !== $adjudicationDecisionId || $existing->surface !== $surface ||
                    $existing->audience !== $audience || $existing->policy_version !== $policyVersion) {
                    $this->reject('idempotency_key', 'Key reused for a different offer-fact publication command.');
                }

                return (string) $existing->id;
            }

            $version = DB::table('programme_offer_fact_versions')->where('id', $factVersionId)->lockForUpdate()->first();
            $decision = DB::table('programme_offer_fact_adjudication_decisions')
                ->where('id', $adjudicationDecisionId)->where('outcome', 'accepted')->first();
            if ($version === null || $version->disposition !== 'accepted' || $decision === null ||
                DB::table('programme_offer_fact_adjudication_cases')->where('id', $decision->adjudication_case_id)->where('fact_version_id', $factVersionId)->exists() === false ||
                DB::table('programme_offer_fact_versions')->where('supersedes_version_id', $factVersionId)->exists()) {
                $this->reject('adjudication', 'A current accepted human adjudication is required.');
            }
            if (! in_array($version->fact_state, ['known', 'unknown', 'not_stated', 'not_applicable', 'conflicting'], true)) {
                $this->reject('fact_state', 'Withdrawn facts cannot be published.');
            }
            if ($version->fact_state === 'known' && $version->freshness_policy_key !== null &&
                $version->freshness_days !== null && $version->observed_at !== null &&
                now()->greaterThanOrEqualTo(now()->parse($version->observed_at)->addDays((int) $version->freshness_days))) {
                $this->reject('freshness', 'A stale fact cannot be newly published as current.');
            }
            if ($version->fact_state === 'known' && ($version->freshness_policy_key === null ||
                $version->freshness_days === null || $version->observed_at === null)) {
                $this->reject('freshness', 'A known public fact requires an explicit field-specific freshness policy and observation time.');
            }

            $evidence = $this->evidenceRows($factVersionId);
            if ($evidence->isEmpty() || (new GovernancePolicy)->canAcceptClaim($evidence->pluck('status')->all()) === false) {
                $this->reject('evidence', 'Current admissible evidence is required for publication.');
            }
            foreach ($evidence as $item) {
                $authorization = (array) DB::table('source_authorizations')->where('id', $item->source_authorization_id)->first();
                $scope = (new GovernancePolicy)->authorizeSourceAction($authorization, 'publication', [
                    'purpose' => 'directory_publication', 'method' => 'approved_projection', 'territory' => 'synthetic',
                ]);
                if ($scope['allowed'] === false) {
                    $this->reject('source_authorization', $scope['reason']);
                }
            }
            $evidenceActorIds = $this->evidenceActorIds($factVersionId);
            $policy = (new GovernancePolicy)->authorizePublication($actor, [
                'outcome' => $decision->outcome, 'claim_disposition' => $version->disposition,
                'actor_id' => $decision->actor_id, 'evidence_admissible' => true,
                'version_current' => true, 'surface' => $surface, 'audience' => $audience,
                'policy_version' => $policyVersion,
            ], $evidenceActorIds);
            if ($policy['allowed'] === false) {
                $this->reject('publication', $policy['reason']);
            }
            if ($surface !== 'directory' || $audience !== 'anonymous' || trim($idempotencyKey) === '') {
                $this->reject('publication', 'Only the anonymous public directory surface is supported in RCV-B02.');
            }

            $fact = DB::table('programme_offer_facts')->where('id', $version->programme_offer_fact_id)->first();
            $offer = $fact === null ? null : DB::table('programme_offers')->where('id', $fact->programme_offer_id)->first();
            if ($fact === null || $offer === null || $offer->status !== 'active') {
                $this->reject('offer', 'The associated programme offer must remain active.');
            }

            $id = (string) Str::uuid();
            $now = now();
            DB::table('programme_offer_fact_publication_decisions')->insert([
                'id' => $id, 'fact_version_id' => $factVersionId, 'decision' => 'approved',
                'surface' => $surface, 'audience' => $audience, 'actor_id' => $actor['actor_id'],
                'actor_class' => 'human', 'adjudication_decision_id' => $adjudicationDecisionId,
                'policy_version' => $policyVersion, 'idempotency_key' => $idempotencyKey,
                'reason_code' => 'human_offer_fact_publication_approval', 'decided_at' => $now,
                'created_at' => $now, 'updated_at' => $now,
            ]);

            $payload = [
                'offer_id' => $offer->id, 'admission_cycle' => $offer->admission_cycle,
                'fact_id' => $fact->id, 'fact_version_id' => $factVersionId,
                'fact_key' => $fact->fact_key, 'category' => $fact->category,
                'fact_state' => $version->fact_state,
                'value' => $version->value === null ? null : json_decode($version->value, true, 512, JSON_THROW_ON_ERROR),
                'observed_at' => $version->observed_at, 'valid_from' => $version->valid_from,
                'valid_to' => $version->valid_to, 'freshness_policy_key' => $version->freshness_policy_key,
                'freshness_days' => $version->freshness_days, 'surface' => $surface, 'audience' => $audience,
            ];
            $snapshotVersion = (int) DB::table('programme_offer_fact_publication_snapshots')
                ->where('fact_version_id', $factVersionId)->max('snapshot_version') + 1;
            $snapshotId = (string) Str::uuid();
            $digest = hash('sha256', json_encode($payload, JSON_THROW_ON_ERROR));
            DB::table('programme_offer_fact_publication_snapshots')->insert([
                'id' => $snapshotId, 'publication_decision_id' => $id, 'fact_version_id' => $factVersionId,
                'snapshot_version' => $snapshotVersion, 'payload' => json_encode($payload, JSON_THROW_ON_ERROR),
                'payload_digest' => $digest, 'surface' => $surface, 'audience' => $audience,
                'status' => 'projected', 'created_at' => $now,
            ]);
            $projectionKey = $factVersionId.':'.$surface.':'.$audience;
            DB::table('programme_offer_fact_public_projections')->updateOrInsert(
                ['projection_key' => $projectionKey],
                ['id' => (string) Str::uuid(), 'publication_snapshot_id' => $snapshotId,
                    'surface' => $surface, 'audience' => $audience, 'status' => 'approved',
                    'projected_at' => $now, 'created_at' => $now, 'updated_at' => $now]
            );
            $this->audit($actor, 'programme_offer_fact_publication_authorized', 'programme_offer_fact_publication_decision', $id, 'human_publication_approval', [
                'snapshot_id' => $snapshotId, 'payload_digest' => $digest,
            ]);

            return $id;
        });
    }

    public function withdrawFactVersion(array $actor, string $factVersionId, string $reasonCode, string $rationale): void
    {
        $this->requireHuman($actor, 'withdraw_claim');
        if (trim($reasonCode) === '' || trim($rationale) === '') {
            $this->reject('withdrawal', 'A reason code and rationale are required.');
        }

        DB::transaction(function () use ($actor, $factVersionId, $reasonCode, $rationale): void {
            $version = DB::table('programme_offer_fact_versions')->where('id', $factVersionId)->lockForUpdate()->first();
            if ($version === null || $version->disposition === 'withdrawn') {
                $this->reject('fact_version', 'A current, non-withdrawn offer-fact version is required.');
            }
            $now = now();
            DB::table('programme_offer_fact_versions')->where('id', $factVersionId)->update([
                'disposition' => 'withdrawn', 'fact_state' => 'withdrawn', 'updated_at' => $now,
            ]);
            $snapshotIds = DB::table('programme_offer_fact_publication_snapshots')
                ->where('fact_version_id', $factVersionId)->pluck('id');
            DB::table('programme_offer_fact_publication_snapshots')->whereIn('id', $snapshotIds)->update(['status' => 'suppressed']);
            DB::table('programme_offer_fact_public_projections')->whereIn('publication_snapshot_id', $snapshotIds)
                ->update(['status' => 'suppressed', 'updated_at' => $now]);
            $this->audit($actor, 'programme_offer_fact_version_withdrawn', 'programme_offer_fact_version', $factVersionId, $reasonCode, [
                'rationale' => $rationale,
            ]);
        });
    }

    public function suppressPublication(array $actor, string $snapshotId, string $reasonCode, string $rationale): void
    {
        $this->requireHuman($actor, 'suppress_publication');
        if (trim($reasonCode) === '' || trim($rationale) === '') {
            $this->reject('suppression', 'A reason code and rationale are required.');
        }

        DB::transaction(function () use ($actor, $snapshotId, $reasonCode, $rationale): void {
            $snapshot = DB::table('programme_offer_fact_publication_snapshots')->where('id', $snapshotId)->lockForUpdate()->first();
            if ($snapshot === null) {
                $this->reject('snapshot', 'Publication snapshot was not found.');
            }
            $now = now();
            DB::table('programme_offer_fact_publication_suppressions')->insert([
                'id' => (string) Str::uuid(), 'publication_snapshot_id' => $snapshotId,
                'reason_code' => $reasonCode, 'rationale' => $rationale,
                'actor_id' => $actor['actor_id'], 'actor_class' => 'human',
                'status' => 'active', 'suppressed_at' => $now, 'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('programme_offer_fact_publication_snapshots')->where('id', $snapshotId)->update(['status' => 'suppressed']);
            DB::table('programme_offer_fact_public_projections')->where('publication_snapshot_id', $snapshotId)->update(['status' => 'suppressed', 'updated_at' => $now]);
            $this->audit($actor, 'programme_offer_fact_publication_suppressed', 'programme_offer_fact_publication_snapshot', $snapshotId, $reasonCode, [
                'rationale' => $rationale,
            ]);
        });
    }

    private function validateFact(string $factKey, string $category, string $state, mixed $value, ?string $observedAt, ?string $validFrom, ?string $validTo, ?string $freshnessPolicyKey, ?int $freshnessDays): void
    {
        if (preg_match('/^[a-z][a-z0-9_]{0,99}$/D', $factKey) !== 1 || in_array($category, self::CATEGORIES, true) === false || in_array($state, self::STATES, true) === false) {
            $this->reject('fact', 'A valid fact key, supported category and fact state are required.');
        }
        if (($state === 'known') !== ($value !== null)) {
            $this->reject('value', 'Known facts require a value; non-known states must not carry an asserted value.');
        }
        if ($state === 'known') {
            if (is_array($value) === false) {
                $this->reject('value', 'Known fact values must be structured JSON objects.');
            }
            if ($category === 'deadline' && (! is_string($value['date'] ?? null) || $this->validDate($value['date']) === false)) {
                $this->reject('deadline', 'Deadline facts require a valid YYYY-MM-DD date.');
            }
            if ($category === 'fee' && ((! is_string($value['amount'] ?? null) && ! is_int($value['amount'] ?? null)) ||
                preg_match('/^(?:0|[1-9][0-9]{0,11})(?:\\.[0-9]{1,2})?$/D', (string) ($value['amount'] ?? '')) !== 1 ||
                ! is_string($value['currency'] ?? null) || preg_match('/^[A-Z]{3}$/D', $value['currency']) !== 1 ||
                ! is_string($value['component'] ?? null) || trim($value['component']) === '')) {
                $this->reject('fee', 'Fee facts require a bounded amount, ISO-style currency code and component label.');
            }
            if (in_array($category, ['eligibility', 'scholarship'], true) &&
                (! is_string($value['text'] ?? null) || trim($value['text']) === '' || mb_strlen($value['text']) > 2000)) {
                $this->reject('value', 'Eligibility and scholarship facts require bounded human-readable text.');
            }
        }
        foreach (['valid_from' => $validFrom, 'valid_to' => $validTo] as $field => $date) {
            if ($date !== null && $this->validDate($date) === false) {
                $this->reject($field, 'A valid YYYY-MM-DD calendar date is required.');
            }
        }
        if ($validFrom !== null && $validTo !== null && $validTo < $validFrom) {
            $this->reject('validity', 'The validity end date cannot precede its start date.');
        }
        if ($observedAt !== null && strtotime($observedAt) === false) {
            $this->reject('observed_at', 'A valid observation timestamp is required.');
        }
        if (($freshnessPolicyKey === null) !== ($freshnessDays === null) ||
            ($freshnessDays !== null && $freshnessDays < 1) ||
            ($freshnessPolicyKey !== null && preg_match('/^[a-z][a-z0-9_.-]{0,99}$/D', $freshnessPolicyKey) !== 1)) {
            $this->reject('freshness', 'Freshness policy key and positive day limit must be supplied together.');
        }
        if ($state === 'known' && ($observedAt === null || $freshnessPolicyKey === null || $freshnessDays === null)) {
            $this->reject('freshness', 'Known facts require an observation timestamp and explicit field-specific freshness policy.');
        }
    }

    private function validDate(string $date): bool
    {
        return preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/D', $date, $parts) === 1 &&
            checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1]);
    }

    private function evidenceRows(string $versionId): \Illuminate\Support\Collection
    {
        return DB::table('programme_offer_fact_evidence_links')
            ->join('evidence_references', 'evidence_references.id', '=', 'programme_offer_fact_evidence_links.evidence_reference_id')
            ->where('programme_offer_fact_evidence_links.fact_version_id', $versionId)
            ->get(['evidence_references.id', 'evidence_references.status', 'evidence_references.source_authorization_id']);
    }

    private function evidenceActorIds(string $versionId): array
    {
        $ids = [];
        foreach ($this->evidenceRows($versionId) as $evidence) {
            $event = DB::table('audit_events')->where('target_type', 'evidence_reference')
                ->where('target_id', $evidence->id)->where('action', 'evidence_reference_registered')->first(['metadata']);
            $metadata = $event === null ? [] : (json_decode((string) $event->metadata, true) ?: []);
            if (is_string($metadata['actor_id'] ?? null) && $metadata['actor_id'] !== '') {
                $ids[] = $metadata['actor_id'];
            }
        }

        return array_values(array_unique($ids));
    }

    private function submissionActor(string $versionId): string
    {
        $event = DB::table('audit_events')->where('target_type', 'programme_offer_fact_version')
            ->where('target_id', $versionId)->where('action', 'programme_offer_fact_version_submitted')->first(['metadata']);
        $metadata = $event === null ? [] : (json_decode((string) $event->metadata, true) ?: []);

        return (string) ($metadata['actor_id'] ?? '');
    }

    private function requireHuman(array $actor, string $capability): void
    {
        $result = (new GovernancePolicy)->requireCapability($actor, $capability);
        if ($result['allowed'] === false || ($actor['actor_class'] ?? null) !== 'human') {
            $this->reject('actor', 'A human actor with the required capability is required: '.$capability.'.');
        }
    }

    private function audit(array $actor, string $action, string $targetType, string $targetId, string $reasonCode, array $metadata): void
    {
        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(), 'actor_class' => $actor['actor_class'], 'action' => $action,
            'target_type' => $targetType, 'target_id' => $targetId, 'reason_code' => $reasonCode,
            'occurred_at' => now(), 'metadata' => json_encode($metadata + ['actor_id' => $actor['actor_id']], JSON_THROW_ON_ERROR),
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    private function reject(string $field, string $message): never
    {
        throw ValidationException::withMessages([$field => $message]);
    }
}
