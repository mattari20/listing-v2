<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Authorization\ScopedAuthorization;
use App\Models\RoleAssignment;
use App\Models\User;
use App\Services\Moderation\SyntheticModerationWorkflow;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

final class SyntheticModerationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_synthetic_case_is_metadata_only_and_records_an_auditable_lifecycle(): void
    {
        $reporter = $this->makeUser('reporter@example.test');
        $moderator = $this->makeUser('moderator@example.test');
        $this->assignModerator($moderator, 'synthetic-review-01');
        $service = app(SyntheticModerationWorkflow::class);

        $case = $service->createSyntheticCase($reporter, 'synthetic-review-01', 'spam', 'synthetic:case-001');
        $service->startReview($moderator, $case);
        $resolved = $service->resolveCase($moderator, $case, 'actioned', 'policy_violation');

        $this->assertSame('actioned', $resolved->status);
        $this->assertSame('synthetic:case-001', $resolved->synthetic_reference);
        $this->assertDatabaseCount('moderation_events', 3);
        $this->assertDatabaseHas('moderation_events', [
            'moderation_case_id' => $case->getKey(),
            'event_type' => 'case.resolved',
            'from_state' => 'in_review',
            'to_state' => 'actioned',
            'reason_code' => 'policy_violation',
        ]);
    }

    public function test_moderator_must_have_exact_scope_and_cannot_moderate_own_case(): void
    {
        $reporter = $this->makeUser('scope-reporter@example.test');
        $case = app(SyntheticModerationWorkflow::class)->createSyntheticCase(
            $reporter, 'scope-a', 'harassment', 'synthetic:scope-001'
        );
        $wrongScope = $this->makeUser('wrong-scope@example.test');
        $this->assignModerator($wrongScope, 'scope-b');

        try {
            app(SyntheticModerationWorkflow::class)->startReview($wrongScope, $case);
            $this->fail('A moderator assigned to another scope must be denied.');
        } catch (AuthorizationException) {
            $this->assertTrue(true);
        }

        $selfModerator = $this->makeUser('self-moderator@example.test');
        $this->assignModerator($selfModerator, 'scope-a');
        $selfCase = app(SyntheticModerationWorkflow::class)->createSyntheticCase(
            $selfModerator, 'scope-a', 'spam', 'synthetic:self-001'
        );

        $this->expectException(AuthorizationException::class);
        app(SyntheticModerationWorkflow::class)->startReview($selfModerator, $selfCase);
    }

    public function test_only_the_assigned_moderator_can_resolve_and_duplicate_transition_is_denied(): void
    {
        $reporter = $this->makeUser('assigned-reporter@example.test');
        $first = $this->makeUser('assigned-moderator@example.test');
        $second = $this->makeUser('other-moderator@example.test');
        $this->assignModerator($first, 'assigned-scope');
        $this->assignModerator($second, 'assigned-scope');
        $service = app(SyntheticModerationWorkflow::class);
        $case = $service->createSyntheticCase($reporter, 'assigned-scope', 'other', 'synthetic:assigned-001');
        $service->startReview($first, $case);

        try {
            $service->resolveCase($second, $case, 'rejected', 'not_actionable');
            $this->fail('An unassigned moderator must not resolve the case.');
        } catch (AuthorizationException) {
            $this->assertTrue(true);
        }

        $service->resolveCase($first, $case, 'rejected', 'not_actionable');

        $this->expectException(AuthorizationException::class);
        $service->resolveCase($first, $case, 'actioned', 'policy_violation');
    }

    public function test_appeal_is_available_only_to_reporter_and_requires_an_independent_reviewer(): void
    {
        $reporter = $this->makeUser('appeal-reporter@example.test');
        $moderator = $this->makeUser('appeal-moderator@example.test');
        $appealReviewer = $this->makeUser('appeal-reviewer@example.test');
        $this->assignModerator($moderator, 'appeal-scope');
        $this->assignModerator($appealReviewer, 'appeal-scope');
        $service = app(SyntheticModerationWorkflow::class);
        $case = $service->createSyntheticCase($reporter, 'appeal-scope', 'personal_data', 'synthetic:appeal-001');
        $service->startReview($moderator, $case);
        $service->resolveCase($moderator, $case, 'actioned', 'policy_violation');

        $appeal = $service->fileSyntheticAppeal($reporter, $case, 'synthetic:appeal-001-a');

        try {
            $service->reviewAppeal($moderator, $appeal, 'upheld', 'appeal_upheld');
            $this->fail('The original moderator cannot review the appeal.');
        } catch (AuthorizationException) {
            $this->assertTrue(true);
        }

        $reviewed = $service->reviewAppeal($appealReviewer, $appeal, 'reversed', 'appeal_reversed');

        $this->assertSame('reversed', $reviewed->status);
        $this->assertSame('appeal_reversed', $case->fresh()->status);
        $this->assertDatabaseHas('moderation_events', [
            'moderation_case_id' => $case->getKey(),
            'event_type' => 'appeal.reviewed',
            'to_state' => 'appeal_reversed',
            'reason_code' => 'appeal_reversed',
        ]);
    }

    public function test_appeal_cannot_be_filed_by_another_account_or_twice(): void
    {
        $reporter = $this->makeUser('appeal-owner@example.test');
        $other = $this->makeUser('appeal-other@example.test');
        $moderator = $this->makeUser('appeal-owner-moderator@example.test');
        $this->assignModerator($moderator, 'appeal-owner-scope');
        $service = app(SyntheticModerationWorkflow::class);
        $case = $service->createSyntheticCase($reporter, 'appeal-owner-scope', 'spam', 'synthetic:appeal-owner-001');
        $service->startReview($moderator, $case);
        $service->resolveCase($moderator, $case, 'rejected', 'not_actionable');

        try {
            $service->fileSyntheticAppeal($other, $case, 'synthetic:appeal-owner-other');
            $this->fail('An unrelated account cannot appeal the synthetic case.');
        } catch (AuthorizationException) {
            $this->assertTrue(true);
        }

        $service->fileSyntheticAppeal($reporter, $case, 'synthetic:appeal-owner-valid');

        $this->expectException(AuthorizationException::class);
        $service->fileSyntheticAppeal($reporter, $case, 'synthetic:appeal-owner-duplicate');
    }

    public function test_appeal_reviewer_cannot_be_the_appellant_or_original_moderator(): void
    {
        $reporter = $this->makeUser('independent-reporter@example.test');
        $moderator = $this->makeUser('independent-moderator@example.test');
        $this->assignModerator($moderator, 'independent-scope');
        $service = app(SyntheticModerationWorkflow::class);
        $case = $service->createSyntheticCase($reporter, 'independent-scope', 'threat', 'synthetic:independent-001');
        $service->startReview($moderator, $case);
        $service->resolveCase($moderator, $case, 'actioned', 'safety_escalation');
        $appeal = $service->fileSyntheticAppeal($reporter, $case, 'synthetic:independent-appeal');

        $this->expectException(AuthorizationException::class);
        $service->reviewAppeal($reporter, $appeal, 'dismissed', 'appeal_dismissed');
    }

    public function test_non_synthetic_input_unknown_categories_and_outcomes_fail_closed(): void
    {
        $reporter = $this->makeUser('invalid-reporter@example.test');
        $service = app(SyntheticModerationWorkflow::class);

        try {
            $service->createSyntheticCase($reporter, 'scope', 'spam', 'real-report-001');
            $this->fail('Non-synthetic references must be rejected.');
        } catch (InvalidArgumentException) {
            $this->assertTrue(true);
        }

        $this->expectException(InvalidArgumentException::class);
        $service->createSyntheticCase($reporter, 'scope', 'unknown-category', 'synthetic:invalid-001');
    }

    public function test_moderation_roles_do_not_grant_directory_publication_or_administration(): void
    {
        $moderator = $this->makeUser('capability-moderator@example.test');
        $this->assignModerator($moderator, 'capability-scope');
        $authorization = app(ScopedAuthorization::class);

        $this->assertTrue($authorization->allows($moderator, 'ugc.moderate', 'review', 'capability-scope'));
        $this->assertTrue($authorization->allows($moderator, 'ugc.appeal.review', 'review', 'capability-scope'));
        $this->assertFalse($authorization->allows($moderator, 'institution.publish', 'institution', 'capability-scope'));
        $this->assertFalse($authorization->allows($moderator, 'roles.manage', 'user', '1'));
    }

    public function test_inactive_moderator_cannot_start_a_synthetic_case_review(): void
    {
        $reporter = $this->makeUser('inactive-reporter@example.test');
        $moderator = $this->makeUser('inactive-moderator@example.test');
        $this->assignModerator($moderator, 'inactive-scope');
        $moderator->forceFill(['is_active' => false])->save();
        $case = app(SyntheticModerationWorkflow::class)->createSyntheticCase(
            $reporter, 'inactive-scope', 'spam', 'synthetic:inactive-001'
        );

        $this->expectException(AuthorizationException::class);
        app(SyntheticModerationWorkflow::class)->startReview($moderator, $case);
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

    private function assignModerator(User $user, string $scopeId): RoleAssignment
    {
        return RoleAssignment::query()->create([
            'user_id' => $user->getKey(),
            'role' => 'moderator',
            'scope_type' => 'review',
            'scope_id' => $scopeId,
        ]);
    }
}
