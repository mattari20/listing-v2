<?php

declare(strict_types=1);
namespace App\Domain\Directory;
use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;
final class ProviderInstitutionRelationshipPolicy
{
    private const PREDICATES = ['operates', 'owns', 'administers'];

    public function assertPredicate(string $predicate): void
    {
        if (in_array($predicate, self::PREDICATES, true) === false) {
            throw ValidationException::withMessages(['relationship_type' => 'Predicate is not enabled for M3-04 P01.']);
        }
    }

    public function assertEndpoints(string $fromType, string $toType, string $predicate): void
    {
        $this->assertPredicate($predicate);
        if ($fromType !== 'provider' || $toType !== 'institution') {
            throw ValidationException::withMessages(['endpoints' => 'P01 relationships must be directed from Provider to Institution.']);
        }
    }

    public function assertValidDates(?string $from, ?string $to): void
    {
        foreach (['valid_from' => $from, 'valid_to' => $to] as $field => $date) {
            if ($date === null) {
                continue;
            }
            try { $parsed = CarbonImmutable::parse($date); } catch (\Throwable) {
                throw ValidationException::withMessages([$field => 'A valid ISO calendar date is required.']);
            }
            if ($parsed->format('Y-m-d') !== $date) {
                throw ValidationException::withMessages([$field => 'Dates must use YYYY-MM-DD format.']);
            }
        }
        if ($from !== null && $to !== null && $to < $from) {
            throw ValidationException::withMessages(['validity' => 'Inclusive end date cannot precede start date.']);
        }
    }

    public function value(string $from, string $to, string $predicate, ?string $scope, ?string $jurisdiction): array
    {
        return ['from_entity_id' => $from, 'to_entity_id' => $to, 'relationship_type' => $predicate, 'scope' => $scope, 'jurisdiction' => $jurisdiction];
    }
}
