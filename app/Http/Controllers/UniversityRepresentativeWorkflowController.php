<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Authorization\ScopedAuthorization;
use App\Models\User;
use App\Services\Directory\EditorialReviewService;
use App\Services\Directory\FieldAwareClaimCorrectionService;
use App\Services\Directory\FieldAwareClaimProposalService;
use App\Services\Directory\FieldDefinitionRegistryReader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class UniversityRepresentativeWorkflowController extends Controller
{
    public function __construct(
        private readonly ScopedAuthorization $authorization,
        private readonly FieldDefinitionRegistryReader $registry,
        private readonly FieldAwareClaimProposalService $proposals,
        private readonly FieldAwareClaimCorrectionService $corrections,
        private readonly EditorialReviewService $editorial,
    ) {}

    public function store(Request $request, string $institution): JsonResponse
    {
        $this->assertUniversityInstitution($institution);
        $actor = $this->authorizedActor(
            $request,
            $institution,
            'institution.claim.submit',
            ['propose_field_value', 'submit_directory_proposal'],
        );

        $validated = $request->validate([
            'field_key' => ['required', 'string', 'max:120'],
            'definition_version' => ['required', 'integer', 'min:1'],
            'value' => ['required'],
            'evidence_reference_ids' => ['required', 'array', 'min:1', 'max:20'],
            'evidence_reference_ids.*' => ['required', 'uuid', 'distinct'],
            'idempotency_key' => ['required', 'string', 'max:100'],
            'valid_from' => ['nullable', 'date_format:Y-m-d'],
            'valid_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:valid_from'],
        ]);

        $result = $this->proposals->propose(
            $actor,
            $institution,
            $validated['field_key'],
            (int) $validated['definition_version'],
            $validated['value'],
            $validated['evidence_reference_ids'],
            $this->syntheticSourceContext(),
            'institution',
            $this->scopedIdempotencyKey('proposal', $request->user(), $validated['idempotency_key']),
            [],
            $validated['valid_from'] ?? null,
            $validated['valid_to'] ?? null,
        );

        return response()->json([
            'status' => 'submitted_for_editorial_review',
            'claim_id' => $result['claim_id'],
            'claim_version_id' => $result['claim_version_id'],
            'editorial_review_case_id' => $result['editorial_review_case_id'],
        ], 201);
    }

    public function correct(Request $request, string $institution, string $claimVersion): JsonResponse
    {
        $this->assertUniversityInstitution($institution);
        $actor = $this->authorizedActor(
            $request,
            $institution,
            'institution.claim.correct',
            ['correct_claim', 'submit_directory_proposal', 'edit_directory_proposal'],
        );

        $prior = DB::table('claim_versions')
            ->join('claims', 'claims.id', '=', 'claim_versions.claim_id')
            ->where('claim_versions.id', $claimVersion)
            ->where('claims.subject_entity_id', $institution)
            ->first(['claim_versions.id']);

        abort_if($prior === null, 404);

        $validated = $request->validate([
            'value' => ['required'],
            'evidence_reference_ids' => ['required', 'array', 'min:1', 'max:20'],
            'evidence_reference_ids.*' => ['required', 'uuid', 'distinct'],
            'idempotency_key' => ['required', 'string', 'max:100'],
            'valid_from' => ['required', 'date_format:Y-m-d'],
            'valid_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:valid_from'],
            'reason_code' => ['required', 'in:synthetic_value_correction'],
            'rationale' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $returnedCase = DB::table('editorial_review_cases')
            ->where('entity_id', $institution)
            ->where('claim_version_id', $claimVersion)
            ->where('submitted_by_actor_id', $actor['actor_id'])
            ->whereIn('status', ['changes_requested', 'superseded'])
            ->first(['id']);
        abort_if($returnedCase === null, 409);

        $result = DB::transaction(function () use ($actor, $claimVersion, $validated, $institution, $request, $returnedCase): array {
            $result = $this->corrections->correct(
            $actor,
            $claimVersion,
            $validated['value'],
            $validated['evidence_reference_ids'],
            $this->syntheticSourceContext(),
            $this->scopedIdempotencyKey('correction', $request->user(), $validated['idempotency_key']),
            $validated['valid_from'],
            $validated['valid_to'] ?? null,
            $validated['reason_code'],
            $validated['rationale'],
            );
            $this->editorial->supersedeAfterCorrection(
                $actor,
                (string) $returnedCase->id,
                $result['claim_version_id'],
                $this->scopedIdempotencyKey('correction-close', $request->user(), $validated['idempotency_key']),
            );

            return $result;
        });

        return response()->json([
            'status' => 'corrected_successor_submitted_for_editorial_review',
            'claim_id' => $result['claim_id'],
            'claim_version_id' => $result['claim_version_id'],
            'editorial_review_case_id' => $result['editorial_review_case_id'],
        ]);
    }

    public function startReview(Request $request, string $institution, string $case): JsonResponse
    {
        $this->assertUniversityInstitution($institution);
        $actor = $this->authorizedActor(
            $request,
            $institution,
            'claim.review',
            ['review_directory_proposal'],
        );
        $this->assertEditorialCaseBelongsToInstitution($case, $institution);

        $validated = $request->validate([
            'idempotency_key' => ['required', 'string', 'max:100'],
        ]);

        $this->editorial->startReview(
            $actor,
            $case,
            $this->scopedIdempotencyKey('review-start', $request->user(), $validated['idempotency_key']),
        );

        return response()->json(['status' => 'in_review']);
    }

    public function completeReview(Request $request, string $institution, string $case): JsonResponse
    {
        $this->assertUniversityInstitution($institution);
        $actor = $this->authorizedActor(
            $request,
            $institution,
            'claim.review',
            ['review_directory_proposal'],
        );
        $this->assertEditorialCaseBelongsToInstitution($case, $institution);

        $validated = $request->validate([
            'outcome' => ['required', 'in:ready_for_adjudication,changes_requested,held'],
            'reason_code' => ['required', 'string', 'max:80'],
            'rationale' => ['required', 'string', 'min:10', 'max:1000'],
            'idempotency_key' => ['required', 'string', 'max:100'],
        ]);

        $this->editorial->completeReview(
            $actor,
            $case,
            $validated['outcome'],
            $validated['reason_code'],
            $validated['rationale'],
            $this->scopedIdempotencyKey('review-complete', $request->user(), $validated['idempotency_key']),
        );

        return response()->json(['status' => $validated['outcome']]);
    }

    private function authorizedActor(Request $request, string $institution, string $action, array $capabilities): array
    {
        $user = $request->user();
        abort_unless($user instanceof User && $user->is_active && $user->email_verified_at !== null, 403);
        abort_unless($this->authorization->allows($user, $action, 'institution', $institution), 403);

        return [
            'actor_id' => 'user:'.$user->getKey(),
            'actor_class' => 'human',
            'capabilities' => $capabilities,
        ];
    }

    private function assertUniversityInstitution(string $institution): void
    {
        $exists = DB::table('directory_entities')
            ->where('id', $institution)
            ->where('entity_type', 'institution')
            ->exists();

        abort_unless($exists && $this->registry->providerCategoryForEntity($institution) === 'university', 404);
    }

    private function assertEditorialCaseBelongsToInstitution(string $case, string $institution): void
    {
        $exists = DB::table('editorial_review_cases')
            ->where('id', $case)
            ->where('entity_id', $institution)
            ->exists();

        abort_unless($exists, 404);
    }

    private function scopedIdempotencyKey(string $operation, User $user, string $key): string
    {
        return hash('sha256', $operation.':'.$user->getKey().':'.$key);
    }

    private function syntheticSourceContext(): array
    {
        return [
            'purpose' => 'synthetic_test_only',
            'method' => 'fixture_reference',
            'territory' => 'synthetic',
        ];
    }
}
