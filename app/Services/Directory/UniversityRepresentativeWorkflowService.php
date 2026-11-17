<?php

declare(strict_types=1);

namespace App\Services\Directory;

use Illuminate\Support\Facades\DB;

final class UniversityRepresentativeWorkflowService
{
    public function __construct(
        private readonly FieldDefinitionRegistryReader $registry,
        private readonly FieldAwareClaimCorrectionService $corrections,
        private readonly EditorialReviewService $editorial,
    ) {}

    public function isUniversityInstitution(string $institutionId): bool
    {
        $exists = DB::table('directory_entities')
            ->where('id', $institutionId)
            ->where('entity_type', 'institution')
            ->exists();

        return $exists && $this->registry->providerCategoryForEntity($institutionId) === 'university';
    }

    public function claimVersionBelongsToInstitution(string $claimVersionId, string $institutionId): bool
    {
        return DB::table('claim_versions')
            ->join('claims', 'claims.id', '=', 'claim_versions.claim_id')
            ->where('claim_versions.id', $claimVersionId)
            ->where('claims.subject_entity_id', $institutionId)
            ->exists();
    }

    public function editorialCaseBelongsToInstitution(string $caseId, string $institutionId): bool
    {
        return DB::table('editorial_review_cases')
            ->where('id', $caseId)
            ->where('entity_id', $institutionId)
            ->exists();
    }

    public function correctReturnedProposal(
        array $actor,
        string $institutionId,
        string $claimVersionId,
        mixed $value,
        array $evidenceReferenceIds,
        array $sourceContext,
        string $correctionKey,
        string $validFrom,
        ?string $validTo,
        string $reasonCode,
        string $rationale,
        string $correctionCloseKey,
    ): ?array {
        return DB::transaction(function () use (
            $actor,
            $institutionId,
            $claimVersionId,
            $value,
            $evidenceReferenceIds,
            $sourceContext,
            $correctionKey,
            $validFrom,
            $validTo,
            $reasonCode,
            $rationale,
            $correctionCloseKey,
        ): ?array {
            if ($this->claimVersionBelongsToInstitution($claimVersionId, $institutionId) === false) {
                return null;
            }

            $returnedCase = DB::table('editorial_review_cases')
                ->where('entity_id', $institutionId)
                ->where('claim_version_id', $claimVersionId)
                ->where('submitted_by_actor_id', $actor['actor_id'])
                ->whereIn('status', ['changes_requested', 'superseded'])
                ->first(['id']);

            if ($returnedCase === null) {
                return null;
            }

            $result = $this->corrections->correct(
                $actor,
                $claimVersionId,
                $value,
                $evidenceReferenceIds,
                $sourceContext,
                $correctionKey,
                $validFrom,
                $validTo,
                $reasonCode,
                $rationale,
            );

            $this->editorial->supersedeAfterCorrection(
                $actor,
                (string) $returnedCase->id,
                $result['claim_version_id'],
                $correctionCloseKey,
            );

            return $result;
        });
    }
}
