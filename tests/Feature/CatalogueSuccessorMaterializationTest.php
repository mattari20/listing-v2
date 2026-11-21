<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\CampusProgrammeCatalogueService;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

final class CatalogueSuccessorMaterializationTest extends TestCase
{
    use RefreshDatabase;

    public function test_programme_successor_replaces_exact_projection_in_place_after_acceptance(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $initial = $this->acceptedVersion($programme, 'programme', [
            'institution_entity_id' => $institution,
            'title' => 'Synthetic Programme Original',
            'description' => 'Original description',
            'level' => 'undergraduate',
        ], 'programme-initial');

        $materializer = app(CampusProgrammeCatalogueService::class);
        $firstId = $materializer->materializeAcceptedRecord($this->actor('programme-materializer'), $initial, 'programme-materialize-initial');
        $this->assertSame($programme, $firstId);
        $this->assertDatabaseHas('programme_catalogue_entries', [
            'entity_id' => $programme,
            'claim_version_id' => $initial,
            'title' => 'Synthetic Programme Original',
        ]);

        $successor = $this->correctAndAccept($initial, [
            'institution_entity_id' => $institution,
            'title' => 'Synthetic Programme Updated',
            'description' => 'Updated description',
            'level' => 'graduate',
        ], 'programme-successor');

        try {
            $materializer->materializeAcceptedRecord($this->actor('programme-materializer'), $successor, 'programme-materialize-successor');
            $this->fail('An accepted but unpublished successor must not replace the prior catalogue projection.');
        } catch (ValidationException) {
            $this->assertDatabaseHas('programme_catalogue_entries', [
                'entity_id' => $programme,
                'claim_version_id' => $initial,
                'title' => 'Synthetic Programme Original',
            ]);
        }
        $this->publishAcceptedVersion($successor, 'programme-successor');

        $secondId = $materializer->materializeAcceptedRecord($this->actor('programme-materializer'), $successor, 'programme-materialize-successor');
        $this->assertSame($firstId, $secondId);
        $this->assertDatabaseCount('programme_catalogue_entries', 1);
        $this->assertDatabaseHas('programme_catalogue_entries', [
            'entity_id' => $programme,
            'claim_version_id' => $successor,
            'title' => 'Synthetic Programme Updated',
            'description' => 'Updated description',
            'level' => 'graduate',
        ]);
        $this->assertSame($secondId, $materializer->materializeAcceptedRecord($this->actor('programme-materializer'), $successor, 'programme-materialize-successor'));
        $this->assertDatabaseCount('public_projections', 0);
    }

    public function test_qualification_link_successor_preserves_link_identity_and_rejects_duplicate_natural_key(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $programmeVersion = $this->acceptedVersion($programme, 'programme', [
            'institution_entity_id' => $institution,
            'title' => 'Synthetic Qualification Programme',
        ], 'qualification-programme');
        app(CampusProgrammeCatalogueService::class)->materializeAcceptedRecord($this->actor('qualification-programme-materializer'), $programmeVersion, 'qualification-programme-materialize');

        $qualificationOne = $this->entity('qualification');
        $qualificationTwo = $this->entity('qualification');
        $awarder = $this->entity('awarding_body');
        $initial = $this->acceptedVersion($programme, 'programme_qualification', [
            'programme_entity_id' => $programme,
            'qualification_entity_id' => $qualificationOne,
            'awarding_body_entity_id' => $awarder,
        ], 'qualification-link-initial');

        $materializer = app(CampusProgrammeCatalogueService::class);
        $linkId = $materializer->materializeAcceptedRecord($this->actor('qualification-link-materializer'), $initial, 'qualification-link-materialize-initial');
        $this->assertDatabaseHas('programme_qualification_links', [
            'id' => $linkId,
            'claim_version_id' => $initial,
            'qualification_entity_id' => $qualificationOne,
        ]);

        $successor = $this->correctAndAccept($initial, [
            'programme_entity_id' => $programme,
            'qualification_entity_id' => $qualificationTwo,
            'awarding_body_entity_id' => $awarder,
        ], 'qualification-link-successor');

        $this->assertDatabaseHas('programme_qualification_links', [
            'id' => $linkId,
            'claim_version_id' => $initial,
            'qualification_entity_id' => $qualificationOne,
        ]);
        $this->publishAcceptedVersion($successor, 'qualification-link-successor');

        $successorId = $materializer->materializeAcceptedRecord($this->actor('qualification-link-materializer'), $successor, 'qualification-link-materialize-successor');
        $this->assertSame($linkId, $successorId);
        $this->assertDatabaseCount('programme_qualification_links', 1);
        $this->assertDatabaseHas('programme_qualification_links', [
            'id' => $linkId,
            'claim_version_id' => $successor,
            'qualification_entity_id' => $qualificationTwo,
            'awarding_body_entity_id' => $awarder,
        ]);
    }

    public function test_admission_offer_successor_preserves_offer_identity_and_existing_fact_relationship(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $programmeVersion = $this->acceptedVersion($programme, 'programme', [
            'institution_entity_id' => $institution,
            'title' => 'Synthetic Offer Programme',
        ], 'offer-programme');
        $materializer = app(CampusProgrammeCatalogueService::class);
        $materializer->materializeAcceptedRecord($this->actor('offer-programme-materializer'), $programmeVersion, 'offer-programme-materialize');

        $campus = $this->entity('campus');
        $campusVersion = $this->acceptedVersion($campus, 'campus', [
            'institution_entity_id' => $institution,
            'label' => 'Synthetic Offer Campus',
            'location_label' => 'Synthetic District',
        ], 'offer-campus');
        $materializer->materializeAcceptedRecord($this->actor('offer-campus-materializer'), $campusVersion, 'offer-campus-materialize');

        $initial = $this->acceptedVersion($programme, 'programme_offer', [
            'programme_entity_id' => $programme,
            'delivery_location_entity_id' => $campus,
            'admission_cycle' => 'Synthetic 2027 Intake',
        ], 'offer-initial');
        $offerId = $materializer->materializeAcceptedRecord($this->actor('offer-materializer'), $initial, 'offer-materialize-initial');

        $factId = (string) str()->uuid();
        DB::table('programme_offer_facts')->insert([
            'id' => $factId,
            'programme_offer_id' => $offerId,
            'fact_key' => 'application_fee',
            'category' => 'fee',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $successor = $this->correctAndAccept($initial, [
            'programme_entity_id' => $programme,
            'delivery_location_entity_id' => $campus,
            'admission_cycle' => 'Synthetic 2028 Intake',
        ], 'offer-successor');

        $this->assertDatabaseHas('programme_offers', [
            'id' => $offerId,
            'claim_version_id' => $initial,
            'admission_cycle' => 'Synthetic 2027 Intake',
        ]);
        $this->publishAcceptedVersion($successor, 'offer-successor');

        $successorId = $materializer->materializeAcceptedRecord($this->actor('offer-materializer'), $successor, 'offer-materialize-successor');
        $this->assertSame($offerId, $successorId);
        $this->assertDatabaseCount('programme_offers', 1);
        $this->assertDatabaseHas('programme_offers', [
            'id' => $offerId,
            'claim_version_id' => $successor,
            'admission_cycle' => 'Synthetic 2028 Intake',
        ]);
        $this->assertDatabaseHas('programme_offer_facts', [
            'id' => $factId,
            'programme_offer_id' => $offerId,
            'fact_key' => 'application_fee',
        ]);
    }

    public function test_successor_cannot_create_a_missing_predecessor_projection(): void
    {
        $institution = $this->entity('institution');
        $programme = $this->entity('programme');
        $initial = $this->acceptedVersion($programme, 'programme', [
            'institution_entity_id' => $institution,
            'title' => 'Synthetic Never Materialized',
        ], 'missing-predecessor-initial');
        $successor = $this->correctAndAccept($initial, [
            'institution_entity_id' => $institution,
            'title' => 'Synthetic Successor Without Projection',
        ], 'missing-predecessor-successor');

        $materializer = app(CampusProgrammeCatalogueService::class);
        try {
            $materializer->materializeAcceptedRecord(
                $this->actor('missing-predecessor-materializer'),
                $successor,
                'missing-predecessor-materialize'
            );
            $this->fail('An unpublished successor must not be materialized.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('programme_catalogue_entries', 0);
        }

        $this->publishAcceptedVersion($successor, 'missing-predecessor-successor');
        try {
            $materializer->materializeAcceptedRecord(
                $this->actor('missing-predecessor-materializer'),
                $successor,
                'missing-predecessor-materialize'
            );
            $this->fail('A published successor must not create a missing predecessor projection.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('programme_catalogue_entries', 0);
        }
    }

    private function acceptedVersion(string $subjectId, string $predicate, array $value, string $prefix): string
    {
        $claimId = (string) str()->uuid();
        $versionId = (string) str()->uuid();
        $now = now();
        DB::table('claims')->insert([
            'id' => $claimId,
            'subject_entity_id' => $subjectId,
            'predicate' => $predicate,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claim_versions')->insert([
            'id' => $versionId,
            'claim_id' => $claimId,
            'version_number' => 1,
            'value' => json_encode($value, JSON_THROW_ON_ERROR),
            'valid_from' => now()->toDateString(),
            'valid_to' => null,
            'recorded_at' => $now,
            'disposition' => 'proposed',
            'supersedes_version_id' => null,
            'correction_reason' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $evidence = $this->evidence($prefix.'-evidence-author');
        DB::table('claim_evidence_links')->insert([
            'id' => (string) str()->uuid(),
            'claim_version_id' => $versionId,
            'evidence_reference_id' => $evidence,
            'relationship_type' => 'supports',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $workflow = app(PersistedGovernanceWorkflowService::class);
        $caseId = $workflow->openAdjudicationCase($this->actor($prefix.'-opener', ['open_adjudication']), $versionId, $prefix.'-case');
        $workflow->decideAdjudication(
            $this->actor($prefix.'-adjudicator', ['adjudicate_claim']),
            $caseId,
            'accepted',
            'synthetic_acceptance',
            'Accepted synthetic catalogue fixture.',
            'synthetic-policy-v1'
        );

        return $versionId;
    }

    private function publishAcceptedVersion(string $claimVersionId, string $prefix): void
    {
        $decisionId = DB::table('adjudication_decisions as decisions')
            ->join('adjudication_cases as cases', 'cases.id', '=', 'decisions.adjudication_case_id')
            ->where('cases.claim_version_id', $claimVersionId)
            ->where('decisions.outcome', 'accepted')
            ->value('decisions.id');
        if (! is_string($decisionId) || $decisionId === '') {
            throw new \RuntimeException('An accepted synthetic adjudication decision is required before publication.');
        }

        $workflow = app(PersistedGovernanceWorkflowService::class);
        $workflow->authorizePublication(
            $this->actor($prefix.'-publisher', ['authorize_publication']),
            $claimVersionId,
            $decisionId,
            'directory',
            'anonymous',
            'synthetic-policy-v1',
            $prefix.'-publication'
        );
        $workflow->processOutbox();
    }

    private function correctAndAccept(string $priorVersionId, array $value, string $prefix): string
    {
        $evidence = $this->evidence($prefix.'-evidence-author');
        $workflow = app(PersistedGovernanceWorkflowService::class);
        $successor = $workflow->correctClaimVersion(
            $this->actor($prefix.'-corrector', ['correct_claim']),
            $priorVersionId,
            $value,
            [$evidence],
            now()->toDateString(),
            null,
            'synthetic_value_correction',
            'Synthetic catalogue successor fixture.',
            $prefix.'-correction-key'
        );
        $caseId = $workflow->openAdjudicationCase($this->actor($prefix.'-opener', ['open_adjudication']), $successor, $prefix.'-case');
        $workflow->decideAdjudication(
            $this->actor($prefix.'-adjudicator', ['adjudicate_claim']),
            $caseId,
            'accepted',
            'synthetic_acceptance',
            'Accepted synthetic successor fixture.',
            'synthetic-policy-v1'
        );

        return $successor;
    }

    private function evidence(string $actorId): string
    {
        $authorizationId = (string) str()->uuid();
        $evidenceId = (string) str()->uuid();
        $now = now();
        DB::table('source_authorizations')->insert([
            'id' => $authorizationId,
            'source_family_id' => 'synthetic-adm-f-only',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['directory_publication', 'synthetic_test_only'], JSON_THROW_ON_ERROR),
            'permitted_methods' => json_encode(['approved_projection', 'fixture_reference'], JSON_THROW_ON_ERROR),
            'territories' => json_encode(['synthetic'], JSON_THROW_ON_ERROR),
            'permitted_scopes' => json_encode(['processing' => true, 'publication' => true], JSON_THROW_ON_ERROR),
            'valid_from' => now()->subDay(),
            'valid_to' => now()->addDay(),
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
            'integrity_digest' => 'sha256:synthetic-adm-f-evidence',
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
            'metadata' => json_encode(['actor_id' => $actorId], JSON_THROW_ON_ERROR),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $evidenceId;
    }

    private function entity(string $type): string
    {
        $id = (string) str()->uuid();
        DB::table('directory_entities')->insert([
            'id' => $id,
            'entity_type' => $type,
            'label' => 'Synthetic '.$type.' '.str()->random(6),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $id;
    }

    private function actor(string $id, array $capabilities = ['materialize_catalogue_record']): array
    {
        return [
            'actor_id' => $id,
            'actor_class' => 'human',
            'capabilities' => $capabilities,
        ];
    }
}
