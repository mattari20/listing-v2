<?php

declare(strict_types=1);

namespace App\Domain\Geography;

use InvalidArgumentException;

final readonly class NearbyOrigin
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {
        if (! self::hasValidCoordinates($latitude, $longitude)) {
            throw new InvalidArgumentException('Nearby origin coordinates are invalid.');
        }
    }

    private static function hasValidCoordinates(float $latitude, float $longitude): bool
    {
        return is_finite($latitude) &&
            is_finite($longitude) &&
            $latitude >= -90.0 &&
            $latitude <= 90.0 &&
            $longitude >= -180.0 &&
            $longitude <= 180.0;
    }
}
