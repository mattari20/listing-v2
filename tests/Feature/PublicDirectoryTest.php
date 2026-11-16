<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\PublicDirectoryQueryService;
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

    public function test_manual_locality_filter_uses_only_approved_public_geography_facts(): void
    {
        $lahore = $this->createEntity();
        $karachi = $this->createEntity();
        $this->publishFact($lahore, 'display_name', 'Synthetic Lahore Academy');
        $this->publishFact($lahore, 'province', 'Punjab');
        $this->publishFact($lahore, 'district', 'Lahore');
        $this->publishFact($lahore, 'city', 'Lahore');
        $this->publishFact($lahore, 'locality', 'Gulberg');
        $this->publishFact($lahore, 'internal_notes', 'Private Lahore address note');
        $this->publishFact($karachi, 'display_name', 'Synthetic Karachi Academy');
        $this->publishFact($karachi, 'province', 'Sindh');
        $this->publishFact($karachi, 'district', 'Karachi East');
        $this->publishFact($karachi, 'city', 'Karachi');
        $this->publishFact($karachi, 'locality', 'Gulshan');

        $this->get('/directory?locality=lahore')
            ->assertOk()
            ->assertSee('Synthetic Lahore Academy')
            ->assertDontSee('Synthetic Karachi Academy')
            ->assertDontSee('Private Lahore address note');

        $this->get('/directory?locality=Gulberg')
            ->assertOk()
            ->assertSee('Synthetic Lahore Academy')
            ->assertDontSee('Synthetic Karachi Academy');

        $this->get('/directory/'.$lahore)
            ->assertOk()
            ->assertSee('Province')
            ->assertSee('Punjab')
            ->assertSee('District')
            ->assertSee('Lahore')
            ->assertSee('Locality')
            ->assertSee('Gulberg');
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
        $this->publishFact($entity, 'city', 'Lahore');
        DB::table('directory_entities')->where('id', $entity)->update(['entity_type' => 'deeni_madaris']);

        config(['directory.deeni_madaris_public' => true]);

        $this->get('/directory?q=Restricted')
            ->assertOk()
            ->assertDontSee('Synthetic Restricted Academy')
            ->assertDontSee('Deeni Madaris');
        $this->get('/directory?locality=Lahore')->assertOk()->assertDontSee('Synthetic Restricted Academy');
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

    public function test_older_snapshot_is_hidden_while_a_newer_snapshot_is_not_yet_projected(): void
    {
        $entity = $this->createEntity();
        $published = $this->publishFact($entity, 'display_name', 'Synthetic Snapshot Academy');
        $workflow = new PersistedGovernanceWorkflowService;
        $workflow->authorizePublication(
            $this->actor('publisher-second-snapshot', ['authorize_publication']),
            $published['version_id'],
            $published['decision_id'],
            'directory',
            'anonymous',
            'policy-v2',
            'synthetic-new-snapshot-pending'
        );

        $this->get('/directory?q=Snapshot')->assertOk()->assertDontSee('Synthetic Snapshot Academy');
        $this->get('/directory/'.$entity)->assertNotFound();
    }

    public function test_expired_source_authorization_removes_a_previously_published_fact(): void
    {
        $entity = $this->createEntity();
        $published = $this->publishFact($entity, 'display_name', 'Synthetic Expired Academy');
        DB::table('source_authorizations')->where('id', $published['authorization_id'])->update([
            'valid_to' => now()->subDay(),
        ]);

        $this->get('/directory?q=Expired')->assertOk()->assertDontSee('Synthetic Expired Academy');
        $this->get('/directory/'.$entity)->assertNotFound();
    }

    public function test_registry_managed_public_fact_uses_exact_definition_and_safe_presentation_metadata(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', 'Synthetic Registry Profile Academy');
        $definitionVersionId = $this->registryDefinition('institution_motto');
        $this->publishFact(
            $entity,
            'institution_motto',
            'A safe registry-managed public motto.',
            '2026-11-13 10:00:00',
            $definitionVersionId
        );
        $booleanDefinitionId = $this->registryDefinition(
            'institution_has_library',
            [],
            'public_eligible',
            'public_eligible',
            'boolean'
        );
        $this->publishFact($entity, 'institution_has_library', true, '2026-11-13 10:00:00', $booleanDefinitionId);

        $this->get('/directory/'.$entity)
            ->assertOk()
            ->assertSee('Institution motto')
            ->assertSee('A safe registry-managed public motto.')
            ->assertSee('Has library')
            ->assertSee('Yes');

        $this->get('/directory?q=registry-managed')
            ->assertOk()
            ->assertDontSee('Synthetic Registry Profile Academy');
    }

    public function test_internal_restricted_mismatched_and_unbound_registry_facts_fail_closed(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', 'Synthetic Registry Boundary Academy');

        $internal = $this->registryDefinition('institution_internal_summary', [], 'internal_only');
        $restricted = $this->registryDefinition('institution_restricted_summary', [], 'restricted', 'editorial_restricted');
        $mismatched = $this->registryDefinition('different_registry_key');
        $this->publishFact($entity, 'institution_internal_summary', 'Internal registry text', '2026-11-13 10:00:00', $internal);
        $this->publishFact($entity, 'institution_restricted_summary', 'Restricted registry text', '2026-11-13 10:00:00', $restricted);
        $this->publishFact($entity, 'institution_mismatched_key', 'Mismatched registry text', '2026-11-13 10:00:00', $mismatched);
        $this->publishFact($entity, 'institution_unbound_summary', 'Unbound registry text');

        $this->get('/directory/'.$entity)
            ->assertOk()
            ->assertDontSee('Internal registry text')
            ->assertDontSee('Restricted registry text')
            ->assertDontSee('Mismatched registry text')
            ->assertDontSee('Unbound registry text');
        $this->get('/directory?q=Internal registry text')
            ->assertOk()
            ->assertDontSee('Synthetic Registry Boundary Academy');
    }

    public function test_registry_search_filter_and_sort_flags_are_independent(): void
    {
        $alpha = $this->createEntity();
        $beta = $this->createEntity();
        $this->publishFact($alpha, 'display_name', 'Synthetic Alpha Academy');
        $this->publishFact($beta, 'display_name', 'Synthetic Beta Academy');

        $codeDefinition = $this->registryDefinition('institution_code', [
            'searchable' => false,
            'filterable' => true,
            'sortable' => false,
        ]);
        $searchDefinition = $this->registryDefinition('institution_search_token', [
            'searchable' => true,
            'filterable' => false,
            'sortable' => false,
        ]);
        $sortDefinition = $this->registryDefinition('institution_sort_key', [
            'searchable' => false,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->publishFact($alpha, 'institution_code', 'code-z', '2026-11-13 10:00:00', $codeDefinition);
        $this->publishFact($beta, 'institution_code', 'code-a', '2026-11-13 10:00:00', $codeDefinition);
        $this->publishFact($alpha, 'institution_search_token', 'search-visible-term', '2026-11-13 10:00:00', $searchDefinition);
        $this->publishFact($beta, 'institution_search_token', 'another-search-term', '2026-11-13 10:00:00', $searchDefinition);
        $this->publishFact($alpha, 'institution_sort_key', '2', '2026-11-13 10:00:00', $sortDefinition);
        $this->publishFact($beta, 'institution_sort_key', '1', '2026-11-13 10:00:00', $sortDefinition);

        $service = app(PublicDirectoryQueryService::class);
        $hiddenSearch = $service->search('code-z');
        $visibleSearch = $service->search('search-visible-term');
        $filterable = $service->search(filters: ['institution_code' => 'code-a']);
        $notFilterable = $service->search(filters: ['institution_search_token' => 'search-visible-term']);
        $defaultSort = $service->search(sortField: 'institution_code');
        $registrySort = $service->search(sortField: 'institution_sort_key');

        $this->assertSame([], $hiddenSearch['results']);
        $this->assertCount(1, $visibleSearch['results']);
        $this->assertSame('Synthetic Alpha Academy', $visibleSearch['results'][0]['name']);
        $this->assertCount(1, $filterable['results']);
        $this->assertSame('Synthetic Beta Academy', $filterable['results'][0]['name']);
        $this->assertSame([], $notFilterable['results']);
        $this->assertSame(
            ['Synthetic Alpha Academy', 'Synthetic Beta Academy'],
            array_column($defaultSort['results'], 'name')
        );
        $this->assertSame(
            ['Synthetic Beta Academy', 'Synthetic Alpha Academy'],
            array_column($registrySort['results'], 'name')
        );
    }

    public function test_retired_exact_definition_version_remains_interpretable_without_using_a_newer_private_version(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', 'Synthetic Historical Definition Academy');
        $versionOneId = $this->registryDefinition('institution_historical_fact');
        $definitionId = DB::table('field_definition_versions')
            ->where('id', $versionOneId)
            ->value('field_definition_id');
        $now = now();

        DB::table('field_definition_versions')->insert([
            'id' => (string) Str::uuid(),
            'field_definition_id' => $definitionId,
            'version_number' => 2,
            'lifecycle_state' => 'active',
            'semantic_version' => '2.0.0',
            'compatibility_class' => 'breaking',
            'value_type' => 'short_text',
            'cardinality' => 'one',
            'scope_key' => 'institution',
            'privacy_class' => 'public_eligible',
            'visibility_class' => 'internal_only',
            'searchable' => false,
            'filterable' => false,
            'sortable' => false,
            'validation_schema' => json_encode(['schema_version' => 1, 'max_length' => 120], JSON_THROW_ON_ERROR),
            'presentation_metadata' => json_encode([
                'section_key' => 'internal',
                'public_label' => 'New private definition label',
            ], JSON_THROW_ON_ERROR),
            'evidence_policy' => json_encode(['required' => true], JSON_THROW_ON_ERROR),
            'freshness_policy' => json_encode(['class' => 'synthetic_test'], JSON_THROW_ON_ERROR),
            'effective_from' => null,
            'effective_to' => null,
            'successor_field_definition_id' => null,
            'proposed_by_actor_id' => 'synthetic-registry-steward',
            'rationale_reference' => 'SYN-I5-HISTORICAL-VERSION',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $this->publishFact(
            $entity,
            'institution_historical_fact',
            'Value remains bound to version one.',
            '2026-11-13 10:00:00',
            $versionOneId
        );
        DB::table('field_definition_versions')->where('id', $versionOneId)->update([
            'lifecycle_state' => 'retired',
        ]);

        $this->get('/directory/'.$entity)
            ->assertOk()
            ->assertSee('Institution Historical Fact')
            ->assertSee('Value remains bound to version one.')
            ->assertDontSee('New private definition label');
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
    private function publishFact(string $entityId, string $predicate, mixed $value, ?string $observedAt = '2026-11-13 10:00:00', ?string $fieldDefinitionVersionId = null): array
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
            'field_definition_version_id' => $fieldDefinitionVersionId,
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
            'decision_id' => $decisionId,
            'evidence_id' => $evidenceId,
            'authorization_id' => $authorizationId,
            'snapshot_id' => $snapshotId,
        ];
    }

    private function registryDefinition(
        string $fieldKey,
        array $flags = [],
        string $visibilityClass = 'public_eligible',
        string $privacyClass = 'public_eligible',
        string $valueType = 'short_text'
    ): string {
        $definitionId = (string) Str::uuid();
        $versionId = (string) Str::uuid();
        $presentationLabel = match ($fieldKey) {
            'institution_motto' => 'Institution motto',
            'institution_has_library' => 'Has library',
            default => ucwords(str_replace('_', ' ', $fieldKey)),
        };
        $schema = ['schema_version' => 1, 'max_length' => 120];
        if ($valueType === 'enum') {
            $schema['allowed_values'] = ['one', 'two'];
        }

        DB::table('field_definitions')->insert([
            'id' => $definitionId,
            'field_key' => $fieldKey,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('field_definition_versions')->insert([
            'id' => $versionId,
            'field_definition_id' => $definitionId,
            'version_number' => 1,
            'lifecycle_state' => 'active',
            'semantic_version' => '1.0.0',
            'compatibility_class' => 'initial',
            'value_type' => $valueType,
            'cardinality' => 'one',
            'scope_key' => 'institution',
            'privacy_class' => $privacyClass,
            'visibility_class' => $visibilityClass,
            'searchable' => $flags['searchable'] ?? false,
            'filterable' => $flags['filterable'] ?? false,
            'sortable' => $flags['sortable'] ?? false,
            'validation_schema' => json_encode($schema, JSON_THROW_ON_ERROR),
            'presentation_metadata' => json_encode([
                'section_key' => 'additional_information',
                'public_label' => $presentationLabel,
                'label_key' => 'synthetic.'.$fieldKey,
            ], JSON_THROW_ON_ERROR),
            'evidence_policy' => json_encode(['required' => true], JSON_THROW_ON_ERROR),
            'freshness_policy' => json_encode(['class' => 'synthetic_test'], JSON_THROW_ON_ERROR),
            'effective_from' => null,
            'effective_to' => null,
            'successor_field_definition_id' => null,
            'proposed_by_actor_id' => 'synthetic-registry-steward',
            'rationale_reference' => 'SYN-I5-PUBLIC-PROFILE',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $versionId;
    }

    private function actor(string $id, array $capabilities): array
    {
        return ['actor_id' => $id, 'actor_class' => 'human', 'capabilities' => $capabilities];
    }

    public function test_public_html_is_escaped_and_hostile_registry_metadata_or_values_are_excluded(): void
    {
        $entity = $this->createEntity();
        $this->publishFact($entity, 'display_name', '<script>alert("synthetic")</script>');

        $hostileLabelVersion = $this->registryDefinition('institution_hostile_label');
        DB::table('field_definition_versions')->where('id', $hostileLabelVersion)->update([
            'presentation_metadata' => json_encode([
                'section_key' => 'additional_information',
                'public_label' => '<img src=x onerror=alert(1)>Unsafe public label',
            ], JSON_THROW_ON_ERROR),
        ]);
        $this->publishFact($entity, 'institution_hostile_label', 'Hostile registry value', '2026-11-13 10:00:00', $hostileLabelVersion);

        $hostileTextVersion = $this->registryDefinition(
            'institution_hostile_long_text',
            [],
            'public_eligible',
            'public_eligible',
            'long_text'
        );
        $this->publishFact(
            $entity,
            'institution_hostile_long_text',
            '<script>alert("payload")</script>',
            '2026-11-13 10:00:00',
            $hostileTextVersion
        );

        $controlTextVersion = $this->registryDefinition(
            'institution_control_text',
            [],
            'public_eligible',
            'public_eligible',
            'long_text'
        );
        $controlText = "synthetic\\0control";
        $this->publishFact($entity, 'institution_control_text', $controlText, '2026-11-13 10:00:00', $controlTextVersion);

        $oversizedTextVersion = $this->registryDefinition(
            'institution_oversized_text',
            [],
            'public_eligible',
            'public_eligible',
            'long_text'
        );
        $oversizedText = str_repeat('oversized-synthetic-', 110);
        $this->publishFact($entity, 'institution_oversized_text', $oversizedText, '2026-11-13 10:00:00', $oversizedTextVersion);

        $html = $this->get('/directory/'.$entity)->assertOk()->getContent();

        $this->assertStringContainsString('&lt;script&gt;alert', $html);
        $this->assertStringNotContainsString('<script>alert("synthetic")</script>', $html);
        $this->assertStringNotContainsString('Unsafe public label', $html);
        $this->assertStringNotContainsString('Hostile registry value', $html);
        $this->assertStringNotContainsString('<script>alert("payload")</script>', $html);
        $this->assertStringNotContainsString($controlText, $html);
        $this->assertStringNotContainsString($oversizedText, $html);
    }

    public function test_public_directory_query_count_is_constant_as_synthetic_result_count_grows(): void
    {
        $first = $this->createEntity();
        $this->publishFact($first, 'display_name', 'Synthetic Query Baseline Academy');

        $recording = false;
        $queryCount = 0;
        DB::listen(static function ($query) use (&$recording, &$queryCount): void {
            if ($recording) {
                $queryCount++;
            }
        });

        $measure = function () use (&$recording, &$queryCount): int {
            $queryCount = 0;
            $recording = true;
            app(PublicDirectoryQueryService::class)->search();
            $recording = false;

            return $queryCount;
        };

        $baselineCount = $measure();
        $this->assertGreaterThan(0, $baselineCount);

        for ($index = 1; $index <= 4; $index++) {
            $entity = $this->createEntity();
            $this->publishFact($entity, 'display_name', 'Synthetic Query Academy '.$index);
        }

        $expandedCount = $measure();

        $this->assertSame(
            $baselineCount,
            $expandedCount,
            'The directory query count should remain bounded as the synthetic result set grows.'
        );
    }

}
