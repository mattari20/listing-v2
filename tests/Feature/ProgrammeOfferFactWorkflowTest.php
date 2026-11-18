<?php

declare(strict_types=1);

namespace Tests\\Feature;

use App\\Services\\Directory\\PublicProgrammeOfferFactsQueryService;
use App\\Services\\Governance\\ProgrammeOfferFactWorkflowService;
use Illuminate\\Foundation\\Testing\\RefreshDatabase;
use Illuminate\\Support\\Facades\\DB;
use Illuminate\\Validation\\ValidationException;
use Tests\\TestCase;

class ProgrammeOfferFactWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_fee_fact_is_public_only_for_its_exact_offer_and_preserves_zero(): void
    {
        [$programme, $offerA] = $this->offer('synthetic-cycle-2027');
        [, $offerB] = $this->offer('synthetic-cycle-2028', $programme);
        $evidence = $this->evidence('synthetic-evidence-author');

        $service = app(ProgrammeOfferFactWorkflowService::class);
        $version = $service->submit(
            $this->actor('synthetic-submitter', ['submit_offer_fact']),
            $offerA,
            'application_fee',
            'fee',
            'known',
            ['component' => 'Application fee', 'amount' => '0.00', 'currency' => 'PKR'],
            [$evidence],
            now()->subHour()->toDateTimeString(),
            '2026-01-01',
            '2027-12-31',
            'synthetic.fee.v1',
            30,
            'synthetic-fee-submit'
        );
        $case = $service->openAdjudicationCase(
            $this->actor('synthetic-case-opener', ['open_adjudication']),
            $version,
            'synthetic-fee-case'
        );
        $decision = $service->decideAdjudication(
            $this->actor('synthetic-adjudicator', ['adjudicate_claim']),
            $case,
            'accepted',
            'synthetic_acceptance',
            'Synthetic fee fact accepted.',
            'synthetic-policy-v1'
        );
        $service->authorizePublication(
            $this->actor('synthetic-publisher', ['authorize_publication']),
            $version,
            $decision,
            'directory',
            'anonymous',
            'synthetic-publication-v1',
            'synthetic-fee-publication'
        );

        $offers = app(PublicProgrammeOfferFactsQueryService::class)->forProgramme($programme);

        $this->assertCount(1, $offers);
        $this->assertSame($offerA, $offers[0]['id']);
        $this->assertSame('synthetic-cycle-2027', $offers[0]['admission_cycle']);
        $this->assertSame('0.00', $offers[0]['facts'][0]['value']['amount']);
        $this->assertSame('PKR', $offers[0]['facts'][0]['value']['currency']);
        $this->assertNotSame($offerB, $offers[0]['id']);
    }

    public function test_submitter_cannot_open_or_adjudicate_own_offer_fact(): void
    {
        [, $offer] = $this->offer('synthetic-cycle-2027');
        $evidence = $this->evidence('synthetic-evidence-author');
        $service = app(ProgrammeOfferFactWorkflowService::class);
        $version = $service->submit(
            $this->actor('synthetic-submitter', ['submit_offer_fact']),
            $offer,
            'eligibility_rule',
            'eligibility',
            'known',
            ['text' => 'Synthetic completion criterion'],
            [$evidence],
            now()->subHour()->toDateTimeString(),
            null,
            null,
            'synthetic.eligibility.v1',
            30,
            'synthetic-eligibility-submit'
        );

        try {
            $service->openAdjudicationCase(
                $this->actor('synthetic-submitter', ['open_adjudication']),
                $version,
                'synthetic-self-open'
            );
            $this->fail('The fact submitter must not open the adjudication case.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('programme_offer_fact_adjudication_cases', 0);
        }
    }

    public function test_stale_known_fact_cannot_be_published_as_current(): void
    {
        [, $offer] = $this->offer('synthetic-cycle-2027');
        $evidence = $this->evidence('synthetic-evidence-author');
        $service = app(ProgrammeOfferFactWorkflowService::class);
        $version = $service->submit(
            $this->actor('synthetic-submitter', ['submit_offer_fact']),
            $offer,
            'application_deadline',
            'deadline',
            'known',
            ['date' => '2027-01-31'],
            [$evidence],
            now()->subDays(5)->toDateTimeString(),
            null,
            null,
            'synthetic.deadline.v1',
            1,
            'synthetic-stale-submit'
        );
        $case = $service->openAdjudicationCase(
            $this->actor('synthetic-case-opener', ['open_adjudication']),
            $version,
            'synthetic-stale-case'
        );
        $decision = $service->decideAdjudication(
            $this->actor('synthetic-adjudicator', ['adjudicate_claim']),
            $case,
            'accepted',
            'synthetic_acceptance',
            'Synthetic deadline fact accepted.',
            'synthetic-policy-v1'
        );

        $this->expectException(ValidationException::class);
        $service->authorizePublication(
            $this->actor('synthetic-publisher', ['authorize_publication']),
            $version,
            $decision,
            'directory',
            'anonymous',
            'synthetic-publication-v1',
            'synthetic-stale-publication'
        );
    }

    public function test_source_authorization_revocation_removes_offer_fact_from_public_query(): void
    {
        [$programme, $offer] = $this->offer('synthetic-cycle-2027');
        $evidence = $this->evidence('synthetic-evidence-author');
        $service = app(ProgrammeOfferFactWorkflowService::class);
        $version = $service->submit(
            $this->actor('synthetic-submitter', ['submit_offer_fact']),
            $offer,
            'eligibility_rule',
            'eligibility',
            'known',
            ['text' => 'Synthetic eligibility statement'],
            [$evidence],
            now()->subHour()->toDateTimeString(),
            null,
            null,
            'synthetic.eligibility.v1',
            30,
            'synthetic-revocation-submit'
        );
        $case = $service->openAdjudicationCase($this->actor('synthetic-case-opener', ['open_adjudication']), $version, 'synthetic-revocation-case');
        $decision = $service->decideAdjudication($this->actor('synthetic-adjudicator', ['adjudicate_claim']), $case, 'accepted', 'synthetic_acceptance', 'Synthetic fact accepted.', 'synthetic-policy-v1');
        $service->authorizePublication($this->actor('synthetic-publisher', ['authorize_publication']), $version, $decision, 'directory', 'anonymous', 'synthetic-publication-v1', 'synthetic-revocation-publication');

        $this->assertCount(1, app(PublicProgrammeOfferFactsQueryService::class)->forProgramme($programme));
        DB::table('source_authorizations')->where('id', DB::table('evidence_references')->where('id', $evidence)->value('source_authorization_id'))
            ->update(['status' => 'revoked', 'revoked_at' => now(), 'updated_at' => now()]);
        $this->assertSame([], app(PublicProgrammeOfferFactsQueryService::class)->forProgramme($programme));
    }

    private function offer(string $cycle, ?string $existingProgramme = null): array
    {
        $now = now();
        $institution = $this->entity('institution');
        $programme = $existingProgramme ?? $this->entity('programme');
        $campus = $this->entity('campus');

        if ($existingProgramme === null) {
            $programmeVersion = $this->claimVersion($programme, 'programme');
            DB::table('programme_catalogue_entries')->insert([
                'entity_id' => $programme, 'institution_entity_id' => $institution,
                'title' => 'Synthetic Programme', 'description' => null, 'level' => 'synthetic',
                'status' => 'active', 'claim_version_id' => $programmeVersion,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        } else {
            $institution = DB::table('programme_catalogue_entries')->where('entity_id', $programme)->value('institution_entity_id');
        }

        $campusVersion = $this->claimVersion($campus, 'campus');
        DB::table('directory_campuses')->insert([
            'entity_id' => $campus, 'institution_entity_id' => $institution,
            'location_label' => 'Synthetic Location', 'status' => 'active',
            'valid_from' => null, 'valid_to' => null, 'claim_version_id' => $campusVersion,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        $offerVersion = $this->claimVersion($programme, 'programme_offer');
        $offer = (string) str()->uuid();
        DB::table('programme_offers')->insert([
            'id' => $offer, 'programme_entity_id' => $programme,
            'delivery_location_entity_id' => $campus, 'admission_cycle' => $cycle,
            'status' => 'active', 'valid_from' => null, 'valid_to' => null,
            'claim_version_id' => $offerVersion, 'created_at' => $now, 'updated_at' => $now,
        ]);

        return [$programme, $offer];
    }

    private function entity(string $type): string
    {
        $id = (string) str()->uuid();
        DB::table('directory_entities')->insert([
            'id' => $id, 'entity_type' => $type, 'label' => 'Synthetic '.$type,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return $id;
    }

    private function claimVersion(string $subject, string $predicate): string
    {
        $claim = (string) str()->uuid();
        $version = (string) str()->uuid();
        DB::table('claims')->insert([
            'id' => $claim, 'subject_entity_id' => $subject, 'predicate' => $predicate,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('claim_versions')->insert([
            'id' => $version, 'claim_id' => $claim, 'version_number' => 1,
            'value' => json_encode(['synthetic' => true]), 'valid_from' => null, 'valid_to' => null,
            'recorded_at' => now(), 'disposition' => 'accepted',
            'supersedes_version_id' => null, 'correction_reason' => null,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return $version;
    }

    private function evidence(string $actorId): string
    {
        $authorization = (string) str()->uuid();
        $evidence = (string) str()->uuid();
        $now = now();
        DB::table('source_authorizations')->insert([
            'id' => $authorization, 'source_family_id' => 'synthetic-rcv-b02',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['directory_publication']),
            'permitted_methods' => json_encode(['approved_projection']),
            'territories' => json_encode(['synthetic']),
            'permitted_scopes' => json_encode(['publication' => true]),
            'valid_from' => now()->subDay(), 'valid_to' => now()->addDay(),
            'revoked_at' => null, 'revocation_reason' => null,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('evidence_references')->insert([
            'id' => $evidence, 'source_authorization_id' => $authorization,
            'reference_kind' => 'synthetic_fixture', 'source_type' => 'synthetic',
            'integrity_digest' => 'synthetic-rcv-b02-digest', 'status' => 'eligible_for_review',
            'content_included' => false, 'observed_at' => $now,
            'recorded_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) str()->uuid(), 'actor_class' => 'human',
            'action' => 'evidence_reference_registered', 'target_type' => 'evidence_reference',
            'target_id' => $evidence, 'reason_code' => 'synthetic_fixture',
            'occurred_at' => $now, 'metadata' => json_encode(['actor_id' => $actorId]),
            'created_at' => $now, 'updated_at' => $now,
        ]);

        return $evidence;
    }

    private function actor(string $id, array $capabilities): array
    {
        return ['actor_id' => $id, 'actor_class' => 'human', 'capabilities' => $capabilities];
    }
}
