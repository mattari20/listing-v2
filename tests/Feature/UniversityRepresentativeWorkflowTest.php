<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\RoleAssignment;
use App\Models\User;
use App\Services\Identity\RoleAssignmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class UniversityRepresentativeWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_submission_requires_authenticated_verified_active_scoped_university_representative(): void
    {
        [$institution, $evidence] = $this->fixture();
        $payload = $this->proposalPayload($evidence);

        $this->postJson("/institutions/{$institution}/claims", $payload)->assertUnauthorized();

        $representative = $this->user('rep@example.test', verified: false);
        $this->assign($representative, 'institution_representative', $institution);
        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $payload)
            ->assertForbidden();

        $inactive = $this->user('inactive@example.test', active: false);
        $this->assign($inactive, 'institution_representative', $institution);
        $this->actingAs($inactive, 'web')
            ->postJson("/institutions/{$institution}/claims", $payload)
            ->assertForbidden();

        $unscoped = $this->user('unscoped@example.test');
        $this->actingAs($unscoped, 'web')
            ->postJson("/institutions/{$institution}/claims", $payload)
            ->assertForbidden();
    }

    public function test_university_representative_can_submit_a_synthetic_registry_bound_proposal_without_publication(): void
    {
        [$institution, $evidence] = $this->fixture();
        $representative = $this->user('submitter@example.test');
        $this->assign($representative, 'institution_representative', $institution);

        $response = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
            ->assertCreated()
            ->assertJsonPath('status', 'submitted_for_editorial_review');

        $version = $response->json('claim_version_id');
        $case = $response->json('editorial_review_case_id');

        $this->assertDatabaseHas('claims', [
            'id' => $response->json('claim_id'),
            'subject_entity_id' => $institution,
            'predicate' => 'institution_display_name',
        ]);
        $this->assertDatabaseHas('claim_versions', [
            'id' => $version,
            'disposition' => 'proposed',
        ]);
        $retry = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
            ->assertCreated();
        $this->assertSame($version, $retry->json('claim_version_id'));
        $this->assertSame($case, $retry->json('editorial_review_case_id'));
        $this->assertSame(1, DB::table('claims')->count());
        $this->assertSame(1, DB::table('editorial_review_cases')->count());

        $this->assertDatabaseHas('editorial_review_cases', [
            'id' => $case,
            'entity_id' => $institution,
            'claim_version_id' => $version,
            'submitted_by_actor_id' => 'user:'.$representative->getKey(),
            'status' => 'submitted',
        ]);
        $this->assertSame(0, DB::table('publication_decisions')->count());
        $this->assertSame(0, DB::table('public_projections')->count());
    }

    public function test_representative_is_limited_to_exact_institution_scope_and_university_category(): void
    {
        [$institution, $evidence] = $this->fixture();
        [$otherInstitution] = $this->fixture();
        $representative = $this->user('scoped-rep@example.test');
        $this->assign($representative, 'institution_representative', $institution);

        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$otherInstitution}/claims", $this->proposalPayload($evidence))
            ->assertForbidden();

        $school = $this->institution('private_school');
        $this->assign($representative, 'institution_representative', $school);
        $this->postJson("/institutions/{$school}/claims", $this->proposalPayload($evidence))
            ->assertNotFound();
    }

    public function test_correction_creates_an_immutable_successor_and_reenters_editorial_review(): void
    {
        [$institution, $evidence] = $this->fixture();
        $representative = $this->user('correction-rep@example.test');
        $this->assign($representative, 'institution_representative', $institution);
        $submitted = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
            ->assertCreated();
        $priorVersion = $submitted->json('claim_version_id');
        $this->assertDatabaseHas('evidence_references', ['id' => $evidence, 'status' => 'eligible_for_review']);

        $reviewer = $this->user('correction-reviewer@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $case = $submitted->json('editorial_review_case_id');
        $this->actingAs($reviewer, 'web')
            ->postJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'idempotency_key' => 'correction-review-start',
            ])->assertOk();
        $this->actingAs($reviewer, 'web')
            ->patchJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'outcome' => 'changes_requested',
                'reason_code' => 'synthetic_correction_required',
                'rationale' => 'A correction is requested for this synthetic fixture.',
                'idempotency_key' => 'correction-review-complete',
            ])->assertOk();

        $response = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims/{$priorVersion}/correction", [
                'value' => 'Synthetic University Corrected',
                'evidence_reference_ids' => [$evidence],
                'idempotency_key' => 'correction-one',
                'valid_from' => '2026-11-17',
                'reason_code' => 'synthetic_value_correction',
                'rationale' => 'Synthetic correction for the isolated test fixture.',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'corrected_successor_submitted_for_editorial_review');

        $successor = $response->json('claim_version_id');
        $this->assertNotSame($priorVersion, $successor);
        $retry = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims/{$priorVersion}/correction", [
                'value' => 'Synthetic University Corrected',
                'evidence_reference_ids' => [$evidence],
                'idempotency_key' => 'correction-one',
                'valid_from' => '2026-11-17',
                'reason_code' => 'synthetic_value_correction',
                'rationale' => 'Synthetic correction for the isolated test fixture.',
            ])
            ->assertOk();

        $this->assertSame($successor, $retry->json('claim_version_id'));
        $this->assertSame($response->json('editorial_review_case_id'), $retry->json('editorial_review_case_id'));
        $this->assertSame(2, DB::table('claim_versions')->count());
        $this->assertSame(2, DB::table('editorial_review_cases')->count());

        $this->assertDatabaseHas('claim_versions', [
            'id' => $priorVersion,
            'disposition' => 'proposed',
            'supersedes_version_id' => null,
        ]);
        $this->assertDatabaseHas('claim_versions', [
            'id' => $successor,
            'supersedes_version_id' => $priorVersion,
            'version_number' => 2,
            'disposition' => 'proposed',
        ]);
        $this->assertDatabaseHas('editorial_review_cases', [
            'id' => $case,
            'status' => 'superseded',
        ]);
        $this->assertDatabaseHas('editorial_review_cases', [
            'id' => $response->json('editorial_review_case_id'),
            'claim_version_id' => $successor,
            'status' => 'submitted',
        ]);
        $this->assertSame(0, DB::table('publication_decisions')->count());
        $this->assertSame(0, DB::table('public_projections')->count());
    }

    public function test_reviewer_must_be_separately_scoped_and_cannot_review_the_submitters_own_case(): void
    {
        [$institution, $evidence] = $this->fixture();
        $submitter = $this->user('editorial-submitter@example.test');
        $this->assign($submitter, 'institution_representative', $institution);
        $submitted = $this->actingAs($submitter, 'web')
            ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
            ->assertCreated();
        $case = $submitted->json('editorial_review_case_id');

        $this->postJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
            'idempotency_key' => 'self-review',
        ])->assertForbidden();

        $reviewer = $this->user('reviewer@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $this->actingAs($reviewer, 'web')
            ->postJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'idempotency_key' => 'review-start',
            ])
            ->assertOk()
            ->assertExactJson(['status' => 'in_review']);

        $this->actingAs($reviewer, 'web')
            ->patchJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'outcome' => 'ready_for_adjudication',
                'reason_code' => 'synthetic_review',
                'rationale' => 'Independent synthetic review completed for the test case.',
                'idempotency_key' => 'review-complete',
            ])
            ->assertOk()
            ->assertExactJson(['status' => 'ready_for_adjudication']);

        $this->assertDatabaseHas('editorial_review_cases', [
            'id' => $case,
            'reviewer_actor_id' => 'user:'.$reviewer->getKey(),
            'status' => 'ready_for_adjudication',
        ]);
        $this->assertDatabaseHas('directory_status_history', [
            'editorial_review_case_id' => $case,
            'new_status' => 'ready_for_adjudication',
            'actor_id' => 'user:'.$reviewer->getKey(),
        ]);
        $this->assertSame(0, DB::table('publication_decisions')->count());
        $this->assertSame(0, DB::table('public_projections')->count());
    }

    public function test_reviewer_scope_and_case_entity_are_both_enforced(): void
    {
        [$institution, $evidence] = $this->fixture();
        [$otherInstitution] = $this->fixture();
        $submitter = $this->user('scope-submitter@example.test');
        $this->assign($submitter, 'institution_representative', $institution);
        $submitted = $this->actingAs($submitter, 'web')
            ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
            ->assertCreated();
        $case = $submitted->json('editorial_review_case_id');

        $reviewer = $this->user('wrong-scope-reviewer@example.test');
        $this->assign($reviewer, 'data_reviewer', $otherInstitution);
        $this->actingAs($reviewer, 'web')
            ->postJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'idempotency_key' => 'wrong-scope',
            ])
            ->assertForbidden();

        $this->actingAs($reviewer, 'web')
            ->postJson("/institutions/{$otherInstitution}/editorial-cases/{$case}/review", [
                'idempotency_key' => 'wrong-case-entity',
            ])
            ->assertNotFound();
    }

    public function test_role_assignment_service_supports_the_new_separate_representative_role(): void
    {
        $admin = $this->user('role-admin@example.test');
        $target = $this->user('role-target@example.test');
        RoleAssignment::query()->create([
            'user_id' => $admin->getKey(),
            'role' => 'administrator',
        ]);

        $assignment = app(RoleAssignmentService::class)->grant(
            $admin,
            $target,
            'institution_representative',
            'institution',
            (string) str()->uuid(),
            'operational_need',
        );

        $this->assertSame('institution_representative', $assignment->role);
        $this->assertDatabaseHas('privileged_action_audits', [
            'actor_user_id' => $admin->getKey(),
            'action' => 'role.granted',
            'subject_id' => (string) $target->getKey(),
        ]);
    }

    public function test_revoked_and_expired_representative_assignments_are_denied_without_writes(): void
    {
        [$institution, $evidence] = $this->fixture();

        foreach (['revoked', 'expired'] as $state) {
            $representative = $this->user($state.'-rep@example.test');
            $this->assign($representative, 'institution_representative', $institution);
            $assignment = RoleAssignment::query()->where('user_id', $representative->getKey())->firstOrFail();

            DB::table('role_assignments')->where('id', $assignment->getKey())->update(
                $state === 'revoked'
                    ? ['revoked_at' => now()]
                    : ['expires_at' => now()->subSecond()]
            );

            $this->actingAs($representative, 'web')
                ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
                ->assertForbidden();
        }

        $this->assertSame(0, DB::table('claims')->count());
        $this->assertSame(0, DB::table('editorial_review_cases')->count());
    }

    public function test_forged_actor_scope_capability_and_source_fields_are_ignored(): void
    {
        [$institution, $evidence] = $this->fixture();
        $representative = $this->user('forged-payload-rep@example.test');
        $this->assign($representative, 'institution_representative', $institution);

        $payload = $this->proposalPayload($evidence) + [
            'actor_id' => 'user:999999',
            'actor_class' => 'agent',
            'capabilities' => ['authorize_publication', 'roles.manage'],
            'scope_type' => 'global',
            'scope_id' => '*',
            'source_context' => [
                'purpose' => 'external_source_ingestion',
                'method' => 'bulk_download',
                'territory' => 'real',
            ],
            'publication_decision' => 'approved',
            'public_visibility' => true,
        ];

        $response = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $payload)
            ->assertCreated();

        $this->assertDatabaseHas('editorial_review_cases', [
            'id' => $response->json('editorial_review_case_id'),
            'submitted_by_actor_id' => 'user:'.$representative->getKey(),
            'status' => 'submitted',
        ]);
        $this->assertSame(0, DB::table('publication_decisions')->count());
        $this->assertSame(0, DB::table('public_projections')->count());
    }

    public function test_unknown_and_revoked_evidence_authorizations_are_rejected_without_claims(): void
    {
        [$institution, $evidence] = $this->fixture();
        $representative = $this->user('invalid-evidence-rep@example.test');
        $this->assign($representative, 'institution_representative', $institution);

        $unknownEvidence = $this->proposalPayload($evidence);
        $unknownEvidence['evidence_reference_ids'] = [(string) str()->uuid()];
        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $unknownEvidence)
            ->assertUnprocessable();

        $authorizationId = DB::table('evidence_references')
            ->where('id', $evidence)
            ->value('source_authorization_id');
        DB::table('source_authorizations')->where('id', $authorizationId)->update([
            'revoked_at' => now(),
            'revocation_reason' => 'synthetic adversarial fixture',
        ]);

        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
            ->assertUnprocessable();

        $this->assertSame(0, DB::table('claims')->count());
        $this->assertSame(0, DB::table('editorial_review_cases')->count());
    }

    public function test_proposal_idempotency_key_cannot_be_replayed_with_a_changed_payload(): void
    {
        [$institution, $evidence] = $this->fixture();
        $representative = $this->user('replay-conflict-rep@example.test');
        $this->assign($representative, 'institution_representative', $institution);
        $payload = $this->proposalPayload($evidence);

        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $payload)
            ->assertCreated();

        $changed = $payload;
        $changed['value'] = 'Synthetic University Tampered Replay';
        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims", $changed)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('idempotency_key');

        $this->assertSame(1, DB::table('claims')->count());
        $this->assertSame(1, DB::table('claim_versions')->count());
        $this->assertSame(1, DB::table('editorial_review_cases')->count());
    }

    public function test_editorial_audit_failure_rolls_back_status_and_history_atomically(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            $this->markTestSkipped('The rollback fault-injection trigger is SQLite-only.');
        }

        [$institution, $evidence] = $this->fixture();
        $submitter = $this->user('rollback-submitter@example.test');
        $this->assign($submitter, 'institution_representative', $institution);
        $submitted = $this->actingAs($submitter, 'web')
            ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
            ->assertCreated();
        $case = $submitted->json('editorial_review_case_id');

        $reviewer = $this->user('rollback-reviewer@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $this->actingAs($reviewer, 'web')
            ->postJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'idempotency_key' => 'rollback-review-start',
            ])->assertOk();

        DB::statement("CREATE TRIGGER synthetic_fail_editorial_audit
            BEFORE INSERT ON audit_events
            WHEN NEW.action = 'directory_editorial_review_completed'
            BEGIN SELECT RAISE(ABORT, 'synthetic audit failure'); END");

        try {
            try {
                app(\App\Services\Directory\EditorialReviewService::class)->completeReview(
                    [
                        'actor_id' => 'user:'.$reviewer->getKey(),
                        'actor_class' => 'human',
                        'capabilities' => ['review_directory_proposal'],
                    ],
                    $case,
                    'ready_for_adjudication',
                    'synthetic_review',
                    'Synthetic rollback fault injection for audit atomicity.',
                    'rollback-review-complete',
                );
                $this->fail('Expected synthetic audit insertion failure.');
            } catch (\Illuminate\Database\QueryException $exception) {
                $this->assertStringContainsString('synthetic audit failure', $exception->getMessage());
            }
        } finally {
            DB::statement('DROP TRIGGER IF EXISTS synthetic_fail_editorial_audit');
        }

        $this->assertDatabaseHas('editorial_review_cases', [
            'id' => $case,
            'status' => 'in_review',
        ]);
        $this->assertSame(0, DB::table('directory_status_history')
            ->where('editorial_review_case_id', $case)
            ->where('event_type', 'review_completed')
            ->count());
        $this->assertSame(0, DB::table('audit_events')
            ->where('target_id', $case)
            ->where('action', 'directory_editorial_review_completed')
            ->count());
    }

    public function test_editorial_transition_has_matching_status_history_and_audit_event(): void
    {
        [$institution, $evidence] = $this->fixture();
        $submitter = $this->user('audit-submitter@example.test');
        $this->assign($submitter, 'institution_representative', $institution);
        $submitted = $this->actingAs($submitter, 'web')
            ->postJson("/institutions/{$institution}/claims", $this->proposalPayload($evidence))
            ->assertCreated();
        $case = $submitted->json('editorial_review_case_id');

        $reviewer = $this->user('audit-reviewer@example.test');
        $this->assign($reviewer, 'data_reviewer', $institution);
        $this->actingAs($reviewer, 'web')
            ->postJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'idempotency_key' => 'audit-review-start',
            ])->assertOk();
        $this->actingAs($reviewer, 'web')
            ->patchJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'outcome' => 'held',
                'reason_code' => 'synthetic_audit_check',
                'rationale' => 'Synthetic review held for audit consistency verification.',
                'idempotency_key' => 'audit-review-complete',
            ])->assertOk();

        $actorId = 'user:'.$reviewer->getKey();
        $this->assertDatabaseHas('directory_status_history', [
            'editorial_review_case_id' => $case,
            'event_type' => 'review_completed',
            'actor_id' => $actorId,
            'new_status' => 'held',
        ]);
        $audit = DB::table('audit_events')
            ->where('target_type', 'editorial_review_case')
            ->where('target_id', $case)
            ->where('action', 'directory_editorial_review_completed')
            ->first();
        $this->assertNotNull($audit);
        $metadata = json_decode((string) $audit->metadata, true);
        $this->assertSame($actorId, $metadata['actor_id'] ?? null);
        $this->assertSame($institution, $metadata['entity_id'] ?? null);
        $this->assertSame('held', $metadata['new_status'] ?? null);
        $this->assertSame(0, DB::table('publication_decisions')->count());
        $this->assertSame(0, DB::table('public_projections')->count());
    }

    private function fixture(string $category = 'university'): array
    {
        $institution = $this->institution($category);
        if (DB::table('field_definitions')->where('field_key', 'institution_display_name')->exists() === false) {
            $this->definition();
        }
        $evidence = $this->evidence();

        return [$institution, $evidence];
    }

    private function institution(string $category): string
    {
        $id = (string) str()->uuid();
        $now = now();
        DB::table('directory_entities')->insert([
            'id' => $id,
            'entity_type' => 'institution',
            'label' => 'Synthetic University '.str()->random(6),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('directory_provider_category_assignments')->insert([
            'entity_id' => $id,
            'provider_category' => $category,
            'assigned_by_actor_id' => 'synthetic-taxonomy-steward',
            'reason_code' => 'synthetic_assignment',
            'idempotency_key' => 'category-'.str()->uuid(),
            'fingerprint' => hash('sha256', $id.$category),
            'assigned_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $id;
    }

    private function definition(): void
    {
        $definition = (string) str()->uuid();
        $version = (string) str()->uuid();
        $now = now();
        DB::table('field_definitions')->insert([
            'id' => $definition,
            'field_key' => 'institution_display_name',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('field_definition_versions')->insert([
            'id' => $version,
            'field_definition_id' => $definition,
            'version_number' => 1,
            'lifecycle_state' => 'active',
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
            'validation_schema' => json_encode(['schema_version' => 1, 'max_length' => 120], JSON_THROW_ON_ERROR),
            'presentation_metadata' => json_encode(['section_key' => 'identity', 'label_key' => 'synthetic.display_name'], JSON_THROW_ON_ERROR),
            'evidence_policy' => json_encode(['required' => true, 'accepted_reference_kinds' => ['synthetic_fixture']], JSON_THROW_ON_ERROR),
            'freshness_policy' => json_encode(['class' => 'synthetic_test'], JSON_THROW_ON_ERROR),
            'effective_from' => null,
            'effective_to' => null,
            'successor_field_definition_id' => null,
            'proposed_by_actor_id' => 'synthetic-steward',
            'rationale_reference' => 'SYN-M310-HTTP',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('field_definition_version_entity_types')->insert([
            'id' => (string) str()->uuid(),
            'field_definition_version_id' => $version,
            'entity_type' => 'institution',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('field_definition_version_provider_categories')->insert([
            'id' => (string) str()->uuid(),
            'field_definition_version_id' => $version,
            'provider_category' => 'university',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function evidence(): string
    {
        $authorization = (string) str()->uuid();
        $evidence = (string) str()->uuid();
        $now = now();
        DB::table('source_authorizations')->insert([
            'id' => $authorization,
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
            'id' => $evidence,
            'source_authorization_id' => $authorization,
            'reference_kind' => 'synthetic_fixture',
            'source_type' => 'synthetic',
            'integrity_digest' => 'sha256:synthetic-http-fixture',
            'status' => 'eligible_for_review',
            'content_included' => false,
            'observed_at' => $now,
            'recorded_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) str()->uuid(),
            'actor_class' => 'human',
            'action' => 'evidence_reference_registered',
            'target_type' => 'evidence_reference',
            'target_id' => $evidence,
            'reason_code' => 'synthetic_fixture',
            'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => 'synthetic-evidence-collector'], JSON_THROW_ON_ERROR),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $evidence;
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

    private function assign(User $user, string $role, string $institution): void
    {
        RoleAssignment::query()->create([
            'user_id' => $user->getKey(),
            'role' => $role,
            'scope_type' => 'institution',
            'scope_id' => $institution,
        ]);
    }

    private function proposalPayload(string $evidence): array
    {
        return [
            'field_key' => 'institution_display_name',
            'definition_version' => 1,
            'value' => 'Synthetic University Example',
            'evidence_reference_ids' => [$evidence],
            'idempotency_key' => 'proposal-one',
            'valid_from' => '2026-11-17',
        ];
    }
}
