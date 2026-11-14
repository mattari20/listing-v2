<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Governance\GovernancePolicy;
use App\Services\Governance\GovernanceCommandService;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class GovernanceServiceContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_source_authorization_fails_closed_for_missing_expired_revoked_or_out_of_scope_grants(): void
    {
        $now = CarbonImmutable::parse('2026-11-13T12:00:00Z');
        $base = $this->authorization();

        $this->assertTrue((new GovernancePolicy)->authorizeSourceAction($base, 'acquisition', $this->context(), $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction([], 'acquisition', $this->context(), $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction(array_replace($base, ['valid_to' => '2026-11-13T11:59:59Z']), 'acquisition', $this->context(), $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction(array_replace($base, ['revoked_at' => '2026-11-13T11:00:00Z']), 'acquisition', $this->context(), $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction($base, 'publication', $this->context(), $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction($base, 'acquisition', ['purpose' => 'other', 'method' => 'fixture_reference', 'territory' => 'synthetic'], $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction($base, 'acquisition', ['purpose' => 'synthetic_test_only', 'method' => 'scrape', 'territory' => 'synthetic'], $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction($base, 'acquisition', ['purpose' => 'synthetic_test_only', 'method' => 'fixture_reference', 'territory' => 'unknown'], $now)['allowed']);
    }

    public function test_actor_capability_and_separation_of_duties_are_enforced(): void
    {
        $collector = $this->actor('collector-1', ['register_evidence', 'register_claim']);
        $automated = $this->actor('validator-1', ['adjudicate_claim'], 'automated');
        $sameCollector = (new GovernancePolicy)->authorizeAdjudication(array_replace($collector, ['capabilities' => ['adjudicate_claim']]), 'collector-1');
        $differentHuman = (new GovernancePolicy)->authorizeAdjudication($this->actor('reviewer-1', ['adjudicate_claim']), 'collector-1');

        $this->assertFalse($sameCollector['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeAdjudication($automated, 'collector-1')['allowed']);
        $this->assertTrue($differentHuman['allowed']);
        $this->assertFalse((new GovernancePolicy)->requireCapability($collector, 'authorize_publication')['allowed']);
    }

    public function test_publication_requires_distinct_human_approval_after_adjudication(): void
    {
        $publisher = $this->actor('publisher-1', ['authorize_publication']);
        $accepted = ['outcome' => 'accepted', 'claim_disposition' => 'accepted', 'evidence_admissible' => true, 'version_current' => true, 'actor_id' => 'reviewer-1', 'policy_version' => 'synthetic-policy-v1', 'surface' => 'synthetic_test', 'audience' => 'synthetic_reviewers'];

        $this->assertTrue((new GovernancePolicy)->authorizePublication($publisher, $accepted, ['collector-1'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, ['outcome' => 'proposed'] + $accepted, ['collector-1'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, ['outcome' => 'accepted', 'claim_disposition' => 'accepted', 'evidence_admissible' => true, 'version_current' => true, 'actor_id' => 'publisher-1', 'policy_version' => 'v1', 'surface' => 'synthetic_test', 'audience' => 'synthetic_reviewers'], [])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($this->actor('bot', ['authorize_publication'], 'automated'), $accepted, [])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, $accepted, ['publisher-1'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, ['outcome' => 'accepted', 'claim_disposition' => 'accepted', 'evidence_admissible' => true, 'version_current' => true, 'actor_id' => 'reviewer-1', 'surface' => 'synthetic_test', 'audience' => 'synthetic_reviewers'], [])['allowed']);
    }

    public function test_restricted_category_visibility_defaults_to_suppressed(): void
    {
        $this->assertTrue((new GovernancePolicy)->isPubliclyVisible(null, false));
        $this->assertTrue((new GovernancePolicy)->isPubliclyVisible(false, false));
        $this->assertFalse((new GovernancePolicy)->isPubliclyVisible(null, true));
        $this->assertFalse((new GovernancePolicy)->isPubliclyVisible(false, true));
        $this->assertTrue((new GovernancePolicy)->isPubliclyVisible(true, true));
    }

    public function test_evidence_registration_is_metadata_only_quarantined_audited_and_idempotent(): void
    {
        $authorizationId = $this->insertAuthorization();
        $service = app(GovernanceCommandService::class);
        $actor = $this->actor('synthetic-collector', ['register_evidence']);

        $first = $service->registerEvidenceReference($authorizationId, $actor, $this->context(), 'evidence-key-1', [
            'reference_kind' => 'synthetic_fixture',
            'integrity_digest' => 'sha256:synthetic-fixture',
            'content_included' => false,
        ]);
        $second = $service->registerEvidenceReference($authorizationId, $actor, $this->context(), 'evidence-key-1', [
            'reference_kind' => 'synthetic_fixture',
            'integrity_digest' => 'sha256:synthetic-fixture',
            'content_included' => false,
        ]);

        $this->assertSame($first, $second);
        $this->assertDatabaseHas('evidence_references', ['id' => $first, 'status' => 'quarantined', 'content_included' => 0]);
        $this->assertSame(1, DB::table('evidence_references')->count());
        $this->assertSame(1, DB::table('audit_events')->where('action', 'evidence_reference_registered')->count());
    }

    public function test_idempotency_key_cannot_be_reused_for_a_different_command(): void
    {
        $authorizationId = $this->insertAuthorization();
        $service = app(GovernanceCommandService::class);
        $actor = $this->actor('synthetic-collector', ['register_evidence']);
        $service->registerEvidenceReference($authorizationId, $actor, $this->context(), 'same-key', [
            'reference_kind' => 'synthetic_fixture',
            'content_included' => false,
        ]);

        $this->expectException(ValidationException::class);
        $service->registerEvidenceReference($authorizationId, $actor, $this->context(), 'same-key', [
            'reference_kind' => 'different-synthetic-fixture',
            'content_included' => false,
        ]);
    }

    public function test_evidence_registration_denies_unapproved_scope_and_content_payloads(): void
    {
        $authorizationId = $this->insertAuthorization(['permitted_scopes' => ['acquisition' => false]]);
        $service = app(GovernanceCommandService::class);
        $actor = $this->actor('synthetic-collector', ['register_evidence']);

        try {
            $service->registerEvidenceReference($authorizationId, $actor, $this->context(), 'deny-key-1', ['content_included' => false]);
            $this->fail('Expected acquisition scope to be denied.');
        } catch (ValidationException) {
            $this->assertSame(0, DB::table('evidence_references')->count());
        }

        try {
            $service->registerEvidenceReference($authorizationId, $actor, $this->context(), 'deny-key-2', ['content_included' => true]);
            $this->fail('Expected evidence content to be rejected.');
        } catch (ValidationException) {
            $this->assertSame(0, DB::table('evidence_references')->count());
        }
    }

    public function test_evidence_registration_requires_separate_retention_permission(): void
    {
        $authorizationId = $this->insertAuthorization([
            'permitted_scopes' => ['acquisition' => true, 'retention' => false, 'processing' => true, 'reuse' => false, 'publication' => false],
        ]);

        $this->expectException(ValidationException::class);
        app(GovernanceCommandService::class)->registerEvidenceReference(
            $authorizationId,
            $this->actor('retention-denied-collector', ['register_evidence']),
            $this->context(),
            'retention-denied-key',
            ['content_included' => false],
        );
    }

    public function test_claim_registration_is_proposed_and_audited_with_quarantined_evidence_linked(): void
    {
        $authorizationId = $this->insertAuthorization();
        $evidenceId = app(GovernanceCommandService::class)->registerEvidenceReference(
            $authorizationId,
            $this->actor('collector-1', ['register_evidence']),
            $this->context(),
            'claim-evidence-key',
            ['content_included' => false],
        );

        $entityId = (string) str()->uuid();
        DB::table('directory_entities')->insert([
            'id' => $entityId,
            'entity_type' => 'institution',
            'label' => 'Synthetic Institute Delta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $versionId = app(GovernanceCommandService::class)->registerProposedClaim(
            $this->actor('claim-author-1', ['register_claim']),
            $entityId,
            'display_name',
            ['value' => 'Synthetic Institute Delta'],
            [$evidenceId],
            $this->context(),
            'claim-key-1',
        );

        $this->assertDatabaseHas('claim_versions', ['id' => $versionId, 'disposition' => 'proposed']);
        $this->assertDatabaseHas('claim_evidence_links', ['claim_version_id' => $versionId, 'evidence_reference_id' => $evidenceId]);
        $this->assertDatabaseHas('evidence_references', ['id' => $evidenceId, 'status' => 'quarantined']);
        $this->assertDatabaseHas('audit_events', ['action' => 'claim_version_registered', 'target_id' => $versionId]);
    }

    public function test_audit_failure_rolls_back_the_authoritative_evidence_registration(): void
    {
        $authorizationId = $this->insertAuthorization();
        DB::unprepared("CREATE TRIGGER fail_governance_audit BEFORE INSERT ON audit_events BEGIN SELECT RAISE(ABORT, 'synthetic audit failure'); END");

        try {
            app(GovernanceCommandService::class)->registerEvidenceReference(
                $authorizationId,
                $this->actor('collector-rollback', ['register_evidence']),
                $this->context(),
                'audit-failure-key',
                ['content_included' => false],
            );
            $this->fail('Expected audit failure.');
        } catch (QueryException) {
            $this->assertSame(0, DB::table('evidence_references')->count());
        } finally {
            DB::unprepared('DROP TRIGGER IF EXISTS fail_governance_audit');
        }
    }

    public function test_entry_point_policy_is_expressed_as_a_single_service_capability_boundary(): void
    {
        $this->assertTrue(Schema::hasTable('audit_events'));
        $this->assertTrue(method_exists(app(GovernanceCommandService::class), 'registerEvidenceReference'));
        $this->assertTrue(method_exists(app(GovernanceCommandService::class), 'registerProposedClaim'));

        foreach ([app_path('Http/Controllers'), app_path('Console/Commands'), app_path('Jobs')] as $directory) {
            if (File::isDirectory($directory) === false) {
                continue;
            }
            foreach (File::allFiles($directory) as $file) {
                $source = File::get($file->getPathname());
                $this->assertDoesNotMatchRegularExpression('/(?:DB::table|Schema::create)\\s*\\(/', $source, $file->getRelativePathname().' must not mutate governance persistence directly.');
            }
        }
    }

    public function test_gs_001_through_gs_032_synthetic_acceptance_contract_matrix(): void
    {
        $now = CarbonImmutable::parse('2026-11-13T12:00:00Z');
        $authorization = $this->authorization();
        $publisher = $this->actor('publisher', ['authorize_publication']);
        $adjudication = [
            'outcome' => 'accepted',
            'claim_disposition' => 'accepted',
            'evidence_admissible' => true,
            'version_current' => true,
            'actor_id' => 'reviewer',
            'policy_version' => 'synthetic-v1',
            'surface' => 'synthetic-directory',
            'audience' => 'synthetic-public',
        ];

        // GS-001 through GS-006: source scope is exact, independent and deny-by-default.
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction([], 'acquisition', $this->context(), $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction(array_replace($authorization, ['valid_to' => '2026-11-13T11:00:00Z']), 'acquisition', $this->context(), $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction($authorization, 'acquisition', ['purpose' => 'synthetic_test_only', 'method' => 'scrape', 'territory' => 'synthetic'], $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction($authorization, 'acquisition', ['purpose' => 'other', 'method' => 'fixture_reference', 'territory' => 'synthetic'], $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction($authorization, 'acquisition', ['purpose' => 'synthetic_test_only', 'method' => 'fixture_reference', 'territory' => 'elsewhere'], $now)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction($authorization, 'publication', $this->context(), $now)['allowed']);

        // GS-007 through GS-011: quarantine, admissibility and validation never imply acceptance.
        $this->assertFalse((new GovernancePolicy)->evidenceCanSupportClaim('quarantined'));
        $this->assertFalse((new GovernancePolicy)->canAcceptClaim(['quarantined']));
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, ['outcome' => 'proposed'], ['collector'])['allowed']);
        $this->assertSame(['conflict' => true, 'candidate_count' => 2], (new GovernancePolicy)->detectClaimConflict([
            ['value' => 'synthetic-A'], ['value' => 'synthetic-B'],
        ]));
        $this->assertFalse((new GovernancePolicy)->canAcceptClaim([]));

        // GS-012 through GS-019: actor, human decision, separation and publication scope.
        $this->assertFalse((new GovernancePolicy)->requireCapability($this->actor('limited', []), 'adjudicate_claim')['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, $adjudication, ['publisher'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($this->actor('robot', ['authorize_publication'], 'automated'), $adjudication, ['collector'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, array_replace($adjudication, ['actor_id' => 'publisher']), ['collector'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, array_replace($adjudication, ['version_current' => false]), ['collector'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, array_replace($adjudication, ['surface' => '', 'audience' => 'synthetic-public']), ['collector'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, array_replace($adjudication, ['policy_version' => '']), ['collector'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, array_replace($adjudication, ['evidence_admissible' => false]), ['collector'])['allowed']);

        // GS-020 through GS-024: retry safety, audit atomicity, conflict and version guards.
        $this->assertTrue((new GovernancePolicy)->detectClaimConflict([['value' => 'old'], ['value' => 'new']])['conflict']);
        $this->assertTrue((new GovernancePolicy)->canAcceptClaim(['eligible_for_review']));
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, array_replace($adjudication, ['claim_disposition' => 'stale']), ['collector'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublication($publisher, array_replace($adjudication, ['version_current' => false]), ['collector'])['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeSourceAction(array_replace($authorization, ['revoked_at' => '2026-11-13T11:00:00Z']), 'acquisition', $this->context(), $now)['allowed']);

        // GS-025 through GS-032: suppression, restoration, retention, policy and public boundary.
        $this->assertFalse((new GovernancePolicy)->isPubliclyVisible(false, true));
        $this->assertFalse((new GovernancePolicy)->authorizeRestore($this->actor('restorer', ['restore_publication']), 'suppressor', false, true)['allowed']);
        $this->assertTrue((new GovernancePolicy)->authorizeRestore($this->actor('restorer', ['restore_publication']), 'suppressor', true, true)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizeEvidenceWithdrawal($this->actor('withdrawer', ['withdraw_evidence']), false)['allowed']);
        $this->assertFalse((new GovernancePolicy)->authorizePublicRead(false));
        $this->assertTrue((new GovernancePolicy)->authorizePublicRead(true));
        $this->assertFalse((new GovernancePolicy)->isPubliclyVisible(null, true));
        $this->assertFalse((new GovernancePolicy)->isPubliclyVisible(false, true));
    }

    private function authorization(array $overrides = []): array
    {
        return array_replace([
            'status' => 'approved_for_defined_purpose_and_method',
            'permitted_purposes' => ['synthetic_test_only'],
            'permitted_methods' => ['fixture_reference'],
            'territories' => ['synthetic'],
            'permitted_scopes' => ['acquisition' => true, 'retention' => true, 'processing' => true, 'reuse' => false, 'publication' => false],
            'valid_from' => '2026-11-13T00:00:00Z',
            'valid_to' => '2026-11-15T00:00:00Z',
            'revoked_at' => null,
        ], $overrides);
    }

    private function context(): array
    {
        return ['purpose' => 'synthetic_test_only', 'method' => 'fixture_reference', 'territory' => 'synthetic'];
    }

    private function actor(string $id, array $capabilities, string $class = 'human'): array
    {
        return ['actor_id' => $id, 'actor_class' => $class, 'capabilities' => $capabilities];
    }

    private function insertAuthorization(array $overrides = []): string
    {
        $id = (string) str()->uuid();
        $authorization = $this->authorization($overrides);
        DB::table('source_authorizations')->insert([
            'id' => $id,
            'source_family_id' => 'synthetic-family-only',
            'status' => $authorization['status'],
            'permitted_purposes' => json_encode($authorization['permitted_purposes']),
            'permitted_methods' => json_encode($authorization['permitted_methods']),
            'territories' => json_encode($authorization['territories']),
            'permitted_scopes' => json_encode($authorization['permitted_scopes']),
            'valid_from' => $authorization['valid_from'],
            'valid_to' => $authorization['valid_to'],
            'revoked_at' => $authorization['revoked_at'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $id;
    }
}
