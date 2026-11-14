<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

final class PublicDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_anonymous_search_and_profile_show_only_allowlisted_approved_facts(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', 'Synthetic Public Academy');
        $this->publishFact($entity, 'overview', 'A fabricated example for public directory tests.');
        $this->publishFact($entity, 'internal_notes', 'This private note must never be shown.');

        $this->get('/directory?q=Public&type=institution')
            ->assertOk()
            ->assertSee('Synthetic Public Academy')
            ->assertDontSee('This private note')
            ->assertDontSee('Synthetic Internal Label');

        $this->get('/directory/'.$entity)
            ->assertOk()
            ->assertSee('Synthetic Public Academy')
            ->assertSee('A fabricated example for public directory tests.')
            ->assertDontSee('This private note')
            ->assertDontSee('Synthetic Internal Label');
    }

    public function test_category_filter_and_facets_are_derived_from_eligible_public_entities(): void
    {
        $institution = $this->createEntity('institution');
        $programme = $this->createEntity('programme');
        $this->publishFact($institution, 'display_name', 'Synthetic Public College');
        $this->publishFact($programme, 'display_name', 'Synthetic Public Diploma');

        $this->get('/directory?type=programme')
            ->assertOk()
            ->assertSee('Synthetic Public Diploma')
            ->assertDontSee('Synthetic Public College')
            ->assertSee('Institution (1)')
            ->assertSee('Programme (1)');
    }

    public function test_unpublished_entity_has_no_search_result_or_direct_profile(): void
    {
        $entity = $this->createEntity();
        $this->get('/directory')
            ->assertOk()
            ->assertDontSee('Synthetic Internal Label');

        $this->get('/directory/'.$entity)->assertNotFound();
    }

    public function test_suppressed_projection_is_removed_from_search_and_direct_profile(): void
    {
        $entity = $this->createEntity();
        $published = $this->publishFact($entity, 'display_name', 'Synthetic Suppressed Academy');
        $service = new PersistedGovernanceWorkflowService;
        $service->suppressPublication(
            $this->actor('suppressor', ['suppress_publication']),
            $published['snapshot_id'],
            'synthetic_public_test',
            'Synthetic suppression regression fixture.'
        );

        $this->get('/directory?q=Suppressed')->assertOk()->assertDontSee('Synthetic Suppressed Academy');
        $this->get('/directory/'.$entity)->assertNotFound();
    }

    public function test_source_authorization_revocation_removes_public_projection(): void
    {
        $entity = $this->createEntity();
        $published = $this->publishFact($entity, 'display_name', 'Synthetic Revoked Academy');
        $service = new PersistedGovernanceWorkflowService;
        $service->revokeSourceAuthorization(
            $this->actor('rights-officer', ['revoke_source_authorization']),
            $published['authorization_id'],
            'synthetic_rights_change',
            'Synthetic source authorization revocation.'
        );

        $this->get('/directory?q=Revoked')->assertOk()->assertDontSee('Synthetic Revoked Academy');
        $this->get('/directory/'.$entity)->assertNotFound();
    }

    public function test_superseded_claim_version_is_not_returned_even_before_successor_publication(): void
    {
        $entity = $this->createEntity();
        $published = $this->publishFact($entity, 'display_name', 'Synthetic Old Name');
        app(PersistedGovernanceWorkflowService::class)->correctClaimVersion(
            $this->actor('corrector', ['correct_claim']),
            $published['version_id'],
            ['value' => 'Synthetic New Name'],
            [$published['evidence_id']],
            '2026-11-14',
            null,
            'synthetic_correction',
            'A successor version makes the prior public claim ineligible.',
            'synthetic-public-correction'
        );

        $this->get('/directory?q=Synthetic')->assertOk()
            ->assertDontSee('Synthetic Old Name')
            ->assertDontSee('Synthetic New Name');
        $this->get('/directory/'.$entity)->assertNotFound();
    }

    public function test_deeni_madaris_never_appears_in_results_facets_or_direct_profile(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', 'Synthetic Restricted Academy');
        DB::table('directory_entities')->where('id', $entity)->update(['entity_type' => 'deeni_madaris']);

        config(['directory.deeni_madaris_public' => true]);

        $this->get('/directory?q=Restricted')
            ->assertOk()
            ->assertDontSee('Synthetic Restricted Academy')
            ->assertDontSee('Deeni Madaris');
        $this->get('/directory/'.$entity)->assertNotFound();
    }

    public function test_ambiguous_public_name_suppresses_profile_and_unknown_predicate_is_not_searchable(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', 'Synthetic Name One');
        $this->publishFact($entity, 'display_name', 'Synthetic Name Two');
        $this->publishFact($entity, 'internal_notes', 'Secret Internal Phrase');

        $this->get('/directory?q=Synthetic')->assertOk()
            ->assertDontSee('Synthetic Name One')
            ->assertDontSee('Synthetic Name Two');
        $this->get('/directory/'.$entity)->assertNotFound();
        $this->get('/directory?q=Secret')->assertOk()->assertDontSee('Secret Internal Phrase');
    }

    public function test_unicode_search_and_missing_observation_date_are_explicit(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', 'جامعہ مثال', null);

        $this->get('/directory?q=مثال')->assertOk()->assertSee('جامعہ مثال');
        $this->get('/directory/'.$entity)
            ->assertOk()
            ->assertSee('Observation date not supplied; freshness is not assessed.');
    }

    public function test_non_http_website_value_is_never_rendered_as_a_link(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', 'Synthetic Safe Link Academy');
        $this->publishFact($entity, 'official_website', 'javascript:alert(1)');

        $response = $this->get('/directory/'.$entity)->assertOk()->assertSee('javascript:alert(1)');
        $response->assertDontSee('href="javascript:alert(1)"', false);
    }

    private function createEntity(string $type = 'institution'): string
    {
        $id = (string) Str::uuid();
        $now = now();
        DB::table('directory_entities')->insert([
            'id' => $id,
            'entity_type' => $type,
            'label' => 'Synthetic Internal Label',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $id;
    }

    /** @return array{version_id: string, evidence_id: string, authorization_id: string, snapshot_id: string} */
    private function publishFact(string $entityId, string $predicate, string $value, ?string $observedAt = '2026-11-13 10:00:00'): array
    {
        $now = now();
        $authorizationId = (string) Str::uuid();
        $evidenceId = (string) Str::uuid();
        $claimId = (string) Str::uuid();
        $versionId = (string) Str::uuid();

        DB::table('source_authorizations')->insert([
            'id' => $authorizationId,
            'source_family_id' => 'synthetic-public-directory',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['directory_publication']),
            'permitted_methods' => json_encode(['approved_projection']),
            'territories' => json_encode(['synthetic']),
            'permitted_scopes' => json_encode(['publication' => true]),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('evidence_references')->insert([
            'id' => $evidenceId,
            'source_authorization_id' => $authorizationId,
            'reference_kind' => 'synthetic_fixture',
            'source_type' => 'synthetic',
            'status' => 'eligible_for_review',
            'content_included' => false,
            'observed_at' => $observedAt,
            'recorded_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('audit_events')->insert([
            'id' => (string) Str::uuid(),
            'actor_class' => 'human',
            'action' => 'evidence_reference_registered',
            'target_type' => 'evidence_reference',
            'target_id' => $evidenceId,
            'reason_code' => 'synthetic_fixture',
            'occurred_at' => $now,
            'metadata' => json_encode(['actor_id' => 'synthetic-evidence-author']),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claims')->insert([
            'id' => $claimId,
            'subject_entity_id' => $entityId,
            'predicate' => $predicate,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claim_versions')->insert([
            'id' => $versionId,
            'claim_id' => $claimId,
            'version_number' => 1,
            'value' => json_encode(['value' => $value]),
            'recorded_at' => $now,
            'disposition' => 'proposed',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('claim_evidence_links')->insert([
            'id' => (string) Str::uuid(),
            'claim_version_id' => $versionId,
            'evidence_reference_id' => $evidenceId,
            'relationship_type' => 'supports',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $workflow = new PersistedGovernanceWorkflowService;
        $suffix = (string) Str::uuid();
        $caseId = $workflow->openAdjudicationCase(
            $this->actor('case-opener-'.$suffix, ['open_adjudication']),
            $versionId,
            'public-directory-case-'.$suffix
        );
        $decisionId = $workflow->decideAdjudication(
            $this->actor('adjudicator-'.$suffix, ['adjudicate_claim']),
            $caseId,
            'accepted',
            'synthetic_acceptance',
            'Accepted synthetic public directory fixture.',
            'policy-v1'
        );
        $publicationId = $workflow->authorizePublication(
            $this->actor('publisher-'.$suffix, ['authorize_publication']),
            $versionId,
            $decisionId,
            'directory',
            'anonymous',
            'policy-v1',
            'public-directory-publication-'.$suffix
        );
        $workflow->processOutbox();
        $snapshotId = (string) DB::table('publication_snapshots')
            ->where('publication_decision_id', $publicationId)
            ->value('id');

        return [
            'version_id' => $versionId,
            'evidence_id' => $evidenceId,
            'authorization_id' => $authorizationId,
            'snapshot_id' => $snapshotId,
        ];
    }

    private function actor(string $id, array $capabilities): array
    {
        return ['actor_id' => $id, 'actor_class' => 'human', 'capabilities' => $capabilities];
    }
}
