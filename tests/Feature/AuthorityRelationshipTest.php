<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\AuthorityRelationshipService;
use App\Services\Governance\GovernanceCommandService;
use App\Services\Governance\PersistedGovernanceWorkflowService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthorityRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_authority_identity_has_a_controlled_type_and_idempotent_registration(): void
    {
        $service = app(AuthorityRelationshipService::class);
        $actor = $this->actor('authority-registrar', ['register_directory_entity']);
        $id = $service->registerAuthority($actor, 'Synthetic Regional Regulator', 'regulator', 'authority-identity-key');
        $this->assertSame($id, $service->registerAuthority($actor, 'Synthetic Regional Regulator', 'regulator', 'authority-identity-key'));
        $this->assertDatabaseHas('directory_entities', ['id' => $id, 'entity_type' => 'authority']);
        $this->assertDatabaseHas('authority_profiles', ['entity_id' => $id, 'authority_type' => 'regulator', 'status' => 'active']);
        $this->expectException(ValidationException::class);
        $service->registerAuthority($actor, 'Synthetic Unknown Authority', 'provider', 'bad-authority-type');
    }

    public function test_each_authority_predicate_requires_its_specific_authority_type(): void
    {
        $cases = [
            ['institution', 'regulator', 'regulated_by'],
            ['institution', 'licensing_authority', 'licensed_by'],
            ['campus', 'accreditation_body', 'accredited_by'],
            ['programme', 'recognition_authority', 'recognized_by'],
            ['qualification', 'examining_body', 'examined_by'],
            ['institution', 'affiliation_body', 'affiliated_with'],
        ];
        foreach ($cases as [$subjectType, $authorityType, $predicate]) {
            $subject = $this->entity($subjectType);
            $authority = $this->authority($authorityType);
            $f = $this->accepted($subject, $authority, $predicate, 'synthetic-scope-'.$predicate, 'synthetic-jurisdiction');
            $id = app(AuthorityRelationshipService::class)->materializeAcceptedRelationship($this->actor('materializer-'.$predicate, ['materialize_relationship']), $f['version'], 'materialize-'.$predicate);
            $this->assertDatabaseHas('entity_relationships', [
                'id' => $id, 'from_entity_id' => $subject, 'to_entity_id' => $authority,
                'relationship_type' => $predicate, 'scope' => 'synthetic-scope-'.$predicate,
                'jurisdiction' => 'synthetic-jurisdiction', 'claim_version_id' => $f['version'], 'status' => 'active',
            ]);
        }
    }

    public function test_recognition_cannot_be_satisfied_by_an_accreditation_body(): void
    {
        $subject = $this->entity('institution');
        $authority = $this->authority('accreditation_body');
        $this->expectException(ValidationException::class);
        app(AuthorityRelationshipService::class)->proposeRelationship(
            $this->actor('claim-author', ['register_claim']), $subject, $authority, 'recognized_by',
            [$this->evidence()], $this->context(), 'wrong-authority-kind',
            'synthetic-programme-scope', 'synthetic-jurisdiction'
        );
    }

    public function test_awarded_by_uses_distinct_awarding_body_identity_not_authority_profile(): void
    {
        $qualification = $this->entity('qualification');
        $awardingBody = $this->entity('awarding_body');
        $f = $this->accepted($qualification, $awardingBody, 'awarded_by', 'synthetic-credential-scope', 'synthetic-jurisdiction');
        $id = app(AuthorityRelationshipService::class)->materializeAcceptedRelationship($this->actor('awarding-materializer', ['materialize_relationship']), $f['version'], 'awarded-by-key');
        $this->assertDatabaseHas('entity_relationships', [
            'id' => $id, 'from_entity_id' => $qualification, 'to_entity_id' => $awardingBody,
            'relationship_type' => 'awarded_by', 'status' => 'active',
        ]);
    }

    public function test_unknown_predicates_wrong_directions_and_untyped_authorities_fail_closed(): void
    {
        $institution = $this->entity('institution');
        $provider = $this->entity('provider');
        $authority = $this->authority('regulator');
        $evidence = $this->evidence();
        foreach ([[$institution, $provider, 'regulated_by'], [$provider, $authority, 'regulated_by'], [$institution, $authority, 'recognition'], [$institution, $authority, 'unknown']] as $index => [$subject, $target, $predicate]) {
            try {
                app(AuthorityRelationshipService::class)->proposeRelationship(
                    $this->actor('invalid-author', ['register_claim']), $subject, $target, $predicate,
                    [$evidence], $this->context(), 'invalid-relationship-'.$index,
                    'synthetic-scope', 'synthetic-jurisdiction'
                );
                $this->fail('Invalid P03 relationship must be rejected.');
            } catch (ValidationException) {
                $this->assertDatabaseCount('claims', 0);
            }
        }
    }

    public function test_scope_and_jurisdiction_are_mandatory_and_dates_are_validated(): void
    {
        $subject = $this->entity('institution');
        $authority = $this->authority('regulator');
        $evidence = $this->evidence();
        $service = app(AuthorityRelationshipService::class);
        try {
            $service->proposeRelationship($this->actor('author', ['register_claim']), $subject, $authority, 'regulated_by', [$evidence], $this->context(), 'no-scope', '', 'synthetic-jurisdiction');
            $this->fail('Missing scope must fail.');
        } catch (ValidationException) {
            $this->assertDatabaseCount('claims', 0);
        }
        $this->expectException(ValidationException::class);
        $service->proposeRelationship($this->actor('author', ['register_claim']), $subject, $authority, 'regulated_by', [$evidence], $this->context(), 'bad-date', 'synthetic-scope', 'synthetic-jurisdiction', '2027-12-31', '2027-01-01');
    }

    public function test_relationship_requires_human_adjudication_distinct_materializer_and_is_idempotent(): void
    {
        $subject = $this->entity('institution');
        $authority = $this->authority('regulator');
        $f = $this->accepted($subject, $authority, 'regulated_by', 'synthetic-institution-scope', 'synthetic-jurisdiction');
        $service = app(AuthorityRelationshipService::class);
        $actor = $this->actor('p03-materializer', ['materialize_relationship']);
        $id = $service->materializeAcceptedRelationship($actor, $f['version'], 'p03-idempotent-key');
        $this->assertSame($id, $service->materializeAcceptedRelationship($actor, $f['version'], 'p03-idempotent-key'));
        $this->assertDatabaseCount('entity_relationships', 1);
        $this->expectException(ValidationException::class);
        $service->materializeAcceptedRelationship($this->actor('synthetic-robot', ['materialize_relationship'], 'automated'), $f['version'], 'p03-robot-key');
    }

    public function test_overlapping_same_predicate_scope_and_jurisdiction_is_rejected(): void
    {
        $subject = $this->entity('institution');
        $authority = $this->authority('regulator');
        $one = $this->accepted($subject, $authority, 'regulated_by', 'synthetic-scope', 'synthetic-jurisdiction', '2026-01-01', '2026-12-31');
        $two = $this->accepted($subject, $authority, 'regulated_by', 'synthetic-scope', 'synthetic-jurisdiction', '2026-06-01', null);
        $service = app(AuthorityRelationshipService::class);
        $service->materializeAcceptedRelationship($this->actor('first-materializer', ['materialize_relationship']), $one['version'], 'p03-overlap-one');
        $this->expectException(ValidationException::class);
        $service->materializeAcceptedRelationship($this->actor('second-materializer', ['materialize_relationship']), $two['version'], 'p03-overlap-two');
    }

    public function test_withdrawal_and_source_authorization_revocation_propagate_to_p03_relationships(): void
    {
        $subject = $this->entity('institution');
        $authority = $this->authority('regulator');
        $f = $this->accepted($subject, $authority, 'regulated_by', 'synthetic-withdraw-scope', 'synthetic-jurisdiction');
        $service = app(AuthorityRelationshipService::class);
        $id = $service->materializeAcceptedRelationship($this->actor('p03-withdraw-materializer', ['materialize_relationship']), $f['version'], 'p03-withdraw');
        app(PersistedGovernanceWorkflowService::class)->withdrawClaimVersion($this->actor('withdrawer', ['withdraw_claim']), $f['version'], 'synthetic_withdrawal', 'Synthetic P03 withdrawal.', 'p03-withdraw-claim');
        $this->assertDatabaseHas('entity_relationships', ['id' => $id, 'status' => 'withdrawn']);

        $g = $this->accepted($subject, $authority, 'regulated_by', 'synthetic-revoke-scope', 'synthetic-jurisdiction');
        $id2 = $service->materializeAcceptedRelationship($this->actor('p03-revoke-materializer', ['materialize_relationship']), $g['version'], 'p03-revoke');
        app(PersistedGovernanceWorkflowService::class)->revokeSourceAuthorization($this->actor('rights-officer', ['revoke_source_authorization']), $g['authorization'], 'synthetic_revocation', 'Synthetic P03 authorization revoked.');
        $this->assertDatabaseHas('entity_relationships', ['id' => $id2, 'status' => 'suppressed']);
    }

    public function test_audit_failure_rolls_back_p03_relationship_projection(): void
    {
        $subject = $this->entity('institution');
        $authority = $this->authority('regulator');
        $f = $this->accepted($subject, $authority, 'regulated_by', 'synthetic-rollback-scope', 'synthetic-jurisdiction');
        DB::unprepared("CREATE TRIGGER fail_p03_audit BEFORE INSERT ON audit_events BEGIN SELECT RAISE(ABORT, 'synthetic P03 audit failure'); END");
        try {
            app(AuthorityRelationshipService::class)->materializeAcceptedRelationship($this->actor('p03-rollback-materializer', ['materialize_relationship']), $f['version'], 'p03-audit-rollback');
            $this->fail('Audit failure must roll back the relationship projection.');
        } catch (QueryException) {
            $this->assertDatabaseCount('entity_relationships', 0);
        } finally {
            DB::unprepared('DROP TRIGGER IF EXISTS fail_p03_audit');
        }
    }

    private function accepted(string $subject, string $target, string $predicate, string $scope, string $jurisdiction, ?string $from = '2026-01-01', ?string $to = null): array
    {
        $authorization = $this->authorization();
        $evidence = app(GovernanceCommandService::class)->registerEvidenceReference($authorization, $this->actor('collector', ['register_evidence']), $this->context(), 'p03-evidence-'.str()->uuid(), ['content_included' => false]);
        DB::table('evidence_references')->where('id', $evidence)->update(['status' => 'eligible_for_review']);
        $version = app(AuthorityRelationshipService::class)->proposeRelationship(
            $this->actor('claim-author', ['register_claim']), $subject, $target, $predicate, [$evidence],
            $this->context(), 'p03-claim-'.str()->uuid(), $scope, $jurisdiction, $from, $to
        );
        $workflow = app(PersistedGovernanceWorkflowService::class);
        $case = $workflow->openAdjudicationCase($this->actor('case-opener', ['open_adjudication']), $version, 'p03-case-'.str()->uuid());
        $workflow->decideAdjudication($this->actor('human-adjudicator', ['adjudicate_claim']), $case, 'accepted', 'synthetic_acceptance', 'Synthetic P03 evidence accepted.', 'synthetic-policy-p03-v1');
        return ['version' => $version, 'evidence' => $evidence, 'authorization' => $authorization];
    }

    private function authority(string $type): string
    {
        return app(AuthorityRelationshipService::class)->registerAuthority(
            $this->actor('authority-registrar', ['register_directory_entity']),
            'Synthetic '.$type.' identity', $type, 'p03-authority-'.str()->uuid()
        );
    }

    private function entity(string $type): string
    {
        return app(\App\Services\Directory\ProviderInstitutionRelationshipService::class)->registerEntity(
            $this->actor('identity-registrar', ['register_directory_entity']),
            $type, 'Synthetic '.$type.' '.str()->random(8), 'p03-entity-'.str()->uuid()
        );
    }

    private function authorization(): string
    {
        $id = (string) str()->uuid();
        $now = now();
        DB::table('source_authorizations')->insert([
            'id' => $id, 'source_family_id' => 'synthetic-only-p03',
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => json_encode(['synthetic_test_only']),
            'permitted_methods' => json_encode(['fixture_reference']),
            'territories' => json_encode(['synthetic']),
            'permitted_scopes' => json_encode(['acquisition' => true, 'retention' => true, 'processing' => true, 'reuse' => false, 'publication' => false]),
            'valid_from' => now()->subDay(), 'valid_to' => now()->addDay(),
            'created_at' => $now, 'updated_at' => $now,
        ]);
        return $id;
    }

    private function evidence(): string
    {
        $authorization = $this->authorization();
        $id = app(GovernanceCommandService::class)->registerEvidenceReference($authorization, $this->actor('collector', ['register_evidence']), $this->context(), 'p03-evidence-'.str()->uuid(), ['content_included' => false]);
        DB::table('evidence_references')->where('id', $id)->update(['status' => 'eligible_for_review']);
        return $id;
    }

    private function context(): array
    {
        return ['purpose' => 'synthetic_test_only', 'method' => 'fixture_reference', 'territory' => 'synthetic'];
    }

    private function actor(string $id, array $capabilities, string $class = 'human'): array
    {
        return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities];
    }
}
