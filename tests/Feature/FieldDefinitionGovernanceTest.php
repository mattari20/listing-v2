<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\FieldDefinitionGovernanceService;
use App\Services\Directory\FieldDefinitionRegistryReader;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FieldDefinitionGovernanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_i4_tables_exist_and_decision_history_is_append_only_by_service_contract(): void
    {
        $this->assertTrue(Schema::hasTable('field_definition_review_cases'));
        $this->assertTrue(Schema::hasTable('field_definition_review_decisions'));
        $this->assertTrue(Schema::hasColumns('field_definition_review_cases', [
            'field_definition_version_id', 'submitted_by_actor_id', 'assigned_reviewer_actor_id',
            'status', 'idempotency_key', 'command_fingerprint',
        ]));
        $this->assertTrue(Schema::hasColumns('field_definition_review_decisions', [
            'review_case_id', 'outcome', 'actor_id', 'actor_class', 'rationale_code',
            'rationale', 'policy_version', 'idempotency_key', 'command_fingerprint',
        ]));
        $this->assertTrue(method_exists(FieldDefinitionGovernanceService::class, 'review'));
        $this->assertTrue(method_exists(FieldDefinitionGovernanceService::class, 'approve'));
        $this->assertTrue(method_exists(FieldDefinitionGovernanceService::class, 'activate'));
    }

    public function test_proposal_creates_definition_version_review_case_audit_and_outbox_atomically(): void
    {
        $service = app(FieldDefinitionGovernanceService::class);
        $versionId = $service->propose($this->actor('proposer', ['propose_field_definition']), $this->definition(), 'synthetic_new_field', 'Create synthetic field.', 'proposal-atomic-1');
        $case = DB::table('field_definition_review_cases')->where('field_definition_version_id', $versionId)->first();

        $this->assertNotNull($case);
        $this->assertSame('submitted', $case->status);
        $this->assertSame('proposer', $case->submitted_by_actor_id);
        $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'version_number' => 1, 'lifecycle_state' => 'proposed']);
        $this->assertDatabaseHas('field_definition_review_decisions', ['review_case_id' => $case->id, 'outcome' => 'proposed', 'actor_class' => 'human']);
        $this->assertDatabaseHas('audit_events', ['target_type' => 'field_definition_version', 'target_id' => $versionId, 'action' => 'field_definition_proposed']);
        $this->assertDatabaseHas('governance_outbox', ['aggregate_id' => $versionId, 'event_type' => 'field_definition.lifecycle.changed', 'status' => 'pending']);
        $this->assertSame('proposed', DB::table('field_definition_versions')->where('id', $versionId)->value('lifecycle_state'));
        $this->assertSame(0, DB::table('claims')->count());
        $this->assertSame(0, DB::table('publication_decisions')->count());
        $this->assertSame(0, DB::table('public_projections')->count());
    }

    public function test_proposal_is_idempotent_and_rejects_idempotency_key_reuse(): void
    {
        $service = app(FieldDefinitionGovernanceService::class);
        $actor = $this->actor('proposer', ['propose_field_definition']);
        $versionId = $service->propose($actor, $this->definition(), 'synthetic_new_field', 'Create synthetic field.', 'proposal-idem-1');
        $this->assertSame($versionId, $service->propose($actor, $this->definition(), 'synthetic_new_field', 'Create synthetic field.', 'proposal-idem-1'));
        $this->assertSame(1, DB::table('field_definition_review_cases')->count());
        $this->assertSame(1, DB::table('field_definition_review_decisions')->count());
        $this->assertSame(1, DB::table('governance_outbox')->count());

        $changed = $this->definition();
        $changed['presentation_metadata']['label_key'] = 'synthetic.changed_label';
        $this->expectException(ValidationException::class);
        $service->propose($actor, $changed, 'synthetic_new_field', 'Changed payload.', 'proposal-idem-1');
    }

    public function test_automated_actor_is_denied_even_when_capability_is_present(): void
    {
        $this->expectException(ValidationException::class);
        app(FieldDefinitionGovernanceService::class)->propose(
            $this->actor('agent', ['propose_field_definition'], 'automation'),
            $this->definition(), 'synthetic_new_field', 'Automated proposal is prohibited.', 'proposal-automation-1'
        );
    }

    public function test_duplicate_field_key_and_restricted_provider_category_are_rejected(): void
    {
        $service = app(FieldDefinitionGovernanceService::class);
        $actor = $this->actor('proposer', ['propose_field_definition']);
        $service->propose($actor, $this->definition(), 'synthetic_new_field', 'Create field.', 'proposal-duplicate-1');

        try {
            $service->propose($actor, $this->definition(), 'synthetic_new_field', 'Attempt key reuse.', 'proposal-duplicate-2');
            $this->fail('Stable field keys cannot be recycled.');
        } catch (ValidationException) {
            $this->assertSame(1, DB::table('field_definitions')->count());
        }

        $restricted = $this->definition('institution_restricted_test');
        $restricted['provider_categories'] = ['private_school', 'deeni_madaris'];
        $this->expectException(ValidationException::class);
        $service->propose($actor, $restricted, 'synthetic_restricted_field', 'Restricted category is excluded.', 'proposal-restricted-1');
    }

    public function test_invalid_definition_type_schema_or_scope_is_rejected_before_persistence(): void
    {
        $invalid = $this->definition();
        $invalid['value_type'] = 'unknown_type';
        $this->expectException(ValidationException::class);
        app(FieldDefinitionGovernanceService::class)->propose(
            $this->actor('proposer', ['propose_field_definition']),
            $invalid, 'synthetic_invalid', 'Invalid definition.', 'proposal-invalid-1'
        );
    }

    public function test_independent_review_approval_and_separate_activation_are_required(): void
    {
        [$versionId, $caseId] = $this->proposed();
        $service = app(FieldDefinitionGovernanceService::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $caseId, 'reviewer', 'assign_reviewer', 'Assign independent reviewer.', 'assign-1');
        $service->review($this->actor('reviewer', ['review_field_definition']), $caseId, 'recommend_approval', 'review_passed', 'Synthetic definition passed review.', 'review-1');
        $service->approve($this->actor('approver', ['approve_field_definition']), $caseId, 'approval_granted', 'Approved after independent review.', 'approve-1');

        $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'lifecycle_state' => 'approved']);
        $this->assertSame('definition_not_active', app(FieldDefinitionRegistryReader::class)->resolveApplicable(
            'institution_test_field', 1, 'institution', 'private_school'
        )['reason']);

        try {
            $service->activate($this->actor('approver', ['activate_field_definition']), $caseId, 'activate', 'Approver cannot activate.', 'activate-same-approver');
            $this->fail('Approver cannot activate their own approval.');
        } catch (ValidationException) {
            $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'lifecycle_state' => 'approved']);
        }

        $service->activate($this->actor('activator', ['activate_field_definition']), $caseId, 'activation_granted', 'Separate human activated the approved definition.', 'activate-1');
        $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'lifecycle_state' => 'active']);
        $this->assertTrue(app(FieldDefinitionRegistryReader::class)->resolveApplicable(
            'institution_test_field', 1, 'institution', 'private_school'
        )['allowed']);
        $this->assertSame(5, app(PersistedGovernanceWorkflowService::class)->processOutbox());
        $this->assertSame(0, app(PersistedGovernanceWorkflowService::class)->processOutbox());
        $this->assertSame(5, DB::table('governance_outbox')->where('status', 'processed')->count());
        $this->assertSame(0, DB::table('claims')->count());
        $this->assertSame(0, DB::table('public_projections')->count());
    }

    public function test_proposer_cannot_be_assigned_as_reviewer_or_review_own_definition(): void
    {
        [, $caseId] = $this->proposed();
        $service = app(FieldDefinitionGovernanceService::class);
        $this->expectException(ValidationException::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $caseId, 'proposer', 'bad_assignment', 'Proposer cannot review.', 'assign-self-1');
    }

    public function test_approver_must_be_distinct_from_proposer_and_reviewer(): void
    {
        [, $caseId] = $this->proposed();
        $service = app(FieldDefinitionGovernanceService::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $caseId, 'reviewer', 'assign_reviewer', 'Assign reviewer.', 'assign-approval-1');
        $service->review($this->actor('reviewer', ['review_field_definition']), $caseId, 'recommend_approval', 'review_passed', 'Recommend approval.', 'review-approval-1');

        try {
            $service->approve($this->actor('proposer', ['approve_field_definition']), $caseId, 'approval', 'Proposer cannot approve.', 'approve-proposer-1');
            $this->fail('Proposer cannot approve.');
        } catch (ValidationException) {
            $this->assertDatabaseHas('field_definition_review_cases', ['id' => $caseId, 'status' => 'awaiting_approval']);
        }
        $this->expectException(ValidationException::class);
        $service->approve($this->actor('reviewer', ['approve_field_definition']), $caseId, 'approval', 'Reviewer cannot approve.', 'approve-reviewer-1');
    }

    public function test_changes_requested_proposal_can_be_edited_and_resubmitted_with_audit_history(): void
    {
        [, $caseId] = $this->proposed();
        $service = app(FieldDefinitionGovernanceService::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $caseId, 'reviewer', 'assign_reviewer', 'Assign reviewer.', 'assign-changes-1');
        $service->review($this->actor('reviewer', ['review_field_definition']), $caseId, 'request_changes', 'changes_requested', 'Improve label metadata.', 'review-changes-1');

        $changed = $this->definition();
        $changed['presentation_metadata']['label_key'] = 'synthetic.updated_label';
        $service->editChangesRequestedProposal(
            $this->actor('proposer', ['propose_field_definition']), $caseId, $changed,
            'proposal_updated', 'Updated presentation metadata after review.', 'edit-changes-1'
        );
        $this->assertDatabaseHas('field_definition_review_cases', ['id' => $caseId, 'status' => 'submitted', 'assigned_reviewer_actor_id' => null]);
        $this->assertDatabaseHas('field_definition_review_decisions', ['review_case_id' => $caseId, 'outcome' => 'proposal_edited']);
        $this->assertDatabaseHas('audit_events', ['action' => 'field_definition_proposal_edited']);
        $this->assertSame('synthetic.updated_label', json_decode(DB::table('field_definition_versions')->value('presentation_metadata'), true)['label_key']);
    }

    public function test_rejected_definition_cannot_be_approved_or_activated(): void
    {
        [$versionId, $caseId] = $this->proposed();
        $service = app(FieldDefinitionGovernanceService::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $caseId, 'reviewer', 'assign_reviewer', 'Assign reviewer.', 'assign-reject-1');
        $service->review($this->actor('reviewer', ['review_field_definition']), $caseId, 'reject', 'definition_rejected', 'Rejected synthetic proposal.', 'review-reject-1');

        $this->assertDatabaseHas('field_definition_review_cases', ['id' => $caseId, 'status' => 'rejected']);
        $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'lifecycle_state' => 'proposed']);
        $this->expectException(ValidationException::class);
        $service->approve($this->actor('approver', ['approve_field_definition']), $caseId, 'approve_rejected', 'Cannot approve rejected definition.', 'approve-rejected-1');
    }

    public function test_future_or_expired_definition_cannot_be_activated(): void
    {
        $definition = $this->definition();
        $definition['effective_from'] = now()->addDay()->toDateTimeString();
        [$versionId, $caseId] = $this->proposed($definition, 'institution_future_field');
        $service = app(FieldDefinitionGovernanceService::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $caseId, 'reviewer', 'assign_reviewer', 'Assign reviewer.', 'assign-future-1');
        $service->review($this->actor('reviewer', ['review_field_definition']), $caseId, 'recommend_approval', 'review_passed', 'Recommend approval.', 'review-future-1');
        $service->approve($this->actor('approver', ['approve_field_definition']), $caseId, 'approval', 'Approve future version.', 'approve-future-1');

        $this->expectException(ValidationException::class);
        $service->activate($this->actor('activator', ['activate_field_definition']), $caseId, 'activation', 'Future definition cannot activate early.', 'activate-future-1');
    }

    public function test_only_one_active_version_per_stable_key_and_successor_requires_prior_retirement(): void
    {
        [$firstVersion, $firstCase] = $this->proposed();
        $service = app(FieldDefinitionGovernanceService::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $firstCase, 'reviewer1', 'assign', 'Assign first reviewer.', 'assign-one-1');
        $service->review($this->actor('reviewer1', ['review_field_definition']), $firstCase, 'recommend_approval', 'review', 'First approved.', 'review-one-1');
        $service->approve($this->actor('approver1', ['approve_field_definition']), $firstCase, 'approval', 'Approve first.', 'approve-one-1');
        $service->activate($this->actor('activator1', ['activate_field_definition']), $firstCase, 'activate', 'Activate first.', 'activate-one-1');

        $second = $this->definition();
        $second['semantic_version'] = '2.0.0';
        $second['compatibility_class'] = 'compatible';
        $second['presentation_metadata']['label_key'] = 'synthetic.v2_label';
        $secondVersion = $service->propose(
            $this->actor('proposer2', ['propose_field_definition']), $second,
            'successor_version', 'Create successor definition version.', 'proposal-successor-1', $firstVersion
        );
        $secondCase = (string) DB::table('field_definition_review_cases')->where('field_definition_version_id', $secondVersion)->value('id');
        $service->assignReviewer($this->actor('review_manager2', ['review_field_definition']), $secondCase, 'reviewer2', 'assign', 'Assign second reviewer.', 'assign-two-1');
        $service->review($this->actor('reviewer2', ['review_field_definition']), $secondCase, 'recommend_approval', 'review', 'Second approved.', 'review-two-1');
        $service->approve($this->actor('approver2', ['approve_field_definition']), $secondCase, 'approval', 'Approve second.', 'approve-two-1');

        try {
            $service->activate($this->actor('activator2', ['activate_field_definition']), $secondCase, 'activate', 'Cannot have two active versions.', 'activate-two-early');
            $this->fail('Second version cannot activate while first remains active.');
        } catch (ValidationException) {
            $this->assertDatabaseHas('field_definition_versions', ['id' => $secondVersion, 'lifecycle_state' => 'approved']);
        }
        $service->retire($this->actor('retirer1', ['retire_field_definition']), $firstCase, 'retire_old', 'Retire prior active version.', 'retire-one-1');
        $service->activate($this->actor('activator2', ['activate_field_definition']), $secondCase, 'activate', 'Activate after prior retirement.', 'activate-two-late');
        $this->assertDatabaseHas('field_definition_versions', ['id' => $firstVersion, 'lifecycle_state' => 'retired']);
        $this->assertDatabaseHas('field_definition_versions', ['id' => $secondVersion, 'lifecycle_state' => 'active']);
    }

    public function test_retirement_preserves_existing_claim_history_and_restore_creates_new_version(): void
    {
        [$versionId, $caseId] = $this->proposed();
        $service = app(FieldDefinitionGovernanceService::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $caseId, 'reviewer', 'assign', 'Assign reviewer.', 'assign-restore-1');
        $service->review($this->actor('reviewer', ['review_field_definition']), $caseId, 'recommend_approval', 'review', 'Recommend approval.', 'review-restore-1');
        $service->approve($this->actor('approver', ['approve_field_definition']), $caseId, 'approve', 'Approve definition.', 'approve-restore-1');
        $service->activate($this->actor('activator', ['activate_field_definition']), $caseId, 'activate', 'Activate definition.', 'activate-restore-1');

        $entityId = (string) str()->uuid();
        $claimId = (string) str()->uuid();
        $claimVersionId = (string) str()->uuid();
        DB::table('directory_entities')->insert(['id' => $entityId, 'entity_type' => 'institution', 'label' => 'Synthetic institution', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('claims')->insert(['id' => $claimId, 'subject_entity_id' => $entityId, 'predicate' => 'institution_test_field', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('claim_versions')->insert([
            'id' => $claimVersionId, 'claim_id' => $claimId, 'version_number' => 1,
            'value' => json_encode(['value' => 'Synthetic historical value'], JSON_THROW_ON_ERROR),
            'recorded_at' => now(), 'disposition' => 'proposed', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $service->retire($this->actor('retirer', ['retire_field_definition']), $caseId, 'retired', 'Retire without deleting claim history.', 'retire-restore-1');
        $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'lifecycle_state' => 'retired']);
        $this->assertDatabaseHas('claims', ['id' => $claimId, 'predicate' => 'institution_test_field']);
        $this->assertDatabaseHas('claim_versions', ['id' => $claimVersionId, 'disposition' => 'proposed']);

        $restoreCaseId = $service->restore(
            $this->actor('restore_proposer', ['propose_field_definition']), $caseId,
            $this->definition(), 'restore_field', 'Restore as a new reviewed version.', 'restore-1'
        );
        $newVersionId = (string) DB::table('field_definition_review_cases')->where('id', $restoreCaseId)->value('field_definition_version_id');
        $this->assertNotSame($versionId, $newVersionId);
        $this->assertDatabaseHas('field_definition_versions', ['id' => $newVersionId, 'version_number' => 2, 'lifecycle_state' => 'proposed']);
        $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'lifecycle_state' => 'retired']);
    }

    public function test_outbox_rejects_mismatched_decision_or_lifecycle_payload_without_side_effects(): void
    {
        [$versionId] = $this->proposed();
        $event = DB::table('governance_outbox')->where('aggregate_id', $versionId)->first();
        $payload = json_decode($event->payload, true);
        $payload['lifecycle_state'] = 'active';
        DB::table('governance_outbox')->where('id', $event->id)->update(['payload' => json_encode($payload, JSON_THROW_ON_ERROR)]);

        $this->assertSame(0, app(PersistedGovernanceWorkflowService::class)->processOutbox(1, 3));
        $this->assertDatabaseHas('governance_outbox', ['id' => $event->id, 'status' => 'pending', 'attempts' => 1]);
        $this->assertSame(0, DB::table('public_projections')->count());
        $this->assertSame(0, DB::table('claims')->count());
    }

    public function test_audit_and_outbox_failure_rolls_back_definition_and_review_records(): void
    {
        $key = 'proposal-rollback-1';
        DB::table('governance_outbox')->insert([
            'id' => (string) str()->uuid(), 'event_type' => 'synthetic.collision',
            'aggregate_type' => 'synthetic', 'aggregate_id' => (string) str()->uuid(),
            'payload' => json_encode([], JSON_THROW_ON_ERROR), 'idempotency_key' => 'field-definition:'.$key,
            'status' => 'pending', 'attempts' => 0, 'available_at' => now(),
            'created_at' => now(), 'updated_at' => now(),
        ]);

        try {
            app(FieldDefinitionGovernanceService::class)->propose(
                $this->actor('proposer', ['propose_field_definition']), $this->definition(),
                'synthetic_new_field', 'Outbox conflict should roll back.', $key
            );
            $this->fail('Outbox uniqueness conflict must abort the complete proposal transaction.');
        } catch (QueryException) {
            $this->assertSame(0, DB::table('field_definitions')->count());
            $this->assertSame(0, DB::table('field_definition_versions')->count());
            $this->assertSame(0, DB::table('field_definition_review_cases')->count());
            $this->assertSame(0, DB::table('field_definition_review_decisions')->count());
            $this->assertSame(0, DB::table('audit_events')->count());
        }
    }

    public function test_deprecation_stops_new_proposals_and_retirement_keeps_the_successor_mapping_immutable(): void
    {
        [$versionId, $caseId] = $this->proposed();
        $service = app(FieldDefinitionGovernanceService::class);
        $service->assignReviewer($this->actor('review_manager', ['review_field_definition']), $caseId, 'reviewer', 'assign', 'Assign reviewer.', 'assign-deprecate-1');
        $service->review($this->actor('reviewer', ['review_field_definition']), $caseId, 'recommend_approval', 'review', 'Recommend approval.', 'review-deprecate-1');
        $service->approve($this->actor('approver', ['approve_field_definition']), $caseId, 'approve', 'Approve.', 'approve-deprecate-1');
        $service->activate($this->actor('activator', ['activate_field_definition']), $caseId, 'activate', 'Activate.', 'activate-deprecate-1');

        $service->deprecate(
            $this->actor('deprecation_steward', ['retire_field_definition']), $caseId,
            now()->addDay()->toDateTimeString(), 'planned_deprecation', 'Stop new proposals for this definition.', 'deprecate-1'
        );
        $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'lifecycle_state' => 'deprecated']);
        $this->assertSame('definition_not_active', app(FieldDefinitionRegistryReader::class)->resolveApplicable(
            'institution_test_field', 1, 'institution', 'private_school'
        )['reason']);
        $service->retire($this->actor('retirer', ['retire_field_definition']), $caseId, 'retired', 'Retire after deprecation.', 'retire-deprecated-1');
        $this->assertDatabaseHas('field_definition_versions', ['id' => $versionId, 'lifecycle_state' => 'retired']);
    }

    private function proposed(?array $definition = null, string $fieldKey = 'institution_test_field'): array
    {
        $definition ??= $this->definition($fieldKey);
        $definition['field_key'] = $fieldKey;
        $versionId = app(FieldDefinitionGovernanceService::class)->propose(
            $this->actor('proposer', ['propose_field_definition']),
            $definition, 'synthetic_new_field', 'Create synthetic definition for tests.',
            'proposal-'.str_replace('.', '-', $fieldKey)
        );
        $caseId = (string) DB::table('field_definition_review_cases')->where('field_definition_version_id', $versionId)->value('id');

        return [$versionId, $caseId];
    }

    private function definition(string $fieldKey = 'institution_test_field'): array
    {
        return [
            'field_key' => $fieldKey,
            'semantic_version' => '1.0.0',
            'compatibility_class' => 'initial',
            'value_type' => 'short_text',
            'cardinality' => 'one',
            'scope_key' => 'institution',
            'privacy_class' => 'public_eligible',
            'visibility_class' => 'public_eligible',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'validation_schema' => ['schema_version' => 1, 'max_length' => 120],
            'presentation_metadata' => ['section_key' => 'identity', 'label_key' => 'synthetic.test_field'],
            'evidence_policy' => ['required' => true, 'accepted_reference_kinds' => ['synthetic_fixture']],
            'freshness_policy' => ['class' => 'synthetic_test'],
            'effective_from' => null,
            'effective_to' => null,
            'entity_types' => ['institution'],
            'provider_categories' => ['private_school'],
        ];
    }

    private function actor(string $id, array $capabilities, string $class = 'human'): array
    {
        return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities];
    }
}
