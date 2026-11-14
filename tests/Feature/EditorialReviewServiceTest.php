<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\EditorialReviewService;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class EditorialReviewServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_review_tables_exist_and_capability_matrix_is_explicit(): void
    {
        $this->assertTrue(Schema::hasTable('editorial_review_cases'));
        $this->assertTrue(Schema::hasTable('directory_status_history'));
        $this->assertSame([
            'submit' => 'submit_directory_proposal', 'edit' => 'edit_directory_proposal',
            'review' => 'review_directory_proposal', 'adjudicate' => 'adjudicate_claim',
            'approve' => 'authorize_publication', 'suppress' => 'suppress_publication',
            'restore' => 'restore_publication',
        ], (new EditorialReviewService)->capabilityMatrix());
    }

    public function test_submission_is_idempotent_and_submitter_cannot_review_own_proposal(): void
    {
        $fixture = $this->fixture();
        $service = new EditorialReviewService;
        $submitter = $this->actor('submitter', ['submit_directory_proposal', 'review_directory_proposal']);
        $case = $service->submit($submitter, $fixture['entity'], $fixture['version'], 'submit-1');
        $this->assertSame($case, $service->submit($submitter, $fixture['entity'], $fixture['version'], 'submit-1'));

        try {
            $service->startReview($submitter, $case, 'review-own');
            $this->fail('A submitter must not review their own proposal.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('directory_status_history', 1);
        }
    }

    public function test_automated_actor_cannot_submit_or_review_and_reviewer_cannot_adjudicate(): void
    {
        $fixture = $this->fixture();
        $service = new EditorialReviewService;
        $case = $service->submit($this->actor('submitter', ['submit_directory_proposal']), $fixture['entity'], $fixture['version'], 'submit-2');

        try {
            $service->startReview($this->actor('robot', ['review_directory_proposal'], 'automated'), $case, 'review-robot');
            $this->fail('Automated review must be denied.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('directory_status_history', 1);
        }

        $reviewer = $this->actor('reviewer', ['review_directory_proposal', 'adjudicate_claim']);
        $service->startReview($reviewer, $case, 'review-2');
        $service->completeReview($reviewer, $case, 'ready_for_adjudication', 'synthetic_review', 'Synthetic review completed.', 'review-complete-2');
        $adjudication = app(PersistedGovernanceWorkflowService::class)->openAdjudicationCase(
            $this->actor('case-opener', ['open_adjudication']), $fixture['version'], 'adjudication-case-2'
        );
        try {
            $service->adjudicate($reviewer, $case, $adjudication, 'accepted', 'synthetic_acceptance', 'Not permitted to adjudicate own review.', 'policy-v1', 'adjudicate-reviewer');
            $this->fail('The assigned reviewer must not adjudicate the same proposal.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('adjudication_decisions', 0);
        }
    }

    public function test_full_editorial_flow_enforces_independent_roles_and_records_status_history(): void
    {
        $fixture = $this->fixture();
        $service = new EditorialReviewService;
        $case = $service->submit($this->actor('submitter', ['submit_directory_proposal']), $fixture['entity'], $fixture['version'], 'submit-full');
        $reviewer = $this->actor('reviewer', ['review_directory_proposal']);
        $service->startReview($reviewer, $case, 'review-start-full');
        $service->completeReview($reviewer, $case, 'ready_for_adjudication', 'synthetic_review', 'Independent review passed.', 'review-finish-full');

        $adjudicationCase = app(PersistedGovernanceWorkflowService::class)->openAdjudicationCase(
            $this->actor('case-opener', ['open_adjudication']), $fixture['version'], 'adjudication-case-full'
        );
        $decision = $service->adjudicate(
            $this->actor('adjudicator', ['adjudicate_claim']), $case, $adjudicationCase, 'accepted',
            'synthetic_acceptance', 'Synthetic claim accepted after review.', 'policy-v1', 'adjudicate-full'
        );
        $publication = $service->approve(
            $this->actor('publisher', ['authorize_publication']), $case, 'directory', 'anonymous', 'policy-v1', 'approve-full'
        );
        $snapshot = DB::table('publication_snapshots')->where('publication_decision_id', $publication)->first();
        $this->assertNotNull($snapshot);

        $suppression = $service->suppress(
            $this->actor('suppressor', ['suppress_publication']), $case, $snapshot->id,
            'synthetic_hold', 'Synthetic suppression test.'
        );
        $restoration = $service->restore(
            $this->actor('restorer', ['restore_publication']), $case, $suppression, 'policy-v2', 'synthetic_restore'
        );

        $this->assertNotSame('', $decision);
        $this->assertNotSame('', $restoration);
        $this->assertEqualsCanonicalizing(
            ['submitted', 'in_review', 'ready_for_adjudication', 'adjudicated_accepted', 'approved', 'suppressed', 'restored'],
            DB::table('directory_status_history')->where('editorial_review_case_id', $case)->pluck('new_status')->all()
        );
        $this->assertDatabaseHas('audit_events', ['target_id' => $case, 'action' => 'directory_editorial_publication_restored']);
    }

    public function test_disputed_review_never_reaches_publication_approval(): void
    {
        $fixture = $this->fixture();
        $service = new EditorialReviewService;
        $case = $service->submit($this->actor('submitter', ['submit_directory_proposal']), $fixture['entity'], $fixture['version'], 'submit-disputed');
        $reviewer = $this->actor('reviewer', ['review_directory_proposal']);
        $service->startReview($reviewer, $case, 'review-disputed');
        $service->completeReview($reviewer, $case, 'ready_for_adjudication', 'synthetic_review', 'Review completed.', 'review-done-disputed');
        $adjudicationCase = app(PersistedGovernanceWorkflowService::class)->openAdjudicationCase(
            $this->actor('case-opener', ['open_adjudication']), $fixture['version'], 'adjudication-disputed'
        );
        $service->adjudicate(
            $this->actor('adjudicator', ['adjudicate_claim']), $case, $adjudicationCase, 'disputed',
            'synthetic_conflict', 'Conflicting synthetic evidence.', 'policy-v1', 'adjudicate-disputed'
        );

        $this->expectException(ValidationException::class);
        $service->approve($this->actor('publisher', ['authorize_publication']), $case, 'directory', 'anonymous', 'policy-v1', 'approve-disputed');
    }

    private function fixture(): array
    {
        $now = now();
        $entity = (string) str()->uuid();
        $authorization = (string) str()->uuid();
        $evidence = (string) str()->uuid();
        $claim = (string) str()->uuid();
        $version = (string) str()->uuid();
        DB::table('directory_entities')->insert(['id' => $entity, 'entity_type' => 'institution', 'label' => 'Synthetic Editorial Academy', 'created_at' => $now, 'updated_at' => $now]);
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
            'id' => $version, 'claim_id' => $claim, 'version_number' => 1, 'value' => json_encode(['value' => 'Synthetic Editorial Academy']),
            'recorded_at' => $now, 'disposition' => 'proposed', 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(), 'claim_version_id' => $version, 'evidence_reference_id' => $evidence,
            'relationship_type' => 'supports', 'created_at' => $now, 'updated_at' => $now,
        ]);
        return ['entity' => $entity, 'version' => $version];
    }

    private function actor(string $id, array $capabilities, string $class = 'human'): array
    {
        return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities];
    }
}
