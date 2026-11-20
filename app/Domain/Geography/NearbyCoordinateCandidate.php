<?php

declare(strict_types=1);

namespace App\Domain\Geography;

final readonly class NearbyCoordinateCandidate
{
    public function __construct(
        public string $entityType,
        public string $entityId,
        public ?string $institutionId,
        public bool $ownershipVerified,
        public ?float $latitude,
        public ?float $longitude,
        public bool $publicationEligible,
        public bool $deeniMadaris,
        public bool $sourceAuthorized,
        public string $visibilityClass,
        public string $precisionClass,
        public string $confidenceClass,
        public string $verificationState,
        public string $provenanceReference,
    ) {
    }

    public function isEligibleForSyntheticRanking(): bool
    {
        if (in_array($this->entityType, ['institution', 'campus', 'delivery_site'], true) === false ||
            trim($this->entityId) === '' ||
            $this->institutionId === null ||
            trim($this->institutionId) === '') {
            return false;
        }

        if ($this->entityType === 'institution' &&
            ($this->institutionId !== $this->entityId || $this->ownershipVerified === false)) {
            return false;
        }

        if (in_array($this->entityType, ['campus', 'delivery_site'], true) &&
            ($this->institutionId === $this->entityId || !$this->ownershipVerified)) {
            return false;
        }

        if ($this->latitude === null || $this->longitude === null ||
            is_finite($this->latitude) === false || is_finite($this->longitude) === false ||
            $this->latitude < -90.0 || $this->latitude > 90.0 ||
            $this->longitude < -180.0 || $this->longitude > 180.0) {
            return false;
        }

        return $this->publicationEligible &&
            $this->deeniMadaris === false &&
            $this->sourceAuthorized &&
            $this->visibilityClass === 'public_generalized' &&
            in_array($this->precisionClass, ['approximate', 'area_centroid', 'generalized'], true) &&
            in_array($this->confidenceClass, ['high', 'medium'], true) &&
            $this->verificationState === 'verified_current' &&
            str_starts_with($this->provenanceReference, 'synthetic:');
    }
}
