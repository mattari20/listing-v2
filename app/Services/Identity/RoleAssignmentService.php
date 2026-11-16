<?php

declare(strict_types=1);

namespace App\Services\Identity;

use App\Authorization\ScopedAuthorization;
use App\Models\PrivilegedActionAudit;
use App\Models\RoleAssignment;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final class RoleAssignmentService
{
    private const ROLES = [
        'provider_representative',
        'data_reviewer',
        'publisher',
        'moderator',
        'service_identity',
    ];

    private const REASON_CODES = [
        'operational_need',
        'correction',
        'incident_response',
        'access_review',
    ];

    public function __construct(private readonly ScopedAuthorization $authorization)
    {
    }

    public function grant(
        User $actor,
        User $target,
        string $role,
        ?string $scopeType,
        ?string $scopeId,
        string $reasonCode,
    ): RoleAssignment {
        if ($actor->is($target)) {
            throw new AuthorizationException('Self-grant is prohibited.');
        }

        $this->assertCanManage($actor, $target);
        $this->assertValidGrant($target, $role, $scopeType, $scopeId, $reasonCode);

        return DB::transaction(function () use ($actor, $target, $role, $scopeType, $scopeId, $reasonCode): RoleAssignment {
            User::query()->whereKey($target->getKey())->lockForUpdate()->firstOrFail();

            $existing = RoleAssignment::query()
                ->where('user_id', $target->getKey())
                ->where('role', $role)
                ->where('scope_type', $scopeType)
                ->where('scope_id', $scopeId)
                ->whereNull('revoked_at')
                ->where(function ($query): void {
                    $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })
                ->first();

            if ($existing !== null) {
                return $existing;
            }

            $assignment = RoleAssignment::query()->create([
                'user_id' => $target->getKey(),
                'role' => $role,
                'scope_type' => $scopeType,
                'scope_id' => $scopeId,
                'granted_by_user_id' => $actor->getKey(),
            ]);

            $this->record($actor, 'role.granted', $target, $role, $scopeType, $scopeId, $reasonCode);

            return $assignment;
        });
    }

    public function revoke(User $actor, RoleAssignment $assignment, string $reasonCode): RoleAssignment
    {
        $target = $assignment->user;

        if ($target === null || $actor->is($target)) {
            throw new AuthorizationException('Self-revocation or missing target is prohibited.');
        }

        $this->assertCanManage($actor, $target, requireActiveTarget: false);

        if (! in_array($reasonCode, self::REASON_CODES, true)) {
            throw new InvalidArgumentException('Unsupported role-change reason code.');
        }

        if ($assignment->role === 'administrator') {
            throw new AuthorizationException('Administrator grants require the separately controlled break-glass process.');
        }

        return DB::transaction(function () use ($actor, $assignment, $target, $reasonCode): RoleAssignment {
            $locked = RoleAssignment::query()->whereKey($assignment->getKey())->lockForUpdate()->firstOrFail();

            if ($locked->revoked_at !== null) {
                return $locked;
            }

            $locked->forceFill(['revoked_at' => now()])->save();

            $this->record(
                $actor,
                'role.revoked',
                $target,
                $locked->role,
                $locked->scope_type,
                $locked->scope_id,
                $reasonCode,
            );

            return $locked->refresh();
        });
    }

    private function assertCanManage(User $actor, User $target, bool $requireActiveTarget = true): void
    {
        if (! $actor->is_active || ($requireActiveTarget && ! $target->is_active)
            || ! $this->authorization->allows($actor, 'roles.manage', 'user', (string) $target->getKey())) {
            throw new AuthorizationException('Role administration is not authorized for this target.');
        }
    }

    private function assertValidGrant(
        User $target,
        string $role,
        ?string $scopeType,
        ?string $scopeId,
        string $reasonCode,
    ): void {
        if (! $target->is_active) {
            throw new AuthorizationException('Roles cannot be granted to inactive accounts.');
        }

        if (! in_array($role, self::ROLES, true)) {
            throw new InvalidArgumentException('Unsupported role. Administrator grants are not available through this service.');
        }

        if (($scopeType === null) !== ($scopeId === null) || ($scopeType !== null && ($scopeType === '' || $scopeId === ''))) {
            throw new InvalidArgumentException('A resource scope requires both a non-empty type and identifier.');
        }

        if (! in_array($reasonCode, self::REASON_CODES, true)) {
            throw new InvalidArgumentException('Unsupported role-change reason code.');
        }
    }

    private function record(
        User $actor,
        string $action,
        User $target,
        string $role,
        ?string $scopeType,
        ?string $scopeId,
        string $reasonCode,
    ): void {
        PrivilegedActionAudit::query()->create([
            'actor_user_id' => $actor->getKey(),
            'action' => $action,
            'subject_type' => 'user',
            'subject_id' => (string) $target->getKey(),
            'scope_type' => $scopeType,
            'scope_id' => $scopeId,
            'reason_code' => $reasonCode,
            'metadata' => ['role' => $role],
            'created_at' => now(),
        ]);
    }
}
