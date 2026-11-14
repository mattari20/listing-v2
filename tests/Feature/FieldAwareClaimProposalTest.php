<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\FieldAwareClaimProposalService;
use App\Services\Directory\ProviderCategoryAssignmentService;
use App\Services\Governance\GovernanceCommandService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FieldAwareClaimProposalTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_field_proposal_binds_exact_definition_and_enters_editorial_review_only(): void
    {
        [$entityId, $versionId, $evidenceId] = $this->fixture();
        $result = app(FieldAwareClaimProposalService::class)->propose(
            $this->proposalActor(),
            $entityId,
            'institution_display_name',
            1,
            'Synthetic Institute Alpha',
            [$evidenceId],
            $this->sourceContext(),
            'institution',
            'field-proposal-key-1'
        );

        $this->assertDatabaseHas('claims', [
            'id' => $result['claim_id'],
            'subject_entity_id' => $entityId,
            'predicate' => 'institution_display_name',
        ]);
        $this->assertDatabaseHas('claim_versions', [
            'id' => $result['claim_version_id'],
            'field_definition_version_id' => $versionId,
            'disposition' => 'proposed',
        ]);
        $this->assertDatabaseHas('claim_evidence_links', [
            'claim_version_id' => $result['claim_version_id'],
            'evidence_reference_id' => $evidenceId,
        ]);
        $this->assertDatabaseHas('editorial_review_cases', [
            'id' => $result['editorial_review_case_id'],
            'claim_version_id' => $result['claim_version_id'],
            'status' => 'submitted',
        ]);
        $this->assertDatabaseHas('governance_outbox', [
            'event_type' => 'field_claim.proposal.submitted',
            'aggregate_id' => $result['claim_version_id'],
            'status' => 'pending',
        ]);
        $this->assertDatabaseHas('audit_events', [
            'action' => 'field_aware_claim_proposed',
            'target_id' => $result['claim_version_id'],
        ]);
        $this->assertSame(0, DB::table('publication_decisions')->count());
        $this->assertSame(0, DB::table('public_projections')->count());
    }

    public function test_exact_definition_provider_category_and_scope_are_mandatory(): void
    {
        [$entityId, , $evidenceId] = $this->fixture('college');

        try {
            app(FieldAwareClaimProposalService::class)->propose(
                $this->proposalActor(), $entityId, 'institution_display_name', 1,
                'Synthetic Institute Beta', [$evidenceId], $this->sourceContext(),
                'institution', 'category-mismatch-key'
            );
            $this->fail('Provider category mismatch must be rejected.');
        } catch (ValidationException) {
            $this->assertSame(0, DB::table('claims')->count());
        }
    }

    public function test_missing_governed_category_and_invalid_typed_value_fail_closed(): void
    {
        $entityId = $this->entity();
        $versionId = $this->definition(['private_school']);
        $evidenceId = $this->evidence();

        try {
            app(FieldAwareClaimProposalService::class)->propose(
                $this->proposalActor(), $entityId, 'institution_display_name', 1,
                'Synthetic Institute Gamma', [$evidenceId], $this->sourceContext(),
                'institution', 'missing-category-key'
            );
            $this->fail('Missing category assignment must fail closed.');
        } catch (ValidationException) {
            $this->assertSame(0, DB::table('claims')->count());
        }

        app(ProviderCategoryAssignmentService::class)->assign(
            $this->taxonomyActor(), $entityId, 'private_school', 'synthetic_assignment', 'assignment-for-invalid-value'
        );

        try {
            app(FieldAwareClaimProposalService::class)->propose(
                $this->proposalActor(), $entityId, 'institution_display_name', 1,
                ['not' => 'a string'], [$evidenceId], $this->sourceContext(),
                'institution', 'invalid-value-key'
            );
            $this->fail('Typed value mismatch must be rejected.');
        } catch (ValidationException) {
            $this->assertSame(0, DB::table('claims')->count());
        }

        $this->assertNotSame('', $versionId);
    }

    public function test_generic_claim_registration_cannot_bypass_registry_or_add_unknown_predicates(): void
    {
        [$entityId, , $evidenceId] = $this->fixture();
        $service = app(GovernanceCommandService::class);

        foreach (['institution_display_name', 'unreviewed_dynamic_predicate'] as $predicate) {
            try {
                $service->registerProposedClaim(
                    $this->actor('legacy-writer', ['register_claim']),
                    $entityId,
                    $predicate,
                    ['value' => 'Synthetic bypass'],
                    [$evidenceId],
                    $this->sourceContext(),
                    'generic-bypass-'.$predicate
                );
                $this->fail('Generic registration must reject registry and unknown predicates.');
            } catch (ValidationException) {
                $this->assertSame(0, DB::table('claims')->count());
            }
        }
    }

    public function test_idempotent_retry_returns_original_proposal_and_rejects_payload_reuse(): void
    {
        [$entityId, , $evidenceId] = $this->fixture();
        $service = app(FieldAwareClaimProposalService::class);
        $actor = $this->proposalActor();

        $first = $service->propose(
            $actor, $entityId, 'institution_display_name', 1, 'Synthetic Institute Delta',
            [$evidenceId], $this->sourceContext(), 'institution', 'proposal-idempotency-key'
        );
        $second = $service->propose(
            $actor, $entityId, 'institution_display_name', 1, 'Synthetic Institute Delta',
            [$evidenceId], $this->sourceContext(), 'institution', 'proposal-idempotency-key'
        );

        $this->assertSame($first, $second);
        $this->assertSame(1, DB::table('claims')->count());
        $this->assertSame(1, DB::table('editorial_review_cases')->count());

        $this->expectException(ValidationException::class);
        $service->propose(
            $actor, $entityId, 'institution_display_name', 1, 'Different Synthetic Institute',
            [$evidenceId], $this->sourceContext(), 'institution', 'proposal-idempotency-key'
        );
    }

    private function fixture(string $assignedCategory = 'private_school'): array
    {
        $entityId = $this->entity();
        app(ProviderCategoryAssignmentService::class)->assign(
            $this->taxonomyActor(), $entityId, $assignedCategory, 'synthetic_assignment', 'category-'.$assignedCategory
        );
        $versionId = $this->definition(['private_school']);
        $evidenceId = $this->evidence();

        return [$entityId, $versionId, $evidenceId];
    }

    private function entity(): string
    {
        $id = (string) str()->uuid();
        DB::table('directory_entities')->insert([
            'id' => $id, 'entity_type' => 'institution', 'label' => 'Synthetic Institution',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return $id;
    }

    private function definition(array $categories): string
    {
        $definitionId = (string) str()->uuid();
        $versionId = (string) str()->uuid();
        DB::table('field_definitions')->insert([
            'id' => $definitionId, 'field_key' => 'institution_display_name',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('field_definition_versions')->insert([
            'id' => $versionId,
            'field_definition_id' => $definitionId,
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
            'rationale_reference' => 'SYN-I3-TEST',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('field_definition_version_entity_types')->insert([
            'id' => (string) str()->uuid(), 'field_definition_version_id' => $versionId,
            'entity_type' => 'institution', 'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach ($categories as $category) {
            DB::table('field_definition_version_provider_categories')->insert([
                'id' => (string) str()->uuid(), 'field_definition_version_id' => $versionId,
                'provider_category' => $category, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        return $versionId;
    }

    private function evidence(): string
    {
        $authorizationId = (string) str()->uuid();
        $evidenceId = (string) str()->uuid();
        $now = now();
        DB::table('source_authorizations')->insert([
            'id' => $authorizationId,
            'source_family_id' => 'synthetic-family',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['synthetic_test_only'], JSON_THROW_ON_ERROR),
            'permitted_methods' => json_encode(['fixture_reference'], JSON_THROW_ON_ERROR),
            'territories' => json_encode(['synthetic'], JSON_THROW_ON_ERROR),
            'permitted_scopes' => json_encode(['processing' => true], JSON_THROW_ON_ERROR),
            'valid_from' => null, 'valid_to' => null, 'revoked_at' => null,
            'revocation_reason' => null, 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('evidence_references')->insert([
            'id' => $evidenceId,
            'source_authorization_id' => $authorizationId,
            'reference_kind' => 'synthetic_fixture',
            'source_type' => 'synthetic',
            'integrity_digest' => 'sha256:synthetic-fixture',
            'status' => 'quarantined',
            'content_included' => false,
            'observed_at' => $now,
            'recorded_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $evidenceId;
    }

    private function sourceContext(): array
    {
        return ['purpose' => 'synthetic_test_only', 'method' => 'fixture_reference', 'territory' => 'synthetic'];
    }

    private function taxonomyActor(): array
    {
        return $this->actor('synthetic-taxonomy-steward', ['assign_provider_category']);
    }

    private function proposalActor(): array
    {
        return $this->actor('synthetic-field-editor', ['propose_field_value', 'submit_directory_proposal']);
    }

    private function actor(string $id, array $capabilities, string $class = 'human'): array
    {
        return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities];
    }
}
