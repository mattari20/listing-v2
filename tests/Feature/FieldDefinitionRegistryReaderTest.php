<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\FieldDefinitionRegistryReader;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FieldDefinitionRegistryReaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_exact_definition_version_is_read_without_latest_version_fallback(): void
    {
        $this->definition('institution.display_name', 1, 'active');
        $this->definition('institution.display_name', 2, 'proposed');

        $reader = app(FieldDefinitionRegistryReader::class);

        $this->assertSame(1, $reader->findVersion('institution.display_name', 1)['version_number']);
        $this->assertSame('proposed', $reader->findVersion('institution.display_name', 2)['lifecycle_state']);
        $this->assertNull($reader->findVersion('institution.display_name', 3));
        $this->assertSame([1, 2], array_column($reader->versionsForKey('institution.display_name'), 'version_number'));
    }

    public function test_field_key_and_definition_version_uniqueness_are_database_enforced(): void
    {
        $this->definition('institution.display_name', 1);

        $this->expectException(QueryException::class);
        DB::table('field_definitions')->insert([
            'id' => (string) str()->uuid(),
            'field_key' => 'institution.display_name',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_version_number_is_unique_within_a_field_identity(): void
    {
        $definitionId = $this->definition('institution.display_name', 1);

        $this->expectException(QueryException::class);
        $this->insertVersion($definitionId, 1, 'proposed');
    }

    public function test_only_active_and_effective_definitions_are_applicable(): void
    {
        $this->definition('test.proposed_field', 1, 'proposed');
        $this->definition('test.retired_field', 1, 'retired');
        $this->definition('test.future_field', 1, 'active', '2026-12-01 00:00:00');
        $this->definition('test.expired_field', 1, 'active', null, '2026-11-01 00:00:00');

        $reader = app(FieldDefinitionRegistryReader::class);
        $at = CarbonImmutable::parse('2026-11-14 12:00:00');

        $this->assertSame('definition_not_active', $reader->resolveApplicable('test.proposed_field', 1, 'institution', 'school', $at)['reason']);
        $this->assertSame('definition_not_active', $reader->resolveApplicable('test.retired_field', 1, 'institution', 'school', $at)['reason']);
        $this->assertSame('definition_not_yet_effective', $reader->resolveApplicable('test.future_field', 1, 'institution', 'school', $at)['reason']);
        $this->assertSame('definition_expired', $reader->resolveApplicable('test.expired_field', 1, 'institution', 'school', $at)['reason']);
    }

    public function test_effective_from_is_inclusive_and_effective_to_is_exclusive(): void
    {
        $this->definition('test.window_field', 1, 'active', '2026-11-14 10:00:00', '2026-11-14 12:00:00');

        $reader = app(FieldDefinitionRegistryReader::class);

        $this->assertTrue($reader->resolveApplicable('test.window_field', 1, 'institution', 'school', CarbonImmutable::parse('2026-11-14 10:00:00'))['allowed']);
        $this->assertTrue($reader->resolveApplicable('test.window_field', 1, 'institution', 'school', CarbonImmutable::parse('2026-11-14 11:59:59'))['allowed']);
        $this->assertSame('definition_expired', $reader->resolveApplicable('test.window_field', 1, 'institution', 'school', CarbonImmutable::parse('2026-11-14 12:00:00'))['reason']);
    }

    public function test_entity_type_and_provider_category_applicability_are_explicit_and_fail_closed(): void
    {
        $this->definition('school.grade_range', 1, 'active', null, null, ['institution'], ['private_school']);

        $reader = app(FieldDefinitionRegistryReader::class);

        $this->assertTrue($reader->resolveApplicable('school.grade_range', 1, 'institution', 'private_school')['allowed']);
        $this->assertSame('entity_type_not_applicable', $reader->resolveApplicable('school.grade_range', 1, 'campus', 'private_school')['reason']);
        $this->assertSame('provider_category_not_applicable', $reader->resolveApplicable('school.grade_range', 1, 'institution', 'academy')['reason']);
        $this->assertSame('definition_not_found', $reader->resolveApplicable('unknown.field', 1, 'institution', 'private_school')['reason']);
    }

    public function test_universal_pilot_applicability_is_explicitly_enumerated_for_four_categories(): void
    {
        $categories = ['private_school', 'college', 'academy', 'university'];
        $this->definition('institution.display_name', 1, 'active', null, null, ['institution'], $categories);

        $reader = app(FieldDefinitionRegistryReader::class);

        foreach ($categories as $category) {
            $this->assertTrue($reader->resolveApplicable('institution.display_name', 1, 'institution', $category)['allowed']);
        }

        $this->assertSame('provider_category_not_applicable', $reader->resolveApplicable('institution.display_name', 1, 'institution', 'unlisted_category')['reason']);
    }

    public function test_campus_scope_does_not_inherit_to_institution_and_internal_field_is_not_a_value_payload(): void
    {
        $this->definition(
            'campus.public_address_label',
            1,
            'active',
            null,
            null,
            ['campus'],
            ['private_school', 'college', 'academy', 'university'],
            'campus',
            'editorial_restricted',
            'internal_only'
        );

        $reader = app(FieldDefinitionRegistryReader::class);
        $result = $reader->resolveApplicable('campus.public_address_label', 1, 'campus', 'private_school');

        $this->assertTrue($result['allowed']);
        $this->assertSame('editorial_restricted', $result['definition']['privacy_class']);
        $this->assertSame('internal_only', $result['definition']['visibility_class']);
        $this->assertArrayNotHasKey('value', $result['definition']);
        $this->assertArrayNotHasKey('public_value', $result['definition']);
        $this->assertSame('entity_type_not_applicable', $reader->resolveApplicable('campus.public_address_label', 1, 'institution', 'private_school')['reason']);
    }

    public function test_read_only_reader_does_not_change_registry_or_existing_claim_data(): void
    {
        $entityId = (string) str()->uuid();
        $claimId = (string) str()->uuid();
        $versionId = (string) str()->uuid();
        $now = now();

        DB::table('directory_entities')->insert([
            'id' => $entityId, 'entity_type' => 'institution', 'label' => 'Synthetic legacy institution',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claims')->insert([
            'id' => $claimId, 'subject_entity_id' => $entityId, 'predicate' => 'legacy.synthetic_predicate',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_versions')->insert([
            'id' => $versionId, 'claim_id' => $claimId, 'version_number' => 1,
            'value' => json_encode(['synthetic' => true], JSON_THROW_ON_ERROR),
            'recorded_at' => $now, 'valid_from' => null, 'valid_to' => null,
            'disposition' => 'proposed', 'supersedes_version_id' => null, 'correction_reason' => null,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $definitionId = $this->definition('institution.profile_note_internal', 1, 'active', null, null, ['institution'], ['private_school'], 'institution', 'editorial_restricted', 'internal_only');

        $beforeClaims = DB::table('claims')->count();
        $beforeVersions = DB::table('claim_versions')->count();
        $beforeDefinitions = DB::table('field_definitions')->count();

        $result = app(FieldDefinitionRegistryReader::class)->resolveApplicable(
            'institution.profile_note_internal',
            1,
            'institution',
            'private_school'
        );

        $this->assertTrue($result['allowed']);
        $this->assertSame($beforeClaims, DB::table('claims')->count());
        $this->assertSame($beforeVersions, DB::table('claim_versions')->count());
        $this->assertSame($beforeDefinitions, DB::table('field_definitions')->count());
        $this->assertDatabaseHas('claims', ['id' => $claimId, 'predicate' => 'legacy.synthetic_predicate']);
        $this->assertDatabaseHas('claim_versions', ['id' => $versionId, 'claim_id' => $claimId]);
        $this->assertFalse(Schema::hasColumn('claim_versions', 'field_definition_version_id'));
        $this->assertNotSame('', $definitionId);
    }

    public function test_i1_migration_down_and_up_are_limited_to_its_four_owned_tables(): void
    {
        $migration = require base_path('database/migrations/2026_11_14_000007_create_field_registry_tables.php');

        $migration->down();

        foreach ($this->registryTables() as $table) {
            $this->assertFalse(Schema::hasTable($table), $table.' should be dropped by the I1 down migration.');
        }
        $this->assertTrue(Schema::hasTable('claims'));
        $this->assertTrue(Schema::hasTable('claim_versions'));

        $migration->up();

        foreach ($this->registryTables() as $table) {
            $this->assertTrue(Schema::hasTable($table), $table.' should be recreated by the I1 up migration.');
        }
        $this->assertTrue(Schema::hasTable('claims'));
        $this->assertTrue(Schema::hasTable('claim_versions'));
    }

    /**
     * @param list<string>  $entityTypes
     * @param list<string>  $providerCategories
     */
    private function definition(
        string $fieldKey,
        int $version,
        string $state = 'active',
        ?string $effectiveFrom = null,
        ?string $effectiveTo = null,
        array $entityTypes = ['institution'],
        array $providerCategories = ['school'],
        string $scope = 'institution',
        string $privacy = 'public_eligible',
        string $visibility = 'public_eligible'
    ): string {
        $definitionId = DB::table('field_definitions')->where('field_key', $fieldKey)->value('id');

        if ($definitionId === null) {
            $definitionId = (string) str()->uuid();
            DB::table('field_definitions')->insert([
                'id' => $definitionId,
                'field_key' => $fieldKey,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $versionId = $this->insertVersion(
            (string) $definitionId,
            $version,
            $state,
            $effectiveFrom,
            $effectiveTo,
            $scope,
            $privacy,
            $visibility
        );

        foreach ($entityTypes as $entityType) {
            DB::table('field_definition_version_entity_types')->insert([
                'id' => (string) str()->uuid(),
                'field_definition_version_id' => $versionId,
                'entity_type' => $entityType,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($providerCategories as $category) {
            DB::table('field_definition_version_provider_categories')->insert([
                'id' => (string) str()->uuid(),
                'field_definition_version_id' => $versionId,
                'provider_category' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return (string) $definitionId;
    }

    private function insertVersion(
        string $definitionId,
        int $version,
        string $state,
        ?string $effectiveFrom = null,
        ?string $effectiveTo = null,
        string $scope = 'institution',
        string $privacy = 'public_eligible',
        string $visibility = 'public_eligible'
    ): string {
        $versionId = (string) str()->uuid();

        DB::table('field_definition_versions')->insert([
            'id' => $versionId,
            'field_definition_id' => $definitionId,
            'version_number' => $version,
            'lifecycle_state' => $state,
            'semantic_version' => '1.0.0',
            'compatibility_class' => 'initial',
            'value_type' => 'short_text',
            'cardinality' => 'one',
            'scope_key' => $scope,
            'privacy_class' => $privacy,
            'visibility_class' => $visibility,
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'validation_schema' => json_encode(['schema_version' => 1, 'max_length' => 120], JSON_THROW_ON_ERROR),
            'presentation_metadata' => json_encode(['section_key' => 'identity', 'label_key' => 'synthetic.label'], JSON_THROW_ON_ERROR),
            'evidence_policy' => json_encode(['required' => true, 'synthetic_fixture_only' => true], JSON_THROW_ON_ERROR),
            'freshness_policy' => json_encode(['class' => 'synthetic_test'], JSON_THROW_ON_ERROR),
            'effective_from' => $effectiveFrom,
            'effective_to' => $effectiveTo,
            'successor_field_definition_id' => null,
            'proposed_by_actor_id' => 'synthetic-owner',
            'rationale_reference' => 'SYN-I1-TEST',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $versionId;
    }

    /**
     * @return list<string>
     */
    private function registryTables(): array
    {
        return [
            'field_definitions',
            'field_definition_versions',
            'field_definition_version_entity_types',
            'field_definition_version_provider_categories',
        ];
    }
}
