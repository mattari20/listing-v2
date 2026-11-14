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
        'education_level' => 'Education level',
        'provider_type' => 'Provider type',
        'programme_title' => 'Programme',
        'programme_level' => 'Programme level',
    ];

    private const MAX_CANDIDATE_ROWS = 5000;

    /** @return array<string, string> */
    public function typeOptions(): array
    {
        return self::TYPE_LABELS;
    }

    /**
     * @return array{
     *   results: array<int, array<string, mixed>>,
     *   facets: array<string, int>,
     *   limited: bool
     * }
     */
    public function search(string $query = '', ?string $type = null): array
    {
        $query = trim(preg_replace('/\s+/u', ' ', $query) ?? '');
        $entities = $this->publishedEntities();
        $matching = [];

        foreach ($entities['items'] as $entity) {
            $searchable = $entity['name'].' '.implode(' ', array_column($entity['facts'], 'value'));
            if ($query !== '' && mb_stripos($searchable, $query) === false) {
                continue;
            }
            $matching[] = $entity;
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

        usort($matching, static fn (array $left, array $right): int => strnatcasecmp($left['name'], $right['name']));

        return [
            'results' => $matching,
            'facets' => $facets,
            'limited' => $entities['limited'],
        ];
    }

    /** @return array<string, mixed>|null */
    public function find(string $entityId): ?array
    {
        foreach ($this->publishedEntities()['items'] as $entity) {
            if ($entity['id'] === $entityId) {
                return $entity;
            }
        }

        return null;
    }

    /**
     * Read only the current, approved, anonymous directory projection.
     * Raw evidence and unpublished assertions are never returned to callers.
     *
     * @return array{items: array<int, array<string, mixed>>, limited: bool}
     */
    private function publishedEntities(): array
    {
        $rows = DB::table('public_projections')
            ->join('publication_snapshots', 'publication_snapshots.id', '=', 'public_projections.publication_snapshot_id')
            ->join('publication_decisions', 'publication_decisions.id', '=', 'publication_snapshots.publication_decision_id')
            ->join('claim_versions', 'claim_versions.id', '=', 'publication_snapshots.claim_version_id')
            ->join('claims', 'claims.id', '=', 'claim_versions.claim_id')
            ->join('directory_entities', 'directory_entities.id', '=', 'claims.subject_entity_id')
            ->where('public_projections.status', 'approved')
            ->where('public_projections.surface', 'directory')
            ->where('public_projections.audience', 'anonymous')
            ->where('publication_snapshots.status', 'projected')
            ->where('publication_snapshots.surface', 'directory')
            ->where('publication_snapshots.audience', 'anonymous')
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
            ->limit(self::MAX_CANDIDATE_ROWS + 1)
            ->get([
                'directory_entities.id as entity_id',
                'directory_entities.entity_type',
                'claims.predicate',
                'claim_versions.id as claim_version_id',
                'publication_snapshots.payload',
            ]);

        $limited = $rows->count() > self::MAX_CANDIDATE_ROWS;
        if ($limited) {
            $rows = $rows->take(self::MAX_CANDIDATE_ROWS);
        }
        if ($rows->isEmpty()) {
            return ['items' => [], 'limited' => false];
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

        foreach ($rows as $row) {
            if (array_key_exists($row->predicate, self::PUBLIC_FIELDS) === false) {
                continue;
            }

            $evidenceRows = $evidenceByVersion->get($row->claim_version_id, collect());
            if ($this->evidenceIsCurrentlyPublishable($evidenceRows, $policy) === false) {
                continue;
            }

            $payload = json_decode((string) $row->payload, true);
            if (is_array($payload) === false ||
                ($payload['surface'] ?? null) !== 'directory' ||
                ($payload['audience'] ?? null) !== 'anonymous' ||
                ($payload['is_deeni_madaris'] ?? null) !== false ||
                ($payload['predicate'] ?? null) !== $row->predicate ||
                array_key_exists('value', $payload) === false) {
                continue;
            }

            $value = $this->publicScalar($payload['value']);
            if ($value === null) {
                continue;
            }

            $entityId = (string) $row->entity_id;
            if (array_key_exists($entityId, $entities) === false) {
                $entities[$entityId] = [
                    'id' => $entityId,
                    'type' => $row->entity_type,
                    'type_label' => self::TYPE_LABELS[$row->entity_type],
                    'name' => null,
                    'facts' => [],
                    'last_observed_at' => null,
                ];
            }

            $observedAt = $this->latestObservedDate($evidenceRows);
            $entities[$entityId]['facts'][] = [
                'key' => $row->predicate,
                'label' => self::PUBLIC_FIELDS[$row->predicate],
                'value' => $value,
                'observed_at' => $observedAt,
                'is_external_url' => $row->predicate === 'official_website' && $this->isSafeHttpUrl($value),
            ];

            if ($observedAt !== null && ($entities[$entityId]['last_observed_at'] === null ||
                $observedAt > $entities[$entityId]['last_observed_at'])) {
                $entities[$entityId]['last_observed_at'] = $observedAt;
            }
        }

        $items = [];
        foreach ($entities as $entity) {
            $name = $this->resolvePublicName($entity['facts']);
            if ($name === null) {
                continue;
            }
            $entity['name'] = $name;
            $items[] = $entity;
        }

        return ['items' => $items, 'limited' => $limited];
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

    private function resolvePublicName(array $facts): ?string
    {
        foreach (['display_name', 'common_name', 'official_name'] as $key) {
            $values = array_values(array_unique(array_column(
                array_values(array_filter($facts, static fn (array $fact): bool => $fact['key'] === $key)),
                'value'
            )));
            if ($values !== []) {
                return count($values) === 1 ? $values[0] : null;
            }
        }

        return null;
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

        return in_array(strtolower((string) parse_url($value, PHP_URL_SCHEME)), ['http', 'https'], true);
    }
}
