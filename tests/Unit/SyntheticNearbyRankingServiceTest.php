<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Geography\NearbyCoordinateCandidate;
use App\Domain\Geography\NearbyOrigin;
use App\Domain\Geography\SyntheticNearbyRankingService;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class SyntheticNearbyRankingServiceTest extends TestCase
{
    public function test_it_ranks_eligible_synthetic_points_by_approximate_straight_line_distance(): void
    {
        $service = new SyntheticNearbyRankingService;
        $origin = new NearbyOrigin(31.5000, 74.3000);

        $farther = $this->candidate('institution', 'synthetic-inst-b', 'synthetic-inst-b', 31.6000, 74.3000);
        $nearer = $this->candidate('campus', 'synthetic-campus-a', 'synthetic-inst-a', 31.5100, 74.3000);

        $results = $service->rank($origin, [$farther, $nearer]);

        $this->assertSame(['synthetic-campus-a', 'synthetic-inst-b'], array_column($results, 'entity_id'));
        $this->assertSame('campus', $results[0]['entity_type']);
        $this->assertSame('synthetic-inst-a', $results[0]['institution_id']);
        $this->assertGreaterThan(0.0, $results[0]['distance_km_approx']);
        $this->assertLessThan($results[1]['distance_km_approx'], $results[0]['distance_km_approx']);
    }

    public function test_equal_distances_have_stable_entity_type_and_id_tie_breaks(): void
    {
        $service = new SyntheticNearbyRankingService;
        $origin = new NearbyOrigin(31.5000, 74.3000);
        $first = $this->candidate('campus', 'synthetic-campus-z', 'synthetic-inst-z', 31.5100, 74.3000);
        $second = $this->candidate('campus', 'synthetic-campus-a', 'synthetic-inst-a', 31.4900, 74.3000);

        $forward = $service->rank($origin, [$first, $second]);
        $reverse = $service->rank($origin, [$second, $first]);

        $this->assertSame(['synthetic-campus-a', 'synthetic-campus-z'], array_column($forward, 'entity_id'));
        $this->assertSame($forward, $reverse);
        $this->assertSame($forward[0]['distance_km_approx'], $forward[1]['distance_km_approx']);
    }

    public function test_it_excludes_candidates_that_fail_any_publication_quality_gate(): void
    {
        $service = new SyntheticNearbyRankingService;
        $origin = new NearbyOrigin(31.5000, 74.3000);
        $eligible = $this->candidate('institution', 'synthetic-inst-ok', 'synthetic-inst-ok', 31.5100, 74.3000);

        $candidates = [
            $eligible,
            $this->candidate('institution', 'synthetic-no-auth', 'synthetic-no-auth', 31.5101, 74.3000, ['sourceAuthorized' => false]),
            $this->candidate('institution', 'synthetic-private', 'synthetic-private', 31.5102, 74.3000, ['visibilityClass' => 'internal']),
            $this->candidate('institution', 'synthetic-exact', 'synthetic-exact', 31.5103, 74.3000, ['precisionClass' => 'exact_restricted']),
            $this->candidate('institution', 'synthetic-low', 'synthetic-low', 31.5104, 74.3000, ['confidenceClass' => 'low']),
            $this->candidate('institution', 'synthetic-unknown', 'synthetic-unknown', 31.5105, 74.3000, ['confidenceClass' => 'unknown']),
            $this->candidate('institution', 'synthetic-stale', 'synthetic-stale', 31.5106, 74.3000, ['verificationState' => 'stale']),
            $this->candidate('institution', 'synthetic-conflict', 'synthetic-conflict', 31.5107, 74.3000, ['verificationState' => 'conflicted']),
            $this->candidate('institution', 'synthetic-withdrawn', 'synthetic-withdrawn', 31.5108, 74.3000, ['verificationState' => 'withdrawn']),
            $this->candidate('institution', 'synthetic-no-provenance', 'synthetic-no-provenance', 31.5109, 74.3000, ['provenanceReference' => '']),
            $this->candidate('institution', 'synthetic-real-marker', 'synthetic-real-marker', 31.5110, 74.3000, ['provenanceReference' => 'source:unapproved']),
        ];

        $results = $service->rank($origin, $candidates);

        $this->assertSame(['synthetic-inst-ok'], array_column($results, 'entity_id'));
    }

    public function test_missing_or_invalid_candidate_coordinates_fail_closed(): void
    {
        $service = new SyntheticNearbyRankingService;
        $origin = new NearbyOrigin(31.5000, 74.3000);

        $results = $service->rank($origin, [
            $this->candidate('institution', 'synthetic-null', 'synthetic-null', null, 74.3),
            $this->candidate('institution', 'synthetic-latitude', 'synthetic-latitude', 91.0, 74.3),
            $this->candidate('institution', 'synthetic-longitude', 'synthetic-longitude', 31.5, 181.0),
            $this->candidate('institution', 'synthetic-nan', 'synthetic-nan', NAN, 74.3),
        ]);

        $this->assertSame([], $results);
    }

    public function test_missing_or_mismatched_subject_ownership_fails_closed(): void
    {
        $service = new SyntheticNearbyRankingService;
        $origin = new NearbyOrigin(31.5000, 74.3000);

        $results = $service->rank($origin, [
            $this->candidate('institution', 'synthetic-inst-a', null, 31.51, 74.3),
            $this->candidate('institution', 'synthetic-inst-b', 'synthetic-inst-other', 31.51, 74.3),
            $this->candidate('campus', 'synthetic-campus-a', 'synthetic-campus-a', 31.51, 74.3),
            $this->candidate('delivery_site', 'synthetic-site-a', null, 31.51, 74.3),
            $this->candidate('programme', 'synthetic-programme-a', 'synthetic-inst-a', 31.51, 74.3),
            $this->candidate('', 'synthetic-empty-type', 'synthetic-empty-type', 31.51, 74.3),
            $this->candidate('campus', '', 'synthetic-inst-a', 31.51, 74.3),
        ]);

        $this->assertSame([], $results);
    }

    public function test_invalid_origin_coordinates_are_rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new NearbyOrigin(90.01, 74.3);
    }

    #[DataProvider('invalidOriginCoordinates')]
    public function test_origin_rejects_non_finite_or_out_of_range_values(float $latitude, float $longitude): void
    {
        $this->expectException(InvalidArgumentException::class);

        new NearbyOrigin($latitude, $longitude);
    }

    public static function invalidOriginCoordinates(): array
    {
        return [
            'latitude below minimum' => [-90.01, 0.0],
            'longitude above maximum' => [0.0, 180.01],
            'infinite latitude' => [INF, 0.0],
            'not-a-number longitude' => [0.0, NAN],
        ];
    }

    public function test_it_handles_coordinate_boundaries_and_zero_distance(): void
    {
        $service = new SyntheticNearbyRankingService;
        $origin = new NearbyOrigin(90.0, 180.0);
        $samePoint = $this->candidate('institution', 'synthetic-pole', 'synthetic-pole', 90.0, 180.0);
        $otherPole = $this->candidate('institution', 'synthetic-equator', 'synthetic-equator', -90.0, -180.0);

        $results = $service->rank($origin, [$otherPole, $samePoint]);

        $this->assertSame('synthetic-pole', $results[0]['entity_id']);
        $this->assertSame(0.0, $results[0]['distance_km_approx']);
        $this->assertGreaterThan(20000.0, $results[1]['distance_km_approx']);
    }

    public function test_entity_coordinate_is_not_inferred_from_parent_or_other_subject(): void
    {
        $service = new SyntheticNearbyRankingService;
        $origin = new NearbyOrigin(31.5000, 74.3000);
        $institution = $this->candidate('institution', 'synthetic-inst-parent', 'synthetic-inst-parent', 31.51, 74.3);

        $results = $service->rank($origin, [$institution]);

        $this->assertSame(['synthetic-inst-parent'], array_column($results, 'entity_id'));
        $this->assertSame('institution', $results[0]['entity_type']);
        $this->assertNotSame('campus', $results[0]['entity_type']);
    }

    private function candidate(
        string $entityType,
        string $entityId,
        ?string $institutionId,
        ?float $latitude,
        ?float $longitude,
        array $overrides = [],
    ): NearbyCoordinateCandidate {
        $defaults = [
            'sourceAuthorized' => true,
            'visibilityClass' => 'public_generalized',
            'precisionClass' => 'approximate',
            'confidenceClass' => 'high',
            'verificationState' => 'verified_current',
            'provenanceReference' => 'synthetic:fixture:coordinate-001',
        ];
        $values = array_merge($defaults, $overrides);

        return new NearbyCoordinateCandidate(
            $entityType,
            $entityId,
            $institutionId,
            $latitude,
            $longitude,
            $values['sourceAuthorized'],
            $values['visibilityClass'],
            $values['precisionClass'],
            $values['confidenceClass'],
            $values['verificationState'],
            $values['provenanceReference'],
        );
    }
}
