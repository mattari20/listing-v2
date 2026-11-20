<?php

declare(strict_types=1);

namespace App\Services\Directory;

final class PublicDirectoryComparisonService
{
    private const NAME_FACTS = ['display_name', 'common_name', 'official_name'];

    /**
     * Build a like-for-like comparison from already-approved public profiles only.
     *
     * @param  array<int, array<string, mixed>>  $profiles
     * @return array{rows: array<int, array<string, mixed>>}
     */
    public function compare(array $profiles): array
    {
        $rows = [];

        foreach ($profiles as $profile) {
            foreach ($profile['facts'] as $fact) {
                $key = (string) $fact['key'];
                if (in_array($key, self::NAME_FACTS, true)) {
                    continue;
                }

                $rows[$key] ??= [
                    'key' => $key,
                    'label' => (string) $fact['label'],
                    'values' => [],
                ];
                $rows[$key]['values'][$profile['id']] = [
                    'state' => 'published',
                    'value' => $fact['value'],
                    'observed_at' => $fact['observed_at'],
                ];
            }
        }

        foreach ($rows as &$row) {
            foreach ($profiles as $profile) {
                $row['values'][$profile['id']] ??= [
                    'state' => 'not_stated',
                    'value' => null,
                    'observed_at' => null,
                ];
            }
        }
        unset($row);

        uasort($rows, static fn (array $left, array $right): int => strnatcasecmp($left['label'], $right['label']));

        return ['rows' => array_values($rows)];
    }
}
