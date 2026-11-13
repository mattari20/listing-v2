<?php

namespace Tests\\Feature;

use Illuminate\\Database\\QueryException;
use Illuminate\\Foundation\\Testing\\RefreshDatabase;
use Illuminate\\Support\\Facades\\DB;
use Illuminate\\Support\\Facades\\Schema;
use Tests\\TestCase;

class CoreGovernancePersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_governance_schema_is_created_with_expected_tables(): void
    {
        foreach ([
            'directory_entities',
            'entity_relationships',
            'source_authorizations',
            'evidence_references',
            'claims',
            'claim_versions',
            'claim_evidence_links',
            'audit_events',
        ] as $table) {
            $this->assertTrue(Schema::hasTable($table), "Missing table: {$table}");
        }
    }

    public function test_relationships_reject_missing_entity_endpoints(): void
    {
        $this->expectException(QueryException::class);

        DB::table('entity_relationships')->insert([
            'id' => (string) str()->uuid(),
            'from_entity_id' => (string) str()->uuid(),
            'to_entity_id' => (string) str()->uuid(),
            'relationship_type' => 'operates',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_authorization_scopes_and_evidence_metadata_remain_separate(): void
    {
        $authorizationId = (string) str()->uuid();
        $now = now();

        DB::table('source_authorizations')->insert([
            'id' => $authorizationId,
            'source_family_id' => 'synthetic-family-only',
            'status' => 'active',
            'permitted_purposes' => json_encode(['synthetic_test_only']),
            'permitted_methods' => json_encode(['fixture_reference']),
            'territories' => json_encode(['synthetic']),
            'permitted_scopes' => json_encode([
                'acquisition' => false,
                'retention' => false,
                'processing' => true,
                'reuse' => false,
                'publication' => false,
            ]),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('evidence_references')->insert([
            'id' => (string) str()->uuid(),
            'source_authorization_id' => $authorizationId,
            'reference_kind' => 'synthetic_fixture',
            'source_type' => 'synthetic',
            'integrity_digest' => 'sha256:synthetic-only',
            'status' => 'quarantined',
            'content_included' => false,
            'recorded_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->assertDatabaseHas('evidence_references', [
            'source_authorization_id' => $authorizationId,
            'content_included' => false,
            'status' => 'quarantined',
        ]);
        $this->assertSame(
            ['acquisition' => false, 'retention' => false, 'processing' => true, 'reuse' => false, 'publication' => false],
            json_decode(DB::table('source_authorizations')->where('id', $authorizationId)->value('permitted_scopes'), true)
        );
    }

    public function test_claim_versions_preserve_disposition_and_supersession_as_separate_fields(): void
    {
        $now = now();
        $entityId = (string) str()->uuid();
        $claimId = (string) str()->uuid();
        $firstVersionId = (string) str()->uuid();

        DB::table('directory_entities')->insert([
            'id' => $entityId,
            'entity_type' => 'institution',
            'label' => 'Synthetic Institute North',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claims')->insert([
            'id' => $claimId,
            'subject_entity_id' => $entityId,
            'predicate' => 'display_name',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claim_versions')->insert([
            'id' => $firstVersionId,
            'claim_id' => $claimId,
            'version_number' => 1,
            'value' => json_encode(['value' => 'Synthetic Institute North']),
            'recorded_at' => $now,
            'disposition' => 'accepted',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $secondVersionId = (string) str()->uuid();
        DB::table('claim_versions')->insert([
            'id' => $secondVersionId,
            'claim_id' => $claimId,
            'version_number' => 2,
            'value' => json_encode(['value' => 'Synthetic Institute North Revised']),
            'recorded_at' => $now->copy()->addSecond(),
            'disposition' => 'proposed',
            'supersedes_version_id' => $firstVersionId,
            'correction_reason' => 'synthetic_fixture_correction',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->assertDatabaseHas('claim_versions', [
            'id' => $firstVersionId,
            'disposition' => 'accepted',
            'supersedes_version_id' => null,
        ]);
        $this->assertDatabaseHas('claim_versions', [
            'id' => $secondVersionId,
            'disposition' => 'proposed',
            'supersedes_version_id' => $firstVersionId,
        ]);
    }

    public function test_audit_events_require_actor_action_target_and_reason(): void
    {
        DB::table('audit_events')->insert([
            'id' => (string) str()->uuid(),
            'actor_class' => 'synthetic_editor',
            'action' => 'claim_created',
            'target_type' => 'claim_version',
            'target_id' => (string) str()->uuid(),
            'reason_code' => 'synthetic_fixture_setup',
            'occurred_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertSame(1, DB::table('audit_events')->count());
    }
}
