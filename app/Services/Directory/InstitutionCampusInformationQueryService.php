<?php

declare(strict_types=1);

namespace App\Services\Directory;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;

final class InstitutionCampusInformationQueryService
{
    /**
     * Return only accepted, current campus and delivery-site projections for one institution.
     *
     * @return array{institution: array{id: string, label: string}, campuses: Collection, delivery_sites: Collection}
     */
    public function forInstitution(string $institutionId): array
    {
        $entity = DB::table('directory_entities')
            ->where('id', $institutionId)
            ->where('entity_type', 'institution')
            ->first(['id', 'label']);

        abort_if($entity === null, 404);

        $campuses = $this->currentLocations('directory_campuses', $institutionId);
        $deliverySites = $this->currentLocations('directory_delivery_sites', $institutionId);

        return [
            'institution' => ['id' => (string) $entity->id, 'label' => (string) $entity->label],
            'campuses' => $campuses,
            'delivery_sites' => $deliverySites,
        ];
    }

    private function currentLocations(string $table, string $institutionId): Collection
    {
        if (!in_array($table, ['directory_campuses', 'directory_delivery_sites'], true)) {
            throw new InvalidArgumentException('Unsupported institution location projection.');
        }

        return DB::table($table.' as locations')
            ->join('directory_entities as entities', 'entities.id', '=', 'locations.entity_id')
            ->join('claim_versions as versions', 'versions.id', '=', 'locations.claim_version_id')
            ->where('locations.institution_entity_id', $institutionId)
            ->where('locations.status', 'active')
            ->where('versions.disposition', 'accepted')
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('claim_versions as successor')
                    ->whereColumn('successor.supersedes_version_id', 'versions.id');
            })
            ->orderBy('entities.label')
            ->get([
                'entities.id',
                'entities.label',
                'locations.location_label',
                'locations.valid_from',
                'locations.valid_to',
            ]);
    }
}
