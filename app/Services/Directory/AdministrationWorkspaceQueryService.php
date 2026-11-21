<?php

declare(strict_types=1);

namespace App\Services\Directory;

use Illuminate\Support\Facades\DB;

final class AdministrationWorkspaceQueryService
{
    public function eligibleUniversityInstitutionIds(array $scopeIds): array
    {
        if ($scopeIds === []) {
            return [];
        }

        return DB::table('directory_entities')
            ->join('directory_provider_category_assignments', 'directory_provider_category_assignments.entity_id', '=', 'directory_entities.id')
            ->whereIn('directory_entities.id', $scopeIds)
            ->where('directory_entities.entity_type', 'institution')
            ->where('directory_provider_category_assignments.provider_category', 'university')
            ->pluck('directory_entities.id')
            ->map(static fn ($id): string => (string) $id)
            ->all();
    }

    public function representativeSubmissions(array $institutionIds, string $actorId): array
    {
        if ($institutionIds === []) {
            return [];
        }

        return DB::table('editorial_review_cases as cases')
            ->join('directory_entities as entities', 'entities.id', '=', 'cases.entity_id')
            ->join('claim_versions as versions', 'versions.id', '=', 'cases.claim_version_id')
            ->join('claims', 'claims.id', '=', 'versions.claim_id')
            ->whereIn('cases.entity_id', $institutionIds)
            ->where('cases.submitted_by_actor_id', $actorId)
            ->orderByDesc('cases.created_at')
            ->limit(50)
            ->get([
                'cases.id',
                'cases.entity_id',
                'entities.label as institution_name',
                'claims.predicate',
                'versions.version_number',
                'cases.status',
                'cases.created_at',
            ])
            ->map(static fn ($row): array => [
                'case_id' => (string) $row->id,
                'institution_id' => (string) $row->entity_id,
                'institution_name' => (string) $row->institution_name,
                'predicate' => (string) $row->predicate,
                'version_number' => (int) $row->version_number,
                'status' => (string) $row->status,
                'created_at' => (string) $row->created_at,
            ])
            ->all();
    }

    public function reviewQueue(array $institutionIds, string $actorId): array
    {
        if ($institutionIds === []) {
            return [];
        }

        $cases = DB::table('editorial_review_cases as cases')
            ->join('directory_entities as entities', 'entities.id', '=', 'cases.entity_id')
            ->join('claim_versions as versions', 'versions.id', '=', 'cases.claim_version_id')
            ->join('claims', 'claims.id', '=', 'versions.claim_id')
            ->whereIn('cases.entity_id', $institutionIds)
            ->where('cases.status', 'submitted')
            ->where('cases.submitted_by_actor_id', '!=', $actorId)
            ->orderBy('cases.created_at')
            ->limit(100)
            ->get([
                'cases.id',
                'cases.entity_id',
                'entities.label as institution_name',
                'claims.predicate',
                'versions.id as claim_version_id',
                'versions.version_number',
                'cases.created_at',
            ]);

        $queue = [];
        foreach ($cases as $case) {
            if ($this->isEvidenceContributor((string) $case->claim_version_id, $actorId)) {
                continue;
            }

            $queue[] = [
                'case_id' => (string) $case->id,
                'institution_id' => (string) $case->entity_id,
                'institution_name' => (string) $case->institution_name,
                'predicate' => (string) $case->predicate,
                'version_number' => (int) $case->version_number,
                'status' => 'submitted',
                'created_at' => (string) $case->created_at,
            ];
        }

        return $queue;
    }

    /**
     * Return a reviewer-safe case projection. Evidence bodies, URLs, integrity
     * digests, authorization scopes and private actor identifiers are excluded.
     */
    public function editorialCaseDetails(string $caseId, string $actorId): ?array
    {
        $case = DB::table('editorial_review_cases as cases')
            ->join('directory_entities as entities', 'entities.id', '=', 'cases.entity_id')
            ->join('claim_versions as versions', 'versions.id', '=', 'cases.claim_version_id')
            ->join('claims', 'claims.id', '=', 'versions.claim_id')
            ->where('cases.id', $caseId)
            ->first([
                'cases.id',
                'cases.entity_id',
                'entities.label as entity_label',
                'entities.entity_type',
                'cases.status',
                'cases.submitted_by_actor_id',
                'cases.reviewer_actor_id',
                'cases.created_at',
                'cases.updated_at',
                'claims.predicate',
                'versions.id as claim_version_id',
                'versions.version_number',
                'versions.value',
                'versions.valid_from',
                'versions.valid_to',
                'versions.disposition',
                'versions.supersedes_version_id',
            ]);

        if ($case === null || ! in_array($case->status, ['submitted', 'in_review'], true)
            || $case->submitted_by_actor_id === $actorId
            || ($case->status === 'in_review' && $case->reviewer_actor_id !== $actorId)
            || $this->isEvidenceContributor((string) $case->claim_version_id, $actorId)) {
            return null;
        }

        $evidence = DB::table('claim_evidence_links as links')
            ->join('evidence_references as refs', 'refs.id', '=', 'links.evidence_reference_id')
            ->join('source_authorizations as authorizations', 'authorizations.id', '=', 'refs.source_authorization_id')
            ->where('links.claim_version_id', $case->claim_version_id)
            ->orderBy('refs.recorded_at')
            ->get([
                'refs.id',
                'refs.reference_kind',
                'refs.source_type',
                'refs.status as evidence_status',
                'refs.content_included',
                'refs.observed_at',
                'refs.recorded_at',
                'authorizations.status as authorization_status',
                'authorizations.valid_from as authorization_valid_from',
                'authorizations.valid_to as authorization_valid_to',
                'authorizations.revoked_at as authorization_revoked_at',
                'links.relationship_type',
            ])
            ->map(static fn ($row): array => [
                'reference_id' => (string) $row->id,
                'reference_kind' => (string) $row->reference_kind,
                'source_type' => (string) $row->source_type,
                'evidence_status' => (string) $row->evidence_status,
                'content_included' => (bool) $row->content_included,
                'observed_at' => $row->observed_at === null ? null : (string) $row->observed_at,
                'recorded_at' => (string) $row->recorded_at,
                'authorization_status' => (string) $row->authorization_status,
                'authorization_valid_from' => $row->authorization_valid_from === null ? null : (string) $row->authorization_valid_from,
                'authorization_valid_to' => $row->authorization_valid_to === null ? null : (string) $row->authorization_valid_to,
                'authorization_revoked' => $row->authorization_revoked_at !== null,
                'relationship_type' => (string) $row->relationship_type,
            ])
            ->all();

        $correctionHistory = [];
        $previousVersionId = $case->supersedes_version_id;
        $visitedVersions = [];
        while ($previousVersionId !== null && count($correctionHistory) < 10
            && ! in_array((string) $previousVersionId, $visitedVersions, true)) {
            $visitedVersions[] = (string) $previousVersionId;
            $previous = DB::table('claim_versions as versions')
                ->leftJoin('editorial_review_cases as prior_cases', 'prior_cases.claim_version_id', '=', 'versions.id')
                ->where('versions.id', $previousVersionId)
                ->orderByDesc('prior_cases.created_at')
                ->first([
                    'versions.id',
                    'versions.version_number',
                    'versions.disposition',
                    'versions.supersedes_version_id',
                    'prior_cases.id as case_id',
                    'prior_cases.status as case_status',
                    'prior_cases.created_at as case_created_at',
                ]);
            if ($previous === null) {
                break;
            }
            $correctionHistory[] = [
                'claim_version_id' => (string) $previous->id,
                'version_number' => (int) $previous->version_number,
                'disposition' => (string) $previous->disposition,
                'case_id' => $previous->case_id === null ? null : (string) $previous->case_id,
                'case_status' => $previous->case_status === null ? null : (string) $previous->case_status,
                'case_created_at' => $previous->case_created_at === null ? null : (string) $previous->case_created_at,
            ];
            $previousVersionId = $previous->supersedes_version_id;
        }

        $history = DB::table('directory_status_history')
            ->where('editorial_review_case_id', $caseId)
            ->orderBy('occurred_at')
            ->get(['event_type', 'previous_status', 'new_status', 'actor_class', 'reason_code', 'occurred_at'])
            ->map(static fn ($row): array => [
                'event_type' => (string) $row->event_type,
                'previous_status' => $row->previous_status === null ? null : (string) $row->previous_status,
                'new_status' => (string) $row->new_status,
                'actor_class' => (string) $row->actor_class,
                'reason_code' => (string) $row->reason_code,
                'occurred_at' => (string) $row->occurred_at,
            ])
            ->all();

        return [
            'case_id' => (string) $case->id,
            'entity_id' => (string) $case->entity_id,
            'entity_label' => (string) $case->entity_label,
            'entity_type' => (string) $case->entity_type,
            'status' => (string) $case->status,
            'predicate' => (string) $case->predicate,
            'claim_version_id' => (string) $case->claim_version_id,
            'version_number' => (int) $case->version_number,
            'proposed_value' => json_decode((string) $case->value, true),
            'valid_from' => $case->valid_from === null ? null : (string) $case->valid_from,
            'valid_to' => $case->valid_to === null ? null : (string) $case->valid_to,
            'disposition' => (string) $case->disposition,
            'submitted_at' => (string) $case->created_at,
            'updated_at' => (string) $case->updated_at,
            'evidence' => $evidence,
            'history' => $history,
            'correction_history' => $correctionHistory,
        ];
    }

    private function isEvidenceContributor(string $claimVersionId, string $actorId): bool
    {
        $evidenceIds = DB::table('claim_evidence_links')
            ->where('claim_version_id', $claimVersionId)
            ->pluck('evidence_reference_id');

        foreach ($evidenceIds as $evidenceId) {
            $event = DB::table('audit_events')
                ->where('target_type', 'evidence_reference')
                ->where('target_id', $evidenceId)
                ->where('action', 'evidence_reference_registered')
                ->first(['metadata']);

            $metadata = $event === null ? [] : (json_decode((string) $event->metadata, true) ?: []);
            if (($metadata['actor_id'] ?? null) === $actorId) {
                return true;
            }
        }

        return false;
    }
}
