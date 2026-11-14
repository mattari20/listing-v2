<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\TypedFieldValueValidator;
use PHPUnit\Framework\TestCase;

class TypedFieldValueValidatorTest extends TestCase
{
    private TypedFieldValueValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new TypedFieldValueValidator;
    }

    public function test_field_keys_must_use_lowercase_ascii_snake_case(): void
    {
        self::assertTrue($this->validator->validateFieldKey('school_grade_range')['valid']);
        self::assertFalse($this->validator->validateFieldKey('institution.display_name')['valid']);
        self::assertFalse($this->validator->validateFieldKey('Uppercase_Key')['valid']);
        self::assertFalse($this->validator->validateFieldKey('ab')['valid']);
    }

    public function test_applicability_requires_explicit_entity_provider_and_exact_scope(): void
    {
        $definition = $this->definition();
        self::assertTrue($this->validator->validateApplicability($definition, $this->context())['valid']);
        self::assertFalse($this->validator->validateApplicability($definition, $this->context(['entity_type' => 'campus']))['valid']);
        self::assertFalse($this->validator->validateApplicability($definition, $this->context(['provider_category' => 'academy']))['valid']);
        self::assertFalse($this->validator->validateApplicability($definition, $this->context(['scope_key' => 'campus']))['valid']);
    }

    public function test_restricted_deeni_category_remains_disabled(): void
    {
        $definition = $this->definition(['provider_categories' => ['deeni_madaris']]);
        $result = $this->validator->validateApplicability($definition, $this->context(['provider_category' => 'deeni_madaris']));
        self::assertFalse($result['valid']);
        self::assertContains('restricted_provider_category_disabled', array_column($result['errors'], 'code'));
    }

    public function test_cardinality_is_bounded_and_never_infers_missing_as_false_or_zero(): void
    {
        self::assertTrue($this->validator->validateCardinality('one', 0, 1)['valid']);
        self::assertFalse($this->validator->validateCardinality('one', 0, 0)['valid']);
        self::assertFalse($this->validator->validateCardinality('one', 1, 1)['valid']);
        self::assertTrue($this->validator->validateCardinality('zero_or_one', 0, 1)['valid']);
        self::assertFalse($this->validator->validateCardinality('zero_or_one', 1, 1)['valid']);
        self::assertTrue($this->validator->validateCardinality('many', 2, 1, 3)['valid']);
        self::assertFalse($this->validator->validateCardinality('many', 3, 1, 3)['valid']);
    }

    public function test_short_text_is_utf8_bounded_and_rejects_invalid_payloads(): void
    {
        $definition = $this->definition(['validation_schema' => ['schema_version' => 1, 'max_length' => 8]]);
        self::assertTrue($this->validator->validate($definition, 'School', $this->context())['valid']);
        self::assertFalse($this->validator->validate($definition, 'A string that is too long', $this->context())['valid']);
        self::assertFalse($this->validator->validate($definition, null, $this->context())['valid']);
    }

    public function test_integer_decimal_boolean_and_date_are_strictly_typed(): void
    {
        self::assertTrue($this->validateType('integer', 4, ['schema_version' => 1, 'minimum' => 1, 'maximum' => 5])['valid']);
        self::assertFalse($this->validateType('integer', '4')['valid']);
        self::assertTrue($this->validateType('decimal', '12.50', ['schema_version' => 1, 'precision' => 5, 'scale' => 2])['valid']);
        self::assertFalse($this->validateType('decimal', '12.500', ['schema_version' => 1, 'precision' => 5, 'scale' => 2])['valid']);
        self::assertTrue($this->validateType('boolean', false)['valid']);
        self::assertFalse($this->validateType('boolean', 0)['valid']);
        self::assertTrue($this->validateType('date', '2026-11-14')['valid']);
        self::assertFalse($this->validateType('date', '2026-02-30')['valid']);
    }

    public function test_date_range_requires_valid_ordered_iso_dates(): void
    {
        self::assertTrue($this->validateType('date_range', ['start' => '2026-01-01', 'end' => '2026-12-31'])['valid']);
        self::assertFalse($this->validateType('date_range', ['start' => '2026-12-31', 'end' => '2026-01-01'])['valid']);
    }

    public function test_urls_email_and_phone_are_restricted_to_safe_normalized_forms(): void
    {
        self::assertTrue($this->validateType('url', 'https://example.edu')['valid']);
        self::assertFalse($this->validateType('url', 'javascript:alert(1)')['valid']);
        self::assertFalse($this->validateType('url', 'https://user:pass@example.edu')['valid']);
        self::assertTrue($this->validateType('email', 'office@example.edu')['valid']);
        self::assertFalse($this->validateType('email', 'not-an-email')['valid']);
        self::assertTrue($this->validateType('phone', '+923001234567')['valid']);
        self::assertFalse($this->validateType('phone', '03001234567')['valid']);
    }

    public function test_enum_language_and_entity_reference_require_allowlisted_values(): void
    {
        self::assertTrue($this->validateType('enum', 'onsite', ['schema_version' => 1, 'allowed_values' => ['onsite', 'online']])['valid']);
        self::assertFalse($this->validateType('enum', 'hybrid', ['schema_version' => 1, 'allowed_values' => ['onsite', 'online']])['valid']);
        self::assertTrue($this->validateType('language_code', 'ur-PK')['valid']);
        self::assertFalse($this->validateType('language_code', 'unknown_language')['valid']);
        self::assertTrue($this->validateType('entity_reference', [
            'id' => '123e4567-e89b-42d3-a456-426614174000',
            'entity_type' => 'campus',
        ], ['schema_version' => 1, 'allowed_target_entity_types' => ['campus']])['valid']);
    }

    public function test_money_and_duration_require_context_and_controlled_units(): void
    {
        self::assertTrue($this->validateType('money', [
            'amount' => '25000.00', 'currency' => 'PKR', 'period' => '2026-2027', 'component' => 'tuition',
        ], ['schema_version' => 1, 'precision' => 12, 'scale' => 2, 'allowed_currencies' => ['PKR']])['valid']);
        self::assertFalse($this->validateType('money', [
            'amount' => '25000.00', 'currency' => 'XYZ', 'period' => '', 'component' => 'tuition',
        ], ['schema_version' => 1, 'precision' => 12, 'scale' => 2, 'allowed_currencies' => ['PKR']])['valid']);
        self::assertTrue($this->validateType('duration', ['amount' => 6, 'unit' => 'months'], [
            'schema_version' => 1, 'allowed_units' => ['months', 'years'],
        ])['valid']);
        self::assertFalse($this->validateType('duration', ['amount' => 6, 'unit' => 'unknown'], [
            'schema_version' => 1, 'allowed_units' => ['months', 'years'],
        ])['valid']);
    }

    public function test_bounded_object_and_collection_enforce_allowlisted_shapes_and_limits(): void
    {
        self::assertTrue($this->validateType('bounded_object', ['mode' => 'online'], [
            'schema_version' => 1,
            'properties' => ['mode' => ['type' => 'enum', 'allowed_values' => ['online', 'onsite']]],
            'required' => ['mode'],
            'max_depth' => 2,
            'max_keys' => 2,
            'max_bytes' => 128,
        ])['valid']);
        self::assertFalse($this->validateType('bounded_object', ['mode' => 'online', 'unlisted' => true], [
            'schema_version' => 1,
            'properties' => ['mode' => ['type' => 'enum', 'allowed_values' => ['online']]],
            'required' => ['mode'],
            'max_depth' => 2,
            'max_keys' => 2,
            'max_bytes' => 128,
        ])['valid']);
        self::assertTrue($this->validateType('bounded_collection', ['A', 'B'], [
            'schema_version' => 1, 'min_items' => 1, 'max_items' => 3,
            'item_schema' => ['type' => 'short_text', 'max_length' => 10],
        ])['valid']);
        self::assertFalse($this->validateType('bounded_collection', ['A', 'B', 'C', 'D'], [
            'schema_version' => 1, 'min_items' => 1, 'max_items' => 3,
            'item_schema' => ['type' => 'short_text', 'max_length' => 10],
        ])['valid']);
    }

    public function test_locale_units_and_freshness_are_explicit_and_deterministic(): void
    {
        $definition = $this->definition([
            'value_type' => 'short_text',
            'validation_schema' => ['schema_version' => 1, 'max_length' => 120, 'locale_required' => true, 'allowed_locales' => ['en', 'ur']],
            'freshness_policy' => ['max_age_days' => 30],
        ]);
        self::assertTrue($this->validator->validate($definition, 'Admissions open', $this->context([
            'locale' => 'en', 'observed_at' => '2026-11-01T00:00:00Z', 'evaluation_at' => '2026-11-14T00:00:00Z',
        ]))['valid']);
        self::assertFalse($this->validator->validate($definition, 'Admissions open', $this->context([
            'locale' => 'fr', 'observed_at' => '2026-10-01T00:00:00Z', 'evaluation_at' => '2026-11-14T00:00:00Z',
        ]))['valid']);
        self::assertFalse($this->validator->validate($definition, 'Admissions open', $this->context([
            'locale' => 'en', 'observed_at' => '2026-12-01T00:00:00Z', 'evaluation_at' => '2026-11-14T00:00:00Z',
        ]))['valid']);
    }

    public function test_privacy_prohibits_sensitive_personal_data_and_internal_fields_from_public_audience(): void
    {
        $definition = $this->definition(['privacy_class' => 'sensitive_prohibited']);
        self::assertFalse($this->validator->validate($definition, 'synthetic', $this->context())['valid']);

        $definition = $this->definition(['privacy_class' => 'editorial_restricted', 'visibility_class' => 'internal_only']);
        self::assertFalse($this->validator->validate($definition, 'synthetic', $this->context(['audience' => 'public']))['valid']);
        self::assertFalse($this->validator->validate($this->definition(), 'synthetic', $this->context([
            'data_classes' => ['student_record'],
        ]))['valid']);
    }

    public function test_validation_is_pure_and_returns_safe_reason_codes_only(): void
    {
        $result = $this->validator->validate($this->definition(), 'valid', $this->context());
        self::assertSame(['valid', 'errors'], array_keys($result));
        self::assertTrue($result['valid']);
        self::assertSame([], $result['errors']);
    }

    private function validateType(string $type, mixed $value, array $schema = ['schema_version' => 1]): array
    {
        return $this->validator->validate(
            $this->definition(['value_type' => $type, 'validation_schema' => $schema]),
            $value,
            $this->context()
        );
    }

    private function definition(array $overrides = []): array
    {
        return array_replace([
            'field_key' => 'school_grade_range',
            'value_type' => 'short_text',
            'cardinality' => 'zero_or_one',
            'scope_key' => 'institution',
            'entity_types' => ['institution'],
            'provider_categories' => ['private_school'],
            'privacy_class' => 'public_eligible',
            'visibility_class' => 'public_eligible',
            'validation_schema' => ['schema_version' => 1, 'max_length' => 120],
            'freshness_policy' => [],
        ], $overrides);
    }

    private function context(array $overrides = []): array
    {
        return array_replace([
            'entity_type' => 'institution',
            'provider_category' => 'private_school',
            'scope_key' => 'institution',
            'audience' => 'internal',
        ], $overrides);
    }
}
