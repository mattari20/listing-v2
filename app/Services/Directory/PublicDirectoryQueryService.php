<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Governance\GovernancePolicy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class PublicDirectoryQueryService
{
    private const TYPE_LABELS = [
        'provider' => 'Provider',
        'institution' => 'Institution',
        'campus' => 'Campus',
        'programme' => 'Programme',
        'qualification' => 'Qualification',
    ];

    private const PUBLIC_FIELDS = [
        'display_name' => 'Name',
        'common_name' => 'Common name',
        'official_name' => 'Official name',
        'overview' => 'Overview',
        'official_website' => 'Official website',
        'public_contact_phone' => 'Public contact phone',
        'public_contact_email' => 'Public contact email',
        'public_address' => 'Public address',
        'province' => 'Province',
        'district' => 'District',
        'city' => 'City',
        'locality' => 'Locality',
        'education_level' => 'Education level',
        'provider_type' => 'Provider type',
        'programme_title' => 'Programme',
        'programme_level' => 'Programme level',
    ];

    /** @return array<string, string> */
    public function typeOptions(): array
    {
        return self::TYPE_LABELS;
    }

    private const LOCALITY_FIELDS = ['province', 'district', 'city', 'locality'];

    /**
     * @return array{
     *   results: array<int, array<string, mixed>>,
     *   facets: array<string, int>
     * }
     */
    public function search(
        string $query = '',
        ?string $type = null,
        string $locality = '',
        array $filters = [],
        ?string $sortField = null
    ): array {
        $query = trim(preg_replace('/\\s+/u', ' ', $query) ?? '');
        $locality = trim(preg_replace('/\\s+/u', ' ', $locality) ?? '');
        $entities = $this->publishedEntities();
        $matching = [];

        foreach ($entities as $entity) {
            $searchableFacts = array_values(array_filter(
                $entity['facts'],
                static fn (array $fact): bool => $fact['is_registry_managed'] === false || $fact['searchable'] === true
            ));
            $searchableName = $entity['name_searchable'] ? $entity['name'] : '';
            $searchable = $searchableName.' '.implode(' ', array_column($searchableFacts, 'value'));
            if ($query !== '' && mb_stripos($searchable, $query) === false) {
                continue;
            }
            if ($locality !== '') {
                $publishedLocalities = array_column(array_values(array_filter(
                    $entity['facts'],
                    static fn (array $fact): bool => in_array($fact['key'], self::LOCALITY_FIELDS, true) &&
                        $fact['filterable'] === true
                )), 'value');
                $localityText = implode(' ', $publishedLocalities);
                if ($localityText === '' || mb_stripos($localityText, $locality) === false) {
                    continue;
                }
            }
            $matching[] = $entity;
        }

        foreach ($filters as $fieldKey => $expectedValue) {
            if (is_string($fieldKey) === false || $fieldKey === '' ||
                is_string($expectedValue) === false || trim($expectedValue) === '') {
                return ['results' => [], 'facets' => []];
            }

            $matching = array_values(array_filter($matching, static function (array $entity) use ($fieldKey, $expectedValue): bool {
                foreach ($entity['facts'] as $fact) {
                    if ($fact['key'] === $fieldKey && $fact['is_registry_managed'] === true &&
                        $fact['filterable'] === true) {
                        return mb_strtolower(trim($fact['value'])) === mb_strtolower(trim($expectedValue));
                    }
                }

                return false;
            }));
        }

        $facets = [];
        foreach ($matching as $entity) {
            $facets[$entity['type']] = ($facets[$entity['type']] ?? 0) + 1;
        }
        ksort($facets);

        if ($type !== null && array_key_exists($type, self::TYPE_LABELS)) {
            $matching = array_values(array_filter(
                $matching,
                static fn (array $entity): bool => $entity['type'] === $type
            ));
        } elseif ($type !== null && $type !== '') {
            $matching = [];
        }

        if ($sortField !== null && $sortField !== '') {
            $hasSortableFact = false;
            foreach ($matching as $entity) {
                if ($this->sortableFactValue($entity, $sortField) !== null) {
                    $hasSortableFact = true;
                    break;
                }
            }
            if ($hasSortableFact) {
                usort($matching, function (array $left, array $right) use ($sortField): int {
                    $leftValue = $this->sortableFactValue($left, $sortField);
                    $rightValue = $this->sortableFactValue($right, $sortField);
                    if ($leftValue === null || $rightValue === null) {
                        return ($leftValue === null ? 1 : 0) <=> ($rightValue === null ? 1 : 0)
                            ?: strcmp($left['id'], $right['id']);
                    }

                    return strnatcasecmp($leftValue, $rightValue) ?: strcmp($left['id'], $right['id']);
                });
            } else {
                $this->sortByDefaultName($matching);
            }
        } else {
            $this->sortByDefaultName($matching);
        }

        return [
            'results' => array_map(fn (array $entity): array => $this->publicProfile($entity), $matching),
            'facets' => $facets,
        ];
    }

    public function find(string $entityId): ?array
    {
        foreach ($this->publishedEntities() as $entity) {
            if ($entity['id'] === $entityId) {
                return $this->publicProfile($entity);
            }
        }

        return null;
    }

    /**
     * Read only the current, approved, anonymous directory projection.
     * Raw evidence and unpublished assertions are never returned to callers.
     *
     * @return array<int, array<string, mixed>>
     */
    private function publishedEntities(): array
    {
        $rows = DB::table('public_projections')
            ->join('publication_snapshots', 'publication_snapshots.id', '=', 'public_projections.publication_snapshot_id')
            ->join('publication_decisions', 'publication_decisions.id', '=', 'publication_snapshots.publication_decision_id')
            ->join('claim_versions', 'claim_versions.id', '=', 'publication_snapshots.claim_version_id')
            ->leftJoin('field_definition_versions as registry_versions', 'registry_versions.id', '=', 'claim_versions.field_definition_version_id')
            ->leftJoin('field_definitions as registry_definitions', 'registry_definitions.id', '=', 'registry_versions.field_definition_id')
            ->join('claims', 'claims.id', '=', 'claim_versions.claim_id')
            ->join('directory_entities', 'directory_entities.id', '=', 'claims.subject_entity_id')
            ->where('public_projections.status', 'approved')
            ->where('public_projections.surface', 'directory')
            ->where('public_projections.audience', 'anonymous')
            ->where('public_projections.is_deeni_madaris', false)
            ->where('publication_snapshots.status', 'projected')
            ->where('publication_snapshots.surface', 'directory')
            ->where('publication_snapshots.audience', 'anonymous')
            ->whereColumn('publication_decisions.claim_version_id', 'publication_snapshots.claim_version_id')
            ->where('publication_decisions.decision', 'approved')
            ->where('publication_decisions.surface', 'directory')
            ->where('publication_decisions.audience', 'anonymous')
            ->where('claim_versions.disposition', 'accepted')
            ->whereIn('directory_entities.entity_type', array_keys(self::TYPE_LABELS))
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('claim_versions as successor')
                    ->whereColumn('successor.supersedes_version_id', 'claim_versions.id');
            })
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('publication_snapshots as newer_snapshot')
                    ->whereColumn('newer_snapshot.claim_version_id', 'publication_snapshots.claim_version_id')
                    ->whereColumn('newer_snapshot.surface', 'publication_snapshots.surface')
                    ->whereColumn('newer_snapshot.audience', 'publication_snapshots.audience')
                    ->whereColumn('newer_snapshot.snapshot_version', '>', 'publication_snapshots.snapshot_version');
            })
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('publication_suppressions')
                    ->whereColumn('publication_suppressions.publication_snapshot_id', 'publication_snapshots.id')
                    ->where('publication_suppressions.status', 'active');
            })
            ->orderBy('directory_entities.id')
            ->orderBy('claims.predicate')
            ->get([
                'directory_entities.id as entity_id',
                'directory_entities.entity_type',
                'claims.predicate',
                'claim_versions.id as claim_version_id',
                'claim_versions.valid_from as claim_valid_from',
                'claim_versions.valid_to as claim_valid_to',
                'claim_versions.field_definition_version_id',
                'registry_versions.id as registry_version_id',
                'registry_definitions.field_key as registry_field_key',
                'registry_versions.visibility_class as registry_visibility_class',
                'registry_versions.privacy_class as registry_privacy_class',
                'registry_versions.searchable as registry_searchable',
                'registry_versions.filterable as registry_filterable',
                'registry_versions.sortable as registry_sortable',
                'registry_versions.value_type as registry_value_type',
                'registry_versions.validation_schema as registry_validation_schema',
                'registry_versions.presentation_metadata as registry_presentation_metadata',
                'publication_snapshots.payload',
            ]);

        if ($rows->isEmpty()) {
            return [];
        }

        $versionIds = $rows->pluck('claim_version_id')->unique()->values()->all();
        $evidenceByVersion = DB::table('claim_evidence_links')
            ->join('evidence_references', 'evidence_references.id', '=', 'claim_evidence_links.evidence_reference_id')
            ->join('source_authorizations', 'source_authorizations.id', '=', 'evidence_references.source_authorization_id')
            ->whereIn('claim_evidence_links.claim_version_id', $versionIds)
            ->get([
                'claim_evidence_links.claim_version_id',
                'evidence_references.status as evidence_status',
                'evidence_references.observed_at',
                'source_authorizations.status as authorization_status',
                'source_authorizations.permitted_purposes',
                'source_authorizations.permitted_methods',
                'source_authorizations.territories',
                'source_authorizations.permitted_scopes',
                'source_authorizations.valid_from',
                'source_authorizations.valid_to',
                'source_authorizations.revoked_at',
            ])->groupBy('claim_version_id');

        $entities = [];
        $policy = new GovernancePolicy;

        $publishedCatalogueClaims = [];

        foreach ($rows as $row) {
            $isRegistryManaged = $row->field_definition_version_id !== null;
            $isCatalogueClaim = false;
            if ($isRegistryManaged) {
                if ((string) $row->registry_version_id !== (string) $row->field_definition_version_id ||
                    $row->registry_field_key !== $row->predicate ||
                    $row->registry_visibility_class !== 'public_eligible' ||
                    $row->registry_privacy_class !== 'public_eligible') {
                    continue;
                }

                $validationSchema = json_decode((string) $row->registry_validation_schema, true);
                $presentation = json_decode((string) $row->registry_presentation_metadata, true);
                if (is_array($validationSchema) === false || is_array($presentation) === false) {
                    continue;
                }
                $label = $this->registryPublicLabel($presentation);
                $section = $this->registryPublicSection($presentation);
                $value = null;
            } elseif (in_array($row->predicate, ['campus', 'delivery_site', 'programme', 'programme_offer'], true)) {
                $isCatalogueClaim = true;
                $validationSchema = [];
                $presentation = [];
                $label = null;
                $section = 'catalogue';
                $value = null;
            } else {
                if (array_key_exists($row->predicate, self::PUBLIC_FIELDS) === false) {
                    continue;
                }
                $validationSchema = [];
                $presentation = [];
                $label = self::PUBLIC_FIELDS[$row->predicate];
                $section = 'legacy';
                $value = null;
            }

            $evidenceRows = $evidenceByVersion->get($row->claim_version_id, collect());
            if ($this->evidenceIsCurrentlyPublishable($evidenceRows, $policy) === false) {
                continue;
            }

            $payload = json_decode((string) $row->payload, true);
            if (is_array($payload) === false ||
                ($payload['surface'] ?? null) !== 'directory' ||
                ($payload['audience'] ?? null) !== 'anonymous' ||
                ($payload['claim_version_id'] ?? null) !== (string) $row->claim_version_id ||
                ($payload['is_deeni_madaris'] ?? null) !== false ||
                ($payload['predicate'] ?? null) !== $row->predicate ||
                array_key_exists('value', $payload) === false) {
                continue;
            }

            if ($isCatalogueClaim) {
                $publishedCatalogueClaims[(string) $row->claim_version_id] = [
                    'predicate' => $row->predicate,
                    'value' => $payload['value'],
                    'subject_entity_id' => (string) $row->entity_id,
                    'valid_from' => $row->claim_valid_from,
                    'valid_to' => $row->claim_valid_to,
                ];
                continue;
            }

            if ($isRegistryManaged) {
                $value = $this->registryPublicScalar($payload['value'], (string) $row->registry_value_type, $validationSchema);
                if ($label === null || $value === null) {
                    continue;
                }
                $searchable = (bool) $row->registry_searchable;
                $filterable = (bool) $row->registry_filterable;
                $sortable = (bool) $row->registry_sortable;
            } else {
                $value = $this->publicScalar($payload['value']);
                if ($value === null) {
                    continue;
                }
                $searchable = true;
                $filterable = in_array($row->predicate, self::LOCALITY_FIELDS, true);
                $sortable = false;
            }

            $entityId = (string) $row->entity_id;
            if (array_key_exists($entityId, $entities) === false) {
                $entities[$entityId] = [
                    'id' => $entityId,
                    'type' => $row->entity_type,
                    'type_label' => self::TYPE_LABELS[$row->entity_type],
                    'name' => null,
                    'name_searchable' => false,
                    'name_sortable' => false,
                    'facts' => [],
                    'last_observed_at' => null,
                ];
            }

            $observedAt = $this->latestObservedDate($evidenceRows);
            $entities[$entityId]['facts'][] = [
                'key' => $row->predicate,
                'label' => $label,
                'value' => $value,
                'section' => $section,
                'observed_at' => $observedAt,
                'is_external_url' => ($isRegistryManaged && $row->registry_value_type === 'url') ||
                    ($row->predicate === 'official_website' && $this->isSafeHttpUrl($value)),
                'is_registry_managed' => $isRegistryManaged,
                'searchable' => $searchable,
                'filterable' => $filterable,
                'sortable' => $sortable,
            ];

            if ($observedAt !== null && ($entities[$entityId]['last_observed_at'] === null ||
                $observedAt > $entities[$entityId]['last_observed_at'])) {
                $entities[$entityId]['last_observed_at'] = $observedAt;
            }
        }

        $items = [];
        foreach ($entities as $entity) {
            $nameFact = $this->resolvePublicNameFact($entity['facts']);
            if ($nameFact === null) {
                continue;
            }
            $entity['name'] = $nameFact['value'];
            $entity['name_searchable'] = $nameFact['is_registry_managed'] === false || $nameFact['searchable'] === true;
            $entity['name_sortable'] = $nameFact['is_registry_managed'] === false || $nameFact['sortable'] === true;
            $items[] = $entity;
        }

        return $this->attachPublicCatalogue($items, $publishedCatalogueClaims);
    }

    /**
     * Attach catalogue records only when their own current anonymous publication
     * projection, the related programme/location projections, and active status
     * all remain valid. Raw claim payloads and internal identifiers never reach views.
     *
     * @param array<int, array<string, mixed>> $items
     * @param array<string, array<string, mixed>> $publishedClaims
     * @return array<int, array<string, mixed>>
     */
    private function attachPublicCatalogue(array $items, array $publishedClaims): array
    {
        $profiles = [];
        $institutionIds = [];
        foreach ($items as $item) {
            $profiles[$item['id']] = $item;
            if ($item['type'] === 'institution') {
                $institutionIds[] = $item['id'];
            }
        }

        $campusRows = DB::table('directory_campuses')
            ->whereIn('institution_entity_id', $institutionIds)
            ->where('status', 'active')
            ->get(['entity_id', 'institution_entity_id', 'claim_version_id', 'valid_from', 'valid_to']);
        $siteRows = DB::table('directory_delivery_sites')
            ->whereIn('institution_entity_id', $institutionIds)
            ->where('status', 'active')
            ->get(['entity_id', 'institution_entity_id', 'claim_version_id', 'valid_from', 'valid_to']);
        $programmeRows = DB::table('programme_catalogue_entries')
            ->whereIn('institution_entity_id', $institutionIds)
            ->where('status', 'active')
            ->get(['entity_id', 'institution_entity_id', 'claim_version_id']);
        $programmeIds = $programmeRows->pluck('entity_id')->all();
        $offerQuery = DB::table('programme_offers')->where('status', 'active');
        $offerRows = $programmeIds === []
            ? $offerQuery->whereRaw('1 = 0')->get(['id', 'programme_entity_id', 'delivery_location_entity_id', 'admission_cycle', 'claim_version_id', 'valid_from', 'valid_to'])
            : $offerQuery->whereIn('programme_entity_id', $programmeIds)->get(['id', 'programme_entity_id', 'delivery_location_entity_id', 'admission_cycle', 'claim_version_id', 'valid_from', 'valid_to']);

        $campusesByInstitution = [];
        $locationsByEntity = [];
        $locationInstitutionByEntity = [];
        foreach ($campusRows as $row) {
            $claimId = (string) $row->claim_version_id;
            $entityId = (string) $row->entity_id;
            if (($publishedClaims[$claimId]['predicate'] ?? null) !== 'campus' ||
                is_array($publishedClaims[$claimId]['value'] ?? null) === false ||
                ($publishedClaims[$claimId]['value']['institution_entity_id'] ?? null) !== (string) $row->institution_entity_id ||
                ($publishedClaims[$claimId]['subject_entity_id'] ?? null) !== $entityId ||
                ($publishedClaims[$claimId]['valid_from'] ?? null) !== $row->valid_from ||
                ($publishedClaims[$claimId]['valid_to'] ?? null) !== $row->valid_to ||
                isset($profiles[$entityId]) === false ||
                $this->catalogueRecordIsCurrent($row->valid_from, $row->valid_to) === false) {
                continue;
            }
            $locationsByEntity[$entityId] = $profiles[$entityId]['name'];
            $locationInstitutionByEntity[$entityId] = (string) $row->institution_entity_id;
            $campusesByInstitution[$row->institution_entity_id][] = ['name' => $profiles[$entityId]['name']];
        }

        foreach ($siteRows as $row) {
            $claimId = (string) $row->claim_version_id;
            $entityId = (string) $row->entity_id;
            if (($publishedClaims[$claimId]['predicate'] ?? null) !== 'delivery_site' ||
                is_array($publishedClaims[$claimId]['value'] ?? null) === false ||
                ($publishedClaims[$claimId]['value']['institution_entity_id'] ?? null) !== (string) $row->institution_entity_id ||
                isset($profiles[$entityId]) === false ||
                $this->catalogueRecordIsCurrent($row->valid_from, $row->valid_to) === false) {
                continue;
            }
            $locationsByEntity[$entityId] = $profiles[$entityId]['name'];
            $locationInstitutionByEntity[$entityId] = (string) $row->institution_entity_id;
        }

        $programmesByInstitution = [];
        $programmeIndexes = [];
        foreach ($programmeRows as $row) {
            $claimId = (string) $row->claim_version_id;
            $programmeId = (string) $row->entity_id;
            if (($publishedClaims[$claimId]['predicate'] ?? null) !== 'programme' ||
                is_array($publishedClaims[$claimId]['value'] ?? null) === false ||
                ($publishedClaims[$claimId]['value']['institution_entity_id'] ?? null) !== (string) $row->institution_entity_id ||
                ($publishedClaims[$claimId]['subject_entity_id'] ?? null) !== $programmeId ||
                ($publishedClaims[$claimId]['value']['title'] ?? null) !== (string) $row->title ||
                isset($profiles[$programmeId]) === false) {
                continue;
            }
            $programmeIndexes[$programmeId] = [
                'name' => $profiles[$programmeId]['name'],
                'institution_entity_id' => (string) $row->institution_entity_id,
                'offers' => [],
            ];
            $programmesByInstitution[$row->institution_entity_id][] = $programmeId;
        }

        foreach ($offerRows as $row) {
            $claimId = (string) $row->claim_version_id;
            $programmeId = (string) $row->programme_entity_id;
            $locationId = (string) $row->delivery_location_entity_id;
            if (($publishedClaims[$claimId]['predicate'] ?? null) !== 'programme_offer' ||
                is_array($publishedClaims[$claimId]['value'] ?? null) === false ||
                ($publishedClaims[$claimId]['subject_entity_id'] ?? null) !== $programmeId ||
                ($publishedClaims[$claimId]['value']['programme_entity_id'] ?? null) !== $programmeId ||
                ($publishedClaims[$claimId]['value']['delivery_location_entity_id'] ?? null) !== $locationId ||
                ($publishedClaims[$claimId]['valid_from'] ?? null) !== $row->valid_from ||
                ($publishedClaims[$claimId]['valid_to'] ?? null) !== $row->valid_to ||
                ($publishedClaims[$claimId]['value']['admission_cycle'] ?? null) !== (string) $row->admission_cycle ||
                isset($programmeIndexes[$programmeId]) === false ||
                isset($locationsByEntity[$locationId]) === false ||
                ($locationInstitutionByEntity[$locationId] ?? null) !== ($programmeIndexes[$programmeId]['institution_entity_id'] ?? null) ||
                $this->catalogueRecordIsCurrent($row->valid_from, $row->valid_to) === false) {
                continue;
            }
            $programmeIndexes[$programmeId]['offers'][] = [
                'admission_cycle' => (string) $row->admission_cycle,
                'location' => $locationsByEntity[$locationId],
            ];
        }

        foreach ($items as $index => $item) {
            if ($item['type'] !== 'institution') {
                continue;
            }
            $programmeItems = [];
            foreach ($programmesByInstitution[$item['id']] ?? [] as $programmeId) {
                $programmeItems[] = $programmeIndexes[$programmeId];
            }
            $items[$index]['catalogue'] = [
                'campuses' => $campusesByInstitution[$item['id']] ?? [],
                'programmes' => $programmeItems,
            ];
        }

        return $items;
    }

    private function catalogueRecordIsCurrent(?string $validFrom, ?string $validTo): bool
    {
        $today = now()->toDateString();

        return ($validFrom === null || $validFrom <= $today) &&
            ($validTo === null || $validTo >= $today);
    }

    private function evidenceIsCurrentlyPublishable(Collection $evidenceRows, GovernancePolicy $policy): bool
    {
        if ($evidenceRows->isEmpty()) {
            return false;
        }

        foreach ($evidenceRows as $evidence) {
            if ($evidence->evidence_status !== 'eligible_for_review') {
                return false;
            }

            $territories = $this->decodeArray($evidence->territories);
            if ($territories === []) {
                return false;
            }

            $authorization = [
                'status' => $evidence->authorization_status,
                'permitted_purposes' => $evidence->permitted_purposes,
                'permitted_methods' => $evidence->permitted_methods,
                'territories' => $evidence->territories,
                'permitted_scopes' => $evidence->permitted_scopes,
                'valid_from' => $evidence->valid_from,
                'valid_to' => $evidence->valid_to,
                'revoked_at' => $evidence->revoked_at,
            ];
            $scope = $policy->authorizeSourceAction($authorization, 'publication', [
                'purpose' => 'directory_publication',
                'method' => 'approved_projection',
                'territory' => (string) $territories[0],
            ]);
            if (($scope['allowed'] ?? false) !== true) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return only display-safe fields to the view layer; query permissions remain internal.
     *
     * @param  array<string, mixed>  $entity
     * @return array<string, mixed>
     */
    private function publicProfile(array $entity): array
    {
        $visibleFactKeys = ['key', 'label', 'value', 'section', 'observed_at', 'is_external_url'];
        $entity['facts'] = array_map(
            static fn (array $fact): array => array_intersect_key($fact, array_flip($visibleFactKeys)),
            $entity['facts']
        );
        unset($entity['name_searchable'], $entity['name_sortable']);

        return $entity;
    }

    /**
     * @param  array<string, mixed>  $entity
     */
    private function sortableFactValue(array $entity, string $fieldKey): ?string
    {
        foreach ($entity['facts'] as $fact) {
            if ($fact['key'] === $fieldKey && $fact['is_registry_managed'] === true &&
                $fact['sortable'] === true) {
                return (string) $fact['value'];
            }
        }

        return null;
    }

    /**
     * @param  array<int, array<string, mixed>>  $entities
     */
    private function sortByDefaultName(array &$entities): void
    {
        usort($entities, static function (array $left, array $right): int {
            if ($left['name_sortable'] === true && $right['name_sortable'] === true) {
                return strnatcasecmp($left['name'], $right['name']) ?: strcmp($left['id'], $right['id']);
            }

            return strcmp($left['id'], $right['id']);
        });
    }

    /**
     * @param  array<int, array<string, mixed>>  $facts
     * @return array<string, mixed>|null
     */
    private function resolvePublicNameFact(array $facts): ?array
    {
        foreach (['display_name', 'common_name', 'official_name'] as $key) {
            $matches = array_values(array_filter(
                $facts,
                static fn (array $fact): bool => $fact['key'] === $key
            ));
            $values = array_values(array_unique(array_column($matches, 'value')));
            if ($values !== []) {
                return count($values) === 1 ? $matches[0] : null;
            }
        }

        return null;
    }

    /** @param  array<string, mixed>  $presentation */
    private function registryPublicLabel(array $presentation): ?string
    {
        $label = $presentation['public_label'] ?? $presentation['label'] ?? null;
        if (is_string($label) === false || trim($label) === '' ||
            mb_strlen($label) > 80 || preg_match('//u', $label) !== 1 ||
            strip_tags($label) !== $label ||
            preg_match('/[\\x00-\\x1F\\x7F]/u', $label) === 1) {
            return null;
        }

        return trim($label);
    }

    /** @param  array<string, mixed>  $presentation */
    private function registryPublicSection(array $presentation): string
    {
        $section = $presentation['section_key'] ?? null;
        if (is_string($section) === false || preg_match('/^[a-z][a-z0-9_]{0,39}$/D', $section) !== 1) {
            return 'general';
        }

        return $section;
    }

    /**
     * Format only bounded scalar types with a deterministic public representation.
     *
     * @param  array<string, mixed>  $schema
     */
    private function registryPublicScalar(mixed $value, string $type, array $schema): ?string
    {
        if (is_array($value)) {
            if (array_key_exists('value', $value) === false) {
                return null;
            }
            $value = $value['value'];
        }

        return match ($type) {
            'short_text' => $this->registryPublicText($value, $schema, false),
            'long_text' => $this->registryPublicText($value, $schema, true),
            'integer' => is_int($value) ? (string) $value : null,
            'decimal' => (is_string($value) || is_int($value)) &&
                strlen((string) $value) <= 32 &&
                preg_match('/^-?(?:0|[1-9][0-9]*)(?:\\.[0-9]+)?$/D', (string) $value) === 1
                    ? (string) $value
                    : null,
            'boolean' => is_bool($value) ? ($value ? 'Yes' : 'No') : null,
            'date' => $this->isIsoPublicDate($value) ? $value : null,
            'url' => is_string($value) && $this->isSafeHttpUrl($value) ? $value : null,
            'email' => is_string($value) && strlen($value) <= 254 &&
                filter_var($value, FILTER_VALIDATE_EMAIL) !== false ? $value : null,
            'phone' => is_string($value) && preg_match('/^\\+[1-9][0-9]{7,14}$/D', $value) === 1 ? $value : null,
            'enum' => is_string($value) && is_array($schema['allowed_values'] ?? null) &&
                in_array($value, $schema['allowed_values'], true) ? $value : null,
            default => null,
        };
    }

    /**
     * @param  array<string, mixed>  $schema
     */
    private function registryPublicText(mixed $value, array $schema, bool $longText): ?string
    {
        if (is_string($value) === false || preg_match('//u', $value) !== 1 ||
            mb_strlen($value) > min(2000, (int) ($schema['max_length'] ?? 2000)) ||
            str_contains($value, "\0") ||
            ($longText && (stripos($value, '<script') !== false || stripos($value, '<iframe') !== false))) {
            return null;
        }

        $value = trim($value);

        return $value !== '' ? $value : null;
    }

    private function isIsoPublicDate(mixed $value): bool
    {
        if (is_string($value) === false || preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/D', $value, $parts) !== 1) {
            return false;
        }

        return checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1]);
    }

    private function publicScalar(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value['value'] ?? null;
        }
        if (is_string($value) === false && is_int($value) === false && is_float($value) === false) {
            return null;
        }

        $value = trim((string) $value);
        if ($value === '' || mb_strlen($value) > 2000) {
            return null;
        }

        return $value;
    }

    private function latestObservedDate(Collection $evidenceRows): ?string
    {
        $dates = $evidenceRows->pluck('observed_at')->filter()->map(static function (string $value): ?string {
            try {
                return Carbon::parse($value)->toDateString();
            } catch (\Throwable) {
                return null;
            }
        })->filter()->all();

        if ($dates === []) {
            return null;
        }

        rsort($dates);

        return $dates[0];
    }

    private function decodeArray(mixed $value): array
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

    private function isSafeHttpUrl(string $value): bool
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $parts = parse_url($value);

        return is_array($parts) &&
            in_array(strtolower((string) ($parts['scheme'] ?? '')), ['http', 'https'], true) &&
            empty($parts['user']) && empty($parts['pass']);
    }
}
