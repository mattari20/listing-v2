<?php

declare(strict_types=1);

namespace App\Services\Governance;

use App\Domain\Governance\GovernancePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class PersistedGovernanceWorkflowService
{
    public function openAdjudicationCase(array $actor, string $claimVersionId, string $idempotencyKey, string $caseKind = 'initial', ?string $parentCaseId = null): string
    {
        $this->requireActor($actor, 'open_adjudication');

        return DB::transaction(function () use ($actor, $claimVersionId, $idempotencyKey, $caseKind, $parentCaseId): string {
            $existing = DB::table('adjudication_cases')->where('idempotency_key', $idempotencyKey)->first();
            if ($existing !== null) {
                if ($existing->claim_version_id !== $claimVersionId || $existing->opened_by_actor_id !== $actor['actor_id'] || $existing->case_kind !== $caseKind || $existing->parent_case_id !== $parentCaseId) {
                    $this->reject('idempotency_key', 'Idempotency key reused for a different adjudication case.');
                }

                return (string) $existing->id;
            }
            if ($idempotencyKey === '' || DB::table('claim_versions')->where('id', $claimVersionId)->exists() === false) {
                $this->reject('case', 'A valid claim version and idempotency key are required.');
            }
            if (! in_array($caseKind, ['initial', 'appeal', 'reconsideration'], true)) {
                $this->reject('case_kind', 'Unsupported adjudication case kind.');
            }
            if ($caseKind !== 'initial' && ($parentCaseId === null || DB::table('adjudication_cases')->where('id', $parentCaseId)->exists() === false)) {
                $this->reject('parent_case', 'Appeal and reconsideration cases require an existing parent case.');
            }
            $id = (string) Str::uuid();
            $now = now();
            DB::table('adjudication_cases')->insert([
                'id' => $id, 'claim_version_id' => $claimVersionId, 'status' => 'open',
                'opened_by_actor_id' => $actor['actor_id'], 'case_kind' => $caseKind,
                'parent_case_id' => $parentCaseId, 'idempotency_key' => $idempotencyKey,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $this->audit($actor, 'adjudication_case_opened', 'adjudication_case', $id, 'case_opened', ['case_kind' => $caseKind]);

            return $id;
        });
    }

    public function decideAdjudication(array $actor, string $caseId, string $outcome, string $rationaleCode, string $rationale, string $policyVersion): string
    {
        $this->requireActor($actor, 'adjudicate_claim');

        return DB::transaction(function () use ($actor, $caseId, $outcome, $rationaleCode, $rationale, $policyVersion): string {
            $case = DB::table('adjudication_cases')->where('id', $caseId)->lockForUpdate()->first();
            if ($case === null || $case->status !== 'open') {
                $this->reject('case', 'Adjudication case is missing or no longer open.');
            }
            if (! in_array($outcome, ['accepted', 'rejected', 'disputed', 'needs_evidence', 'deferred'], true) || $rationaleCode === '' || trim($rationale) === '' || $policyVersion === '') {
                $this->reject('decision', 'Outcome, rationale and policy version are required.');
            }
            $evidence = DB::table('claim_evidence_links')
                ->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')
                ->where('claim_evidence_links.claim_version_id', $case->claim_version_id)
                ->get(['evidence_references.status']);
            $statuses = $evidence->pluck('status')->all();
            if ($outcome === 'accepted' && ! (new GovernancePolicy)->canAcceptClaim($statuses)) {
                $this->reject('evidence', 'Claim cannot be accepted without admissible evidence.');
            }
            $evidenceActorIds = $this->evidenceActorIds($case->claim_version_id);
            foreach ($evidenceActorIds as $evidenceActorId) {
                $authorization = (new GovernancePolicy)->authorizeAdjudication($actor, $evidenceActorId, true);
                if ($authorization['allowed'] === false) {
                    $this->reject('actor', $authorization['reason']);
                }
            }
            $id = (string) Str::uuid();
            $now = now();
            DB::table('adjudication_decisions')->insert([
                'id' => $id, 'adjudication_case_id' => $caseId, 'outcome' => $outcome,
                'actor_id' => $actor['actor_id'], 'actor_class' => $actor['actor_class'],
                'rationale_code' => $rationaleCode, 'rationale' => $rationale,
                'policy_version' => $policyVersion, 'decided_at' => $now,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('adjudication_cases')->where('id', $caseId)->update(['status' => 'decided', 'updated_at' => $now]);
            DB::table('claim_versions')->where('id', $case->claim_version_id)->update(['disposition' => $outcome, 'updated_at' => $now]);
            $this->audit($actor, 'adjudication_decided', 'adjudication_decision', $id, $rationaleCode, ['outcome' => $outcome, 'case_id' => $caseId]);

            return $id;
        });
    }

    public function authorizePublication(array $actor, string $claimVersionId, string $adjudicationDecisionId, string $surface, string $audience, string $policyVersion, string $idempotencyKey): string
    {
        $this->requireActor($actor, 'authorize_publication');

        return DB::transaction(function () use ($actor, $claimVersionId, $adjudicationDecisionId, $surface, $audience, $policyVersion, $idempotencyKey): string {
            $existing = DB::table('publication_decisions')->where('idempotency_key', $idempotencyKey)->first();
            if ($existing !== null) {
                if ($existing->claim_version_id !== $claimVersionId || $existing->actor_id !== $actor['actor_id'] || $existing->adjudication_decision_id !== $adjudicationDecisionId || $existing->surface !== $surface || $existing->audience !== $audience || $existing->policy_version !== $policyVersion) {
                    $this->reject('idempotency_key', 'Idempotency key reused for a different publication command.');
                }

                return (string) $existing->id;
            }
            $version = DB::table('claim_versions')->where('id', $claimVersionId)->lockForUpdate()->first();
            $decision = DB::table('adjudication_decisions')
                ->join('adjudication_cases', 'adjudication_cases.id', '=', 'adjudication_decisions.adjudication_case_id')
                ->where('adjudication_decisions.id', $adjudicationDecisionId)
                ->where('adjudication_cases.claim_version_id', $claimVersionId)
                ->first(['adjudication_decisions.*']);
            $hasSuccessor = DB::table('claim_versions')->where('supersedes_version_id', $claimVersionId)->exists();
            if ($version === null || $version->disposition !== 'accepted' || $decision === null || $decision->outcome !== 'accepted' || $hasSuccessor) {
                $this->reject('adjudication', 'A current accepted human adjudication is required.');
            }
            $evidenceRows = DB::table('claim_evidence_links')
                ->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')
                ->where('claim_evidence_links.claim_version_id', $claimVersionId)->get(['evidence_references.id', 'evidence_references.status', 'evidence_references.source_authorization_id']);
            $statuses = $evidenceRows->pluck('status')->all();
            if (! (new GovernancePolicy)->canAcceptClaim($statuses)) {
                $this->reject('evidence', 'Evidence is not currently admissible for publication.');
            }
            $authorizationActors = $this->evidenceActorIds($claimVersionId);
            $policy = (new GovernancePolicy)->authorizePublication($actor, [
                'outcome' => $decision->outcome, 'claim_disposition' => $version->disposition,
                'actor_id' => $decision->actor_id, 'evidence_admissible' => true,
                'version_current' => true, 'surface' => $surface, 'audience' => $audience,
                'policy_version' => $policyVersion,
            ], $authorizationActors);
            if ($policy['allowed'] === false) {
                $this->reject('publication', $policy['reason']);
            }
            foreach ($evidenceRows as $evidence) {
                $authorization = (array) DB::table('source_authorizations')->where('id', $evidence->source_authorization_id)->first();
                $scope = (new GovernancePolicy)->authorizeSourceAction($authorization, 'publication', [
                    'purpose' => 'directory_publication', 'method' => 'approved_projection', 'territory' => 'synthetic',
                ]);
                if ($scope['allowed'] === false) {
                    $this->reject('source_authorization', $scope['reason']);
                }
            }
            $entity = DB::table('claims')->join('directory_entities', 'directory_entities.id', '=', 'claims.subject_entity_id')
                ->where('claims.id', $version->claim_id)->first(['directory_entities.entity_type', 'directory_entities.label']);
            $isDeeniMadaris = $entity !== null && $entity->entity_type === 'deeni_madaris';
            if (! (new GovernancePolicy)->isPubliclyVisible(false, $isDeeniMadaris)) {
                $this->reject('visibility', 'Restricted-category publication is disabled by default.');
            }
            if ($surface === '' || $audience === '' || $policyVersion === '' || $idempotencyKey === '') {
                $this->reject('publication', 'Surface, audience, policy version and idempotency key are required.');
            }
            $id = (string) Str::uuid();
            $now = now();
            DB::table('publication_decisions')->insert([
                'id' => $id, 'claim_version_id' => $claimVersionId, 'decision' => 'approved',
                'surface' => $surface, 'audience' => $audience, 'actor_id' => $actor['actor_id'],
                'actor_class' => $actor['actor_class'], 'adjudication_decision_id' => $adjudicationDecisionId,
                'policy_version' => $policyVersion, 'idempotency_key' => $idempotencyKey,
                'reason_code' => 'human_publication_approval', 'decided_at' => $now,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $payload = ['claim_version_id' => $claimVersionId, 'claim_id' => $version->claim_id,
                'entity_label' => $entity->label ?? null, 'predicate' => DB::table('claims')->where('id', $version->claim_id)->value('predicate'),
                'value' => json_decode($version->value, true), 'surface' => $surface, 'audience' => $audience,
                'is_deeni_madaris' => $isDeeniMadaris, 'policy_version' => $policyVersion];
            $snapshotVersion = (int) DB::table('publication_snapshots')->where('claim_version_id', $claimVersionId)->max('snapshot_version') + 1;
            $snapshotId = (string) Str::uuid();
            $digest = hash('sha256', json_encode($payload, JSON_THROW_ON_ERROR));
            DB::table('publication_snapshots')->insert([
                'id' => $snapshotId, 'publication_decision_id' => $id, 'claim_version_id' => $claimVersionId,
                'snapshot_version' => $snapshotVersion, 'payload' => json_encode($payload, JSON_THROW_ON_ERROR),
                'payload_digest' => $digest, 'surface' => $surface, 'audience' => $audience,
                'status' => 'approved_pending_projection', 'created_at' => $now,
            ]);
            $this->enqueue('publication.snapshot.approved', 'publication_snapshot', $snapshotId, $payload, 'publish:'.$snapshotId);
            $this->audit($actor, 'publication_authorized', 'publication_decision', $id, 'human_publication_approval', ['snapshot_id' => $snapshotId, 'payload_digest' => $digest]);

            return $id;
        });
    }

    public function revokeSourceAuthorization(array $actor, string $authorizationId, string $reasonCode, string $rationale): int
    {
        $this->requireActor($actor, 'revoke_source_authorization');
        if (($actor['actor_class'] ?? null) !== 'human' || $reasonCode === '' || trim($rationale) === '') {
            $this->reject('revocation', 'Human authority, reason code and rationale are required.');
        }

        return DB::transaction(function () use ($actor, $authorizationId, $reasonCode, $rationale): int {
            $authorization = DB::table('source_authorizations')->where('id', $authorizationId)->lockForUpdate()->first();
            if ($authorization === null) {
                $this->reject('authorization', 'Source authorization was not found.');
            }
            if ($authorization->revoked_at !== null) {

                return 0;
            }
            $now = now();
            DB::table('source_authorizations')->where('id', $authorizationId)->update([
                'status' => 'revoked', 'revoked_at' => $now, 'revocation_reason' => $reasonCode, 'updated_at' => $now,
            ]);
            $evidenceIds = DB::table('evidence_references')->where('source_authorization_id', $authorizationId)->pluck('id');
            DB::table('evidence_references')->whereIn('id', $evidenceIds)->update(['status' => 'quarantined', 'updated_at' => $now]);
            $versionIds = DB::table('claim_evidence_links')->whereIn('evidence_reference_id', $evidenceIds)->distinct()->pluck('claim_version_id');
            $snapshotIds = DB::table('publication_snapshots')->whereIn('claim_version_id', $versionIds)->pluck('id');
            foreach ($snapshotIds as $snapshotId) {
                $suppressionId = (string) Str::uuid();
                DB::table('publication_suppressions')->insert([
                    'id' => $suppressionId, 'publication_snapshot_id' => $snapshotId,
                    'reason_code' => $reasonCode, 'rationale' => $rationale, 'actor_id' => $actor['actor_id'],
                    'actor_class' => $actor['actor_class'], 'status' => 'active', 'suppressed_at' => $now,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
                DB::table('publication_snapshots')->where('id', $snapshotId)->update(['status' => 'suppressed']);
                DB::table('public_projections')->where('publication_snapshot_id', $snapshotId)->update(['status' => 'suppressed', 'updated_at' => $now]);
                $this->enqueue('publication.snapshot.suppressed', 'publication_snapshot', $snapshotId,
                    ['snapshot_id' => $snapshotId, 'source_authorization_revoked' => true], 'revoke:'.$authorizationId.':'.$snapshotId);
            }
            $this->audit($actor, 'source_authorization_revoked', 'source_authorization', $authorizationId, $reasonCode, [
                'affected_evidence_count' => $evidenceIds->count(), 'affected_snapshot_count' => $snapshotIds->count(),
            ]);

            return $snapshotIds->count();
        });
    }

    public function suppressPublication(array $actor, string $snapshotId, string $reasonCode, string $rationale): string
    {
        $this->requireActor($actor, 'suppress_publication');
        if (($actor['actor_class'] ?? null) !== 'human') {
            $this->reject('actor', 'Emergency suppression requires a human actor.');
        }

        return DB::transaction(function () use ($actor, $snapshotId, $reasonCode, $rationale): string {
            $snapshot = DB::table('publication_snapshots')->where('id', $snapshotId)->lockForUpdate()->first();
            if ($snapshot === null || $reasonCode === '' || trim($rationale) === '') {
                $this->reject('suppression', 'Snapshot, reason code and rationale are required.');
            }
            $id = (string) Str::uuid();
            $now = now();
            DB::table('publication_suppressions')->insert([
                'id' => $id, 'publication_snapshot_id' => $snapshotId, 'reason_code' => $reasonCode,
                'rationale' => $rationale, 'actor_id' => $actor['actor_id'], 'actor_class' => $actor['actor_class'],
                'status' => 'active', 'suppressed_at' => $now, 'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('publication_snapshots')->where('id', $snapshotId)->update(['status' => 'suppressed']);
            DB::table('public_projections')->where('publication_snapshot_id', $snapshotId)->update(['status' => 'suppressed', 'updated_at' => $now]);
            $this->enqueue('publication.snapshot.suppressed', 'publication_snapshot', $snapshotId, ['snapshot_id' => $snapshotId], 'suppress:'.$id);
            $this->audit($actor, 'publication_suppressed', 'publication_suppression', $id, $reasonCode, ['snapshot_id' => $snapshotId]);

            return $id;
        });
    }

    public function restorePublication(array $actor, string $suppressionId, string $policyVersion, string $reasonCode): string
    {
        $this->requireActor($actor, 'restore_publication');

        return DB::transaction(function () use ($actor, $suppressionId, $policyVersion, $reasonCode): string {
            $suppression = DB::table('publication_suppressions')->where('id', $suppressionId)->lockForUpdate()->first();
            if ($suppression === null || $suppression->status !== 'active') {
                $this->reject('suppression', 'Only an active suppression can be restored.');
            }
            $snapshot = DB::table('publication_snapshots')->where('id', $suppression->publication_snapshot_id)->first();
            $version = DB::table('claim_versions')->where('id', $snapshot->claim_version_id)->first();
            $evidence = DB::table('claim_evidence_links')->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')
                ->where('claim_evidence_links.claim_version_id', $snapshot->claim_version_id)->pluck('evidence_references.status')->all();
            $sourceAuthorizations = DB::table('claim_evidence_links')
                ->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')
                ->where('claim_evidence_links.claim_version_id', $snapshot->claim_version_id)
                ->pluck('evidence_references.source_authorization_id');
            $sourceScopesValid = $sourceAuthorizations->isNotEmpty();
            foreach ($sourceAuthorizations as $authorizationId) {
                $sourceAuthorization = (array) DB::table('source_authorizations')->where('id', $authorizationId)->first();
                $scope = (new GovernancePolicy)->authorizeSourceAction($sourceAuthorization, 'publication', [
                    'purpose' => 'directory_publication', 'method' => 'approved_projection', 'territory' => 'synthetic',
                ]);
                $sourceScopesValid = $sourceScopesValid && $scope['allowed'];
            }
            $policyEligible = $version !== null && $version->disposition === 'accepted'
                && (new GovernancePolicy)->canAcceptClaim($evidence) && $sourceScopesValid;
            $priorApproval = DB::table('publication_decisions')->where('id', $snapshot->publication_decision_id)->where('decision', 'approved')->exists();
            $decision = (new GovernancePolicy)->authorizeRestore($actor, $suppression->actor_id, $priorApproval, $policyEligible);
            if ($decision['allowed'] === false || $policyVersion === '' || $reasonCode === '') {
                $this->reject('restoration', $decision['allowed'] ? 'Policy version and reason are required.' : $decision['reason']);
            }
            $id = (string) Str::uuid();
            $now = now();
            DB::table('publication_restorations')->insert([
                'id' => $id, 'suppression_id' => $suppressionId, 'publication_snapshot_id' => $snapshot->id,
                'actor_id' => $actor['actor_id'], 'actor_class' => $actor['actor_class'],
                'policy_version' => $policyVersion, 'reason_code' => $reasonCode,
                'restored_at' => $now, 'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('publication_suppressions')->where('id', $suppressionId)->update(['status' => 'restored', 'updated_at' => $now]);
            DB::table('publication_snapshots')->where('id', $snapshot->id)->update(['status' => 'approved_pending_projection']);
            $this->enqueue('publication.snapshot.restored', 'publication_snapshot', $snapshot->id, ['snapshot_id' => $snapshot->id], 'restore:'.$id);
            $this->audit($actor, 'publication_restored', 'publication_restoration', $id, $reasonCode, ['snapshot_id' => $snapshot->id]);

            return $id;
        });
    }

    public function processOutbox(int $limit = 50, int $maxAttempts = 5, int $leaseMinutes = 5): int
    {
        if ($limit < 1 || $limit > 100) {
            throw ValidationException::withMessages(['limit' => 'Outbox batch size must be between 1 and 100.']);
        }
        if ($maxAttempts < 1 || $maxAttempts > 10) {
            throw ValidationException::withMessages(['max_attempts' => 'Maximum attempts must be between 1 and 10.']);
        }
        if ($leaseMinutes < 1 || $leaseMinutes > 60) {
            throw ValidationException::withMessages(['lease_minutes' => 'Outbox lease must be between 1 and 60 minutes.']);
        }

        $processed = 0;
        for ($index = 0; $index < $limit; $index++) {
            $claim = $this->claimOutboxEvent($leaseMinutes);
            if ($claim === null) {
                break;
            }

            try {
                $this->applyOutboxEvent($claim['id'], $claim['token']);
                $processed++;
            } catch (\Throwable $exception) {
                $this->recordOutboxFailure($claim, $exception, $maxAttempts);
            }
        }

        return $processed;
    }

    /**
     * Claim one event in a short transaction. A stale processing lease can be
     * reclaimed after a worker crash; the token fences the previous worker.
     *
     * @return array{id: string, token: string, attempts: int}|null
     */
    private function claimOutboxEvent(int $leaseMinutes): ?array
    {
        return DB::transaction(function () use ($leaseMinutes): ?array {
            $now = now();
            $staleBefore = $now->copy()->subMinutes($leaseMinutes);
            $event = DB::table('governance_outbox')
                ->where(function ($query) use ($now, $staleBefore): void {
                    $query->where(function ($pending) use ($now): void {
                        $pending->where('status', 'pending')->where('available_at', '<=', $now);
                    })->orWhere(function ($stale) use ($staleBefore): void {
                        $stale->where('status', 'processing')->where('claimed_at', '<=', $staleBefore);
                    });
                })
                ->orderBy('created_at')
                ->orderBy('id')
                ->lockForUpdate()
                ->first();

            if ($event === null || (int) $event->attempts >= 10) {
                return null;
            }

            $token = (string) Str::uuid();
            $attempts = (int) $event->attempts + 1;
            DB::table('governance_outbox')->where('id', $event->id)->update([
                'status' => 'processing',
                'attempts' => $attempts,
                'claim_token' => $token,
                'claimed_at' => $now,
                'updated_at' => $now,
            ]);

            return ['id' => (string) $event->id, 'token' => $token, 'attempts' => $attempts];
        });
    }

    private function applyOutboxEvent(string $eventId, string $claimToken): void
    {
        DB::transaction(function () use ($eventId, $claimToken): void {
            $event = DB::table('governance_outbox')->where('id', $eventId)
                ->where('status', 'processing')->where('claim_token', $claimToken)
                ->lockForUpdate()->first();
            if ($event === null) {
                return;
            }

            $payload = json_decode($event->payload, true, 512, JSON_THROW_ON_ERROR);
            if (in_array($event->event_type, ['publication.snapshot.approved', 'publication.snapshot.restored'], true)) {
                $snapshot = DB::table('publication_snapshots')->where('id', $event->aggregate_id)->lockForUpdate()->first();
                if ($snapshot !== null && $snapshot->status === 'approved_pending_projection') {
                    $snapshotPayload = json_decode($snapshot->payload, true, 512, JSON_THROW_ON_ERROR);
                    if (($snapshotPayload['is_deeni_madaris'] ?? false) === true) {
                        throw new \RuntimeException('Restricted Deeni Madaris snapshots cannot be projected.');
                    }

                    $latestSnapshotId = DB::table('publication_snapshots')
                        ->where('claim_version_id', $snapshot->claim_version_id)
                        ->where('surface', $snapshot->surface)
                        ->where('audience', $snapshot->audience)
                        ->orderByDesc('snapshot_version')
                        ->value('id');

                    // A delayed retry for an older snapshot must never replace a newer publication.
                    if ((string) $latestSnapshotId === (string) $snapshot->id) {
                        $projectionKey = $snapshot->claim_version_id.':'.$snapshot->surface.':'.$snapshot->audience;
                        $projection = DB::table('public_projections')->where('projection_key', $projectionKey)->first();
                        if ($projection !== null) {
                            $currentSnapshotVersion = DB::table('publication_snapshots')
                                ->where('id', $projection->publication_snapshot_id)->value('snapshot_version');
                            if ($currentSnapshotVersion === null || (int) $currentSnapshotVersion <= (int) $snapshot->snapshot_version) {
                                DB::table('public_projections')->where('id', $projection->id)->update([
                                    'publication_snapshot_id' => $snapshot->id,
                                    'surface' => $snapshot->surface,
                                    'audience' => $snapshot->audience,
                                    'status' => 'approved',
                                    'is_deeni_madaris' => false,
                                    'projected_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        } else {
                            DB::table('public_projections')->insert([
                                'id' => (string) Str::uuid(),
                                'publication_snapshot_id' => $snapshot->id,
                                'projection_key' => $projectionKey,
                                'surface' => $snapshot->surface,
                                'audience' => $snapshot->audience,
                                'status' => 'approved',
                                'is_deeni_madaris' => false,
                                'projected_at' => now(),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                        DB::table('publication_snapshots')->where('id', $snapshot->id)->update(['status' => 'projected']);
                    }
                }
            } elseif ($event->event_type === 'publication.snapshot.suppressed') {
                $snapshot = DB::table('publication_snapshots')->where('id', $event->aggregate_id)->first();
                if ($snapshot !== null && $snapshot->status === 'suppressed') {
                    DB::table('public_projections')->where('publication_snapshot_id', $snapshot->id)
                        ->update(['status' => 'suppressed', 'updated_at' => now()]);
                }
            } else {
                throw new \RuntimeException('Unsupported governance outbox event type: '.$event->event_type);
            }

            DB::table('governance_outbox')->where('id', $eventId)->where('claim_token', $claimToken)->update([
                'status' => 'processed',
                'processed_at' => now(),
                'claim_token' => null,
                'claimed_at' => null,
                'last_error' => null,
                'updated_at' => now(),
            ]);
        });
    }

    private function recordOutboxFailure(array $claim, \Throwable $exception, int $maxAttempts): void
    {
        DB::transaction(function () use ($claim, $exception, $maxAttempts): void {
            $event = DB::table('governance_outbox')->where('id', $claim['id'])
                ->where('status', 'processing')->where('claim_token', $claim['token'])
                ->lockForUpdate()->first();
            if ($event === null) {
                return;
            }

            $deadLetter = (int) $claim['attempts'] >= $maxAttempts;
            $delayMinutes = min(2 ** max(0, (int) $claim['attempts'] - 1), 60);
            DB::table('governance_outbox')->where('id', $claim['id'])->update([
                'status' => $deadLetter ? 'dead_letter' : 'pending',
                'available_at' => $deadLetter ? $event->available_at : now()->addMinutes($delayMinutes),
                'claim_token' => null,
                'claimed_at' => null,
                'last_error' => substr($exception->getMessage(), 0, 2000),
                'updated_at' => now(),
            ]);
        });
    }

    private function evidenceActorIds(string $claimVersionId): array
    {
        $ids = DB::table('claim_evidence_links')->where('claim_version_id', $claimVersionId)->pluck('evidence_reference_id');
        $actors = [];
        foreach ($ids as $id) {
            $event = DB::table('audit_events')->where('target_type', 'evidence_reference')->where('target_id', $id)
                ->where('action', 'evidence_reference_registered')->first();
            $metadata = $event === null ? [] : (json_decode((string) $event->metadata, true) ?: []);
            if (! empty($metadata['actor_id'])) {
                $actors[] = (string) $metadata['actor_id'];
            }
        }

        return array_values(array_unique($actors));
    }

    private function enqueue(string $eventType, string $aggregateType, string $aggregateId, array $payload, string $key): void
    {
        DB::table('governance_outbox')->insert([
            'id' => (string) Str::uuid(), 'event_type' => $eventType, 'aggregate_type' => $aggregateType,
            'aggregate_id' => $aggregateId, 'payload' => json_encode($payload, JSON_THROW_ON_ERROR),
            'idempotency_key' => $key, 'status' => 'pending', 'attempts' => 0,
            'available_at' => now(), 'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    private function audit(array $actor, string $action, string $type, string $id, string $reason, array $metadata): void
    {
        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(), 'actor_class' => $actor['actor_class'], 'action' => $action,
            'target_type' => $type, 'target_id' => $id, 'reason_code' => $reason,
            'occurred_at' => now(), 'metadata' => json_encode(['actor_id' => $actor['actor_id']] + $metadata, JSON_THROW_ON_ERROR),
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    private function requireActor(array $actor, string $capability): void
    {
        $result = (new GovernancePolicy)->requireCapability($actor, $capability);
        if ($result['allowed'] === false) {
            $this->reject('actor', $result['reason']);
        }
    }

    private function reject(string $key, string $message): never
    {
        throw ValidationException::withMessages([$key => $message]);
    }
}
