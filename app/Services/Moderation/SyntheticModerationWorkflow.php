<?php

declare(strict_types=1);

namespace App\Services\Moderation;

use App\Authorization\ScopedAuthorization;
use App\Models\ModerationAppeal;
use App\Models\ModerationCase;
use App\Models\ModerationEvent;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final class SyntheticModerationWorkflow
{
    private const CATEGORIES = [
        'harassment',
        'personal_data',
        'threat',
        'impersonation',
        'spam',
        'other',
    ];

    private const CASE_OUTCOMES = ['actioned', 'rejected', 'escalated'];

    private const CASE_REASONS = [
        'policy_violation',
        'insufficient_context',
        'not_actionable',
        'safety_escalation',
    ];

    private const APPEAL_OUTCOMES = ['upheld', 'reversed', 'dismissed'];

    private const APPEAL_REASONS = [
        'appeal_upheld',
        'appeal_reversed',
        'appeal_dismissed',
    ];

    public function __construct(private readonly ScopedAuthorization $authorization)
    {}

    /**
     * Internal test-fixture entry point only. It accepts a synthetic reference,
     * never report text, attachments, identity documents or arbitrary payloads.
     */
    public function createSyntheticCase(
        User $reporter,
        string $scopeId,
        string $category,
        string $syntheticReference,
    ): ModerationCase {
        if ($reporter->is_active !== true || trim($scopeId) === '' || mb_strlen($scopeId) > 120
            || in_array($category, self::CATEGORIES, true) === false
            || $this->isSyntheticReference($syntheticReference) === false) {
            throw new InvalidArgumentException('A valid synthetic moderation fixture is required.');
        }

        return DB::transaction(function () use ($reporter, $scopeId, $category, $syntheticReference): ModerationCase {
            $case = ModerationCase::query()->create([
                'scope_type' => 'review',
                'scope_id' => $scopeId,
                'category' => $category,
                'status' => 'pending',
                'reporter_user_id' => $reporter->getKey(),
                'synthetic_reference' => $syntheticReference,
            ]);

            $this->record($case, null, $reporter, 'case.created', null, 'pending', null);

            return $case;
        });
    }

    public function startReview(User $moderator, ModerationCase $case): ModerationCase
    {
        $this->assertModerator($moderator, 'ugc.moderate', $case);

        return DB::transaction(function () use ($moderator, $case): ModerationCase {
            $locked = ModerationCase::query()->whereKey($case->getKey())->lockForUpdate()->firstOrFail();

            if ($locked->status !== 'pending' || (int) $locked->reporter_user_id === (int) $moderator->getKey()) {
                throw new AuthorizationException('The case is not eligible for independent moderation.');
            }

            $locked->forceFill(['status' => 'in_review', 'reviewer_user_id' => $moderator->getKey()])->save();
            $this->record($locked, null, $moderator, 'case.review_started', 'pending', 'in_review', null);

            return $locked->refresh();
        });
    }

    public function resolveCase(
        User $moderator,
        ModerationCase $case,
        string $outcome,
        string $reasonCode,
    ): ModerationCase {
        $this->assertModerator($moderator, 'ugc.moderate', $case);

        if (in_array($outcome, self::CASE_OUTCOMES, true) === false
            || in_array($reasonCode, self::CASE_REASONS, true) === false) {
            throw new InvalidArgumentException('Unsupported moderation outcome or reason code.');
        }

        return DB::transaction(function () use ($moderator, $case, $outcome, $reasonCode): ModerationCase {
            $locked = ModerationCase::query()->whereKey($case->getKey())->lockForUpdate()->firstOrFail();

            if ($locked->status !== 'in_review' || (int) $locked->reviewer_user_id !== (int) $moderator->getKey()) {
                throw new AuthorizationException('Only the assigned independent moderator may resolve this case.');
            }

            $locked->forceFill([
                'status' => $outcome,
                'outcome_code' => $outcome,
                'reason_code' => $reasonCode,
            ])->save();
            $this->record($locked, null, $moderator, 'case.resolved', 'in_review', $outcome, $reasonCode);

            return $locked->refresh();
        });
    }

    public function fileSyntheticAppeal(
        User $appellant,
        ModerationCase $case,
        string $syntheticReference,
    ): ModerationAppeal {
        if ($this->isSyntheticReference($syntheticReference) === false) {
            throw new InvalidArgumentException('A synthetic appeal reference is required.');
        }

        return DB::transaction(function () use ($appellant, $case, $syntheticReference): ModerationAppeal {
            $locked = ModerationCase::query()->whereKey($case->getKey())->lockForUpdate()->firstOrFail();

            if ($appellant->is_active !== true || (int) $locked->reporter_user_id !== (int) $appellant->getKey()
                || in_array($locked->status, ['actioned', 'rejected'], true) === false
                || $locked->appeal()->exists()) {
                throw new AuthorizationException('The synthetic case is not eligible for an appeal by this account.');
            }

            $appeal = ModerationAppeal::query()->create([
                'moderation_case_id' => $locked->getKey(),
                'appellant_user_id' => $appellant->getKey(),
                'status' => 'submitted',
                'synthetic_reference' => $syntheticReference,
            ]);
            $this->record($locked, $appeal, $appellant, 'appeal.submitted', null, 'submitted', null);

            return $appeal;
        });
    }

    public function reviewAppeal(
        User $appealReviewer,
        ModerationAppeal $appeal,
        string $outcome,
        string $reasonCode,
    ): ModerationAppeal {
        $case = $appeal->moderationCase;
        if ($case === null) {
            throw new AuthorizationException('The appeal has no moderation case.');
        }

        $this->assertModerator($appealReviewer, 'ugc.appeal.review', $case);

        if (in_array($outcome, self::APPEAL_OUTCOMES, true) === false
            || in_array($reasonCode, self::APPEAL_REASONS, true) === false) {
            throw new InvalidArgumentException('Unsupported appeal outcome or reason code.');
        }

        return DB::transaction(function () use ($appealReviewer, $appeal, $outcome, $reasonCode): ModerationAppeal {
            $lockedAppeal = ModerationAppeal::query()->whereKey($appeal->getKey())->lockForUpdate()->firstOrFail();
            $lockedCase = ModerationCase::query()->whereKey($lockedAppeal->moderation_case_id)->lockForUpdate()->firstOrFail();

            if ($lockedAppeal->status !== 'submitted'
                || (int) $lockedAppeal->appellant_user_id === (int) $appealReviewer->getKey()
                || (int) $lockedAppeal->appellant_user_id === (int) $lockedCase->reviewer_user_id
                || (int) $lockedCase->reviewer_user_id === (int) $appealReviewer->getKey()) {
                throw new AuthorizationException('Appeal review requires a distinct independent reviewer.');
            }

            $lockedAppeal->forceFill([
                'status' => $outcome,
                'reviewer_user_id' => $appealReviewer->getKey(),
                'outcome_code' => $outcome,
                'reason_code' => $reasonCode,
            ])->save();

            $caseFrom = $lockedCase->status;
            $caseTo = 'appeal_'.$outcome;
            $lockedCase->forceFill(['status' => $caseTo])->save();
            $this->record($lockedCase, $lockedAppeal, $appealReviewer, 'appeal.reviewed', $caseFrom, $caseTo, $reasonCode);

            return $lockedAppeal->refresh();
        });
    }

    private function assertModerator(User $actor, string $action, ModerationCase $case): void
    {
        if ($this->authorization->allows($actor, $action, 'review', $case->scope_id) === false) {
            throw new AuthorizationException('The requested moderation action is outside the actor scope.');
        }
    }

    private function isSyntheticReference(string $reference): bool
    {
        return str_starts_with($reference, 'synthetic:')
            && mb_strlen($reference) <= 80
            && preg_match('/^synthetic:[a-zA-Z0-9._:-]+$/', $reference) === 1;
    }

    private function record(
        ModerationCase $case,
        ?ModerationAppeal $appeal,
        User $actor,
        string $event,
        ?string $from,
        string $to,
        ?string $reason,
    ): void {
        ModerationEvent::query()->create([
            'moderation_case_id' => $case->getKey(),
            'moderation_appeal_id' => $appeal?->getKey(),
            'actor_user_id' => $actor->getKey(),
            'event_type' => $event,
            'from_state' => $from,
            'to_state' => $to,
            'reason_code' => $reason,
            'created_at' => now(),
        ]);
    }
}
