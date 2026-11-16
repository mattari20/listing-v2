<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Models\RoleAssignment;
use App\Models\User;

final class ScopedAuthorization
{
    /**
     * These are intentionally narrow capabilities, not a UI role hierarchy.
     * Reviews and user-generated content remain disabled; their permissions
     * are reserved for a separately approved post-launch implementation.
     */
    private const ROLE_ACTIONS = [
        'provider_representative' => [
            'provider.claim.submit',
        ],
        'data_reviewer' => [
            'evidence.review',
            'claim.review',
        ],
        'publisher' => [
            'assertion.publish',
            'institution.publish',
        ],
        'moderator' => [
            'ugc.moderate',
            'ugc.appeal.review',
        ],
        'administrator' => [
            'roles.manage',
            'security.audit.read',
        ],
        'service_identity' => [],
    ];

    public function allows(
        ?User $actor,
        string $action,
        string $resourceType,
        ?string $resourceId = null,
        ?int $subjectOwnerUserId = null,
    ): bool {
        if ($actor === null || $actor->is_active === false || $action === '' || $resourceType === '') {
            return false;
        }

        if (in_array($action, ['evidence.review', 'claim.review', 'assertion.publish', 'institution.publish'], true)
            && $subjectOwnerUserId !== null
            && $subjectOwnerUserId === $actor->getKey()) {
            return false;
        }

        $roles = array_keys(array_filter(
            self::ROLE_ACTIONS,
            static fn (array $actions): bool => in_array($action, $actions, true),
        ));

        if ($roles === []) {
            return false;
        }

        return RoleAssignment::query()
            ->where('user_id', $actor->getKey())
            ->whereIn('role', $roles)
            ->whereNull('revoked_at')
            ->where(function ($query): void {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->where(function ($query) use ($resourceType, $resourceId): void {
                $query->where(function ($global): void {
                    $global->where('role', 'administrator')
                        ->whereNull('scope_type')
                        ->whereNull('scope_id');
                });

                if ($resourceId !== null) {
                    $query->orWhere(function ($scoped) use ($resourceType, $resourceId): void {
                        $scoped->where('role', '!=', 'administrator')
                            ->where('scope_type', $resourceType)
                            ->where('scope_id', $resourceId);
                    });
                }
            })
            ->exists();
    }
}
