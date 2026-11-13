<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Governance\PersistedConflictAndRollbackService;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PersistedConflictAndRollbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_overlapping_incompatible_assertions_persist_both_candidates_and_recorded_time_conflict(): void
    {
        $fixture = $this->fixture();
        $second = $this->secondVersion($fixture, 'Synthetic Academy North', '2026-06-01', '2027-05-31', '2026-11-01 00:00:00');
        $service = new PersistedConflictAndRollbackService;

        $conflictId = $service->evaluateTemporalConflict(
            $this->actor('conflict-reviewer', ['evaluate_conflicts']),
            [$fixture['version'], $second],
            'conflict-overlap-1',
        );

        $this->assertNotNull($conflictId);
        $this->assertDatabaseHas('claim_conflicts', [
            'id' => $conflictId,
            'conflict_kind' => 'recorded_time_valid_time_overlap',
            'status' => 'open',
        ]);
        $this->assertDatabaseCount('claim_conflict_candidates', 2);
        $this->assertDatabaseHas('claim_conflict_candidates', ['claim_conflict_id' => $conflictId, 'claim_version_id' => $fixture['version']]);
        $this->assertDatabaseHas('claim_conflict_candidates', ['claim_conflict_id' => $conflictId, 'claim_version_id' => $second]);

        $this->assertSame($conflictId, $service->evaluateTemporalConflict(
            $this->actor('conflict-reviewer', ['evaluate_conflicts']),
            [$second, $fixture['version']],
            'conflict-overlap-1',
        ));
    }

    public function test_non_overlapping_different_assertions_are_temporal_succession_not_a_conflict(): void
    {
        $fixture = $this->fixture();
        DB::table('claim_versions')->where('id', $fixture['version'])->update([
            'valid_from' => '2026-01-01',
            'valid_to' => '2026-05-31',
        ]);
        $second = $this->secondVersion($fixture, 'Synthetic Academy North', '2026-06-01', '2027-05-31', '2026-11-01 00:00:00');

        $conflictId = (new PersistedConflictAndRollbackService)->evaluateTemporalConflict(
            $this->actor('conflict-reviewer', ['evaluate_conflicts']),
            [$fixture['version'], $second],
            'conflict-non-overlap-1',
        );

        $this->assertNull($conflictId);
        $this->assertDatabaseCount('claim_conflicts', 0);
        $this->assertDatabaseCount('claim_conflict_candidates', 0);
    }

    public function test_conflict_resolution_requires_a_distinct_human_adjudicator_and_preserves_candidates(): void
    {
        $fixture = $this->fixture();
        $second = $this->secondVersion($fixture, 'Synthetic Academy North', '2026-06-01', '2027-05-31', '2026-11-01 00:00:00');
        $conflicts = new PersistedConflictAndRollbackService;
        $conflictId = $conflicts->evaluateTemporalConflict(
            $this->actor('conflict-reviewer', ['evaluate_conflicts']),
            [$fixture['version'], $second],
            'conflict-resolution-1',
        );

        $workflow = new PersistedGovernanceWorkflowService;
        $caseId = $workflow->openAdjudicationCase($this->actor('case-reviewer', ['open_adjudication']), $second, 'conflict-case-1');
        $decisionId = $workflow->decideAdjudication(
            $this->actor('human-adjudicator', ['adjudicate_claim']),
            $caseId,
            'accepted',
            'synthetic_conflict_resolution',
            'Synthetic evidence supports the selected candidate.',
            'policy-v1',
        );

        $conflicts->resolveConflict(
            $this->actor('independent-resolver', ['resolve_conflict']),
            $conflictId,
            $second,
            $decisionId,
            'Independent human resolution after candidate adjudication.',
        );

        $this->assertDatabaseHas('claim_conflicts', [
            'id' => $conflictId,
            'status' => 'resolved',
            'resolved_candidate_version_id' => $second,
            'adjudication_decision_id' => $decisionId,
            'resolved_by_actor_id' => 'independent-resolver',
        ]);
        $this->assertDatabaseCount('claim_conflict_candidates', 2);
        $this->assertDatabaseHas('audit_events', ['target_id' => $conflictId, 'action' => 'claim_conflict_resolved']);
    }

    public function test_conflict_and_candidate_records_roll_back_when_audit_write_fails(): void
    {
        $fixture = $this->fixture();
        $second = $this->secondVersion($fixture, 'Synthetic Academy North', '2026-06-01', '2027-05-31', '2026-11-01 00:00:00');
        $auditCount = DB::table('audit_events')->count();

        DB::listen(function (QueryExecuted $query): void {
            if (str_contains(strtolower($query->sql), 'insert into "audit_events"')) {
                throw new \\RuntimeException('Synthetic audit sink failure.');
            }
        });

        try {
            (new PersistedConflictAndRollbackService)->evaluateTemporalConflict(
                $this->actor('conflict-reviewer', ['evaluate_conflicts']),
                [$fixture['version'], $second],
                'conflict-audit-failure',
            );
            $this->fail('A failed audit write must abort conflict persistence.');
        } catch (\\RuntimeException $exception) {
            $this->assertSame('Synthetic audit sink failure.', $exception->getMessage());
        }

        $this->assertDatabaseCount('claim_conflicts', 0);
        $this->assertDatabaseCount('claim_conflict_candidates', 0);
        $this->assertSame($auditCount, DB::table('audit_events')->count());
    }

    public function test_automated_conflict_evaluation_and_rollback_are_denied(): void
    {
        $fixture = $this->fixture();
        $second = $this->secondVersion($fixture, 'Synthetic Academy North', '2026-06-01', '2027-05-31', '2026-11-01 00:00:00');
        $service = new PersistedConflictAndRollbackService;

        try {
            $service->evaluateTemporalConflict($this->actor('robot', ['evaluate_conflicts'], 'automation'), [$fixture['version'], $second], 'automated-conflict');
            $this->fail('Automated conflict evaluation must be denied.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('claim_conflicts', 0);
        }

        try {
            $service->rollbackPublication($this->actor('robot', ['rollback_publication'], 'automation'), 'missing-snapshot', 'policy-v1', 'test', 'automated-rollback');
            $this->fail('Automated rollback must be denied.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('publication_rollbacks', 0);
        }
    }

    public function test_rollback_creates_new_audit_and_outbox_lineage_to_prior_approved_snapshot(): void
    {
        $fixture = $this->fixture();
        $workflow = new PersistedGovernanceWorkflowService;
        $caseId = $workflow->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'rollback-case');
        $decisionId = $workflow->decideAdjudication(
            $this->actor('adjudicator', ['adjudicate_claim']),
            $caseId,
            'accepted',
            'synthetic_acceptance',
            'Accepted for rollback fixture.',
            'policy-v1',
        );
        $workflow->authorizePublication($this->actor('publisher-one', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'rollback-publish-one');
        $workflow->authorizePublication($this->actor('publisher-two', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'rollback-publish-two');
        $workflow->processOutbox();

        $snapshots = DB::table('publication_snapshots')->orderBy('snapshot_version')->get();
        $this->assertCount(2, $snapshots);
        $this->assertDatabaseHas('public_projections', ['publication_snapshot_id' => $snapshots[1]->id, 'status' => 'approved']);

        $rollbacks = new PersistedConflictAndRollbackService;
        $actor = $this->actor('rollback-officer', ['rollback_publication']);
        $rollbackId = $rollbacks->rollbackPublication($actor, $snapshots[0]->id, 'policy-v2', 'synthetic_rollback', 'rollback-key-1');
        $this->assertSame($rollbackId, $rollbacks->rollbackPublication($actor, $snapshots[0]->id, 'policy-v2', 'synthetic_rollback', 'rollback-key-1'));
        $this->assertDatabaseHas('publication_rollbacks', [
            'id' => $rollbackId,
            'current_snapshot_id' => $snapshots[1]->id,
            'target_snapshot_id' => $snapshots[0]->id,
        ]);
        $this->assertDatabaseHas('governance_outbox', [
            'aggregate_id' => $rollbackId,
            'event_type' => 'publication.snapshot.rollback',
            'status' => 'pending',
        ]);

        $workflow->processOutbox();

        $this->assertDatabaseHas('public_projections', [
            'projection_key' => $fixture['version'].':directory:anonymous',
            'publication_snapshot_id' => $snapshots[0]->id,
            'status' => 'approved',
        ]);
        $this->assertDatabaseHas('audit_events', ['target_id' => $rollbackId, 'action' => 'publication_rollback_authorized']);
        $this->assertDatabaseHas('audit_events', ['target_id' => $rollbackId, 'action' => 'publication_rollback_projected']);
        $this->assertDatabaseHas('publication_snapshots', ['id' => $snapshots[1]->id, 'status' => 'projected']);
    }

    public function test_rollback_outbox_rechecks_current_source_authorization_before_projection(): void
    {
        $fixture = $this->fixture();
        $workflow = new PersistedGovernanceWorkflowService;
        $caseId = $workflow->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'rollback-recheck-case');
        $decisionId = $workflow->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted for rollback recheck.', 'policy-v1');
        $workflow->authorizePublication($this->actor('publisher-one', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'rollback-recheck-publish-one');
        $workflow->authorizePublication($this->actor('publisher-two', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'rollback-recheck-publish-two');
        $workflow->processOutbox();
        $snapshots = DB::table('publication_snapshots')->orderBy('snapshot_version')->get();
        $rollbacks = new PersistedConflictAndRollbackService;
        $rollbackId = $rollbacks->rollbackPublication($this->actor('rollback-officer', ['rollback_publication']), $snapshots[0]->id, 'policy-v2', 'synthetic_rollback', 'rollback-recheck-key');

        DB::table('source_authorizations')->where('id', $fixture['authorization'])->update([
            'status' => 'revoked',
            'revoked_at' => now(),
        ]);
        $workflow->processOutbox();

        $this->assertDatabaseHas('public_projections', [
            'projection_key' => $fixture['version'].':directory:anonymous',
            'publication_snapshot_id' => $snapshots[1]->id,
            'status' => 'approved',
        ]);
        $event = DB::table('governance_outbox')->where('aggregate_id', $rollbackId)->first();
        $this->assertSame('pending', $event->status);
        $this->assertNotEmpty($event->last_error);
    }

    private function fixture(): array
    {
        $now = now();
        $entity = (string) str()->uuid();
        $authorization = (string) str()->uuid();
        $evidence = (string) str()->uuid();
        $claim = (string) str()->uuid();
        $version = (string) str()->uuid();

        DB::table('directory_entities')->insert([
            'id' => $entity, 'entity_type' => 'institution', 'label' => 'Synthetic Academy',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('source_authorizations')->insert([
            'id' => $authorization,
            'source_family_id' => 'synthetic-only',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['directory_publication']),
            'permitted_methods' => json_encode(['approved_projection']),
            'territories' => json_encode(['synthetic']),
            'permitted_scopes' => json_encode(['publication' => true]),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('evidence_references')->insert([
            'id' => $evidence, 'source_authorization_id' => $authorization, 'reference_kind' => 'synthetic_fixture',
            'source_type' => 'synthetic', 'status' => 'eligible_for_review', 'content_included' => false,
            'recorded_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) str()->uuid(), 'actor_class' => 'human', 'action' => 'evidence_reference_registered',
            'target_type' => 'evidence_reference', 'target_id' => $evidence, 'reason_code' => 'synthetic_fixture',
            'occurred_at' => $now, 'metadata' => json_encode(['actor_id' => 'evidence_submitter']),
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claims')->insert([
            'id' => $claim, 'subject_entity_id' => $entity, 'predicate' => 'display_name',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_versions')->insert([
            'id' => $version, 'claim_id' => $claim, 'version_number' => 1,
            'value' => json_encode(['value' => 'Synthetic Academy']),
            'valid_from' => '2026-01-01', 'valid_to' => '2026-12-31',
            'recorded_at' => '2026-01-01 00:00:00', 'disposition' => 'proposed',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(), 'claim_version_id' => $version,
            'evidence_reference_id' => $evidence, 'relationship_type' => 'supports',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        return ['version' => $version, 'authorization' => $authorization, 'evidence' => $evidence, 'claim' => $claim];
    }

    private function secondVersion(array $fixture, string $value, string $validFrom, ?string $validTo, string $recordedAt): string
    {
        $id = (string) str()->uuid();
        $now = now();
        DB::table('claim_versions')->insert([
            'id' => $id, 'claim_id' => $fixture['claim'], 'version_number' => 2,
            'value' => json_encode(['value' => $value]),
            'valid_from' => $validFrom, 'valid_to' => $validTo,
            'recorded_at' => $recordedAt, 'disposition' => 'proposed',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(), 'claim_version_id' => $id,
            'evidence_reference_id' => $fixture['evidence'], 'relationship_type' => 'supports',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        return $id;
    }

    private function actor(string $id, array $capabilities, string $class = 'human'): array
    {
        return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities];
    }
}
