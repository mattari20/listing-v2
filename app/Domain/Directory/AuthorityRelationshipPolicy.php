<?php

declare(strict_types=1);

namespace App\Domain\Directory;

use Illuminate\Validation\ValidationException;

final class AuthorityRelationshipPolicy
{
    private const AUTHORITY_TYPES = [
        'regulator',
        'licensing_authority',
        'accreditation_body',
        'recognition_authority',
        'examining_body',
        'affiliation_body',
    ];

    private const RULES = [
        'regulated_by' => ['subjects' => ['institution', 'campus', 'programme'], 'target' => 'authority', 'authority' => ['regulator']],
        'licensed_by' => ['subjects' => ['institution', 'campus'], 'target' => 'authority', 'authority' => ['licensing_authority']],
        'accredited_by' => ['subjects' => ['institution', 'campus', 'programme'], 'target' => 'authority', 'authority' => ['accreditation_body']],
        'recognized_by' => ['subjects' => ['institution', 'campus', 'programme', 'qualification'], 'target' => 'authority', 'authority' => ['recognition_authority']],
        'examined_by' => ['subjects' => ['programme', 'qualification'], 'target' => 'authority', 'authority' => ['examining_body']],
        'awarded_by' => ['subjects' => ['qualification'], 'target' => 'awarding_body', 'authority' => []],
        'affiliated_with' => ['subjects' => ['institution', 'campus'], 'target' => 'authority', 'authority' => ['affiliation_body']],
    ];

    public function assertAuthorityType(string $type): void
    {
        if (! in_array($type, self::AUTHORITY_TYPES, true)) {
            throw ValidationException::withMessages(['authority_type' => 'Authority type is not in the controlled P03 vocabulary.']);
        }
    }

    public function assertRelationship(string $predicate, string $subjectType, string $targetType, ?string $authorityType): void
    {
        $rule = self::RULES[$predicate] ?? null;
        if ($rule === null || ! in_array($subjectType, $rule['subjects'], true) || $targetType !== $rule['target']) {
            throw ValidationException::withMessages(['relationship' => 'Predicate or typed relationship endpoints are not permitted by P03.']);
        }
        if ($targetType === 'authority' && ! in_array($authorityType, $rule['authority'], true)) {
            throw ValidationException::withMessages(['authority_type' => 'The authority type cannot satisfy this relationship predicate.']);
        }
        if ($targetType === 'awarding_body' && $authorityType !== null) {
            throw ValidationException::withMessages(['authority_type' => 'Awarding bodies are distinct identities, not authority profiles.']);
        }
    }

    public function assertDates(?string $from, ?string $to): void
    {
        foreach (['valid_from' => $from, 'valid_to' => $to] as $field => $date) {
            if ($date === null) {
                continue;
            }
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) !== 1 || ! checkdate((int) substr($date, 5, 2), (int) substr($date, 8, 2), (int) substr($date, 0, 4))) {
                throw ValidationException::withMessages([$field => 'Date must be a valid YYYY-MM-DD calendar date.']);
            }
        }
        if ($from !== null && $to !== null && $to < $from) {
            throw ValidationException::withMessages(['validity' => 'Inclusive end date cannot precede start date.']);
        }
    }
}
