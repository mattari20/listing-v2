<?php

declare(strict_types=1);

namespace App\Domain\Geography;

use InvalidArgumentException;

final class SyntheticNearbyRankingService
{
    private const EARTH_MEAN_RADIUS_KM = 6371.0088;

    /**
     * Rank only explicitly eligible synthetic candidates by straight-line distance.
     *
     * @param  array<int, NearbyCoordinateCandidate>  $candidates
     * @return array<int, array{
     *   entity_type: string,
     *   entity_id: string,
     *   institution_id: string,
     *   distance_km_approx: float
     * }>
     */
    public function rank(NearbyOrigin $origin, array $candidates): array
    {
        $ranked = [];

        foreach ($candidates as $candidate) {
            if (! $candidate instanceof NearbyCoordinateCandidate) {
                throw new InvalidArgumentException('Every nearby candidate must use the typed candidate contract.');
            }

            if (! $candidate->isEligibleForSyntheticRanking()) {
                continue;
            }

            $distance = $this->distanceKilometres(
                $origin->latitude,
                $origin->longitude,
                $candidate->latitude,
                $candidate->longitude,
            );

            $ranked[] = [
                'entity_type' => $candidate->entityType,
                'entity_id' => $candidate->entityId,
                'institution_id' => $candidate->institutionId,
                'distance_km_approx' => round($distance, 2),
                '_distance_unrounded' => $distance,
            ];
        }

        usort($ranked, static function (array $left, array $right): int {
            return ($left['_distance_unrounded'] <=> $right['_distance_unrounded'])
                ?: strcmp($left['entity_type'], $right['entity_type'])
                ?: strcmp($left['entity_id'], $right['entity_id']);
        });

        return array_map(static function (array $item): array {
            unset($item['_distance_unrounded']);

            return $item;
        }, $ranked);
    }

    private function distanceKilometres(
        float $latitudeA,
        float $longitudeA,
        float $latitudeB,
        float $longitudeB,
    ): float {
        $latitudeDelta = deg2rad($latitudeB - $latitudeA);
        $longitudeDelta = deg2rad($longitudeB - $longitudeA);

        $a = sin($latitudeDelta / 2) ** 2 +
            cos(deg2rad($latitudeA)) *
            cos(deg2rad($latitudeB)) *
            sin($longitudeDelta / 2) ** 2;

        $centralAngle = 2 * atan2(sqrt($a), sqrt(max(0.0, 1 - $a)));

        return self::EARTH_MEAN_RADIUS_KM * $centralAngle;
    }
}
