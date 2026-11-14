<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\FieldDefinitionRegistryReader;
use App\Services\Directory\ProviderCategoryAssignmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ProviderCategoryAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_is_not_inferred_from_entity_label(): void
    {
        $entityId = $this->institution('Synthetic Private School North');

        $this->assertNull(app(FieldDefinitionRegistryReader::class)->providerCategoryForEntity($entityId));
    }

    public function test_only_human_actor_with_assignment_capability_can_assign_category(): void
    {
        $entityId = $this->institution();

        try {
            app(ProviderCategoryAssignmentService::class)->assign(
                $this->actor('agent-1', ['assign_provider_category'], 'automated'),
                $entityId, 'private_school', 'synthetic_taxonomy_assignment', 'category-key-1'
            );
            $this->fail('Automated actors must not assign provider categories.');
        } catch (ValidationException) {
            $this->assertDatabaseMissing('directory_provider_category_assignments', ['entity_id' => $entityId]);
        }

        $this->expectException(ValidationException::class);
        app(ProviderCategoryAssignmentService::class)->assign(
            $this->actor('human-without-capability', []),
            $entityId, 'private_school', 'synthetic_taxonomy_assignment', 'category-key-2'
        );
    }

    public function test_assignment_uses_controlled_pilot_vocabulary_and_institution_subjects_only(): void
    {
        $entityId = $this->institution();

        try {
            app(ProviderCategoryAssignmentService::class)->assign(
                $this->actor('taxonomy-steward', ['assign_provider_category']),
                $entityId, 'unlisted_category', 'synthetic_taxonomy_assignment', 'category-key-3'
            );
            $this->fail('Unknown categories must fail closed.');
        } catch (ValidationException) {
            $this->assertDatabaseMissing('directory_provider_category_assignments', ['entity_id' => $entityId]);
        }

        $campusId = $this->institution('Synthetic Campus', 'campus');
        $this->expectException(ValidationException::class);
        app(ProviderCategoryAssignmentService::class)->assign(
            $this->actor('taxonomy-steward', ['assign_provider_category']),
            $campusId, 'private_school', 'synthetic_taxonomy_assignment', 'category-key-4'
        );
    }

    public function test_assignment_is_human_audited_idempotent_and_reassignment_preserves_history(): void
    {
        $entityId = $this->institution();
        $service = app(ProviderCategoryAssignmentService::class);
        $actor = $this->actor('taxonomy-steward', ['assign_provider_category']);

        $service->assign($actor, $entityId, 'private_school', 'synthetic_initial_assignment', 'category-key-5');
        $service->assign($actor, $entityId, 'private_school', 'synthetic_initial_assignment', 'category-key-5');

        $this->assertSame('private_school', app(FieldDefinitionRegistryReader::class)->providerCategoryForEntity($entityId));
        $this->assertSame(1, DB::table('audit_events')->where('action', 'provider_category_assigned')->count());

        $service->assign($actor, $entityId, 'college', 'synthetic_reclassification', 'category-key-6');

        $this->assertSame('college', app(FieldDefinitionRegistryReader::class)->providerCategoryForEntity($entityId));
        $this->assertSame(2, DB::table('audit_events')->where('action', 'provider_category_assigned')->count());
        $this->assertDatabaseHas('audit_events', [
            'action' => 'provider_category_assigned',
            'target_id' => $entityId,
            'reason_code' => 'synthetic_reclassification',
        ]);
        $history = DB::table('audit_events')->where('action', 'provider_category_assigned')
            ->orderBy('occurred_at')->get();
        $this->assertSame('private_school', json_decode($history[1]->metadata, true)['previous_provider_category']);
    }

    private function institution(string $label = 'Synthetic Institution', string $type = 'institution'): string
    {
        $id = (string) str()->uuid();
        DB::table('directory_entities')->insert([
            'id' => $id, 'entity_type' => $type, 'label' => $label,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return $id;
    }

    private function actor(string $id, array $capabilities, string $class = 'human'): array
    {
        return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities];
    }
}
