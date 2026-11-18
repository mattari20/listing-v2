<?php

declare(strict_types=1);

namespace App\Services\Directory;

use App\Domain\Governance\GovernancePolicy;
use Illuminate\Support\Facades\DB;

final class PublicProgrammeOfferFactsQueryService
{
    /**
     * Return only currently publishable offer facts for one already-public programme.
     *
     * @return array<int, array<string, mixed>>
     */
    public function forProgramme(string $programmeEntityId): array
    {
        $rows = DB::table('programme_offer_fact_public_projections as projections')
            ->join('programme_offer_fact_publication_snapshots as snapshots', 'snapshots.id', '=', 'projections.publication_snapshot_id')
            ->join('programme_offer_fact_publication_decisions as publication_decisions', 'publication_decisions.id', '=', 'snapshots.publication_decision_id')
            ->join('programme_offer_fact_adjudication_decisions as adjudication_decisions', 'adjudication_decisions.id', '=', 'publication_decisions.adjudication_decision_id')
            ->join('programme_offer_fact_adjudication_cases as adjudication_cases', 'adjudication_cases.id', '=', 'adjudication_decisions.adjudication_case_id')
            ->join('programme_offer_fact_versions as versions', 'versions.id', '=', 'snapshots.fact_version_id')
            ->join('programme_offer_facts as facts', 'facts.id', '=', 'versions.programme_offer_fact_id')
            ->leftJoin('programme_offer_fact_freshness_policies as freshness_policies', function ($join): void {
                $join->on('freshness_policies.policy_key', '=', 'versions.freshness_policy_key')
                    ->on('freshness_policies.category', '=', 'facts.category')
                    ->on('freshness_policies.freshness_days', '=', 'versions.freshness_days');
            })
            ->join('programme_offers as offers', 'offers.id', '=', 'facts.programme_offer_id')
            ->join('programme_catalogue_entries as programmes', 'programmes.entity_id', '=', 'offers.programme_entity_id')
            ->join('directory_entities as institutions', 'institutions.id', '=', 'programmes.institution_entity_id')
            ->join('directory_entities as locations', 'locations.id', '=', 'offers.delivery_location_entity_id')
            ->where('offers.programme_entity_id', $programmeEntityId)
            ->where('offers.status', 'active')
            ->where('projections.status', 'approved')
            ->where('projections.surface', 'directory')
            ->where('projections.audience', 'anonymous')
            ->where('snapshots.status', 'projected')
            ->where('snapshots.surface', 'directory')
            ->where('snapshots.audience', 'anonymous')
            ->where('publication_decisions.decision', 'approved')
            ->where('publication_decisions.surface', 'directory')
            ->where('publication_decisions.audience', 'anonymous')
            ->whereColumn('publication_decisions.fact_version_id', 'snapshots.fact_version_id')
            ->where('adjudication_decisions.outcome', 'accepted')
            ->where('adjudication_decisions.actor_class', 'human')
            ->whereColumn('adjudication_cases.fact_version_id', 'versions.id')
            ->where('versions.disposition', 'accepted')
            ->whereIn('versions.fact_state', ['known', 'unknown', 'not_stated', 'not_applicable', 'conflicting'])
            ->where('institutions.entity_type', '!=', 'deeni_madaris')
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('programme_offer_fact_versions as successor')
                    ->whereColumn('successor.supersedes_version_id', 'versions.id');
            })
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('programme_offer_fact_publication_suppressions as suppressions')
                    ->whereColumn('suppressions.publication_snapshot_id', 'snapshots.id')
                    ->where('suppressions.status', 'active');
            })
            ->orderBy('offers.admission_cycle')
            ->orderBy('locations.label')
            ->orderBy('facts.fact_key')
            ->get([
                'offers.id as offer_id',
                'offers.admission_cycle',
                'locations.entity_type as delivery_location_type',
                'facts.id as fact_id',
                'facts.fact_key',
                'facts.category',
                'versions.id as fact_version_id',
                'versions.fact_state',
                'versions.value',
                'versions.observed_at',
                'versions.valid_from',
                'versions.valid_to',
                'versions.freshness_policy_key',
                'versions.freshness_days',
                'freshness_policies.status as freshness_policy_status',
                'freshness_policies.valid_from as freshness_policy_valid_from',
                'freshness_policies.valid_to as freshness_policy_valid_to',
            ]);

        if ($rows->isEmpty()) {
            return [];
        }

        $versionIds = $rows->pluck('fact_version_id')->unique()->values()->all();
        $evidenceByVersion = DB::table('programme_offer_fact_evidence_links as links')
            ->join('evidence_references as evidence', 'evidence.id', '=', 'links.evidence_reference_id')
            ->join('source_authorizations as authorizations', 'authorizations.id', '=', 'evidence.source_authorization_id')
            ->whereIn('links.fact_version_id', $versionIds)
            ->get([
                'links.fact_version_id',
                'evidence.status as evidence_status',
                'authorizations.status as authorization_status',
                'authorizations.permitted_purposes',
                'authorizations.permitted_methods',
                'authorizations.territories',
                'authorizations.permitted_scopes',
                'authorizations.valid_from',
                'authorizations.valid_to',
                'authorizations.revoked_at',
            ])->groupBy('fact_version_id');

        $policy = new GovernancePolicy;
        $offers = [];
        foreach ($rows as $row) {
            if ($row->valid_from !== null && $row->valid_from > now()->toDateString()) {
                continue;
            }
            if ($row->valid_to !== null && $row->valid_to < now()->toDateString()) {
                continue;
            }
            $displayState = (string) $row->fact_state;
            if ($row->fact_state === 'known' &&
                ($row->observed_at === null || $row->freshness_policy_key === null ||
                    $row->freshness_days === null || $row->freshness_policy_status !== 'approved' ||
                    ($row->freshness_policy_valid_from !== null && \\Illuminate\\Support\\Carbon::parse($row->freshness_policy_valid_from)->greaterThan(now())) ||
                    ($row->freshness_policy_valid_to !== null && \\Illuminate\\Support\\Carbon::parse($row->freshness_policy_valid_to)->lessThanOrEqualTo(now())) ||
                    now()->greaterThanOrEqualTo(\\Illuminate\\Support\\Carbon::parse($row->observed_at)->addDays((int) $row->freshness_days)))) {
                $displayState = 'stale';
            }

            $evidenceRows = $evidenceByVersion->get($row->fact_version_id, collect());
            if ($evidenceRows->isEmpty()) {
                continue;
            }
            $evidenceValid = true;
            foreach ($evidenceRows as $evidence) {
                if ($evidence->evidence_status !== 'eligible_for_review') {
                    $evidenceValid = false;
                    break;
                }
                $territories = is_array($evidence->territories)
                    ? $evidence->territories
                    : (json_decode((string) $evidence->territories, true) ?: []);
                if (in_array('synthetic', $territories, true) === false) {
                    $evidenceValid = false;
                    break;
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
                    'territory' => 'synthetic',
                ]);
                if ($scope['allowed'] !== true) {
                    $evidenceValid = false;
                    break;
                }
            }
            if (! $evidenceValid) {
                continue;
            }

            $offerId = (string) $row->offer_id;
            if (! isset($offers[$offerId])) {
                $offers[$offerId] = [
                    'id' => $offerId,
                    'admission_cycle' => (string) $row->admission_cycle,
                    'delivery_location' => $row->delivery_location_type === 'campus' ? 'Campus' : 'Delivery site',
                    'facts' => [],
                ];
            }
            $value = $row->value === null ? null : json_decode((string) $row->value, true, 512, JSON_THROW_ON_ERROR);
            $offers[$offerId]['facts'][] = [
                'key' => (string) $row->fact_key,
                'label' => ucwords(str_replace('_', ' ', (string) $row->fact_key)),
                'category' => (string) $row->category,
                'state' => $displayState,
                'value' => $value,
                'observed_at' => $row->observed_at,
            ];
        }

        return array_values($offers);
    }
}
