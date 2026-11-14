<?php

declare(strict_types=1);

namespace App\Services\Directory;

use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use JsonException;

final class FieldDefinitionRegistryReader
{
    /**
     * Read one exact immutable definition version. No "latest version" fallback is performed.
     *
     * @return array<string, mixed>|null
     */
    public function findVersion(string $fieldKey, int $versionNumber): ?array
    {
        $row = DB::table('field_definitions as definitions')
            ->join('field_definition_versions as versions', 'versions.field_definition_id', '=', 'definitions.id')
            ->where('definitions.field_key', $fieldKey)
            ->where('versions.version_number', $versionNumber)
            ->first([
                'definitions.id as field_definition_id',
                'definitions.field_key',
                'versions.id as field_definition_version_id',
                'versions.version_number',
                'versions.lifecycle_state',
                'versions.semantic_version',
                'versions.compatibility_class',
                'versions.value_type',
                'versions.cardinality',
                'versions.scope_key',
                'versions.privacy_class',
                'versions.visibility_class',
                'versions.searchable',
                'versions.filterable',
                'versions.sortable',
                'versions.validation_schema',
                'versions.presentation_metadata',
                'versions.evidence_policy',
                'versions.freshness_policy',
                'versions.effective_from',
                'versions.effective_to',
                'versions.successor_field_definition_id',
            ]);

        return $row === null ? null : $this->mapDefinition($row);
    }

    /**
     * Read all versions for a key in ascending immutable version order.
     *
     * @return list<array<string, mixed>>
     */
    public function versionsForKey(string $fieldKey): array
    {
        $rows = DB::table('field_definitions as definitions')
            ->join('field_definition_versions as versions', 'versions.field_definition_id', '=', 'definitions.id')
            ->where('definitions.field_key', $fieldKey)
            ->orderBy('versions.version_number')
            ->get([
                'definitions.id as field_definition_id',
                'definitions.field_key',
                'versions.id as field_definition_version_id',
                'versions.version_number',
                'versions.lifecycle_state',
                'versions.semantic_version',
                'versions.compatibility_class',
                'versions.value_type',
                'versions.cardinality',
                'versions.scope_key',
                'versions.privacy_class',
                'versions.visibility_class',
                'versions.searchable',
                'versions.filterable',
                'versions.sortable',
                'versions.validation_schema',
                'versions.presentation_metadata',
                'versions.evidence_policy',
                'versions.freshness_policy',
                'versions.effective_from',
                'versions.effective_to',
                'versions.successor_field_definition_id',
            ]);

        return $rows->map(fn (object $row): array => $this->mapDefinition($row))->all();
    }

    /**
     * Resolve exact-version applicability. Entity and provider applicability are explicit;
     * neither is inherited from a parent or inferred from a label.
     *
     * @return array{allowed: bool, reason: string, definition: array<string, mixed>|null}
     */
    public function resolveApplicable(
        string $fieldKey,
        int $versionNumber,
        string $entityType,
        string $providerCategory,
        ?DateTimeInterface $at = null
    ): array {
        $definition = $this->findVersion($fieldKey, $versionNumber);

        if ($definition === null) {
            return ['allowed' => false, 'reason' => 'definition_not_found', 'definition' => null];
        }

        if ($definition['lifecycle_state'] !== 'active') {
            return ['allowed' => false, 'reason' => 'definition_not_active', 'definition' => $definition];
        }

        $instant = $at === null
            ? CarbonImmutable::now()
            : CarbonImmutable::instance($at);

        if ($definition['effective_from'] !== null && $instant->lt(CarbonImmutable::parse($definition['effective_from']))) {
            return ['allowed' => false, 'reason' => 'definition_not_yet_effective', 'definition' => $definition];
        }

        if ($definition['effective_to'] !== null && $instant->gte(CarbonImmutable::parse($definition['effective_to']))) {
            return ['allowed' => false, 'reason' => 'definition_expired', 'definition' => $definition];
        }

        $entityAllowed = DB::table('field_definition_version_entity_types')
            ->where('field_definition_version_id', $definition['field_definition_version_id'])
            ->where('entity_type', $entityType)
            ->exists();

        if ($entityAllowed === false) {
            return ['allowed' => false, 'reason' => 'entity_type_not_applicable', 'definition' => $definition];
        }

        $categoryAllowed = DB::table('field_definition_version_provider_categories')
            ->where('field_definition_version_id', $definition['field_definition_version_id'])
            ->where('provider_category', $providerCategory)
            ->exists();

        if ($categoryAllowed === false) {
            return ['allowed' => false, 'reason' => 'provider_category_not_applicable', 'definition' => $definition];
        }

        return ['allowed' => true, 'reason' => 'applicable', 'definition' => $definition];
    }

    /**
     * @return array<string, mixed>
     *
     * @throws JsonException
     */
    private function mapDefinition(object $row): array
    {
        return [
            'field_definition_id' => (string) $row->field_definition_id,
            'field_key' => (string) $row->field_key,
            'field_definition_version_id' => (string) $row->field_definition_version_id,
            'version_number' => (int) $row->version_number,
            'lifecycle_state' => (string) $row->lifecycle_state,
            'semantic_version' => (string) $row->semantic_version,
            'compatibility_class' => (string) $row->compatibility_class,
            'value_type' => (string) $row->value_type,
            'cardinality' => (string) $row->cardinality,
            'scope_key' => (string) $row->scope_key,
            'privacy_class' => (string) $row->privacy_class,
            'visibility_class' => (string) $row->visibility_class,
            'searchable' => (bool) $row->searchable,
            'filterable' => (bool) $row->filterable,
            'sortable' => (bool) $row->sortable,
            'validation_schema' => json_decode((string) $row->validation_schema, true, 32, JSON_THROW_ON_ERROR),
            'presentation_metadata' => json_decode((string) $row->presentation_metadata, true, 32, JSON_THROW_ON_ERROR),
            'evidence_policy' => json_decode((string) $row->evidence_policy, true, 32, JSON_THROW_ON_ERROR),
            'freshness_policy' => json_decode((string) $row->freshness_policy, true, 32, JSON_THROW_ON_ERROR),
            'effective_from' => $row->effective_from,
            'effective_to' => $row->effective_to,
            'successor_field_definition_id' => $row->successor_field_definition_id,
        ];
    }
}
