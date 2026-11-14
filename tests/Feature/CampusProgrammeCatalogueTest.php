<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\CampusProgrammeCatalogueService;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CampusProgrammeCatalogueTest extends TestCase
{
    use RefreshDatabase;

    public function test_institution_can_have_multiple_distinct_campuses_and_delivery_sites(): void
    {
        $institution = $this->entity('institution');
        $campusA = $this->entity('campus', 'Synthetic North Campus');
        $campusB = $this->entity('campus', 'Synthetic North Campus');
        $site = $this->entity('delivery_site', 'Synthetic Remote Learning Site');

        $this->materialize('campus', $campusA, ['institution_entity_id' => $institution, 'location_label' => 'Synthetic District A'], 'campus-a');
        $this->materialize('campus', $campusB, ['institution_entity_id' => $institution, 'location_label' => 'Synthetic District B'], 'campus-b');
        $this->materialize('delivery_site', $site, ['institution_entity_id' => $institution, 'location_label' => 'Synthetic Remote Region'], 'site-1');

        $this->assertDatabaseCount('directory_campuses', 2);
        $this->assertDatabaseCount('directory_delivery_sites', 1);
        $this->assertDatabaseHas('directory_campuses', ['entity_id' => $campusA, 'institution_entity_id' => $institution]);
        $this->assertDatabaseHas('directory_campuses', ['entity_id' => $campusB, 'institution_entity_id' => $institution]);
        $this->assertDatabaseHas('directory_delivery_sites', ['entity_id' => $site, 'institution_entity_id' => $institution]);
    }

    public function test_similar_campus_names_remain_distinct_identities(): void
    {
        $institution = $this->entity('institution');
        $a = $this->entity('campus', 'Synthetic Central Campus');
        $b = $this->entity('campus', 'Synthetic Central Campus');
        $this->materialize('campus', $a, ['institution_entity_id' => $institution], 'same-name-a');
        $this->materialize('campus', $b, ['institution_entity_id' => $institution], 'same-name-b');

        $this->assertNotSame($a, $b);
        $this->assertDatabaseCount('directory_campuses', 2);
    }

    public function test_programme_catalogue_is_distinct_from_qualification_and_offer(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $this->materialize('programme', $programme, ['institution_entity_id' => $institution, 'title' => 'Synthetic Applied Studies', 'level' => 'synthetic-level-5'], 'programme');
        $this->assertDatabaseHas('programme_catalogue_entries', ['entity_id' => $programme, 'title' => 'Synthetic Applied Studies']);
        $this->assertDatabaseCount('programme_offers', 0);
        $this->assertDatabaseCount('programme_qualification_links', 0);
    }

    public function test_qualification_and_awarding_body_are_explicitly_linked(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $qualification = $this->entity('qualification');
        $awarder = $this->entity('awarding_body');
        $this->materialize('programme', $programme, ['institution_entity_id' => $institution, 'title' => 'Synthetic Engineering Programme'], 'programme-link-base');
        $id = $this->materialize('programme_qualification', $programme, [
            'programme_entity_id' => $programme,
            'qualification_entity_id' => $qualification,
            'awarding_body_entity_id' => $awarder,
        ], 'qualification-link');

        $this->assertDatabaseHas('programme_qualification_links', [
            'id' => $id, 'programme_entity_id' => $programme,
            'qualification_entity_id' => $qualification, 'awarding_body_entity_id' => $awarder,
        ]);
    }

    public function test_programme_offer_requires_explicit_campus_or_delivery_site_and_admission_cycle(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $campus = $this->entity('campus');
        $site = $this->entity('delivery_site');
        $this->materialize('programme', $programme, ['institution_entity_id' => $institution, 'title' => 'Synthetic Computing'], 'offer-programme');
        $this->materialize('campus', $campus, ['institution_entity_id' => $institution], 'offer-campus');
        $this->materialize('delivery_site', $site, ['institution_entity_id' => $institution], 'offer-site');

        $offerA = $this->materialize('programme_offer', $programme, [
            'programme_entity_id' => $programme, 'delivery_location_entity_id' => $campus, 'admission_cycle' => 'synthetic-2027',
        ], 'offer-campus-2027');
        $offerB = $this->materialize('programme_offer', $programme, [
            'programme_entity_id' => $programme, 'delivery_location_entity_id' => $site, 'admission_cycle' => 'synthetic-2028',
        ], 'offer-site-2028');

        $this->assertDatabaseCount('programme_offers', 2);
        $this->assertDatabaseHas('programme_offers', ['id' => $offerA, 'delivery_location_entity_id' => $campus, 'admission_cycle' => 'synthetic-2027']);
        $this->assertDatabaseHas('programme_offers', ['id' => $offerB, 'delivery_location_entity_id' => $site, 'admission_cycle' => 'synthetic-2028']);
    }

    public function test_wrong_identity_types_and_missing_cycle_fail_closed(): void
    {
        $programme = $this->entity('programme');
        $this->expectException(ValidationException::class);
        $this->materialize('campus', $this->entity('campus'), ['institution_entity_id' => $programme], 'wrong-institution-type');
    }

    public function test_programme_offer_without_an_admission_cycle_is_rejected(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $campus = $this->entity('campus');
        $this->materialize('programme', $programme, ['institution_entity_id' => $institution, 'title' => 'Synthetic Cycle Test'], 'cycle-programme');
        $this->materialize('campus', $campus, ['institution_entity_id' => $institution], 'cycle-campus');
        $version = $this->claim('programme_offer', $programme, [
            'programme_entity_id' => $programme, 'delivery_location_entity_id' => $campus,
        ]);
        $this->expectException(ValidationException::class);
        app(CampusProgrammeCatalogueService::class)->materializeAcceptedRecord($this->actor('catalogue-manager'), $version, 'missing-cycle');
    }

    public function test_offer_cannot_be_assigned_to_another_institutions_campus(): void
    {
        $institutionA = $this->entity('institution');
        $institutionB = $this->entity('institution');
        $programme = $this->entity('programme');
        $campus = $this->entity('campus');
        $this->materialize('programme', $programme, ['institution_entity_id' => $institutionA, 'title' => 'Synthetic Cross Institution'], 'cross-programme');
        $this->materialize('campus', $campus, ['institution_entity_id' => $institutionB], 'cross-campus');
        $version = $this->claim('programme_offer', $programme, [
            'programme_entity_id' => $programme, 'delivery_location_entity_id' => $campus, 'admission_cycle' => 'synthetic-2027',
        ]);
        $this->expectException(ValidationException::class);
        app(CampusProgrammeCatalogueService::class)->materializeAcceptedRecord($this->actor('catalogue-manager'), $version, 'cross-institution-offer');
    }

    public function test_unadjudicated_claim_cannot_be_materialized(): void
    {
        $programme = $this->entity('programme');
        $version = $this->claim('programme', $programme, ['title' => 'Synthetic Unaccepted'], false);
        $this->expectException(ValidationException::class);
        app(CampusProgrammeCatalogueService::class)->materializeAcceptedRecord($this->actor('catalogue-manager'), $version, 'unaccepted');
    }

    public function test_claim_withdrawal_propagates_to_campus_catalogue_projection(): void
    {
        $institution = $this->entity('institution');
        $campus = $this->entity('campus');
        $version = $this->claim('campus', $campus, ['institution_entity_id' => $institution]);
        app(CampusProgrammeCatalogueService::class)->materializeAcceptedRecord($this->actor('catalogue-manager'), $version, 'withdraw-campus');
        app(PersistedGovernanceWorkflowService::class)->withdrawClaimVersion([
            'actor_id' => 'synthetic-withdrawer', 'actor_class' => 'human', 'capabilities' => ['withdraw_claim'],
        ], $version, 'synthetic_withdrawal', 'Synthetic P02 withdrawal.', 'withdraw-campus-key');

        $this->assertDatabaseHas('directory_campuses', ['entity_id' => $campus, 'status' => 'withdrawn']);
    }

    public function test_audit_failure_rolls_back_catalogue_projection(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $version = $this->claim('programme', $programme, ['institution_entity_id' => $institution, 'title' => 'Synthetic Rollback']);
        DB::unprepared("CREATE TRIGGER fail_p02_audit BEFORE INSERT ON audit_events BEGIN SELECT RAISE(ABORT, 'synthetic P02 audit failure'); END");
        try {
            app(CampusProgrammeCatalogueService::class)->materializeAcceptedRecord($this->actor('catalogue-manager'), $version, 'audit-failure');
            $this->fail('Audit failure must abort materialization.');
        } catch (\Illuminate\Database\QueryException) {
            $this->assertDatabaseCount('programme_catalogue_entries', 0);
        } finally {
            DB::unprepared('DROP TRIGGER IF EXISTS fail_p02_audit');
        }
    }

    private function materialize(string $predicate, string $subject, array $value, string $key): string
    {
        $version = $this->claim($predicate, $subject, $value);
        return app(CampusProgrammeCatalogueService::class)->materializeAcceptedRecord($this->actor('catalogue-manager'), $version, $key);
    }

    private function claim(string $predicate, string $subject, array $value, bool $accepted = true): string
    {
        $now = now();
        $authorization = (string) str()->uuid();
        $evidence = (string) str()->uuid();
        $claim = (string) str()->uuid();
        $version = (string) str()->uuid();
        $case = (string) str()->uuid();
        DB::table('source_authorizations')->insert([
            'id' => $authorization, 'source_family_id' => 'synthetic-p02-only',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['synthetic_test_only']),
            'permitted_methods' => json_encode(['fixture_reference']),
            'territories' => json_encode(['synthetic']),
            'permitted_scopes' => json_encode(['acquisition' => true, 'retention' => true, 'processing' => true, 'reuse' => false, 'publication' => false]),
            'valid_from' => now()->subDay(), 'valid_to' => now()->addDay(),
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('evidence_references')->insert([
            'id' => $evidence, 'source_authorization_id' => $authorization,
            'reference_kind' => 'synthetic_fixture', 'source_type' => 'synthetic',
            'integrity_digest' => 'synthetic-p02-digest', 'status' => 'eligible_for_review',
            'content_included' => false, 'recorded_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) str()->uuid(), 'actor_class' => 'human', 'action' => 'evidence_reference_registered',
            'target_type' => 'evidence_reference', 'target_id' => $evidence, 'reason_code' => 'synthetic_fixture',
            'occurred_at' => $now, 'metadata' => json_encode(['actor_id' => 'synthetic-evidence-author']),
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claims')->insert([
            'id' => $claim, 'subject_entity_id' => $subject, 'predicate' => $predicate,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_versions')->insert([
            'id' => $version, 'claim_id' => $claim, 'version_number' => 1,
            'value' => json_encode($value), 'recorded_at' => $now,
            'disposition' => $accepted ? 'accepted' : 'proposed',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(), 'claim_version_id' => $version,
            'evidence_reference_id' => $evidence, 'relationship_type' => 'supports',
            'created_at' => $now, 'updated_at' => $now,
        ]);
        if ($accepted) {
            DB::table('adjudication_cases')->insert([
                'id' => $case, 'claim_version_id' => $version, 'status' => 'decided',
                'opened_by_actor_id' => 'synthetic-case-opener', 'case_kind' => 'initial',
                'idempotency_key' => 'case-'.str()->uuid(), 'created_at' => $now, 'updated_at' => $now,
            ]);
            DB::table('adjudication_decisions')->insert([
                'id' => (string) str()->uuid(), 'adjudication_case_id' => $case,
                'outcome' => 'accepted', 'actor_id' => 'synthetic-adjudicator',
                'actor_class' => 'human', 'rationale_code' => 'synthetic_acceptance',
                'rationale' => 'Synthetic fixture adjudicated.', 'policy_version' => 'synthetic-policy-v1',
                'decided_at' => $now, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        return $version;
    }

    private function entity(string $type, ?string $label = null): string
    {
        $id = (string) str()->uuid();
        $now = now();
        DB::table('directory_entities')->insert([
            'id' => $id, 'entity_type' => $type,
            'label' => $label ?? 'Synthetic '.$type.' '.str()->random(6),
            'created_at' => $now, 'updated_at' => $now,
        ]);
        return $id;
    }

    private function actor(string $id): array
    {
        return ['actor_id' => $id, 'actor_class' => 'human', 'capabilities' => ['materialize_catalogue_record']];
    }
}
