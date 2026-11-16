<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Authorization\ScopedAuthorization;
use App\Models\RoleAssignment;
use App\Models\User;
use App\Services\Identity\RoleAssignmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

final class ScopedAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_scoped_reviewer_can_only_review_the_assigned_resource(): void
    {
        $user = $this->makeUser('reviewer@example.test');
        $this->assign($user, 'data_reviewer', 'provider', 'provider-01');

        $authorization = app(ScopedAuthorization::class);

        $this->assertTrue($authorization->allows($user, 'evidence.review', 'provider', 'provider-01'));
        $this->assertFalse($authorization->allows($user, 'evidence.review', 'provider', 'provider-02'));
        $this->assertFalse($authorization->allows($user, 'institution.publish', 'provider', 'provider-01'));
        $this->assertFalse($authorization->allows($user, 'unknown.action', 'provider', 'provider-01'));
    }

    public function test_global_administrator_role_is_limited_to_role_and_audit_capabilities(): void
    {
        $admin = $this->makeUser('admin@example.test');
        $this->assign($admin, 'administrator');

        $authorization = app(ScopedAuthorization::class);

        $this->assertTrue($authorization->allows($admin, 'roles.manage', 'user', '99'));
        $this->assertTrue($authorization->allows($admin, 'security.audit.read', 'audit', '1'));
        $this->assertFalse($authorization->allows($admin, 'institution.publish', 'institution', '1'));
        $this->assertFalse($authorization->allows($admin, 'ugc.moderate', 'review', '1'));
    }

    public function test_self_review_and_self_publication_are_denied_even_with_role(): void
    {
        $user = $this->makeUser('publisher@example.test');
        $this->assign($user, 'publisher');

        $authorization = app(ScopedAuthorization::class);

        $this->assertFalse($authorization->allows($user, 'assertion.publish', 'claim', 'claim-1', $user->getKey()));
        $this->assertTrue($authorization->allows($user, 'assertion.publish', 'claim', 'claim-1', 99999));
    }

    public function test_expired_and_revoked_assignments_are_denied(): void
    {
        $user = $this->makeUser('expired@example.test');
        $expired = $this->assign($user, 'data_reviewer');
        $expired->forceFill(['expires_at' => now()->subMinute()])->save();

        $this->assertFalse(app(ScopedAuthorization::class)->allows($user, 'evidence.review', 'provider', 'provider-01'));

        $expired->forceFill(['expires_at' => null, 'revoked_at' => now()])->save();

        $this->assertFalse(app(ScopedAuthorization::class)->allows($user, 'evidence.review', 'provider', 'provider-01'));
    }

    public function test_role_grant_is_scoped_audited_and_idempotent(): void
    {
        $admin = $this->makeUser('admin-grant@example.test');
        $target = $this->makeUser('target@example.test');
        $this->assign($admin, 'administrator');

        $service = app(RoleAssignmentService::class);
        $first = $service->grant($admin, $target, 'data_reviewer', 'provider', 'provider-01', 'operational_need');
        $second = $service->grant($admin, $target, 'data_reviewer', 'provider', 'provider-01', 'operational_need');

        $this->assertSame($first->getKey(), $second->getKey());
        $this->assertDatabaseCount('role_assignments', 2);
        $this->assertDatabaseHas('privileged_action_audits', [
            'actor_user_id' => $admin->getKey(),
            'action' => 'role.granted',
            'subject_type' => 'user',
            'subject_id' => (string) $target->getKey(),
            'reason_code' => 'operational_need',
        ]);
    }

    public function test_conflicting_privileged_roles_cannot_be_combined(): void
    {
        $admin = $this->makeUser('admin-conflict@example.test');
        $target = $this->makeUser('target-conflict@example.test');
        $this->assign($admin, 'administrator');
        $this->assign($target, 'data_reviewer');

        $this->expectException(AuthorizationException::class);

        app(RoleAssignmentService::class)->grant(
            $admin,
            $target,
            'publisher',
            'provider',
            'provider-01',
            'operational_need',
        );
    }

    public function test_role_revocation_is_audited_and_takes_effect_immediately(): void
    {
        $admin = $this->makeUser('admin-revoke@example.test');
        $target = $this->makeUser('target-revoke@example.test');
        $this->assign($admin, 'administrator');
        $assignment = $this->assign($target, 'data_reviewer');

        app(RoleAssignmentService::class)->revoke($admin, $assignment, 'access_review');

        $this->assertFalse(app(ScopedAuthorization::class)->allows($target, 'evidence.review', 'provider', 'provider-01'));
        $this->assertDatabaseHas('privileged_action_audits', [
            'actor_user_id' => $admin->getKey(),
            'action' => 'role.revoked',
            'subject_id' => (string) $target->getKey(),
            'reason_code' => 'access_review',
        ]);
    }

    public function test_administrator_can_revoke_role_from_an_inactive_account(): void
    {
        $admin = $this->makeUser('admin-inactive-revoke@example.test');
        $target = $this->makeUser('inactive-target@example.test');
        $this->assign($admin, 'administrator');
        $assignment = $this->assign($target, 'data_reviewer');
        $target->forceFill(['is_active' => false])->save();

        app(RoleAssignmentService::class)->revoke($admin, $assignment, 'incident_response');

        $this->assertNotNull($assignment->fresh()->revoked_at);
        $this->assertDatabaseHas('privileged_action_audits', [
            'actor_user_id' => $admin->getKey(),
            'action' => 'role.revoked',
            'subject_id' => (string) $target->getKey(),
        ]);
    }

    public function test_self_grant_and_application_level_administrator_grants_are_prohibited(): void
    {
        $admin = $this->makeUser('admin-self@example.test');
        $this->assign($admin, 'administrator');
        $service = app(RoleAssignmentService::class);

        try {
            $service->grant($admin, $admin, 'moderator', null, null, 'operational_need');
            $this->fail('Self-grant should be rejected.');
        } catch (AuthorizationException) {
            $this->assertTrue(true);
        }

        $target = $this->makeUser('target-admin@example.test');

        $this->expectException(InvalidArgumentException::class);
        $service->grant($admin, $target, 'administrator', null, null, 'operational_need');
    }

    public function test_non_administrator_cannot_grant_roles_and_unknown_reason_codes_fail_closed(): void
    {
        $user = $this->makeUser('ordinary@example.test');
        $target = $this->makeUser('ordinary-target@example.test');
        $service = app(RoleAssignmentService::class);

        try {
            $service->grant($user, $target, 'data_reviewer', null, null, 'operational_need');
            $this->fail('Unprivileged role grant should be rejected.');
        } catch (AuthorizationException) {
            $this->assertTrue(true);
        }

        $admin = $this->makeUser('admin-reason@example.test');
        $this->assign($admin, 'administrator');

        $this->expectException(InvalidArgumentException::class);
        $service->grant($admin, $target, 'data_reviewer', null, null, 'free-form-personal-data');
    }

    private function makeUser(string $email): User
    {
        return User::query()->create([
            'email' => $email,
            'password' => 'synthetic-password',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
    }

    private function assign(User $user, string $role, ?string $scopeType = null, ?string $scopeId = null): RoleAssignment
    {
        return RoleAssignment::query()->create([
            'user_id' => $user->getKey(),
            'role' => $role,
            'scope_type' => $scopeType,
            'scope_id' => $scopeId,
        ]);
    }
}
