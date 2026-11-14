<?php
declare(strict_types=1);
namespace Tests\Feature;
use App\Services\Directory\ProviderInstitutionRelationshipService;
use App\Services\Governance\GovernanceCommandService;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
class ProviderInstitutionRelationshipTest extends TestCase
{
    use RefreshDatabase;
    public function test_provider_institution_predicates_materialize_only_after_human_acceptance(): void
    {
        foreach (['operates', 'owns', 'administers'] as $predicate) {
            $f = $this->accepted($predicate);
            $id = app(ProviderInstitutionRelationshipService::class)->materializeAcceptedRelationship($this->actor('materializer-'.$predicate, ['materialize_relationship']), $f['version'], 'materialize-'.$predicate);
            $this->assertDatabaseHas('entity_relationships', ['id' => $id, 'from_entity_id' => $f['provider'], 'to_entity_id' => $f['institution'], 'relationship_type' => $predicate, 'claim_version_id' => $f['version'], 'status' => 'active']);
        }
    }
    public function test_reversed_or_incompatible_endpoint_types_are_rejected(): void
    {
        $provider = $this->entity('provider'); $institution = $this->entity('institution'); $campus = $this->entity('campus'); $evidence = $this->evidence();
        foreach ([[$institution, $provider], [$provider, $campus]] as [$from, $to]) {
            try {
                app(ProviderInstitutionRelationshipService::class)->propose($this->actor('author', ['register_claim']), $from, $to, 'operates', [$evidence], $this->context(), 'bad-endpoint-'.str()->uuid());
                $this->fail('Invalid endpoint types must be rejected.');
            } catch (ValidationException) { $this->assertDatabaseCount('claims', 0); }
        }
    }
    public function test_unknown_and_reserved_predicates_fail_closed(): void
    {
        $provider = $this->entity('provider'); $institution = $this->entity('institution'); $evidence = $this->evidence();
        foreach (['unknown_predicate', 'affiliated_with', 'regulated_by'] as $predicate) {
            try {
                app(ProviderInstitutionRelationshipService::class)->propose($this->actor('author', ['register_claim']), $provider, $institution, $predicate, [$evidence], $this->context(), 'bad-predicate-'.$predicate);
                $this->fail('Unknown and reserved predicates must fail closed.');
            } catch (ValidationException) { $this->assertDatabaseCount('claims', 0); }
        }
    }
    public function test_missing_endpoints_and_missing_evidence_are_rejected(): void
    {
        $provider = $this->entity('provider'); $institution = $this->entity('institution');
        try {
            app(ProviderInstitutionRelationshipService::class)->propose($this->actor('author', ['register_claim']), $provider, (string) str()->uuid(), 'operates', [$this->evidence()], $this->context(), 'missing-endpoint');
            $this->fail('Missing endpoint must fail.');
        } catch (ValidationException) { $this->assertDatabaseCount('claims', 0); }
        $this->expectException(ValidationException::class);
        app(ProviderInstitutionRelationshipService::class)->propose($this->actor('author', ['register_claim']), $provider, $institution, 'operates', [], $this->context(), 'missing-evidence');
    }
    public function test_institution_may_have_no_provider_relationship(): void
    {
        $this->entity('institution');
        $this->assertDatabaseCount('entity_relationships', 0);
    }
    public function test_non_overlapping_historical_provider_relationships_are_preserved(): void
    {
        $a = $this->accepted('operates', '2020-01-01', '2022-12-31');
        $b = $this->accepted('operates', '2023-01-01', null);
        $service = app(ProviderInstitutionRelationshipService::class);
        $one = $service->materializeAcceptedRelationship($this->actor('materializer-a', ['materialize_relationship']), $a['version'], 'history-a');
        $two = $service->materializeAcceptedRelationship($this->actor('materializer-b', ['materialize_relationship']), $b['version'], 'history-b');
        $this->assertDatabaseHas('entity_relationships', ['id' => $one, 'valid_to' => '2022-12-31']);
        $this->assertDatabaseHas('entity_relationships', ['id' => $two, 'valid_from' => '2023-01-01', 'valid_to' => null]);
    }
    public function test_distinct_scope_jurisdiction_assertions_are_preserved(): void
    {
        $a = $this->accepted('operates', null, null, 'operations', 'synthetic-north');
        $b = $this->accepted('operates', null, null, 'administration', 'synthetic-south');
        $service = app(ProviderInstitutionRelationshipService::class);
        $service->materializeAcceptedRelationship($this->actor('materializer-a', ['materialize_relationship']), $a['version'], 'scope-a');
        $service->materializeAcceptedRelationship($this->actor('materializer-b', ['materialize_relationship']), $b['version'], 'scope-b');
        $this->assertDatabaseCount('entity_relationships', 2);
    }
    public function test_invalid_date_interval_is_rejected_and_null_bounds_are_open(): void
    {
        $provider = $this->entity('provider'); $institution = $this->entity('institution'); $evidence = $this->evidence();
        $this->expectException(ValidationException::class);
        app(ProviderInstitutionRelationshipService::class)->propose($this->actor('author', ['register_claim']), $provider, $institution, 'operates', [$evidence], $this->context(), 'bad-interval', null, null, '2026-12-31', '2026-01-01');
    }
    public function test_open_ended_relationship_interval_is_retained(): void
    {
        $f = $this->accepted('owns', null, '2026-12-31');
        $id = app(ProviderInstitutionRelationshipService::class)->materializeAcceptedRelationship($this->actor('materializer', ['materialize_relationship']), $f['version'], 'open-bound');
        $this->assertDatabaseHas('entity_relationships', ['id' => $id, 'valid_from' => null, 'valid_to' => '2026-12-31']);
    }
    public function test_materialization_requires_current_admissible_evidence(): void
    {
        $f = $this->accepted();
        DB::table('evidence_references')->where('id', $f['evidence'])->update(['status' => 'quarantined']);
        $this->expectException(ValidationException::class);
        app(ProviderInstitutionRelationshipService::class)->materializeAcceptedRelationship($this->actor('materializer', ['materialize_relationship']), $f['version'], 'quarantined-evidence');
    }
    public function test_materialization_requires_human_capability_and_is_idempotent(): void
    {
        $f = $this->accepted(); $service = app(ProviderInstitutionRelationshipService::class);
        $actor = $this->actor('materializer', ['materialize_relationship']);
        $id = $service->materializeAcceptedRelationship($actor, $f['version'], 'same-key');
        $this->assertSame($id, $service->materializeAcceptedRelationship($actor, $f['version'], 'same-key'));
        $this->assertDatabaseCount('entity_relationships', 1);
        $this->expectException(ValidationException::class);
        $service->materializeAcceptedRelationship($this->actor('robot', ['materialize_relationship'], 'automated'), $f['version'], 'robot-key');
    }
    public function test_similar_labels_do_not_merge_distinct_provider_identities(): void
    {
        $one = $this->entity('provider', 'Synthetic Provider Same Name');
        $two = $this->entity('provider', 'Synthetic Provider Same Name');
        $this->assertNotSame($one, $two);
        $this->assertDatabaseCount('directory_entities', 2);
    }
    public function test_audit_failure_rolls_back_relationship_projection(): void
    {
        $f = $this->accepted();
        DB::unprepared("CREATE TRIGGER fail_relationship_audit BEFORE INSERT ON audit_events BEGIN SELECT RAISE(ABORT, 'synthetic relationship audit failure'); END");
        try {
            app(ProviderInstitutionRelationshipService::class)->materializeAcceptedRelationship($this->actor('materializer', ['materialize_relationship']), $f['version'], 'audit-rollback');
            $this->fail('Audit failure must abort the projection.');
        } catch (QueryException) { $this->assertDatabaseCount('entity_relationships', 0); }
        finally { DB::unprepared('DROP TRIGGER IF EXISTS fail_relationship_audit'); }
    }
    public function test_claim_withdrawal_and_source_revocation_update_relationship_projection_status(): void
    {
        $f = $this->accepted(); $service = app(ProviderInstitutionRelationshipService::class);
        $id = $service->materializeAcceptedRelationship($this->actor('materializer', ['materialize_relationship']), $f['version'], 'withdraw-projection');
        app(PersistedGovernanceWorkflowService::class)->withdrawClaimVersion($this->actor('withdrawer', ['withdraw_claim']), $f['version'], 'synthetic_withdrawal', 'Synthetic withdrawal.', 'withdraw-key');
        $this->assertDatabaseHas('entity_relationships', ['id' => $id, 'status' => 'withdrawn']);

        $g = $this->accepted(); $id2 = $service->materializeAcceptedRelationship($this->actor('materializer-two', ['materialize_relationship']), $g['version'], 'revoke-projection');
        app(PersistedGovernanceWorkflowService::class)->revokeSourceAuthorization($this->actor('rights-officer', ['revoke_source_authorization']), $g['authorization'], 'synthetic_revocation', 'Synthetic rights change.');
        $this->assertDatabaseHas('entity_relationships', ['id' => $id2, 'status' => 'suppressed']);
    }
    private function accepted(string $predicate = 'operates', ?string $from = '2026-01-01', ?string $to = null, ?string $scope = null, ?string $jurisdiction = null): array
    {
        $provider = $this->entity('provider'); $institution = $this->entity('institution'); $authorization = $this->authorization();
        $evidence = app(GovernanceCommandService::class)->registerEvidenceReference($authorization, $this->actor('collector', ['register_evidence']), $this->context(), 'evidence-'.str()->uuid(), ['content_included' => false]);
        DB::table('evidence_references')->where('id', $evidence)->update(['status' => 'eligible_for_review']);
        $version = app(ProviderInstitutionRelationshipService::class)->propose($this->actor('author', ['register_claim']), $provider, $institution, $predicate, [$evidence], $this->context(), 'claim-'.str()->uuid(), $scope, $jurisdiction, $from, $to);
        $workflow = app(PersistedGovernanceWorkflowService::class);
        $case = $workflow->openAdjudicationCase($this->actor('case-opener', ['open_adjudication']), $version, 'case-'.str()->uuid());
        $workflow->decideAdjudication($this->actor('adjudicator', ['adjudicate_claim']), $case, 'accepted', 'synthetic_acceptance', 'Synthetic fixture accepted after review.', 'synthetic-policy-v1');
        return ['provider' => $provider, 'institution' => $institution, 'version' => $version, 'authorization' => $authorization, 'evidence' => $evidence];
    }
    private function authorization(): string
    {
        $id = (string) str()->uuid(); $now = now();
        DB::table('source_authorizations')->insert([
            'id' => $id, 'source_family_id' => 'synthetic-only', 'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['synthetic_test_only']), 'permitted_methods' => json_encode(['fixture_reference']),
            'territories' => json_encode(['synthetic']), 'permitted_scopes' => json_encode(['acquisition' => true, 'retention' => true, 'processing' => true, 'reuse' => false, 'publication' => false]),
            'valid_from' => now()->subDay(), 'valid_to' => now()->addDay(), 'created_at' => $now, 'updated_at' => $now,
        ]);
        return $id;
    }
    private function evidence(): string
    {
        $authorization = $this->authorization();
        $id = app(GovernanceCommandService::class)->registerEvidenceReference($authorization, $this->actor('collector', ['register_evidence']), $this->context(), 'evidence-'.str()->uuid(), ['content_included' => false]);
        DB::table('evidence_references')->where('id', $id)->update(['status' => 'eligible_for_review']);
        return $id;
    }
    private function entity(string $type, ?string $label = null): string
    {
        $id = (string) str()->uuid();
        DB::table('directory_entities')->insert(['id' => $id, 'entity_type' => $type, 'label' => $label ?? 'Synthetic '.$type.' '.str()->random(6), 'created_at' => now(), 'updated_at' => now()]);
        return $id;
    }
    private function context(): array { return ['purpose' => 'synthetic_test_only', 'method' => 'fixture_reference', 'territory' => 'synthetic']; }
    private function actor(string $id, array $capabilities, string $class = 'human'): array { return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities]; }
}