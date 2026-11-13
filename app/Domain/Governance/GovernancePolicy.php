<?php

declare(strict_types=1);

namespace App\Domain\Governance;

use Carbon\CarbonImmutable;

final class GovernancePolicy
{
    public function authorizeSourceAction(array $authorization, string $action, array $context, ?CarbonImmutable $now = null): array
    {
        $now ??= CarbonImmutable::now();

        if (($authorization['status'] ?? null) !== 'approved_for_defined_purpose_and_method') {
            return $this->deny('authorization_not_currently_approved');
        }
        if (empty($authorization['revoked_at']) === false) {
            return $this->deny('authorization_revoked');
        }
        if ($this->withinWindow($authorization, $now) === false) {
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
            if (is_string($requested) === false || $requested === '' || in_array($requested, $permitted, true) === false) {
                return $this->deny($contextKey.'_not_permitted');
            }
        }

        return ['allowed' => true, 'reason' => 'scope_permitted'];
    }

    public function requireCapability(array $actor, string $capability): array
    {
        if (($actor['actor_id'] ?? '') === '' || ($actor['actor_class'] ?? '') === '') {
            return $this->deny('actor_identity_missing');
        }
        if (in_array($capability, $actor['capabilities'] ?? [], true) === false) {
            return $this->deny('capability_missing');
        }

        return ['allowed' => true, 'reason' => 'capability_granted'];
    }

    public function authorizeAdjudication(array $actor, string $evidenceActorId, bool $highImpact = true): array
    {
        $capability = $this->requireCapability($actor, 'adjudicate_claim');
        if ($capability['allowed'] === false) {
            return $capability;
        }
        if (($actor['actor_class'] ?? null) !== 'human') {
            return $this->deny('automated_adjudication_prohibited');
        }
        if ($highImpact && ($actor['actor_id'] ?? null) === $evidenceActorId) {
            return $this->deny('evidence_submitter_cannot_adjudicate_high_impact_claim');
        }

        return ['allowed' => true, 'reason' => 'human_adjudication_permitted'];
    }

    public function evidenceCanSupportClaim(string $status): bool
    {
        return $status === 'eligible_for_review';
    }

    public function detectClaimConflict(array $claims): array
    {
        $values = [];
        foreach ($claims as $claim) {
            $values[json_encode($claim['value'] ?? null, JSON_THROW_ON_ERROR)] = true;
        }

        return ['conflict' => count($values) > 1, 'candidate_count' => count($claims)];
    }

    public function authorizePublication(array $actor, array $adjudication, array $evidenceActorIds): array
    {
        $capability = $this->requireCapability($actor, 'authorize_publication');
        if ($capability['allowed'] === false) {
            return $capability;
        }
        if (($actor['actor_class'] ?? null) !== 'human') {
            return $this->deny('automated_publication_prohibited');
        }
        if (($adjudication['outcome'] ?? null) !== 'accepted' || ($adjudication['claim_disposition'] ?? null) !== 'accepted') {
            return $this->deny('claim_not_human_accepted');
        }
        if (($adjudication['actor_id'] ?? '') === '' || ($actor['actor_id'] ?? '') === $adjudication['actor_id']) {
            return $this->deny('publication_requires_distinct_adjudicator');
        }
        if ($evidenceActorIds === [] || in_array($actor['actor_id'] ?? '', $evidenceActorIds, true)) {
            return $this->deny('evidence_submitter_cannot_publish_or_evidence_missing');
        }
        if (($adjudication['evidence_admissible'] ?? false) !== true || ($adjudication['version_current'] ?? false) !== true) {
            return $this->deny('evidence_or_claim_version_not_publishable');
        }
        if (($adjudication['surface'] ?? '') === '' || ($adjudication['audience'] ?? '') === '') {
            return $this->deny('publication_surface_and_audience_required');
        }
        if (($adjudication['policy_version'] ?? '') === '') {
            return $this->deny('policy_version_missing');
        }

        return ['allowed' => true, 'reason' => 'human_publication_permitted'];
    }

    public function authorizeRestore(array $actor, string $suppressorActorId, bool $snapshotApproved, bool $policyEligible): array
    {
        $capability = $this->requireCapability($actor, 'restore_publication');
        if ($capability['allowed'] === false) {
            return $capability;
        }
        if (($actor['actor_class'] ?? null) !== 'human') {
            return $this->deny('automated_restoration_prohibited');
        }
        if (($actor['actor_id'] ?? '') === $suppressorActorId) {
            return $this->deny('restoration_requires_distinct_suppressor');
        }
        if ($snapshotApproved === false || $policyEligible === false) {
            return $this->deny('snapshot_not_reapproved_by_current_policy');
        }

        return ['allowed' => true, 'reason' => 'restoration_permitted'];
    }

    public function authorizeEvidenceWithdrawal(array $actor, bool $retentionPolicyApproved): array
    {
        $capability = $this->requireCapability($actor, 'withdraw_evidence');
        if ($capability['allowed'] === false) {
            return $capability;
        }
        if (($actor['actor_class'] ?? null) !== 'human') {
            return $this->deny('human_evidence_withdrawal_required');
        }
        if ($retentionPolicyApproved === false) {
            return $this->deny('retention_policy_decision_missing');
        }

        return ['allowed' => true, 'reason' => 'evidence_withdrawal_permitted'];
    }

    public function authorizePublicRead(bool $approvedProjection): bool
    {
        return $approvedProjection;
    }

    /** Missing/unknown Deeni Madaris visibility defaults to OFF. */
    public function isPubliclyVisible(?bool $deeniMadarisEnabled, bool $isDeeniMadaris): bool
    {
        return $isDeeniMadaris === false || $deeniMadarisEnabled === true;
    }

    private function withinWindow(array $authorization, CarbonImmutable $now): bool
    {
        try {
            if (empty($authorization['valid_from']) === false && $now->lessThan(CarbonImmutable::parse($authorization['valid_from']))) {
                return false;
            }
            if (empty($authorization['valid_to']) === false && $now->lessThan(CarbonImmutable::parse($authorization['valid_to'])) === false) {
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
        if (is_string($value) === false) {
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
