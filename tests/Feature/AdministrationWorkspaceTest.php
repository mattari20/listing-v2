<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\RoleAssignment;
use App\Models\User;
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
            ->assertSee('proposal_submitted')
            ->assertDontSee('sha256:private-evidence-digest')
            ->assertDontSee('hidden-note')
            ->assertDontSee('hidden-history-note')
            ->assertHeader('Cache-Control', 'max-age=0, no-store, private')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
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

}
