<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Governance\GovernancePolicy;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class EditorialReviewService
{
    /** @return array<string, string> */
    public function capabilityMatrix(): array
    {
        return [
            'submit' => 'submit_directory_proposal',
            'edit' => 'edit_directory_proposal',
            'review' => 'review_directory_proposal',
            'adjudicate' => 'adjudicate_claim',
            'approve' => 'authorize_publication',
            'suppress' => 'suppress_publication',
            'restore' => 'restore_publication',
        ];
    }

    public function submit(array $actor, string $entityId, string $claimVersionId, string $idempotencyKey): string
    {
        $this->requireHuman($actor, 'submit_directory_proposal');
        $this->required($idempotencyKey, 'idempotency_key');
        $fingerprint = $this->fingerprint(['submit', $actor['actor_id'], $entityId, $claimVersionId]);

        return DB::transaction(function () use ($actor, $entityId, $claimVersionId, $idempotencyKey, $fingerprint): string {
            $prior = $this->priorTransition($idempotencyKey, $fingerprint);
            if ($prior !== null) {
                return (string) $prior->editorial_review_case_id;
            }
            $claim = DB::table('claim_versions')->join('claims', 'claims.id', '=', 'claim_versions.claim_id')
                ->where('claim_versions.id', $claimVersionId)->first(['claims.subject_entity_id']);
            if ($claim === null || (string) $claim->subject_entity_id !== $entityId ||
                ! DB::table('directory_entities')->where('id', $entityId)->exists()) {
                $this->reject('proposal', 'The claim version must belong to the submitted directory entity.');
            }

            $id = (string) Str::uuid();
            $now = now();
            DB::table('editorial_review_cases')->insert([
                'id' => $id, 'entity_id' => $entityId, 'claim_version_id' => $claimVersionId,
                'status' => 'submitted', 'submitted_by_actor_id' => $actor['actor_id'],
                'idempotency_key' => $idempotencyKey, 'fingerprint' => $fingerprint,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $this->history($actor, $entityId, $claimVersionId, $id, 'proposal_submitted', null, 'submitted',
                'editorial_proposal_submitted', $idempotencyKey, $fingerprint, []);
            return $id;
        });
    }

    public function startReview(array $actor, string $caseId, string $idempotencyKey): void
    {
        $this->requireHuman($actor, 'review_directory_proposal');
        DB::transaction(function () use ($actor, $caseId, $idempotencyKey): void {
            $case = $this->caseFor($caseId);
            $fingerprint = $this->fingerprint(['review_started', $caseId, $actor['actor_id']]);
            if ($this->priorTransition($idempotencyKey, $fingerprint) !== null) {
                return;
            }
            if ($case->status !== 'submitted' || $case->submitted_by_actor_id === $actor['actor_id'] ||
                in_array($actor['actor_id'], $this->evidenceActors($case->claim_version_id), true)) {
                $this->reject('review', 'Review requires a distinct human who did not submit the proposal or its evidence.');
            }
            $now = now();
            DB::table('editorial_review_cases')->where('id', $caseId)->update([
                'status' => 'in_review', 'reviewer_actor_id' => $actor['actor_id'], 'updated_at' => $now,
            ]);
            $this->history($actor, $case->entity_id, $case->claim_version_id, $caseId, 'review_started',
                'submitted', 'in_review', 'editorial_review_started', $idempotencyKey, $fingerprint, []);
        });
    }

    public function completeReview(array $actor, string $caseId, string $outcome, string $reasonCode, string $rationale, string $idempotencyKey): void
    {
        $this->requireHuman($actor, 'review_directory_proposal');
        if (! in_array($outcome, ['ready_for_adjudication', 'changes_requested', 'held'], true) ||
            trim($reasonCode) === '' || trim($rationale) === '') {
            $this->reject('review', 'A supported review outcome, reason and rationale are required.');
        }
        DB::transaction(function () use ($actor, $caseId, $outcome, $reasonCode, $rationale, $idempotencyKey): void {
            $case = $this->caseFor($caseId);
            $fingerprint = $this->fingerprint(['review_completed', $caseId, $actor['actor_id'], $outcome, $reasonCode, $rationale]);
            if ($this->priorTransition($idempotencyKey, $fingerprint) !== null) {
                return;
            }
            if ($case->status !== 'in_review' || $case->reviewer_actor_id !== $actor['actor_id']) {
                $this->reject('review', 'Only the assigned independent reviewer may complete this review.');
            }
            DB::table('editorial_review_cases')->where('id', $caseId)->update(['status' => $outcome, 'updated_at' => now()]);
            $this->history($actor, $case->entity_id, $case->claim_version_id, $caseId, 'review_completed',
                'in_review', $outcome, $reasonCode, $idempotencyKey, $fingerprint, ['rationale' => $rationale]);
        });
    }

    public function correctProposal(array $actor, string $caseId, array $value, array $evidenceIds, string $validFrom, ?string $validTo,
        string $reasonCode, string $rationale, string $correctionKey, string $submissionKey): string
    {
        $this->requireHuman($actor, 'edit_directory_proposal');
        $this->requireHuman($actor, 'correct_claim');
        $case = $this->caseFor($caseId);
        if ($case->status !== 'changes_requested' || $case->submitted_by_actor_id !== $actor['actor_id']) {
            $this->reject('correction', 'Only the original submitter may edit a proposal returned for changes.');
        }
        $newVersion = app(PersistedGovernanceWorkflowService::class)->correctClaimVersion(
            $actor, $case->claim_version_id, $value, $evidenceIds, $validFrom, $validTo,
            $reasonCode, $rationale, $correctionKey
        );
        return $this->submit($actor, $case->entity_id, $newVersion, $submissionKey);
    }

    public function adjudicate(array $actor, string $caseId, string $adjudicationCaseId, string $outcome,
        string $reasonCode, string $rationale, string $policyVersion, string $idempotencyKey): string
    {
        $this->requireHuman($actor, 'adjudicate_claim');
        return DB::transaction(function () use ($actor, $caseId, $adjudicationCaseId, $outcome, $reasonCode, $rationale, $policyVersion, $idempotencyKey): string {
            $case = $this->caseFor($caseId);
            $fingerprint = $this->fingerprint(['adjudicate', $caseId, $adjudicationCaseId, $actor['actor_id'], $outcome, $reasonCode, $rationale, $policyVersion]);
            $prior = $this->priorTransition($idempotencyKey, $fingerprint);
            if ($prior !== null) {
                return (string) ($prior->metadata ? (json_decode($prior->metadata, true)['result_id'] ?? '') : '');
            }
            $adjudicationCase = DB::table('adjudication_cases')->where('id', $adjudicationCaseId)->first();
            if ($case->status !== 'ready_for_adjudication' || $adjudicationCase === null ||
                $adjudicationCase->claim_version_id !== $case->claim_version_id ||
                in_array($actor['actor_id'], [$case->submitted_by_actor_id, $case->reviewer_actor_id], true)) {
                $this->reject('adjudication', 'Adjudication requires a distinct human after independent editorial review.');
            }
            $decisionId = app(PersistedGovernanceWorkflowService::class)->decideAdjudication(
                $actor, $adjudicationCaseId, $outcome, $reasonCode, $rationale, $policyVersion
            );
            $next = $outcome === 'accepted' ? 'adjudicated_accepted' : ($outcome === 'disputed' ? 'disputed' : 'adjudicated_rejected');
            DB::table('editorial_review_cases')->where('id', $caseId)->update([
                'status' => $next, 'adjudication_case_id' => $adjudicationCaseId,
                'adjudication_decision_id' => $decisionId, 'updated_at' => now(),
            ]);
            $this->history($actor, $case->entity_id, $case->claim_version_id, $caseId, 'adjudication_recorded',
                'ready_for_adjudication', $next, $reasonCode, $idempotencyKey, $fingerprint, ['result_id' => $decisionId]);
            return $decisionId;
        });
    }

    public function approve(array $actor, string $caseId, string $surface, string $audience, string $policyVersion, string $idempotencyKey): string
    {
        $this->requireHuman($actor, 'authorize_publication');
        return DB::transaction(function () use ($actor, $caseId, $surface, $audience, $policyVersion, $idempotencyKey): string {
            $case = $this->caseFor($caseId);
            $fingerprint = $this->fingerprint(['approve', $caseId, $actor['actor_id'], $surface, $audience, $policyVersion]);
            $prior = $this->priorTransition($idempotencyKey, $fingerprint);
            if ($prior !== null) {
                return (string) (json_decode($prior->metadata, true)['result_id'] ?? '');
            }
            $decision = $case->adjudication_decision_id === null ? null : DB::table('adjudication_decisions')->where('id', $case->adjudication_decision_id)->first();
            if ($case->status !== 'adjudicated_accepted' || $decision === null ||
                in_array($actor['actor_id'], [$case->submitted_by_actor_id, $case->reviewer_actor_id, $decision->actor_id], true)) {
                $this->reject('publication', 'Publication requires accepted adjudication and a distinct human publisher.');
            }
            $publicationId = app(PersistedGovernanceWorkflowService::class)->authorizePublication(
                $actor, $case->claim_version_id, $case->adjudication_decision_id, $surface, $audience, $policyVersion, $idempotencyKey
            );
            DB::table('editorial_review_cases')->where('id', $caseId)->update([
                'status' => 'approved', 'publication_decision_id' => $publicationId, 'updated_at' => now(),
            ]);
            $this->history($actor, $case->entity_id, $case->claim_version_id, $caseId, 'publication_approved',
                'adjudicated_accepted', 'approved', 'editorial_publication_approved', $idempotencyKey, $fingerprint, ['result_id' => $publicationId]);
            return $publicationId;
        });
    }

    public function suppress(array $actor, string $caseId, string $snapshotId, string $reasonCode, string $rationale): string
    {
        $this->requireHuman($actor, 'suppress_publication');
        return DB::transaction(function () use ($actor, $caseId, $snapshotId, $reasonCode, $rationale): string {
            $case = $this->caseFor($caseId);
            $snapshot = DB::table('publication_snapshots')->where('id', $snapshotId)->first();
            if (! in_array($case->status, ['approved', 'restored'], true) || $snapshot === null ||
                $snapshot->claim_version_id !== $case->claim_version_id) {
                $this->reject('suppression', 'Only the approved case publication may be suppressed.');
            }
            $id = app(PersistedGovernanceWorkflowService::class)->suppressPublication($actor, $snapshotId, $reasonCode, $rationale);
            DB::table('editorial_review_cases')->where('id', $caseId)->update(['status' => 'suppressed', 'updated_at' => now()]);
            $key = 'editorial-suppress:'.$id;
            $fingerprint = $this->fingerprint(['suppress', $caseId, $snapshotId, $actor['actor_id'], $reasonCode, $rationale]);
            $this->history($actor, $case->entity_id, $case->claim_version_id, $caseId, 'publication_suppressed',
                $case->status, 'suppressed', $reasonCode, $key, $fingerprint, ['result_id' => $id]);
            return $id;
        });
    }

    public function restore(array $actor, string $caseId, string $suppressionId, string $policyVersion, string $reasonCode): string
    {
        $this->requireHuman($actor, 'restore_publication');
        return DB::transaction(function () use ($actor, $caseId, $suppressionId, $policyVersion, $reasonCode): string {
            $case = $this->caseFor($caseId);
            $suppression = DB::table('publication_suppressions')->where('id', $suppressionId)->first();
            $snapshot = $suppression === null ? null : DB::table('publication_snapshots')->where('id', $suppression->publication_snapshot_id)->first();
            if ($case->status !== 'suppressed' || $snapshot === null || $snapshot->claim_version_id !== $case->claim_version_id) {
                $this->reject('restoration', 'Only the suppressed publication for this review case may be restored.');
            }
            $id = app(PersistedGovernanceWorkflowService::class)->restorePublication($actor, $suppressionId, $policyVersion, $reasonCode);
            DB::table('editorial_review_cases')->where('id', $caseId)->update(['status' => 'restored', 'updated_at' => now()]);
            $key = 'editorial-restore:'.$id;
            $fingerprint = $this->fingerprint(['restore', $caseId, $suppressionId, $actor['actor_id'], $policyVersion, $reasonCode]);
            $this->history($actor, $case->entity_id, $case->claim_version_id, $caseId, 'publication_restored',
                'suppressed', 'restored', $reasonCode, $key, $fingerprint, ['result_id' => $id]);
            return $id;
        });
    }

    private function caseFor(string $id): object
    {
        $case = DB::table('editorial_review_cases')->where('id', $id)->lockForUpdate()->first();
        if ($case === null) {
            $this->reject('case', 'Editorial review case was not found.');
        }
        return $case;
    }

    private function history(array $actor, string $entityId, string $versionId, string $caseId, string $event,
        ?string $from, string $to, string $reason, string $key, string $fingerprint, array $metadata): void
    {
        $now = now();
        DB::table('directory_status_history')->insert([
            'id' => (string) Str::uuid(), 'entity_id' => $entityId, 'claim_version_id' => $versionId,
            'editorial_review_case_id' => $caseId, 'event_type' => $event, 'previous_status' => $from,
            'new_status' => $to, 'actor_id' => $actor['actor_id'], 'actor_class' => $actor['actor_class'],
            'reason_code' => $reason, 'idempotency_key' => $key, 'fingerprint' => $fingerprint,
            'metadata' => json_encode($metadata, JSON_THROW_ON_ERROR), 'occurred_at' => $now,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(), 'actor_class' => $actor['actor_class'],
            'action' => 'directory_editorial_'.$event, 'target_type' => 'editorial_review_case',
            'target_id' => $caseId, 'reason_code' => $reason, 'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => $actor['actor_id'], 'entity_id' => $entityId,
                'claim_version_id' => $versionId, 'previous_status' => $from, 'new_status' => $to] + $metadata, JSON_THROW_ON_ERROR),
            'created_at' => $now, 'updated_at' => $now,
        ]);
    }

    private function priorTransition(string $key, string $fingerprint): ?object
    {
        $prior = DB::table('directory_status_history')->where('idempotency_key', $key)->first();
        if ($prior !== null && $prior->fingerprint !== $fingerprint) {
            $this->reject('idempotency_key', 'Editorial idempotency key was reused for a different command.');
        }
        return $prior;
    }

    private function evidenceActors(string $versionId): array
    {
        $actors = [];
        $ids = DB::table('claim_evidence_links')->where('claim_version_id', $versionId)->pluck('evidence_reference_id');
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

    private function requireHuman(array $actor, string $capability): void
    {
        $decision = (new GovernancePolicy)->requireCapability($actor, $capability);
        if (($decision['allowed'] ?? false) !== true || ($actor['actor_class'] ?? null) !== 'human') {
            $this->reject('actor', 'A human actor with the required capability is mandatory.');
        }
    }

    private function required(string $value, string $key): void
    {
        if (trim($value) === '') {
            $this->reject($key, 'A non-empty value is required.');
        }
    }

    private function fingerprint(array $command): string
    {
        return hash('sha256', json_encode($command, JSON_THROW_ON_ERROR));
    }

    private function reject(string $key, string $message): never
    {
        throw ValidationException::withMessages([$key => $message]);
    }
}
