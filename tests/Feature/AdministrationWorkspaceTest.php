<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\RoleAssignment;
use App\Models\User;
use App\Services\Directory\AdministrationWorkspaceQueryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class AdministrationWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_workspace_requires_an_authenticated_active_verified_user_with_a_supported_scoped_role(): void
    {
        $this->getJson('/workspace')->assertUnauthorized();

        $institution = $this->institution();
        $unverified = $this->user('unverified@example.test', verified: false);
        $this->assign($unverified, 'institution_representative', $institution);
        $this->actingAs($unverified)->getJson('/workspace')->assertForbidden();

        $inactive = $this->user('inactive@example.test', active: false);
        $this->assign($inactive, 'institution_representative', $institution);
        $this->actingAs($inactive)->getJson('/workspace')->assertForbidden();

        $ordinary = $this->user('ordinary@example.test');
        $this->actingAs($ordinary)->getJson('/workspace')->assertForbidden();

        $administrator = $this->user('admin@example.test');
        $this->assign($administrator, 'administrator', $institution, 'user');
        $this->actingAs($administrator)->getJson('/workspace')->assertForbidden();
    }

    public function test_representative_sees_only_own_submissions_within_assigned_university_scope(): void
    {
        $institution = $this->institution();
        $otherInstitution = $this->institution();
        $representative = $this->user('representative@example.test');
        $otherRepresentative = $this->user('other-representative@example.test');
        $this->assign($representative, 'institution_representative', $institution);
        $ownCase = $this->case($institution, $representative);
        $otherOwnCase = $this->case($institution, $otherRepresentative);
        $outsideCase = $this->case($otherInstitution, $representative);

        $response = $this->actingAs($representative)->get('/workspace')->assertOk();
        $response->assertSee($ownCase['id']);
        $response->assertDontSee($otherOwnCase['id']);
        $response->assertDontSee($outsideCase['id']);
        $response->assertHeader('Cache-Control', 'max-age=0, no-store, private');
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_reviewer_queue_is_limited_to_assigned_scope_and_excludes_self_submitted_cases(): void
    {
        $institution = $this->institution();
        $otherInstitution = $this->institution();
        $reviewer = $this->user('reviewer@example.test');
        $submitter = $this->user('submitter@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);

        $reviewable = $this->case($institution, $submitter);
        $selfSubmitted = $this->case($institution, $reviewer);
        $outsideScope = $this->case($otherInstitution, $submitter);

        $response = $this->actingAs($reviewer)->get('/workspace')->assertOk();
        $response->assertSee($reviewable['id']);
        $response->assertDontSee($selfSubmitted['id']);
        $response->assertDontSee($outsideScope['id']);
    }

    public function test_reviewer_queue_excludes_cases_where_reviewer_registered_linked_evidence(): void
    {
        $institution = $this->institution();
        $reviewer = $this->user('evidence-reviewer@example.test');
        $submitter = $this->user('evidence-submitter@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $case = $this->case($institution, $submitter);

        $authorizationId = (string) str()->uuid();
        $evidenceId = (string) str()->uuid();
        $now = now();
        DB::table('source_authorizations')->insert([
            'id' => $authorizationId,
            'source_family_id' => 'synthetic-only',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['synthetic_test_only'], JSON_THROW_ON_ERROR),
            'permitted_methods' => json_encode(['fixture_reference'], JSON_THROW_ON_ERROR),
            'territories' => json_encode(['synthetic'], JSON_THROW_ON_ERROR),
            'permitted_scopes' => json_encode(['processing' => true], JSON_THROW_ON_ERROR),
            'valid_from' => null,
            'valid_to' => null,
            'revoked_at' => null,
            'revocation_reason' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('evidence_references')->insert([
            'id' => $evidenceId,
            'source_authorization_id' => $authorizationId,
            'reference_kind' => 'synthetic_fixture',
            'source_type' => 'synthetic',
            'integrity_digest' => 'sha256:synthetic-workspace-test',
            'status' => 'eligible_for_review',
            'content_included' => false,
            'observed_at' => $now,
            'recorded_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(),
            'claim_version_id' => $case['claim_version_id'],
            'evidence_reference_id' => $evidenceId,
            'relationship_type' => 'supports',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) str()->uuid(),
            'actor_class' => 'human',
            'action' => 'evidence_reference_registered',
            'target_type' => 'evidence_reference',
            'target_id' => $evidenceId,
            'reason_code' => 'synthetic_fixture',
            'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => 'user:'.$reviewer->getKey()], JSON_THROW_ON_ERROR),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->actingAs($reviewer)->get('/workspace')->assertOk()->assertDontSee($case['id']);
    }

    public function test_workspace_includes_exact_parent_scoped_child_cases_and_only_the_reviewers_assigned_in_review_work(): void
    {
        $institution = $this->institution();
        $otherInstitution = $this->institution();
        $reviewer = $this->user('child-queue-reviewer@example.test');
        $submitter = $this->user('child-queue-submitter@example.test');
        $otherReviewer = $this->user('child-queue-other-reviewer@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);

        $campusSubmitted = $this->childCase($institution, $submitter, 'campus', 'submitted');
        $siteAssigned = $this->childCase($institution, $submitter, 'delivery_site', 'in_review', 'user:'.$reviewer->getKey());
        $campusAssignedElsewhere = $this->childCase($institution, $submitter, 'campus', 'in_review', 'user:'.$otherReviewer->getKey());
        $outsideScope = $this->childCase($otherInstitution, $submitter, 'delivery_site', 'submitted');
        $mismatchedProjection = $this->childCase($institution, $submitter, 'campus', 'submitted', null, $otherInstitution);

        $response = $this->actingAs($reviewer)->get('/workspace')->assertOk();
        $response->assertSee($campusSubmitted['id']);
        $response->assertSee($siteAssigned['id']);
        $response->assertDontSee($campusAssignedElsewhere['id']);
        $response->assertDontSee($outsideScope['id']);
        $response->assertDontSee($mismatchedProjection['id']);
        $response->assertSee('Start reviewing this submission');
        $response->assertSee('Continue your assigned review');
        $response->assertSee('Synthetic campus child');
        $response->assertSee('Synthetic delivery_site child');
    }

    public function test_representative_workspace_surfaces_returned_campus_correction_next_action_in_parent_scope(): void
    {
        $institution = $this->institution();
        $otherInstitution = $this->institution();
        $representative = $this->user('child-correction-representative@example.test');
        $this->assign($representative, 'institution_representative', $institution);
        $returnedChildCase = $this->childCase($institution, $representative, 'campus', 'changes_requested');
        $outsideChildCase = $this->childCase($otherInstitution, $representative, 'delivery_site', 'changes_requested');

        $response = $this->actingAs($representative)->get('/workspace')->assertOk();
        $response->assertSee($returnedChildCase['id']);
        $response->assertDontSee($outsideChildCase['id']);
        $response->assertSee('Correct and resubmit');
        $response->assertSee('Synthetic campus child');
        $response->assertSee('Parent institution');
    }

    public function test_expired_or_revoked_scoped_assignments_do_not_grant_workspace_access(): void
    {
        $institution = $this->institution();
        $expired = $this->user('expired@example.test');
        $expiredAssignment = $this->assign($expired, 'institution_representative', $institution);
        $expiredAssignment->forceFill(['expires_at' => now()->subMinute()])->save();

        $revoked = $this->user('revoked@example.test');
        $revokedAssignment = $this->assign($revoked, 'institution_representative', $institution);
        $revokedAssignment->forceFill(['revoked_at' => now()])->save();

        $this->actingAs($expired)->getJson('/workspace')->assertForbidden();
        $this->actingAs($revoked)->getJson('/workspace')->assertForbidden();
    }

    public function test_reviewer_case_detail_is_scoped_and_never_exposes_raw_evidence_digest_or_audit_metadata(): void
    {
        $institution = $this->institution();
        $reviewer = $this->user('detail-reviewer@example.test');
        $submitter = $this->user('detail-submitter@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $case = $this->case($institution, $submitter);
        $authorizationId = (string) str()->uuid();
        $evidenceId = (string) str()->uuid();
        $now = now();

        DB::table('source_authorizations')->insert([
            'id' => $authorizationId, 'source_family_id' => 'synthetic-only',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['synthetic_test_only'], JSON_THROW_ON_ERROR),
            'permitted_methods' => json_encode(['fixture_reference'], JSON_THROW_ON_ERROR),
            'territories' => json_encode(['synthetic'], JSON_THROW_ON_ERROR),
            'permitted_scopes' => json_encode(['processing' => true], JSON_THROW_ON_ERROR),
            'valid_from' => null, 'valid_to' => null, 'revoked_at' => null, 'revocation_reason' => null,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('evidence_references')->insert([
            'id' => $evidenceId, 'source_authorization_id' => $authorizationId,
            'reference_kind' => 'synthetic_fixture', 'source_type' => 'synthetic',
            'integrity_digest' => 'sha256:private-evidence-digest',
            'status' => 'eligible_for_review', 'content_included' => false,
            'observed_at' => $now, 'recorded_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(), 'claim_version_id' => $case['claim_version_id'],
            'evidence_reference_id' => $evidenceId, 'relationship_type' => 'supports',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) str()->uuid(), 'actor_class' => 'human',
            'action' => 'evidence_reference_registered', 'target_type' => 'evidence_reference',
            'target_id' => $evidenceId, 'reason_code' => 'synthetic_fixture', 'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => 'user:'.$submitter->getKey(), 'private_audit_note' => 'hidden-note'], JSON_THROW_ON_ERROR),
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('directory_status_history')->insert([
            'id' => (string) str()->uuid(), 'entity_id' => $institution,
            'claim_version_id' => $case['claim_version_id'], 'editorial_review_case_id' => $case['id'],
            'event_type' => 'proposal_submitted', 'previous_status' => null, 'new_status' => 'submitted',
            'actor_id' => 'user:'.$submitter->getKey(), 'actor_class' => 'human',
            'reason_code' => 'synthetic_submission', 'idempotency_key' => 'history-'.str()->uuid(),
            'fingerprint' => hash('sha256', $case['id']),
            'metadata' => json_encode(['private_history_note' => 'hidden-history-note'], JSON_THROW_ON_ERROR),
            'occurred_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);

        $this->actingAs($reviewer)
            ->get('/institutions/'.$institution.'/editorial-cases/'.$case['id'])
            ->assertOk()
            ->assertSee($evidenceId)
            ->assertSee('synthetic_fixture')
            ->assertSee('proposal submitted')
            ->assertSee('Unbounded / incomplete')
            ->assertDontSee('sha256:private-evidence-digest')
            ->assertDontSee('hidden-note')
            ->assertDontSee('hidden-history-note')
            ->assertHeader('Cache-Control', 'max-age=0, no-store, private')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_reviewer_evidence_authorization_states_are_explicit_and_private_metadata_stays_hidden(): void
    {
        $institution = $this->institution();
        $reviewer = $this->user('authorization-state-reviewer@example.test');
        $submitter = $this->user('authorization-state-submitter@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $case = $this->case($institution, $submitter);
        $now = now();
        $states = [
            'current' => ['status' => 'approved_for_defined_purpose_and_method', 'from' => $now->copy()->subDay(), 'to' => $now->copy()->addDay(), 'revoked' => null],
            'expired' => ['status' => 'approved_for_defined_purpose_and_method', 'from' => $now->copy()->subDays(3), 'to' => $now->copy()->subDay(), 'revoked' => null],
            'not_yet_valid' => ['status' => 'approved_for_defined_purpose_and_method', 'from' => $now->copy()->addDay(), 'to' => $now->copy()->addDays(2), 'revoked' => null],
            'revoked' => ['status' => 'approved_for_defined_purpose_and_method', 'from' => $now->copy()->subDay(), 'to' => $now->copy()->addDay(), 'revoked' => $now->copy()->subHour()],
            'not_approved' => ['status' => 'draft', 'from' => $now->copy()->subDay(), 'to' => $now->copy()->addDay(), 'revoked' => null],
            'unbounded' => ['status' => 'approved_for_defined_purpose_and_method', 'from' => null, 'to' => null, 'revoked' => null],
            'invalid_window' => ['status' => 'approved_for_defined_purpose_and_method', 'from' => $now->copy()->addDays(2), 'to' => $now->copy()->addDay(), 'revoked' => null],
        ];

        foreach ($states as $name => $state) {
            $authorizationId = (string) str()->uuid();
            $evidenceId = (string) str()->uuid();
            DB::table('source_authorizations')->insert([
                'id' => $authorizationId,
                'source_family_id' => 'synthetic-only',
                'status' => $state['status'],
                'permitted_purposes' => json_encode(['private-purpose-must-not-leak'], JSON_THROW_ON_ERROR),
                'permitted_methods' => json_encode(['private-method-must-not-leak'], JSON_THROW_ON_ERROR),
                'territories' => json_encode(['synthetic'], JSON_THROW_ON_ERROR),
                'permitted_scopes' => json_encode(['private_scope_must_not_leak' => true], JSON_THROW_ON_ERROR),
                'valid_from' => $state['from'],
                'valid_to' => $state['to'],
                'revoked_at' => $state['revoked'],
                'revocation_reason' => 'private-revocation-reason-must-not-leak',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('evidence_references')->insert([
                'id' => $evidenceId,
                'source_authorization_id' => $authorizationId,
                'reference_kind' => 'synthetic_'.$name,
                'source_type' => 'synthetic',
                'integrity_digest' => 'sha256-private-'.$name,
                'status' => 'eligible_for_review',
                'content_included' => false,
                'observed_at' => $now,
                'recorded_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('claim_evidence_links')->insert([
                'id' => (string) str()->uuid(),
                'claim_version_id' => $case['claim_version_id'],
                'evidence_reference_id' => $evidenceId,
                'relationship_type' => 'supports',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('audit_events')->insert([
                'id' => (string) str()->uuid(),
                'actor_class' => 'human',
                'action' => 'evidence_reference_registered',
                'target_type' => 'evidence_reference',
                'target_id' => $evidenceId,
                'reason_code' => 'synthetic_fixture',
                'occurred_at' => $now,
                'metadata' => json_encode(['actor_id' => 'synthetic-evidence-owner-'.$name, 'private_actor_note' => 'private-actor-must-not-leak'], JSON_THROW_ON_ERROR),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $details = app(AdministrationWorkspaceQueryService::class)->editorialCaseDetails(
            $case['id'],
            'user:'.$reviewer->getKey()
        );
        $this->assertNotNull($details);
        $byKind = collect($details['evidence'])->keyBy('reference_kind');
        foreach ($states as $name => $_state) {
            $this->assertArrayHasKey('synthetic_'.$name, $byKind);
            $this->assertSame($name, $byKind['synthetic_'.$name]['authorization_window_state']);
        }
        $encoded = json_encode($details, JSON_THROW_ON_ERROR);
        foreach (['private-purpose-must-not-leak', 'private-method-must-not-leak', 'private_scope_must_not_leak', 'private-revocation-reason-must-not-leak', 'private-actor-must-not-leak', 'sha256-private-'] as $secret) {
            $this->assertStringNotContainsString($secret, $encoded);
        }

        $this->actingAs($reviewer)
            ->get('/institutions/'.$institution.'/editorial-cases/'.$case['id'])
            ->assertOk()
            ->assertSee('Current')
            ->assertSee('Expired')
            ->assertSee('Not yet valid')
            ->assertSee('Revoked')
            ->assertSee('Not approved')
            ->assertSee('Unbounded / incomplete')
            ->assertSee('Invalid validity window');
    }

    public function test_case_detail_denies_submitter_and_evidence_contributor(): void
    {
        $institution = $this->institution();
        $reviewer = $this->user('contributor-reviewer@example.test');
        $submitter = $this->user('case-owner@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $case = $this->case($institution, $submitter);

        $this->actingAs($submitter)
            ->get('/institutions/'.$institution.'/editorial-cases/'.$case['id'])
            ->assertForbidden();

        $authorizationId = (string) str()->uuid();
        $evidenceId = (string) str()->uuid();
        $now = now();
        DB::table('source_authorizations')->insert([
            'id' => $authorizationId, 'source_family_id' => 'synthetic-only',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['synthetic_test_only'], JSON_THROW_ON_ERROR),
            'permitted_methods' => json_encode(['fixture_reference'], JSON_THROW_ON_ERROR),
            'territories' => json_encode(['synthetic'], JSON_THROW_ON_ERROR),
            'permitted_scopes' => json_encode(['processing' => true], JSON_THROW_ON_ERROR),
            'valid_from' => null, 'valid_to' => null, 'revoked_at' => null, 'revocation_reason' => null,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('evidence_references')->insert([
            'id' => $evidenceId, 'source_authorization_id' => $authorizationId,
            'reference_kind' => 'synthetic_fixture', 'source_type' => 'synthetic',
            'integrity_digest' => null, 'status' => 'eligible_for_review', 'content_included' => false,
            'observed_at' => $now, 'recorded_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(), 'claim_version_id' => $case['claim_version_id'],
            'evidence_reference_id' => $evidenceId, 'relationship_type' => 'supports',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) str()->uuid(), 'actor_class' => 'human',
            'action' => 'evidence_reference_registered', 'target_type' => 'evidence_reference',
            'target_id' => $evidenceId, 'reason_code' => 'synthetic_fixture', 'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => 'user:'.$reviewer->getKey()], JSON_THROW_ON_ERROR),
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $this->actingAs($reviewer)
            ->get('/institutions/'.$institution.'/editorial-cases/'.$case['id'])
            ->assertNotFound();
    }

    public function test_case_detail_displays_immutable_correction_version_history(): void
    {
        $institution = $this->institution();
        $reviewer = $this->user('correction-reviewer@example.test');
        $submitter = $this->user('correction-submitter@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $original = $this->case($institution, $submitter);
        $now = now();
        DB::table('editorial_review_cases')->where('id', $original['id'])->update(['status' => 'superseded']);

        DB::table('directory_status_history')->insert([
            'id' => (string) str()->uuid(),
            'entity_id' => $institution,
            'claim_version_id' => $original['claim_version_id'],
            'editorial_review_case_id' => $original['id'],
            'event_type' => 'review_completed',
            'previous_status' => 'in_review',
            'new_status' => 'changes_requested',
            'actor_id' => 'private-reviewer-actor',
            'actor_class' => 'human',
            'reason_code' => 'synthetic_correction_required',
            'idempotency_key' => 'correction-reason-'.str()->uuid(),
            'fingerprint' => hash('sha256', $original['id']),
            'metadata' => json_encode(['rationale' => 'private correction rationale must not be shown'], JSON_THROW_ON_ERROR),
            'occurred_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $claimId = (string) DB::table('claim_versions')
            ->where('id', $original['claim_version_id'])
            ->value('claim_id');
        $successorId = (string) str()->uuid();
        DB::table('claim_versions')->insert([
            'id' => $successorId,
            'claim_id' => $claimId,
            'version_number' => 2,
            'value' => json_encode('Synthetic corrected workspace value', JSON_THROW_ON_ERROR),
            'valid_from' => null,
            'valid_to' => null,
            'recorded_at' => $now,
            'disposition' => 'proposed',
            'supersedes_version_id' => $original['claim_version_id'],
            'correction_reason' => 'synthetic_value_correction',
            'field_definition_version_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $successorCaseId = (string) str()->uuid();
        DB::table('editorial_review_cases')->insert([
            'id' => $successorCaseId,
            'entity_id' => $institution,
            'claim_version_id' => $successorId,
            'status' => 'submitted',
            'submitted_by_actor_id' => 'user:'.$submitter->getKey(),
            'reviewer_actor_id' => null,
            'adjudication_case_id' => null,
            'adjudication_decision_id' => null,
            'publication_decision_id' => null,
            'idempotency_key' => 'workspace-successor-'.str()->uuid(),
            'fingerprint' => hash('sha256', $successorCaseId),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->actingAs($reviewer)
            ->get('/institutions/'.$institution.'/editorial-cases/'.$successorCaseId)
            ->assertOk()
            ->assertSee('Correction history')
            ->assertSee('Version 1')
            ->assertSee('superseded')
            ->assertSee('synthetic_correction_required')
            ->assertSee('synthetic_value_correction')
            ->assertDontSee('private correction rationale must not be shown')
            ->assertSee('Synthetic corrected workspace value');
    }

    private function institution(): string
    {
        $id = (string) str()->uuid();
        $now = now();
        DB::table('directory_entities')->insert([
            'id' => $id,
            'entity_type' => 'institution',
            'label' => 'Synthetic Workspace Institute '.str()->random(5),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('directory_provider_category_assignments')->insert([
            'entity_id' => $id,
            'provider_category' => 'university',
            'assigned_by_actor_id' => 'synthetic-taxonomy-steward',
            'reason_code' => 'synthetic_assignment',
            'idempotency_key' => 'workspace-category-'.str()->uuid(),
            'fingerprint' => hash('sha256', $id),
            'assigned_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $id;
    }

    private function user(string $email, bool $verified = true, bool $active = true): User
    {
        return User::query()->create([
            'email' => $email,
            'password' => 'synthetic-password',
            'email_verified_at' => $verified ? now() : null,
            'is_active' => $active,
        ]);
    }

    private function assign(User $user, string $role, string $scopeId, string $scopeType = 'institution'): RoleAssignment
    {
        return RoleAssignment::query()->create([
            'user_id' => $user->getKey(),
            'role' => $role,
            'scope_type' => $scopeType,
            'scope_id' => $scopeId,
        ]);
    }

    private function childCase(
        string $institution,
        User $submitter,
        string $entityType,
        string $status,
        ?string $reviewerActorId = null,
        ?string $projectionInstitutionId = null,
    ): array {
        $entityId = (string) str()->uuid();
        $claimId = (string) str()->uuid();
        $versionId = (string) str()->uuid();
        $caseId = (string) str()->uuid();
        $now = now();
        DB::table('directory_entities')->insert([
            'id' => $entityId,
            'entity_type' => $entityType,
            'label' => 'Synthetic '.$entityType.' child '.substr($entityId, 0, 6),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claims')->insert([
            'id' => $claimId,
            'subject_entity_id' => $entityId,
            'predicate' => $entityType,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claim_versions')->insert([
            'id' => $versionId,
            'claim_id' => $claimId,
            'version_number' => 1,
            'value' => json_encode([
                'institution_entity_id' => $institution,
                'label' => 'Synthetic '.$entityType.' child',
            ], JSON_THROW_ON_ERROR),
            'valid_from' => null,
            'valid_to' => null,
            'recorded_at' => $now,
            'disposition' => 'proposed',
            'supersedes_version_id' => null,
            'correction_reason' => null,
            'field_definition_version_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('editorial_review_cases')->insert([
            'id' => $caseId,
            'entity_id' => $entityId,
            'claim_version_id' => $versionId,
            'status' => $status,
            'submitted_by_actor_id' => 'user:'.$submitter->getKey(),
            'reviewer_actor_id' => $reviewerActorId,
            'adjudication_case_id' => null,
            'adjudication_decision_id' => null,
            'publication_decision_id' => null,
            'idempotency_key' => 'workspace-child-case-'.str()->uuid(),
            'fingerprint' => hash('sha256', $caseId),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if ($projectionInstitutionId !== null) {
            $table = $entityType === 'campus' ? 'directory_campuses' : 'directory_delivery_sites';
            DB::table($table)->insert([
                'entity_id' => $entityId,
                'institution_entity_id' => $projectionInstitutionId,
                'location_label' => 'Synthetic mismatch fixture',
                'status' => 'active',
                'valid_from' => null,
                'valid_to' => null,
                'claim_version_id' => $versionId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return ['id' => $caseId, 'entity_id' => $entityId, 'claim_version_id' => $versionId];
    }

    private function case(string $institution, User $submitter): array
    {
        $claimId = (string) str()->uuid();
        $versionId = (string) str()->uuid();
        $caseId = (string) str()->uuid();
        $now = now();
        DB::table('claims')->insert([
            'id' => $claimId,
            'subject_entity_id' => $institution,
            'predicate' => 'institution_display_name',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claim_versions')->insert([
            'id' => $versionId,
            'claim_id' => $claimId,
            'version_number' => 1,
            'value' => json_encode('Synthetic workspace value', JSON_THROW_ON_ERROR),
            'valid_from' => null,
            'valid_to' => null,
            'recorded_at' => $now,
            'disposition' => 'proposed',
            'supersedes_version_id' => null,
            'correction_reason' => null,
            'field_definition_version_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('editorial_review_cases')->insert([
            'id' => $caseId,
            'entity_id' => $institution,
            'claim_version_id' => $versionId,
            'status' => 'submitted',
            'submitted_by_actor_id' => 'user:'.$submitter->getKey(),
            'reviewer_actor_id' => null,
            'adjudication_case_id' => null,
            'adjudication_decision_id' => null,
            'publication_decision_id' => null,
            'idempotency_key' => 'workspace-case-'.str()->uuid(),
            'fingerprint' => hash('sha256', $caseId),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return ['id' => $caseId, 'claim_version_id' => $versionId];
    }
}
