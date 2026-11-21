<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\RoleAssignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class InstitutionCampusWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_representative_can_submit_a_registry_bound_campus_without_publishing_it_and_retry_idempotently(): void
    {
        $institution = $this->institution();
        $this->campusDefinition();
        $evidence = $this->evidence();
        $representative = $this->user('campus-representative@example.test');
        $this->assign($representative, $institution);

        $payload = $this->campusPayload($evidence);
        $response = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/campuses", $payload)
            ->assertCreated()
            ->assertJsonPath('status', 'submitted_for_editorial_review')
            ->assertJsonPath('publication', 'not_published');

        $entityId = $response->json('entity_id');
        $versionId = $response->json('claim_version_id');
        $caseId = $response->json('editorial_review_case_id');

        $this->assertDatabaseHas('directory_entities', [
            'id' => $entityId,
            'entity_type' => 'campus',
            'label' => 'Synthetic North Campus',
        ]);
        $this->assertDatabaseHas('claims', [
            'subject_entity_id' => $entityId,
            'predicate' => 'campus',
        ]);
        $this->assertDatabaseHas('claim_versions', [
            'id' => $versionId,
            'disposition' => 'proposed',
        ]);
        $this->assertDatabaseHas('editorial_review_cases', [
            'id' => $caseId,
            'entity_id' => $entityId,
            'status' => 'submitted',
            'submitted_by_actor_id' => 'user:'.$representative->getKey(),
        ]);
        $this->assertDatabaseCount('directory_campuses', 0);
        $this->assertDatabaseCount('publication_decisions', 0);
        $this->assertDatabaseCount('public_projections', 0);

        $retry = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/campuses", $payload)
            ->assertCreated();
        $this->assertSame($entityId, $retry->json('entity_id'));
        $this->assertSame($versionId, $retry->json('claim_version_id'));
        $this->assertSame($caseId, $retry->json('editorial_review_case_id'));
        $this->assertDatabaseCount('directory_entities', 2);
        $this->assertDatabaseCount('claims', 1);
        $this->assertDatabaseCount('editorial_review_cases', 1);
    }

    public function test_campus_proposal_is_rejected_when_registry_does_not_explicitly_allow_campus_scope(): void
    {
        $institution = $this->institution();
        $this->campusDefinition('institution');
        $evidence = $this->evidence();
        $representative = $this->user('campus-scope-representative@example.test');
        $this->assign($representative, $institution);

        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/campuses", $this->campusPayload($evidence))
            ->assertUnprocessable();

        $this->assertDatabaseCount('directory_entities', 1);
        $this->assertDatabaseCount('claims', 0);
        $this->assertDatabaseCount('editorial_review_cases', 0);
    }

    public function test_campus_proposal_cannot_cross_institution_scope_or_change_parent_identity(): void
    {
        $institution = $this->institution();
        $otherInstitution = $this->institution();
        $this->campusDefinition();
        $evidence = $this->evidence();
        $representative = $this->user('campus-cross-scope@example.test');
        $this->assign($representative, $institution);

        $payload = $this->campusPayload($evidence);
        $payload['institution_entity_id'] = $otherInstitution;

        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/campuses", $payload)
            ->assertUnprocessable();

        $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$otherInstitution}/campuses", $this->campusPayload($evidence))
            ->assertForbidden();

        $this->assertDatabaseCount('directory_entities', 2);
        $this->assertDatabaseCount('claims', 0);
    }

    public function test_returned_campus_proposal_can_be_corrected_as_an_immutable_successor_within_parent_scope(): void
    {
        $institution = $this->institution();
        $this->campusDefinition();
        $evidence = $this->evidence();
        $representative = $this->user('campus-correction-representative@example.test');
        $reviewer = $this->user('campus-correction-reviewer@example.test');
        $this->assign($representative, $institution);
        $this->assign($reviewer, $institution, 'data_reviewer');

        $submitted = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/campuses", $this->campusPayload($evidence))
            ->assertCreated();
        $campus = $submitted->json('entity_id');
        $priorVersion = $submitted->json('claim_version_id');
        $case = $submitted->json('editorial_review_case_id');

        $this->actingAs($reviewer, 'web')
            ->postJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'idempotency_key' => 'campus-review-start',
            ])->assertOk();
        $this->actingAs($reviewer, 'web')
            ->patchJson("/institutions/{$institution}/editorial-cases/{$case}/review", [
                'outcome' => 'changes_requested',
                'reason_code' => 'synthetic_campus_correction',
                'rationale' => 'Please correct this synthetic campus location label.',
                'idempotency_key' => 'campus-review-complete',
            ])->assertOk();

        $correctedValue = [
            'institution_entity_id' => $institution,
            'label' => 'Synthetic North Campus Updated',
            'location_label' => 'Synthetic District Updated',
        ];
        $correction = $this->actingAs($representative, 'web')
            ->postJson("/institutions/{$institution}/claims/{$priorVersion}/correction", [
                'value' => $correctedValue,
                'evidence_reference_ids' => [$evidence],
                'idempotency_key' => 'campus-correction-one',
                'valid_from' => '2026-11-21',
                'reason_code' => 'synthetic_value_correction',
                'rationale' => 'Correcting a synthetic campus label and location.',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'corrected_successor_submitted_for_editorial_review');

        $successor = $correction->json('claim_version_id');
        $this->assertNotSame($priorVersion, $successor);
        $this->assertDatabaseHas('claim_versions', [
            'id' => $priorVersion,
            'supersedes_version_id' => null,
            'disposition' => 'proposed',
        ]);
        $this->assertDatabaseHas('claim_versions', [
            'id' => $successor,
            'supersedes_version_id' => $priorVersion,
            'version_number' => 2,
            'disposition' => 'proposed',
        ]);
        $this->assertDatabaseHas('editorial_review_cases', ['id' => $case, 'status' => 'superseded']);
        $this->assertDatabaseHas('editorial_review_cases', [
            'claim_version_id' => $successor,
            'entity_id' => $campus,
            'status' => 'submitted',
        ]);
        $this->assertDatabaseCount('publication_decisions', 0);
        $this->assertDatabaseCount('public_projections', 0);
    }

    public function test_private_information_endpoint_lists_only_accepted_current_campuses_and_delivery_sites(): void
    {
        $institution = $this->institution();
        $representative = $this->user('campus-information@example.test');
        $this->assign($representative, $institution);

        $response = $this->actingAs($representative, 'web')
            ->getJson("/institutions/{$institution}/information")
            ->assertOk()
            ->assertJsonPath('institution.id', $institution)
            ->assertJsonCount(0, 'campuses')
            ->assertJsonCount(0, 'delivery_sites');

        $response->assertHeader('Cache-Control', 'max-age=0, no-store, private');
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    private function institution(): string
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
            'provider_category' => 'university',
            'assigned_by_actor_id' => 'synthetic-taxonomy-steward',
            'reason_code' => 'synthetic_assignment',
            'idempotency_key' => 'campus-category-'.str()->uuid(),
            'fingerprint' => hash('sha256', $id),
            'assigned_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $id;
    }

    private function campusDefinition(string $entityType = 'campus'): void
    {
        $definitionId = (string) str()->uuid();
        $versionId = (string) str()->uuid();
        $now = now();
        DB::table('field_definitions')->insert([
            'id' => $definitionId,
            'field_key' => 'campus',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('field_definition_versions')->insert([
            'id' => $versionId,
            'field_definition_id' => $definitionId,
            'version_number' => 1,
            'lifecycle_state' => 'active',
            'semantic_version' => '1.0.0',
            'compatibility_class' => 'initial',
            'value_type' => 'bounded_object',
            'cardinality' => 'many',
            'scope_key' => 'campus',
            'privacy_class' => 'public_eligible',
            'visibility_class' => 'public_eligible',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'validation_schema' => json_encode([
                'schema_version' => 1,
                'max_depth' => 2,
                'max_keys' => 3,
                'max_bytes' => 512,
                'required' => ['institution_entity_id', 'label'],
                'properties' => [
                    'institution_entity_id' => ['type' => 'short_text', 'max_length' => 36],
                    'label' => ['type' => 'short_text', 'max_length' => 255],
                    'location_label' => ['type' => 'short_text', 'max_length' => 5000],
                ],
            ], JSON_THROW_ON_ERROR),
            'presentation_metadata' => json_encode(['section_key' => 'campus', 'label_key' => 'synthetic.campus'], JSON_THROW_ON_ERROR),
            'evidence_policy' => json_encode(['required' => true, 'accepted_reference_kinds' => ['synthetic_fixture']], JSON_THROW_ON_ERROR),
            'freshness_policy' => json_encode(['class' => 'synthetic_test'], JSON_THROW_ON_ERROR),
            'effective_from' => null,
            'effective_to' => null,
            'successor_field_definition_id' => null,
            'proposed_by_actor_id' => 'synthetic-field-steward',
            'rationale_reference' => 'SYN-ADM-C-CAMPUS',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('field_definition_version_entity_types')->insert([
            'id' => (string) str()->uuid(),
            'field_definition_version_id' => $versionId,
            'entity_type' => $entityType,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('field_definition_version_provider_categories')->insert([
            'id' => (string) str()->uuid(),
            'field_definition_version_id' => $versionId,
            'provider_category' => 'university',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function evidence(): string
    {
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
            'integrity_digest' => 'sha256:synthetic-campus-evidence',
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
            'target_id' => $evidenceId,
            'reason_code' => 'synthetic_fixture',
            'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => 'synthetic-evidence-author'], JSON_THROW_ON_ERROR),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $evidenceId;
    }

    private function user(string $email): User
    {
        return User::query()->create([
            'email' => $email,
            'password' => 'synthetic-password',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
    }

    private function assign(User $user, string $institution, string $role = 'institution_representative'): void
    {
        RoleAssignment::query()->create([
            'user_id' => $user->getKey(),
            'role' => $role,
            'scope_type' => 'institution',
            'scope_id' => $institution,
        ]);
    }

    private function campusPayload(string $evidence): array
    {
        return [
            'label' => 'Synthetic North Campus',
            'location_label' => 'Synthetic District North',
            'definition_version' => 1,
            'evidence_reference_ids' => [$evidence],
            'idempotency_key' => 'campus-create-one',
            'valid_from' => '2026-11-21',
        ];
    }
}
