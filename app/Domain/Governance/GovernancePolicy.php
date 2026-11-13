<?php

declare(strict_types=1);

namespace App\Domain\Governance;

use Carbon\CarbonImmutable;

final class GovernancePolicy
{
    /**
     * Evaluate one precisely scoped source permission. Unknown or missing values deny.
     *
     * @param array<string, mixed> $authorization
     * @param array<string, mixed> $context
     * @return array{allowed: bool, reason: string}
     */
    public function authorizeSourceAction(
        array $authorization,
        string $action,
        array $context,
        ?CarbonImmutable $now = null,
    ): array {
        $now ??= CarbonImmutable::now();

        if (($authorization['status'] ?? null) !== 'approved_for_defined_purpose_and_method') {
            return $this->deny('authorization_not_currently_approved');
        }

        if (! empty($authorization['revoked_at'])) {
            return $this->deny('authorization_revoked');
        }

        if (! $this->withinWindow($authorization, $now)) {
            return $this->deny('authorization_outside_validity_window');
        }

        $scopes = $this->decode($authorization['permitted_scopes'] ?? null);
        if (($scopes[$action] ?? false) !== true) {
            return $this->deny('action_scope_not_permitted');
        }

        foreach ([
            'purpose' => 'permitted_purposes',
            'method' => 'permitted_methods',
            'territory' => 'territories',
        ] as $contextKey => $authorizationKey) {
            $requested = $context[$contextKey] ?? null;
            $permitted = $this->decode($authorization[$authorizationKey] ?? null);

            if (! is_string($requested) || $requested === '' || ! in_array($requested, $permitted, true)) {
                return $this->deny($contextKey.'_not_permitted');
            }
        }

        return ['allowed' => true, 'reason' => 'scope_permitted'];
    }

    /** @param array<string, mixed> $actor
     *  @return array{allowed: bool, reason: string}
     */
    public function requireCapability(array $actor, string $capability): array
    {
        if (($actor['actor_id'] ?? '') === '' || ($actor['actor_class'] ?? '') === '') {
            return $this->deny('actor_identity_missing');
        }

        if (! in_array($capability, $actor['capabilities'] ?? [], true)) {
            return $this->deny('capability_missing');
        }

        return ['allowed' => true, 'reason' => 'capability_granted'];
    }

    /**
     * Automated actors may validate but can never adjudicate a claim.
     *
     * @param array<string, mixed> $actor
     * @return array{allowed: bool, reason: string}
     */
    public function authorizeAdjudication(array $actor, string $evidenceActorId, bool $highImpact = true): array
    {
        $capability = $this->requireCapability($actor, 'adjudicate_claim');
        if (! $capability['allowed']) {
            return $capability;
        }

        if (in_array($actor['actor_class'] ?? '', ['automated', 'system', 'agent'], true)) {
            return $this->deny('automated_adjudication_prohibited');
        }

        if ($highImpact && ($actor['actor_id'] ?? null) === $evidenceActorId) {
            return $this->deny('evidence_submitter_cannot_adjudicate_high_impact_claim');
        }

        return ['allowed' => true, 'reason' => 'human_adjudication_permitted'];
    }

    /**
     * Publication is a separate human decision and must not be performed by the
     * evidence submitter or the adjudicator.
     *
     * @param array<string, mixed> $actor
     * @param array<string, mixed> $adjudication
     * @param list<string> $evidenceActorIds
     * @return array{allowed: bool, reason: string}
     */
    public function authorizePublication(array $actor, array $adjudication, array $evidenceActorIds): array
    {
        $capability = $this->requireCapability($actor, 'authorize_publication');
        if (! $capability['allowed']) {
            return $capability;
        }

        if (in_array($actor['actor_class'] ?? '', ['automated', 'system', 'agent'], true)) {
            return $this->deny('automated_publication_prohibited');
        }

        if (($adjudication['outcome'] ?? null) !== 'accepted') {
            return $this->deny('claim_not_human_accepted');
        }

        if (($adjudication['actor_id'] ?? '') === '' || ($actor['actor_id'] ?? '') === $adjudication['actor_id']) {
            return $this->deny('publication_requires_distinct_adjudicator');
        }

        if (in_array($actor['actor_id'] ?? '', $evidenceActorIds, true)) {
            return $this->deny('evidence_submitter_cannot_publish');
        }

        if (($adjudication['policy_version'] ?? '') === '') {
            return $this->deny('policy_version_missing');
        }

        return ['allowed' => true, 'reason' => 'human_publication_permitted'];
    }

    /**
     * Missing/unknown restricted-category state is suppressed (default OFF).
     */
    public function isPubliclyVisible(?bool $deeniMadarisEnabled, bool $restricted): bool
    {
        return ! $restricted && $deeniMadarisEnabled === true;
    }

    /** @param array<string, mixed> $authorization */
    private function withinWindow(array $authorization, CarbonImmutable $now): bool
    {
        try {
            if (! empty($authorization['valid_from']) && $now->lessThan(CarbonImmutable::parse($authorization['valid_from']))) {
                return false;
            }

            if (! empty($authorization['valid_to']) && ! $now->lessThan(CarbonImmutable::parse($authorization['valid_to']))) {
                return false;
            }
        } catch (\Throwable) {
            return false;
        }

        return true;
    }

    /** @return array<string|int, mixed> */
    private function decode(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    /** @return array{allowed: false, reason: string} */
    private function deny(string $reason): array
    {
        return ['allowed' => false, 'reason' => $reason];
    }
}
