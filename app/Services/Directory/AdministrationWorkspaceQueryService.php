<?php

declare(strict_types=1);

namespace App\Services\Directory;

use Illuminate\Support\Facades\DB;

final class AdministrationWorkspaceQueryService
{
    /**
     * @param  array<int, string>  $scopeIds
     * @return array<int, string>
     */
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

    /**
     * @param  array<int, string>  $institutionIds
     * @return array<int, array<string, mixed>>
     */
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

    /**
     * @param array<int, string> $institutionIds
     * @return array<int, array<string, mixed>>
     */
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
