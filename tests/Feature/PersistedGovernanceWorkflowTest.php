<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PersistedGovernanceWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_workflow_tables_exist(): void
    {
        foreach (['adjudication_cases', 'adjudication_decisions', 'publication_decisions', 'publication_snapshots', 'public_projections', 'governance_outbox', 'publication_suppressions', 'publication_restorations'] as $table) {
            $this->assertTrue(Schema::hasTable($table));
        }
        $this->assertTrue(Schema::hasColumns('governance_outbox', ['claim_token', 'claimed_at']));
    }

    public function test_human_adjudication_is_persisted_with_appeal_lineage_and_audit(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-1');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Synthetic evidence supports this fixture claim.', 'policy-v1');
        $appealId = $service->openAdjudicationCase($this->actor('appeals', ['open_adjudication']), $fixture['version'], 'appeal-1', 'appeal', $caseId);

        $this->assertDatabaseHas('adjudication_decisions', ['id' => $decisionId, 'outcome' => 'accepted', 'actor_id' => 'adjudicator']);
        $this->assertDatabaseHas('adjudication_cases', ['id' => $caseId, 'status' => 'decided']);
        $this->assertDatabaseHas('adjudication_cases', ['id' => $appealId, 'case_kind' => 'appeal', 'parent_case_id' => $caseId]);
        $this->assertDatabaseHas('audit_events', ['target_id' => $decisionId, 'action' => 'adjudication_decided']);
    }

    public function test_publication_creates_immutable_snapshot_and_outbox_projection_is_idempotent(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-publish');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');
        $publicationId = $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-1');

        $this->assertDatabaseHas('publication_decisions', ['id' => $publicationId, 'decision' => 'approved']);
        $snapshot = DB::table('publication_snapshots')->where('publication_decision_id', $publicationId)->first();
        $this->assertNotNull($snapshot);
        $this->assertSame(hash('sha256', $snapshot->payload), $snapshot->payload_digest);
        $this->assertSame(1, $service->processOutbox());
        $this->assertSame(0, $service->processOutbox());
        $this->assertDatabaseHas('public_projections', ['publication_snapshot_id' => $snapshot->id, 'status' => 'approved']);
        $this->assertDatabaseHas('publication_snapshots', ['id' => $snapshot->id, 'status' => 'projected']);
    }

    public function test_publication_idempotency_rejects_changed_surface_or_decision(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-idempotency');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-idempotency');

        $this->expectException(ValidationException::class);
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'partner-feed', 'anonymous', 'policy-v1', 'publish-idempotency');
    }

    public function test_same_claim_can_have_distinct_immutable_snapshots_for_multiple_surfaces(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-multi-surface');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher-one', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-surface-one');
        $service->authorizePublication($this->actor('publisher-two', ['authorize_publication']), $fixture['version'], $decisionId, 'partner-feed', 'anonymous', 'policy-v1', 'publish-surface-two');

        $this->assertSame([1, 2], DB::table('publication_snapshots')->orderBy('snapshot_version')->pluck('snapshot_version')->all());
    }

    public function test_suppression_freezes_projection_and_distinct_human_can_restore_after_recheck(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-suppress');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-suppress');
        $service->processOutbox();
        $snapshot = DB::table('publication_snapshots')->first();
        $suppressionId = $service->suppressPublication($this->actor('suppressor', ['suppress_publication']), $snapshot->id, 'synthetic_safety_hold', 'Synthetic emergency suppression test.');
        $this->assertDatabaseHas('public_projections', ['publication_snapshot_id' => $snapshot->id, 'status' => 'suppressed']);

        $restorationId = $service->restorePublication($this->actor('restorer', ['restore_publication']), $suppressionId, 'policy-v2', 'synthetic_reapproval');
        $this->assertDatabaseHas('publication_restorations', ['id' => $restorationId, 'actor_id' => 'restorer']);
        $service->processOutbox();
        $this->assertDatabaseHas('public_projections', ['publication_snapshot_id' => $snapshot->id, 'status' => 'approved']);
    }

    public function test_source_authorization_revocation_quarantines_evidence_and_freezes_every_dependent_projection(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-revoke');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted before revocation.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-revoke');
        $service->processOutbox();

        $affected = $service->revokeSourceAuthorization($this->actor('rights_officer', ['revoke_source_authorization']), $fixture['authorization'], 'synthetic_rights_change', 'Synthetic authorization revocation.');
        $this->assertSame(1, $affected);
        $this->assertDatabaseHas('evidence_references', ['id' => $fixture['evidence'], 'status' => 'quarantined']);
        $this->assertDatabaseHas('publication_snapshots', ['status' => 'suppressed']);
        $this->assertDatabaseHas('public_projections', ['status' => 'suppressed']);
        $this->assertDatabaseHas('audit_events', ['target_id' => $fixture['authorization'], 'action' => 'source_authorization_revoked']);
        $suppression = DB::table('publication_suppressions')->first();

        try {
            $service->restorePublication($this->actor('restorer', ['restore_publication']), $suppression->id, 'policy-v2', 'must_remain_suppressed');
            $this->fail('Restoration after source authorization revocation must be denied.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('publication_restorations', 0);
        }
    }

    public function test_deeni_madaris_publication_remains_default_off(): void
    {
        $fixture = $this->fixture('deeni_madaris');
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-deeni');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted synthetic fixture claim.', 'policy-v1');

        $this->expectException(ValidationException::class);
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-deeni');
    }

    public function test_adjudicator_cannot_publish_their_own_accepted_decision(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-separation');
        $decisionId = $service->decideAdjudication($this->actor('same_human', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');

        $this->expectException(ValidationException::class);
        $service->authorizePublication($this->actor('same_human', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-same-actor');
    }

    public function test_automated_adjudication_and_same_actor_publication_are_denied(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-deny');

        try {
            $service->decideAdjudication($this->actor('robot', ['adjudicate_claim'], 'automation'), $caseId, 'accepted', 'x', 'No automation allowed.', 'policy-v1');
            $this->fail('Automated adjudication should be denied.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('adjudication_decisions', 0);
        }
    }

    public function test_outbox_reclaims_a_stale_worker_lease_after_a_crash(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-stale-lease');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-stale-lease');
        $event = DB::table('governance_outbox')->first();

        DB::table('governance_outbox')->where('id', $event->id)->update([
            'status' => 'processing',
            'attempts' => 1,
            'claim_token' => (string) str()->uuid(),
            'claimed_at' => now()->subMinutes(10),
        ]);

        $this->assertSame(1, $service->processOutbox(10, 5, 5));
        $this->assertDatabaseHas('governance_outbox', [
            'id' => $event->id,
            'status' => 'processed',
            'attempts' => 2,
            'claim_token' => null,
            'claimed_at' => null,
        ]);
    }

    public function test_failed_outbox_event_is_retried_with_backoff_and_error_evidence(): void
    {
        $id = (string) str()->uuid();
        DB::table('governance_outbox')->insert([
            'id' => $id,
            'event_type' => 'unsupported.synthetic.event',
            'aggregate_type' => 'synthetic',
            'aggregate_id' => (string) str()->uuid(),
            'payload' => json_encode([], JSON_THROW_ON_ERROR),
            'idempotency_key' => 'retry-test-'.$id,
            'status' => 'pending',
            'attempts' => 0,
            'available_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $service = new PersistedGovernanceWorkflowService;
        $this->assertSame(0, $service->processOutbox(1, 3));
        $event = DB::table('governance_outbox')->where('id', $id)->first();

        $this->assertSame('pending', $event->status);
        $this->assertSame(1, (int) $event->attempts);
        $this->assertNotNull($event->last_error);
        $this->assertNotNull($event->available_at);
        $this->assertNull($event->claim_token);
        $this->assertNull($event->claimed_at);
    }

    public function test_outbox_moves_permanently_failing_event_to_dead_letter(): void
    {
        $id = (string) str()->uuid();
        DB::table('governance_outbox')->insert([
            'id' => $id,
            'event_type' => 'unsupported.synthetic.event',
            'aggregate_type' => 'synthetic',
            'aggregate_id' => (string) str()->uuid(),
            'payload' => json_encode([], JSON_THROW_ON_ERROR),
            'idempotency_key' => 'dead-letter-test-'.$id,
            'status' => 'pending',
            'attempts' => 0,
            'available_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $service = new PersistedGovernanceWorkflowService;
        $this->assertSame(0, $service->processOutbox(1, 1));
        $this->assertDatabaseHas('governance_outbox', [
            'id' => $id,
            'status' => 'dead_letter',
            'attempts' => 1,
        ]);
        $this->assertNotNull(DB::table('governance_outbox')->where('id', $id)->value('last_error'));
    }

    public function test_pending_approval_event_cannot_resurrect_a_suppressed_snapshot(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-suppress-before-project');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-suppress-before-project');
        $snapshot = DB::table('publication_snapshots')->first();
        $service->suppressPublication($this->actor('suppressor', ['suppress_publication']), $snapshot->id, 'synthetic_safety_hold', 'Suppress before pending projection is processed.');

        $this->assertSame(2, $service->processOutbox());
        $this->assertDatabaseCount('public_projections', 0);
        $this->assertDatabaseHas('publication_snapshots', ['id' => $snapshot->id, 'status' => 'suppressed']);
    }

    public function test_only_latest_snapshot_for_a_surface_is_projected_when_older_event_is_pending(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-latest-snapshot');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher-one', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-old-snapshot');
        $service->authorizePublication($this->actor('publisher-two', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-new-snapshot');
        $snapshots = DB::table('publication_snapshots')->orderBy('snapshot_version')->get();

        $this->assertSame(2, $service->processOutbox());
        $this->assertDatabaseCount('public_projections', 1);
        $this->assertDatabaseHas('public_projections', [
            'projection_key' => $fixture['version'].':directory:anonymous',
            'publication_snapshot_id' => $snapshots[1]->id,
            'status' => 'approved',
        ]);
    }

    public function test_claim_correction_creates_immutable_temporal_successor_with_audit_and_idempotency(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-correction-publish-guard');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted before a synthetic correction.', 'policy-v1');
        $originalValue = DB::table('claim_versions')->where('id', $fixture['version'])->value('value');
        $actor = $this->actor('correction-reviewer', ['correct_claim']);
        $arguments = [
            $actor,
            $fixture['version'],
            ['value' => 'Synthetic Academy Corrected'],
            [$fixture['evidence']],
            '2026-11-14',
            '2027-06-30',
            'synthetic_correction',
            'Synthetic correction supported by eligible fixture evidence.',
            'correction-key-1',
        ];

        $correctedVersionId = $service->correctClaimVersion(...$arguments);
        $this->assertSame($correctedVersionId, $service->correctClaimVersion(...$arguments));
        $this->assertSame($originalValue, DB::table('claim_versions')->where('id', $fixture['version'])->value('value'));
        $this->assertDatabaseHas('claim_versions', [
            'id' => $correctedVersionId,
            'claim_id' => DB::table('claim_versions')->where('id', $fixture['version'])->value('claim_id'),
            'version_number' => 2,
            'valid_from' => '2026-11-14',
            'valid_to' => '2027-06-30',
            'disposition' => 'proposed',
            'supersedes_version_id' => $fixture['version'],
            'correction_reason' => 'synthetic_correction',
        ]);
        $this->assertDatabaseHas('claim_evidence_links', [
            'claim_version_id' => $correctedVersionId,
            'evidence_reference_id' => $fixture['evidence'],
            'relationship_type' => 'correction_support',
        ]);
        $this->assertDatabaseHas('audit_events', [
            'target_id' => $fixture['version'],
            'action' => 'claim_version_corrected',
            'reason_code' => 'synthetic_correction',
        ]);

        $this->expectException(ValidationException::class);
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-superseded-version');
    }

    public function test_claim_correction_rejects_invalid_temporal_ranges_and_reused_keys(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $actor = $this->actor('correction-reviewer', ['correct_claim']);

        try {
            $service->correctClaimVersion($this->actor('automated-corrector', ['correct_claim'], 'automated'), $fixture['version'], ['value' => 'Automated'], [$fixture['evidence']], '2026-11-14', null, 'automated_attempt', 'Automated correction must be denied.', 'automated-correction-key');
            $this->fail('Automated actors must not correct claim versions.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('claim_versions', 1);
        }

        try {
            $service->correctClaimVersion($actor, $fixture['version'], ['value' => 'Invalid'], [$fixture['evidence']], '2027-01-01', '2026-01-01', 'invalid_range', 'Invalid synthetic range.', 'invalid-range-key');
            $this->fail('A correction whose end precedes its start must be rejected.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('claim_versions', 1);
        }

        $first = $service->correctClaimVersion($actor, $fixture['version'], ['value' => 'Corrected'], [$fixture['evidence']], '2026-11-14', null, 'synthetic_correction', 'First correction.', 'correction-reuse-key');
        $this->expectException(ValidationException::class);
        $service->correctClaimVersion($actor, $fixture['version'], ['value' => 'Different'], [$fixture['evidence']], '2026-11-14', null, 'synthetic_correction', 'Different correction.', 'correction-reuse-key');
    }

    public function test_disputed_claim_version_is_persisted_and_cannot_be_published(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-disputed');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'disputed', 'synthetic_conflict', 'Conflicting synthetic evidence requires resolution.', 'policy-v1');
        $this->assertDatabaseHas('claim_versions', ['id' => $fixture['version'], 'disposition' => 'disputed']);
        $this->assertDatabaseHas('audit_events', ['target_id' => $decisionId, 'action' => 'adjudication_decided', 'reason_code' => 'synthetic_conflict']);

        $this->expectException(ValidationException::class);
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-disputed');
    }

    public function test_claim_withdrawal_suppresses_pending_publication_and_is_idempotent(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-withdraw-pending');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted before withdrawal.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-before-withdrawal');

        $actor = $this->actor('withdrawal-officer', ['withdraw_claim']);
        $service->withdrawClaimVersion($actor, $fixture['version'], 'synthetic_withdrawal', 'Synthetic correction requires withdrawal.', 'withdraw-key-1');
        $service->withdrawClaimVersion($actor, $fixture['version'], 'synthetic_withdrawal', 'Synthetic correction requires withdrawal.', 'withdraw-key-1');
        $this->assertDatabaseHas('claim_versions', ['id' => $fixture['version'], 'disposition' => 'withdrawn']);

        $this->assertSame(2, $service->processOutbox());
        $this->assertDatabaseCount('public_projections', 0);
        $this->assertDatabaseHas('publication_snapshots', ['claim_version_id' => $fixture['version'], 'status' => 'suppressed']);
        $this->assertDatabaseHas('audit_events', ['target_id' => $fixture['version'], 'action' => 'claim_version_withdrawn']);
    }

    public function test_withdrawal_of_projected_claim_suppresses_projection_and_blocks_restoration(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService;
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-withdraw-projected');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted before withdrawal.', 'policy-v1');
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-projected-withdrawal');
        $service->processOutbox();
        $snapshot = DB::table('publication_snapshots')->first();

        $service->withdrawClaimVersion($this->actor('withdrawal-officer', ['withdraw_claim']), $fixture['version'], 'synthetic_withdrawal', 'Synthetic withdrawal after publication.', 'withdraw-key-2');
        $service->processOutbox();
        $this->assertDatabaseHas('public_projections', ['publication_snapshot_id' => $snapshot->id, 'status' => 'suppressed']);

        $suppression = DB::table('publication_suppressions')->where('publication_snapshot_id', $snapshot->id)->first();
        $this->assertNotNull($suppression);
        $this->expectException(ValidationException::class);
        $service->restorePublication($this->actor('restorer', ['restore_publication']), $suppression->id, 'policy-v2', 'withdrawn_claim_cannot_restore');
    }

    private function fixture(string $entityType = 'institution'): array
    {
        $now = now();
        $entity = (string) str()->uuid();
        $authorization = (string) str()->uuid();
        $evidence = (string) str()->uuid();
        $claim = (string) str()->uuid();
        $version = (string) str()->uuid();

        DB::table('directory_entities')->insert(['id' => $entity, 'entity_type' => $entityType, 'label' => 'Synthetic Academy', 'created_at' => $now, 'updated_at' => $now]);
        DB::table('source_authorizations')->insert([
            'id' => $authorization, 'source_family_id' => 'synthetic-only', 'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['directory_publication']), 'permitted_methods' => json_encode(['approved_projection']),
            'territories' => json_encode(['synthetic']), 'permitted_scopes' => json_encode(['publication' => true]),
            'created_at' => $now, 'updated_at' => $now,
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
        DB::table('claims')->insert(['id' => $claim, 'subject_entity_id' => $entity, 'predicate' => 'display_name', 'created_at' => $now, 'updated_at' => $now]);
        DB::table('claim_versions')->insert([
            'id' => $version, 'claim_id' => $claim, 'version_number' => 1, 'value' => json_encode(['value' => 'Synthetic Academy']),
            'recorded_at' => $now, 'disposition' => 'proposed', 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(), 'claim_version_id' => $version, 'evidence_reference_id' => $evidence,
            'relationship_type' => 'supports', 'created_at' => $now, 'updated_at' => $now,
        ]);

        return ['version' => $version, 'authorization' => $authorization, 'evidence' => $evidence];
    }

    private function actor(string $id, array $capabilities, string $class = 'human'): array
    {

        return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities];
    }
}
