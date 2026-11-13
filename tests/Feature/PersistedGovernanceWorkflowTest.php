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
    }

    public function test_human_adjudication_is_persisted_with_appeal_lineage_and_audit(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService();
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
        $service = new PersistedGovernanceWorkflowService();
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

    public function test_suppression_freezes_projection_and_distinct_human_can_restore_after_recheck(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService();
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
        $service = new PersistedGovernanceWorkflowService();
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
        $service = new PersistedGovernanceWorkflowService();
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-deeni');
        $decisionId = $service->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted synthetic fixture claim.', 'policy-v1');

        $this->expectException(ValidationException::class);
        $service->authorizePublication($this->actor('publisher', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-deeni');
    }

    public function test_adjudicator_cannot_publish_their_own_accepted_decision(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService();
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-separation');
        $decisionId = $service->decideAdjudication($this->actor('same_human', ['adjudicate_claim']), $caseId, 'accepted', 'synthetic_acceptance', 'Accepted after synthetic review.', 'policy-v1');

        $this->expectException(ValidationException::class);
        $service->authorizePublication($this->actor('same_human', ['authorize_publication']), $fixture['version'], $decisionId, 'directory', 'anonymous', 'policy-v1', 'publish-same-actor');
    }

    public function test_automated_adjudication_and_same_actor_publication_are_denied(): void
    {
        $fixture = $this->fixture();
        $service = new PersistedGovernanceWorkflowService();
        $caseId = $service->openAdjudicationCase($this->actor('reviewer', ['open_adjudication']), $fixture['version'], 'case-deny');
        try {
            $service->decideAdjudication($this->actor('robot', ['adjudicate_claim'], 'automation'), $caseId, 'accepted', 'x', 'No automation allowed.', 'policy-v1');
            $this->fail('Automated adjudication should be denied.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('adjudication_decisions', 0);
        }
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
