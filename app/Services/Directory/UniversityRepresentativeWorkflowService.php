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
        $claim = DB::table('claim_versions')
            ->join('claims', 'claims.id', '=', 'claim_versions.claim_id')
            ->join('directory_entities', 'directory_entities.id', '=', 'claims.subject_entity_id')
            ->where('claim_versions.id', $claimVersionId)
            ->first(['claims.subject_entity_id', 'directory_entities.entity_type', 'claim_versions.value']);

        if ($claim === null) {
            return false;
        }
        if ((string) $claim->subject_entity_id === $institutionId) {
            return true;
        }
        if (! in_array($claim->entity_type, ['campus', 'delivery_site'], true)) {
            return false;
        }

        $table = $claim->entity_type === 'campus' ? 'directory_campuses' : 'directory_delivery_sites';
        $projection = DB::table($table)->where('entity_id', $claim->subject_entity_id)->first(['institution_entity_id']);
        $value = json_decode((string) $claim->value, true);
        $parentId = $projection === null
            ? (is_array($value) ? ($value['institution_entity_id'] ?? null) : null)
            : (string) $projection->institution_entity_id;

        return $parentId === $institutionId && is_array($value) && ($value['institution_entity_id'] ?? null) === $institutionId;
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

            $subjectEntityId = (string) DB::table('claims')
                ->join('claim_versions', 'claim_versions.claim_id', '=', 'claims.id')
                ->where('claim_versions.id', $claimVersionId)
                ->value('claims.subject_entity_id');

            $returnedCase = DB::table('editorial_review_cases')
                ->where('entity_id', $subjectEntityId)
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
