<?php

declare(strict_types=1);

namespace App\Services\Directory;

use DateTimeImmutable;
use DateTimeInterface;
use JsonException;

/**
 * Pure, deterministic validation for registry-managed field definitions and values.
 *
 * This service deliberately performs no database reads/writes, source access, clock
 * lookup, claim registration, adjudication or publication. Callers supply all context.
 */
final class TypedFieldValueValidator
{
    private const VALUE_TYPES = [
        'short_text', 'long_text', 'integer', 'decimal', 'boolean', 'date',
        'date_range', 'url', 'email', 'phone', 'enum', 'money', 'duration',
        'language_code', 'entity_reference', 'bounded_object', 'bounded_collection',
    ];

    private const CARDINALITIES = ['one', 'zero_or_one', 'many'];

    private const PRIVACY_CLASSES = ['public_eligible', 'editorial_restricted', 'sensitive_prohibited'];

    private const PROHIBITED_DATA_CLASSES = [
        'student_record', 'applicant_record', 'child_personal_data', 'identity_document',
        'marksheet', 'credential', 'health_data', 'disability_data', 'personal_address',
        'password', 'secret', 'access_token',
    ];

    private const RESTRICTED_PROVIDER_CATEGORIES = ['deeni_madaris', 'madrasah', 'deeni_education'];

    /**
     * @return array{valid: bool, errors: list<array{code: string, path: string}>}
     */
    public function validateFieldKey(string $fieldKey): array
    {
        $errors = [];
        if (preg_match('/^[a-z][a-z0-9]*(?:_[a-z0-9]+)*$/D', $fieldKey) !== 1 ||
            strlen($fieldKey) < 3 || strlen($fieldKey) > 80) {
            $errors[] = ['code' => 'field_key_must_be_lowercase_snake_case', 'path' => 'field_key'];
        }

        return $this->result($errors);
    }

    /**
     * Validate explicit entity/provider/scope applicability without resolving or
     * inferring any relationship. All allowlists must be supplied by the caller.
     *
     * @param array<string, mixed> $definition
     * @param array<string, mixed> $context
     * @return array{valid: bool, errors: list<array{code: string, path: string}>}
     */
    public function validateApplicability(array $definition, array $context): array
    {
        $errors = [];
        $entityTypes = $definition['entity_types'] ?? null;
        $providerCategories = $definition['provider_categories'] ?? null;
        $entityType = $context['entity_type'] ?? null;
        $providerCategory = $context['provider_category'] ?? null;
        $scope = $definition['scope_key'] ?? null;
        $requestedScope = $context['scope_key'] ?? null;

        if (!is_array($entityTypes) || $entityTypes === [] ||
            !is_string($entityType) || !in_array($entityType, $entityTypes, true)) {
            $errors[] = ['code' => 'entity_type_not_applicable', 'path' => 'entity_type'];
        }

        if (!is_array($providerCategories) || $providerCategories === [] ||
            !is_string($providerCategory) || !in_array($providerCategory, $providerCategories, true)) {
            $errors[] = ['code' => 'provider_category_not_applicable', 'path' => 'provider_category'];
        }

        if (is_string($providerCategory) &&
            in_array(strtolower($providerCategory), self::RESTRICTED_PROVIDER_CATEGORIES, true)) {
            $errors[] = ['code' => 'restricted_provider_category_disabled', 'path' => 'provider_category'];
        }

        if (!is_string($scope) || $scope === '' ||
            !is_string($requestedScope) || $requestedScope !== $scope) {
            $errors[] = ['code' => 'scope_mismatch', 'path' => 'scope_key'];
        }

        return $this->result($errors);
    }

    /**
     * Validate field-level cardinality using caller-supplied counts. No existing
     * claims are queried and no count is inferred by this class.
     *
     * @return array{valid: bool, errors: list<array{code: string, path: string}>}
     */
    public function validateCardinality(
        string $cardinality,
        int $existingValueCount,
        int $incomingValueCount,
        int $maximumValues = 100
    ): array {
        $errors = [];
        $total = $existingValueCount + $incomingValueCount;

        if (!in_array($cardinality, self::CARDINALITIES, true) ||
            $existingValueCount < 0 || $incomingValueCount < 0) {
            $errors[] = ['code' => 'invalid_cardinality_context', 'path' => 'cardinality'];
        } elseif ($cardinality === 'one' && $total !== 1) {
            $errors[] = ['code' => 'single_value_required', 'path' => 'cardinality'];
        } elseif ($cardinality === 'zero_or_one' && $total > 1) {
            $errors[] = ['code' => 'single_optional_value_limit_exceeded', 'path' => 'cardinality'];
        } elseif ($cardinality === 'many' &&
            ($maximumValues < 1 || $maximumValues > 100 || $total > $maximumValues)) {
            $errors[] = ['code' => 'bounded_many_value_limit_exceeded', 'path' => 'cardinality'];
        }

        return $this->result($errors);
    }

    /**
     * Validate one proposed value against one exact definition snapshot.
     *
     * Required context: entity_type, provider_category and scope_key.
     * Optional context: locale, audience, data_classes, observed_at,
     * evaluation_at, existing_value_count and maximum_values.
     *
     * @param array<string, mixed> $definition
     * @param array<string, mixed> $context
     * @return array{valid: bool, errors: list<array{code: string, path: string}>}
     */
    public function validate(array $definition, mixed $value, array $context): array
    {
        $errors = [];
        $keyResult = $this->validateFieldKey((string) ($definition['field_key'] ?? ''));
        $errors = array_merge($errors, $keyResult['errors']);

        $type = $definition['value_type'] ?? null;
        if (!is_string($type) || !in_array($type, self::VALUE_TYPES, true)) {
            $errors[] = ['code' => 'unsupported_value_type', 'path' => 'value_type'];
        }

        $cardinality = $definition['cardinality'] ?? null;
        $existingCount = $context['existing_value_count'] ?? 0;
        $rawSchema = $definition['validation_schema'] ?? [];
        $schemaForLimits = is_array($rawSchema) ? $rawSchema : [];
        $maximumValues = $context['maximum_values'] ?? ($schemaForLimits['max_values'] ?? 100);
        if (!is_int($existingCount) || !is_int($maximumValues)) {
            $errors[] = ['code' => 'invalid_cardinality_context', 'path' => 'cardinality'];
        } else {
            $cardinalityResult = $this->validateCardinality(
                is_string($cardinality) ? $cardinality : '',
                $existingCount,
                1,
                $maximumValues
            );
            $errors = array_merge($errors, $cardinalityResult['errors']);
        }

        $applicabilityResult = $this->validateApplicability($definition, $context);
        $errors = array_merge($errors, $applicabilityResult['errors']);

        $privacyResult = $this->validatePrivacy($definition, $context);
        $errors = array_merge($errors, $privacyResult['errors']);

        $schema = $definition['validation_schema'] ?? null;
        if (!is_array($schema) || !is_int($schema['schema_version'] ?? null) ||
            $schema['schema_version'] < 1) {
            $errors[] = ['code' => 'invalid_validation_schema', 'path' => 'validation_schema'];
            $schema = [];
        } elseif (in_array($type, self::VALUE_TYPES, true)) {
            $errors = array_merge($errors, $this->validateType($type, $value, $schema, 'value'));
        }

        $errors = array_merge($errors, $this->validateLocale($schema, $context));
        $errors = array_merge($errors, $this->validateFreshness($definition, $context));

        return $this->result($errors);
    }

    /**
     * @param array<string, mixed> $definition
     * @param array<string, mixed> $context
     * @return list<array{code: string, path: string}>
     */
    private function validatePrivacy(array $definition, array $context): array
    {
        $errors = [];
        $privacy = $definition['privacy_class'] ?? null;
        $visibility = $definition['visibility_class'] ?? null;
        $audience = $context['audience'] ?? 'internal';
        $dataClasses = $context['data_classes'] ?? [];

        if (!is_string($privacy) || !in_array($privacy, self::PRIVACY_CLASSES, true)) {
            $errors[] = ['code' => 'unknown_privacy_class', 'path' => 'privacy_class'];
        } elseif ($privacy === 'sensitive_prohibited') {
            $errors[] = ['code' => 'sensitive_data_class_prohibited', 'path' => 'privacy_class'];
        }

        if ($privacy === 'editorial_restricted' && $audience === 'public') {
            $errors[] = ['code' => 'editorial_restricted_value_not_public', 'path' => 'privacy_class'];
        }

        if (!in_array($visibility, ['public_eligible', 'editorial_restricted', 'internal_only', 'restricted'], true)) {
            $errors[] = ['code' => 'unknown_visibility_class', 'path' => 'visibility_class'];
        } elseif ($audience === 'public' && in_array($visibility, ['internal_only', 'restricted', 'editorial_restricted'], true)) {
            $errors[] = ['code' => 'restricted_visibility_not_public', 'path' => 'visibility_class'];
        }
        if (!in_array($audience, ['internal', 'editorial', 'public'], true)) {
            $errors[] = ['code' => 'unknown_validation_audience', 'path' => 'audience'];
        }

        if (!is_array($dataClasses)) {
            $errors[] = ['code' => 'invalid_data_class_context', 'path' => 'data_classes'];
        } elseif (array_intersect($dataClasses, self::PROHIBITED_DATA_CLASSES) !== []) {
            $errors[] = ['code' => 'prohibited_personal_or_secret_data', 'path' => 'data_classes'];
        }

        if (($context['contains_sensitive_personal_data'] ?? false) === true) {
            $errors[] = ['code' => 'sensitive_personal_data_prohibited', 'path' => 'value'];
        }

        return $errors;
    }

    /**
     * @param array<string, mixed> $schema
     * @param array<string, mixed> $context
     * @return list<array{code: string, path: string}>
     */
    private function validateLocale(array $schema, array $context): array
    {
        $errors = [];
        $locale = $context['locale'] ?? null;
        $required = ($schema['locale_required'] ?? false) === true;
        $allowed = $schema['allowed_locales'] ?? null;

        if ($required && (!is_string($locale) || $locale === '')) {
            $errors[] = ['code' => 'locale_required', 'path' => 'locale'];
        }

        if ($allowed !== null && (!is_array($allowed) || $allowed === [])) {
            $errors[] = ['code' => 'invalid_locale_allowlist', 'path' => 'validation_schema.allowed_locales'];
        }
        if ($locale !== null) {
            if (!is_string($locale) || preg_match('/^[a-z]{2,3}(?:-[A-Z]{2})?$/D', $locale) !== 1) {
                $errors[] = ['code' => 'invalid_locale', 'path' => 'locale'];
            } elseif (is_array($allowed) && !in_array($locale, $allowed, true)) {
                $errors[] = ['code' => 'locale_not_allowed', 'path' => 'locale'];
            }
        }

        return $errors;
    }

    /**
     * Freshness checks are deterministic: the caller supplies both timestamps.
     *
     * @param array<string, mixed> $definition
     * @param array<string, mixed> $context
     * @return list<array{code: string, path: string}>
     */
    private function validateFreshness(array $definition, array $context): array
    {
        $policy = $definition['freshness_policy'] ?? [];
        if (!is_array($policy)) {
            return [['code' => 'invalid_freshness_policy', 'path' => 'freshness_policy']];
        }

        $maximumAge = $policy['max_age_days'] ?? null;
        if ($maximumAge === null) {
            return [];
        }
        if (!is_int($maximumAge) || $maximumAge < 0) {
            return [['code' => 'invalid_freshness_limit', 'path' => 'freshness_policy.max_age_days']];
        }

        $observedAt = $this->parseDateTime($context['observed_at'] ?? null);
        $evaluationAt = $this->parseDateTime($context['evaluation_at'] ?? null);
        if ($observedAt === null || $evaluationAt === null) {
            return [['code' => 'freshness_timestamps_required', 'path' => 'freshness']];
        }
        if ($observedAt > $evaluationAt) {
            return [['code' => 'observation_time_in_future', 'path' => 'observed_at']];
        }

        $ageSeconds = $evaluationAt->getTimestamp() - $observedAt->getTimestamp();
        if ($ageSeconds > ($maximumAge * 86400)) {
            return [['code' => 'value_exceeds_freshness_window', 'path' => 'observed_at']];
        }

        return [];
    }

    /**
     * @param array<string, mixed> $schema
     * @return list<array{code: string, path: string}>
     */
    private function validateType(string $type, mixed $value, array $schema, string $path): array
    {
        $errors = [];
        if ($value === null) {
            return [['code' => 'missing_value_is_not_a_value', 'path' => $path]];
        }

        switch ($type) {
            case 'short_text':
            case 'long_text':
                $max = $schema['max_length'] ?? null;
                $limit = $type === 'short_text' ? 500 : 10000;
                if (!is_string($value) || preg_match('//u', $value) !== 1 ||
                    !is_int($max) || $max < 1 || $max > $limit ||
                    $this->characterLength($value) > $max ||
                    str_contains($value, "\0")) {
                    $errors[] = ['code' => 'invalid_bounded_text', 'path' => $path];
                }
                if ($type === 'long_text' && is_string($value) &&
                    (stripos($value, '<script') !== false || stripos($value, '<iframe') !== false)) {
                    $errors[] = ['code' => 'active_markup_prohibited', 'path' => $path];
                }
                break;

            case 'integer':
                if (!is_int($value) ||
                    (isset($schema['minimum']) && $value < $schema['minimum']) ||
                    (isset($schema['maximum']) && $value > $schema['maximum'])) {
                    $errors[] = ['code' => 'invalid_integer', 'path' => $path];
                }
                break;

            case 'decimal':
                $scale = $schema['scale'] ?? null;
                $precision = $schema['precision'] ?? null;
                if ((!is_string($value) && !is_int($value)) ||
                    !is_int($scale) || $scale < 0 || $scale > 8 ||
                    !is_int($precision) || $precision < 1 || $precision > 18 ||
                    $this->matchesDecimal((string) $value, $scale, $precision) === false ||
                    (isset($schema['minimum']) && (float) $value < (float) $schema['minimum']) ||
                    (isset($schema['maximum']) && (float) $value > (float) $schema['maximum'])) {
                    $errors[] = ['code' => 'invalid_fixed_precision_decimal', 'path' => $path];
                }
                break;

            case 'boolean':
                if (!is_bool($value)) {
                    $errors[] = ['code' => 'invalid_boolean', 'path' => $path];
                }
                break;

            case 'date':
                if ($this->isIsoDate($value) === false) {
                    $errors[] = ['code' => 'invalid_iso_date', 'path' => $path];
                }
                break;

            case 'date_range':
                if (!is_array($value) || array_is_list($value) ||
                    $this->isIsoDate($value['start'] ?? null) === false ||
                    $this->isIsoDate($value['end'] ?? null) === false ||
                    !is_bool($schema['end_inclusive'] ?? null) ||
                    $value['start'] > $value['end'] ||
                    ($value['start'] === $value['end'] && $schema['end_inclusive'] === false)) {
                    $errors[] = ['code' => 'invalid_date_range', 'path' => $path];
                }
                break;

            case 'url':
                if (!is_string($value) || filter_var($value, FILTER_VALIDATE_URL) === false) {
                    $errors[] = ['code' => 'invalid_http_url', 'path' => $path];
                } else {
                    $parts = parse_url($value);
                    if (!is_array($parts) || !in_array(strtolower((string) ($parts['scheme'] ?? '')), ['http', 'https'], true) ||
                        empty($parts['host']) || isset($parts['user']) || isset($parts['pass'])) {
                        $errors[] = ['code' => 'invalid_http_url', 'path' => $path];
                    }
                }
                break;

            case 'email':
                $allowedDomains = $schema['allowed_domains'] ?? null;
                $domain = is_string($value) && str_contains($value, '@') ? strtolower(substr(strrchr($value, '@'), 1)) : '';
                if (!is_string($value) || filter_var($value, FILTER_VALIDATE_EMAIL) === false ||
                    strlen($value) > 254 || !is_array($allowedDomains) || $allowedDomains === [] ||
                    !in_array($domain, array_map('strtolower', $allowedDomains), true)) {
                    $errors[] = ['code' => 'invalid_or_unapproved_institutional_email', 'path' => $path];
                }
                break;

            case 'phone':
                if (!is_string($value) || preg_match('/^\+[1-9][0-9]{7,14}$/D', $value) !== 1) {
                    $errors[] = ['code' => 'phone_must_be_normalized_e164', 'path' => $path];
                }
                break;

            case 'enum':
                $allowed = $schema['allowed_values'] ?? null;
                if (!is_string($value) || !is_array($allowed) || $allowed === [] ||
                    !in_array($value, $allowed, true)) {
                    $errors[] = ['code' => 'enum_value_not_allowed', 'path' => $path];
                }
                break;

            case 'money':
                if (!is_array($value) || array_is_list($value) ||
                    (!is_string($value['amount'] ?? null) && !is_int($value['amount'] ?? null)) ||
                    !is_int($schema['scale'] ?? null) || !is_int($schema['precision'] ?? null) ||
                    str_starts_with((string) ($value['amount'] ?? ''), '-') ||
                    $this->matchesDecimal((string) ($value['amount'] ?? ''), $schema['scale'] ?? -1, $schema['precision'] ?? 0) === false ||
                    !is_string($value['currency'] ?? null) ||
                    preg_match('/^[A-Z]{3}$/D', $value['currency']) !== 1 ||
                    !is_string($value['period'] ?? null) || trim($value['period']) === '' ||
                    !is_string($value['component'] ?? null) || trim($value['component']) === '') {
                    $errors[] = ['code' => 'invalid_money_context', 'path' => $path];
                } elseif (!is_array($schema['allowed_currencies'] ?? null) ||
                    $schema['allowed_currencies'] === [] ||
                    !in_array($value['currency'], $schema['allowed_currencies'], true)) {
                    $errors[] = ['code' => 'currency_not_allowed', 'path' => $path.'.currency'];
                }
                break;

            case 'duration':
                $units = $schema['allowed_units'] ?? null;
                if (!is_array($value) || array_is_list($value) ||
                    (!is_int($value['amount'] ?? null) && !is_string($value['amount'] ?? null)) ||
                    !is_string($value['unit'] ?? null) || !is_array($units) ||
                    !in_array($value['unit'], $units, true) ||
                    !is_string((string) $value['amount']) ||
                    preg_match('/^[0-9]+(?:\\.[0-9]+)?$/D', (string) $value['amount']) !== 1 ||
                    (float) $value['amount'] <= 0) {
                    $errors[] = ['code' => 'invalid_duration_or_unit', 'path' => $path];
                }
                break;

            case 'language_code':
                $languageAllowlist = $schema['allowed_values'] ?? null;
                if (!is_string($value) || preg_match('/^[a-z]{2,3}(?:-[A-Z]{2})?$/D', $value) !== 1 ||
                    !is_array($languageAllowlist) || $languageAllowlist === [] ||
                    !in_array($value, $languageAllowlist, true)) {
                    $errors[] = ['code' => 'invalid_or_unapproved_language_code', 'path' => $path];
                }
                break;

            case 'entity_reference':
                $targets = $schema['allowed_target_entity_types'] ?? null;
                if (!is_array($value) || array_is_list($value) ||
                    !is_string($value['id'] ?? null) ||
                    preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-8][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/iD', $value['id']) !== 1 ||
                    !is_string($value['entity_type'] ?? null) || !is_array($targets) ||
                    !in_array($value['entity_type'], $targets, true)) {
                    $errors[] = ['code' => 'invalid_entity_reference', 'path' => $path];
                }
                break;

            case 'bounded_object':
                $properties = $schema['properties'] ?? null;
                $required = $schema['required'] ?? [];
                $maxDepth = $schema['max_depth'] ?? 3;
                $maxKeys = $schema['max_keys'] ?? 20;
                $maxBytes = $schema['max_bytes'] ?? 4096;
                if (!is_array($value) || array_is_list($value) || !is_array($properties) ||
                    !is_array($required) || !is_int($maxDepth) || $maxDepth < 1 || $maxDepth > 5 ||
                    !is_int($maxKeys) || $maxKeys < 1 || $maxKeys > 50 ||
                    !is_int($maxBytes) || $maxBytes < 1 || $maxBytes > 16384) {
                    $errors[] = ['code' => 'invalid_bounded_object', 'path' => $path];
                    break;
                }
                try {
                    $encoded = json_encode($value, JSON_THROW_ON_ERROR);
                } catch (JsonException) {
                    $errors[] = ['code' => 'invalid_bounded_object_encoding', 'path' => $path];
                    break;
                }
                if (strlen($encoded) > $maxBytes || count($value) > $maxKeys ||
                    $this->arrayDepth($value) > $maxDepth ||
                    array_diff(array_keys($value), array_keys($properties)) !== [] ||
                    array_diff($required, array_keys($value)) !== []) {
                    $errors[] = ['code' => 'bounded_object_constraints_failed', 'path' => $path];
                    break;
                }
                foreach ($value as $key => $item) {
                    $property = $properties[$key] ?? null;
                    if (!is_array($property) || !is_string($property['type'] ?? null)) {
                        $errors[] = ['code' => 'invalid_object_property_schema', 'path' => $path.'.'.$key];
                        continue;
                    }
                    $errors = array_merge($errors, $this->validateType($property['type'], $item, $property, $path.'.'.$key));
                }
                break;

            case 'bounded_collection':
                $maxItems = $schema['max_items'] ?? null;
                $minItems = $schema['min_items'] ?? 0;
                $itemSchema = $schema['item_schema'] ?? null;
                if (!is_array($value) || !array_is_list($value) ||
                    !is_int($maxItems) || $maxItems < 1 || $maxItems > 100 ||
                    !is_int($minItems) || $minItems < 0 || $minItems > $maxItems ||
                    count($value) < $minItems || count($value) > $maxItems ||
                    !is_array($itemSchema) || !is_string($itemSchema['type'] ?? null)) {
                    $errors[] = ['code' => 'bounded_collection_constraints_failed', 'path' => $path];
                    break;
                }
                foreach ($value as $index => $item) {
                    $errors = array_merge($errors, $this->validateType(
                        $itemSchema['type'],
                        $item,
                        $itemSchema,
                        $path.'.'.$index
                    ));
                }
                break;

            default:
                $errors[] = ['code' => 'unsupported_nested_value_type', 'path' => $path];
                break;
        }

        if (isset($schema['allowed_units']) && is_array($value) && isset($value['unit']) &&
            is_array($schema['allowed_units']) && !in_array($value['unit'], $schema['allowed_units'], true)) {
            $errors[] = ['code' => 'unit_not_allowed', 'path' => $path.'.unit'];
        }

        return $errors;
    }

    private function matchesDecimal(string $value, int $scale, int $precision): bool
    {
        if ($scale < 0 || $scale > 8 || $precision < 1 || $precision > 18) {
            return false;
        }
        if (preg_match('/^-?[0-9]+(?:\.([0-9]+))?$/D', $value, $matches) !== 1) {
            return false;
        }
        $fraction = $matches[1] ?? '';
        $digits = strlen(str_replace(['-', '.'], '', $value));

        return strlen($fraction) <= $scale && $digits <= $precision;
    }

    private function isIsoDate(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        $errors = DateTimeImmutable::getLastErrors();

        return $date !== false && ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0)) &&
            $date->format('Y-m-d') === $value;
    }

    private function parseDateTime(mixed $value): ?DateTimeImmutable
    {
        if ($value instanceof DateTimeInterface) {
            return DateTimeImmutable::createFromInterface($value);
        }
        if (!is_string($value) || trim($value) === '') {
            return null;
        }
        try {
            return new DateTimeImmutable($value);
        } catch (\Throwable) {
            return null;
        }
    }

    private function characterLength(string $value): int
    {
        $count = preg_match_all('/./us', $value);

        return $count === false ? PHP_INT_MAX : $count;
    }

    private function arrayDepth(array $value, int $depth = 1): int
    {
        $maximum = $depth;
        foreach ($value as $item) {
            if (is_array($item)) {
                $maximum = max($maximum, $this->arrayDepth($item, $depth + 1));
            }
        }

        return $maximum;
    }

    /**
     * @param list<array{code: string, path: string}> $errors
     * @return array{valid: bool, errors: list<array{code: string, path: string}>}
     */
    private function result(array $errors): array
    {
        return ['valid' => $errors === [], 'errors' => array_values($errors)];
    }
}
