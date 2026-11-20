<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Seeders\PrivatePreviewDirectorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class SyntheticDirectoryMeasurementTest extends TestCase
{
    use RefreshDatabase;

    public function test_synthetic_directory_workload_emits_diagnostic_measurements_without_timing_thresholds(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);

        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $entityCount = DB::table('directory_entities')->count();
        $this->assertSame(7, $entityCount);

        $profileId = (string) DB::table('directory_entities')
            ->where('entity_type', 'institution')
            ->orderBy('id')
            ->value('id');
        $programmeIds = DB::table('directory_entities')
            ->where('entity_type', 'programme')
            ->orderBy('id')
            ->limit(2)
            ->pluck('id')
            ->all();
        $this->assertCount(2, $programmeIds);
        $this->withSession(['directory_shortlist' => $programmeIds]);

        $scenarios = [
            'directory_landing' => '/directory?lang=en',
            'text_search' => '/directory?q=Sample&lang=en',
            'manual_locality_filter' => '/directory?locality=Lahore&lang=en',
            'category_filter' => '/directory?type=programme&lang=en',
            'pagination_page_two' => '/directory?page=2&lang=en',
            'profile_read' => '/directory/'.$profileId.'?lang=en',
            'session_comparison' => '/directory/compare?lang=en',
        ];

        $captureQueries = false;
        $queryCount = 0;
        DB::listen(static function () use (&$captureQueries, &$queryCount): void {
            if ($captureQueries) {
                $queryCount++;
            }
        });

        $report = [
            'revision' => getenv('GITHUB_SHA') ?: 'local-unrecorded',
            'php_version' => PHP_VERSION,
            'database_driver' => DB::connection()->getDriverName(),
            'dataset' => [
                'fixture' => 'PrivatePreviewDirectorySeeder',
                'entity_count' => $entityCount,
                'entity_types' => DB::table('directory_entities')
                    ->select('entity_type', DB::raw('COUNT(*) as count'))
                    ->groupBy('entity_type')
                    ->orderBy('entity_type')
                    ->pluck('count', 'entity_type')
                    ->all(),
            ],
            'measurement' => [
                'iterations_per_scenario' => 3,
                'warmup_requests_per_scenario' => 1,
                'concurrency' => 1,
                'mode' => 'in-process HTTP kernel; warm sequential requests; diagnostic only',
                'scenarios' => [],
            ],
        ];

        foreach ($scenarios as $scenario => $path) {
            $this->get($path)->assertOk();
            $samples = [];

            for ($iteration = 0; $iteration < 3; $iteration++) {
                $queryCount = 0;
                $captureQueries = true;
                $startedAt = hrtime(true);
                $response = $this->get($path);
                $elapsedMilliseconds = (hrtime(true) - $startedAt) / 1_000_000;
                $captureQueries = false;

                $response->assertOk();
                $body = (string) $response->getContent();
                $samples[] = [
                    'latency_ms' => $elapsedMilliseconds,
                    'query_count' => $queryCount,
                    'response_bytes' => strlen($body),
                ];
            }

            $latencies = array_column($samples, 'latency_ms');
            $queries = array_column($samples, 'query_count');
            $responseBytes = array_column($samples, 'response_bytes');

            $report['measurement']['scenarios'][$scenario] = [
                'sample_count' => count($samples),
                'latency_ms' => [
                    'p50' => round($this->percentile($latencies, 0.50), 3),
                    'p95' => round($this->percentile($latencies, 0.95), 3),
                    'p99' => round($this->percentile($latencies, 0.99), 3),
                ],
                'query_count_median' => $this->percentile($queries, 0.50),
                'response_bytes_median' => $this->percentile($responseBytes, 0.50),
            ];
        }

        fwrite(STDERR, '[RCV-B07_SYNTHETIC_MEASUREMENT] '.json_encode($report, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES).PHP_EOL);

        $this->assertCount(7, $report['measurement']['scenarios']);
        foreach ($report['measurement']['scenarios'] as $scenario) {
            $this->assertSame(3, $scenario['sample_count']);
            $this->assertGreaterThan(0, $scenario['response_bytes_median']);
            $this->assertGreaterThan(0, $scenario['query_count_median']);
        }
    }

    /** @param array<int, int|float> $values */
    private function percentile(array $values, float $percentile): int|float
    {
        sort($values, SORT_NUMERIC);
        $rank = max(1, (int) ceil($percentile * count($values)));

        return $values[$rank - 1];
    }
}
