<?php

declare(strict_types=1);

namespace App\Services\Governance;

use App\Domain\Governance\GovernancePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class PersistedConflictAndRollbackService
{
    /**
     * Persist a conflict only when distinct assertions for the same claim
     * disagree over an overlapping valid-time interval. Recorded time is
     * retained as provenance; it never selects a winner.
     *
     * @param array<int, string> $claimVersionIds
     */
    public function evaluateTemporalConflict(array $actor, array $claimVersionIds, string $idempotencyKey): ?string
    {
        $this->requireHumanCapability($actor, 'evaluate_conflicts');
        $ids = array_values(array_unique($claimVersionIds));
        sort($ids);
        if (count($ids) < 2 || trim($idempotencyKey) === '') {
            $this->reject('conflict', 'At least two distinct claim versions and an idempotency key are required.');
        }

        return DB::transaction(function () use ($actor, $ids, $idempotencyKey): ?string {
            $versions = DB::table('claim_versions')->whereIn('id', $ids)->orderBy('id')->get();
            if ($versions->count() !== count($ids)) {
                $this->reject('claim_versions', 'Every conflict candidate must exist.');
            }
            $claimIds = $versions->pluck('claim_id')->unique()->values();
            if ($claimIds->count() !== 1) {
                $this->reject('claim_versions', 'Conflict candidates must belong to the same claim.');
            }

            $values = $versions->map(fn ($version) => hash('sha256', (string) $version->value))->unique();
            if ($values->count() < 2) {
                $this->reject('claim_versions', 'Identical assertions do not form a conflict.');
            }

            $overlap = true;
            foreach ($versions as $index => $left) {
                if ($left->valid_from !== null && $left->valid_to !== null && $left->valid_to < $left->valid_from) {
                    $this->reject('validity', 'A conflict candidate has an invalid valid-time interval.');
                }
                foreach ($versions->slice($index + 1) as $right) {
                    if ($right->valid_from !== null && $right->valid_to !== null && $right->valid_to < $right->valid_from) {
                        $this->reject('validity', 'A conflict candidate has an invalid valid-time interval.');
                    }
                    $overlap = $overlap && $this->intervalsOverlap(
                        $left->valid_from,
                        $left->valid_to,
                        $right->valid_from,
                        $right->valid_to,
                    );
                }
            }

            if (! $overlap) {
                return null;
            }

            $fingerprint = hash('sha256', json_encode([
                'claim_id' => (string) $claimIds[0],
                'candidates' => $versions->map(fn ($version) => [
                    'id' => (string) $version->id,
                    'value_digest' => hash('sha256', (string) $version->value),
                    'valid_from' => $version->valid_from,
                    'valid_to' => $version->valid_to,
                    'recorded_at' => (string) $version->recorded_at,
                ])->values()->all(),
            ], JSON_THROW_ON_ERROR));

            $existing = DB::table('claim_conflicts')->where('idempotency_key', $idempotencyKey)->first();
            if ($existing !== null) {
                if ($existing->fingerprint !== $fingerprint) {
                    $this->reject('idempotency_key', 'Conflict idempotency key was reused for different candidates.');
                }

                return (string) $existing->id;
            }

            $conflictId = (string) Str::uuid();
            $recordedTimes = $versions->pluck('recorded_at')->unique();
            $kind = $recordedTimes->count() > 1 ? 'recorded_time_valid_time_overlap' : 'overlapping_valid_time';
            $now = now();
            DB::table('claim_conflicts')->insert([
                'id' => $conflictId,
                'claim_id' => $claimIds[0],
                'conflict_kind' => $kind,
                'status' => 'open',
                'fingerprint' => $fingerprint,
                'idempotency_key' => $idempotencyKey,
                'evaluated_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($versions as $version) {
                DB::table('claim_conflict_candidates')->insert([
                    'id' => (string) Str::uuid(),
                    'claim_conflict_id' => $conflictId,
                    'claim_version_id' => $version->id,
                    'valid_from' => $version->valid_from,
                    'valid_to' => $version->valid_to,
                    'recorded_at' => $version->recorded_at,
                    'value_digest' => hash('sha256', (string) $version->value),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $this->audit($actor, 'claim_conflict_opened', 'claim_conflict', $conflictId, 'temporal_conflict_detected', [
                'candidate_version_ids' => $ids,
                'conflict_kind' => $kind,
                'winner_selected' => false,
            ]);

            return $conflictId;
        });
    }

    public function resolveConflict(
        array $actor,
        string $conflictId,
        string $selectedCandidateVersionId,
        string $adjudicationDecisionId,
        string $rationale,
    ): void {
        $this->requireHumanCapability($actor, 'resolve_conflict');
        if (trim($rationale) === '') {
            $this->reject('rationale', 'A human resolution rationale is required.');
        }

        DB::transaction(function () use ($actor, $conflictId, $selectedCandidateVersionId, $adjudicationDecisionId, $rationale): void {
            $conflict = DB::table('claim_conflicts')->where('id', $conflictId)->lockForUpdate()->first();
            if ($conflict === null || $conflict->status !== 'open') {
                $this->reject('conflict', 'Only an open conflict can be resolved.');
            }
            $candidate = DB::table('claim_conflict_candidates')
                ->where('claim_conflict_id', $conflictId)
                ->where('claim_version_id', $selectedCandidateVersionId)->first();
            $decision = DB::table('adjudication_decisions')
                ->join('adjudication_cases', 'adjudication_cases.id', '=', 'adjudication_decisions.adjudication_case_id')
                ->where('adjudication_decisions.id', $adjudicationDecisionId)
                ->where('adjudication_cases.claim_version_id', $selectedCandidateVersionId)
                ->first(['adjudication_decisions.*']);
            if ($candidate === null || $decision === null || $decision->outcome !== 'accepted') {
                $this->reject('adjudication', 'The selected candidate requires its own persisted accepted human adjudication.');
            }
            if ($decision->actor_id === $actor['actor_id']) {
                $this->reject('separation_of_duties', 'The conflict resolver must differ from the adjudicator.');
            }

            $now = now();
            DB::table('claim_conflicts')->where('id', $conflictId)->update([
                'status' => 'resolved',
                'resolved_candidate_version_id' => $selectedCandidateVersionId,
                'adjudication_decision_id' => $adjudicationDecisionId,
                'resolved_by_actor_id' => $actor['actor_id'],
                'resolution_rationale' => $rationale,
                'resolved_at' => $now,
                'updated_at' => $now,
            ]);
            $this->audit($actor, 'claim_conflict_resolved', 'claim_conflict', $conflictId, 'human_adjudication', [
                'selected_candidate_version_id' => $selectedCandidateVersionId,
                'adjudication_decision_id' => $adjudicationDecisionId,
                'rationale' => $rationale,
            ]);
        });
    }

    public function rollbackPublication(
        array $actor,
        string $targetSnapshotId,
        string $policyVersion,
        string $reasonCode,
        string $idempotencyKey,
    ): string {
        $this->requireHumanCapability($actor, 'rollback_publication');
        if (trim($policyVersion) === '' || trim($reasonCode) === '' || trim($idempotencyKey) === '') {
            $this->reject('rollback', 'Policy version, reason and idempotency key are required.');
        }

        return DB::transaction(function () use ($actor, $targetSnapshotId, $policyVersion, $reasonCode, $idempotencyKey): string {
            $existing = DB::table('publication_rollbacks')->where('idempotency_key', $idempotencyKey)->first();
            if ($existing !== null) {
                if ($existing->target_snapshot_id !== $targetSnapshotId || $existing->actor_id !== $actor['actor_id']
                    || $existing->policy_version !== $policyVersion || $existing->reason_code !== $reasonCode) {
                    $this->reject('idempotency_key', 'Rollback idempotency key was reused for a different command.');
                }

                return (string) $existing->id;
            }

            $target = DB::table('publication_snapshots')->where('id', $targetSnapshotId)->lockForUpdate()->first();
            if ($target === null || $target->status === 'suppressed') {
                $this->reject('target_snapshot', 'The target snapshot is missing or suppressed.');
            }
            $targetDecision = DB::table('publication_decisions')->where('id', $target->publication_decision_id)->first();
            if ($targetDecision === null || $targetDecision->decision !== 'approved') {
                $this->reject('target_snapshot', 'Rollback target must have a prior approved publication decision.');
            }

            $projection = DB::table('public_projections')
                ->where('projection_key', $target->claim_version_id.':'.$target->surface.':'.$target->audience)
                ->lockForUpdate()->first();
            if ($projection === null || $projection->status !== 'approved' || $projection->publication_snapshot_id === $targetSnapshotId) {
                $this->reject('projection', 'A different currently approved snapshot must exist for this publication scope.');
            }
            $current = DB::table('publication_snapshots')->where('id', $projection->publication_snapshot_id)->first();
            if ($current === null || $current->claim_version_id !== $target->claim_version_id
                || $current->surface !== $target->surface || $current->audience !== $target->audience
                || (int) $target->snapshot_version >= (int) $current->snapshot_version) {
                $this->reject('snapshot_lineage', 'Rollback target must be an older snapshot in the same publication lineage.');
            }
            if ($targetDecision->actor_id === $actor['actor_id']) {
                $this->reject('separation_of_duties', 'Rollback authority must differ from the original publisher.');
            }

            $this->assertCurrentPublicationEligibility((string) $target->claim_version_id);
            $rollbackId = (string) Str::uuid();
            $now = now();
            DB::table('publication_rollbacks')->insert([
                'id' => $rollbackId,
                'current_snapshot_id' => $current->id,
                'target_snapshot_id' => $targetSnapshotId,
                'actor_id' => $actor['actor_id'],
                'actor_class' => $actor['actor_class'],
                'policy_version' => $policyVersion,
                'reason_code' => $reasonCode,
                'idempotency_key' => $idempotencyKey,
                'rolled_back_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('governance_outbox')->insert([
                'id' => (string) Str::uuid(),
                'event_type' => 'publication.snapshot.rollback',
                'aggregate_type' => 'publication_rollback',
                'aggregate_id' => $rollbackId,
                'payload' => json_encode([
                    'rollback_id' => $rollbackId,
                    'current_snapshot_id' => (string) $current->id,
                    'target_snapshot_id' => $targetSnapshotId,
                ], JSON_THROW_ON_ERROR),
                'idempotency_key' => 'rollback:'.$rollbackId,
                'status' => 'pending',
                'attempts' => 0,
                'available_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $this->audit($actor, 'publication_rollback_authorized', 'publication_rollback', $rollbackId, $reasonCode, [
                'current_snapshot_id' => (string) $current->id,
                'target_snapshot_id' => $targetSnapshotId,
                'policy_version' => $policyVersion,
            ]);

            return $rollbackId;
        });
    }

    /**
     * Called by the existing leased outbox worker inside its transaction.
     * The projection is moved only if the projection still points at the
     * snapshot captured by the rollback command and current policy remains valid.
     */
    public function applyRollbackOutboxEvent(string $rollbackId): void
    {
        $rollback = DB::table('publication_rollbacks')->where('id', $rollbackId)->first();
        if ($rollback === null) {
            throw new \RuntimeException('Rollback record is missing.');
        }
        $target = DB::table('publication_snapshots')->where('id', $rollback->target_snapshot_id)->first();
        if ($target === null || $target->status === 'suppressed') {
            throw new \RuntimeException('Rollback target is no longer eligible.');
        }
        $projectionKey = $target->claim_version_id.':'.$target->surface.':'.$target->audience;
        $projection = DB::table('public_projections')->where('projection_key', $projectionKey)->lockForUpdate()->first();
        if ($projection === null || $projection->publication_snapshot_id !== $rollback->current_snapshot_id) {
            throw new \RuntimeException('Projection changed after rollback authorization; stale rollback refused.');
        }
        $this->assertCurrentPublicationEligibility((string) $target->claim_version_id);

        DB::table('public_projections')->where('id', $projection->id)->update([
            'publication_snapshot_id' => $target->id,
            'status' => 'approved',
            'surface' => $target->surface,
            'audience' => $target->audience,
            'is_deeni_madaris' => false,
            'projected_at' => now(),
            'updated_at' => now(),
        ]);
        $actor = ['actor_id' => $rollback->actor_id, 'actor_class' => $rollback->actor_class];
        $this->audit($actor, 'publication_rollback_projected', 'publication_rollback', $rollbackId, $rollback->reason_code, [
            'target_snapshot_id' => (string) $target->id,
        ]);
    }

    private function assertCurrentPublicationEligibility(string $claimVersionId): void
    {
        $version = DB::table('claim_versions')->where('id', $claimVersionId)->first();
        $evidenceRows = DB::table('claim_evidence_links')
            ->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')
            ->where('claim_evidence_links.claim_version_id', $claimVersionId)
            ->get(['evidence_references.status', 'evidence_references.source_authorization_id']);
        if ($version === null || $version->disposition !== 'accepted'
            || DB::table('claim_versions')->where('supersedes_version_id', $claimVersionId)->exists()
            || $evidenceRows->isEmpty()
            || ! (new GovernancePolicy)->canAcceptClaim($evidenceRows->pluck('status')->all())) {
            $this->reject('rollback_eligibility', 'Current claim and evidence policy no longer permits publication.');
        }

        foreach ($evidenceRows as $evidence) {
            $authorization = (array) DB::table('source_authorizations')->where('id', $evidence->source_authorization_id)->first();
            $scope = (new GovernancePolicy)->authorizeSourceAction($authorization, 'publication', [
                'purpose' => 'directory_publication',
                'method' => 'approved_projection',
                'territory' => 'synthetic',
            ]);
            if ($scope['allowed'] === false) {
                $this->reject('rollback_eligibility', $scope['reason']);
            }
        }
    }

    private function intervalsOverlap(?string $aFrom, ?string $aTo, ?string $bFrom, ?string $bTo): bool
    {
        $aStartsBeforeBEnds = $bTo === null || $aFrom === null || $aFrom <= $bTo;
        $bStartsBeforeAEnds = $aTo === null || $bFrom === null || $bFrom <= $aTo;

        return $aStartsBeforeBEnds && $bStartsBeforeAEnds;
    }

    private function requireHumanCapability(array $actor, string $capability): void
    {
        if (($actor['actor_class'] ?? null) !== 'human') {
            $this->reject('actor', 'This governance action requires a human actor.');
        }
        $result = (new GovernancePolicy)->requireCapability($actor, $capability);
        if ($result['allowed'] === false) {
            $this->reject('actor', $result['reason']);
        }
    }

    private function audit(array $actor, string $action, string $type, string $id, string $reason, array $metadata): void
    {
        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(),
            'actor_class' => $actor['actor_class'],
            'action' => $action,
            'target_type' => $type,
            'target_id' => $id,
            'reason_code' => $reason,
            'occurred_at' => now(),
            'metadata' => json_encode(['actor_id' => $actor['actor_id']] + $metadata, JSON_THROW_ON_ERROR),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function reject(string $key, string $message): never
    {
        throw ValidationException::withMessages([$key => $message]);
    }
}
