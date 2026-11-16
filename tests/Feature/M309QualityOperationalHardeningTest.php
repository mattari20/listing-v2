<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

final class M309QualityOperationalHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_directory_search_has_semantic_accessibility_landmarks_and_associated_labels(): void
    {
        $response = $this->get('/directory')->assertOk();
        $html = (string) $response->getContent();

        $this->assertStringContainsString('<html lang="en">', $html);
        $this->assertStringContainsString('<h1>Education Directory</h1>', $html);
        $this->assertStringContainsString('<label for="q">', $html);
        $this->assertStringContainsString('<input id="q"', $html);
        $this->assertStringContainsString('<label for="type">', $html);
        $this->assertStringContainsString('<select id="type"', $html);
        $this->assertStringContainsString('<label for="locality">', $html);
        $this->assertStringContainsString('<input id="locality"', $html);
        $this->assertStringContainsString('<section class="results" aria-labelledby="results-heading">', $html);
        $this->assertStringContainsString('<h2 id="results-heading">Directory results</h2>', $html);
    }

    public function test_directory_page_does_not_require_script_or_remote_assets(): void
    {
        $html = (string) $this->get('/directory')->assertOk()->getContent();

        $this->assertStringNotContainsString('<script', strtolower($html));
        $this->assertDoesNotMatchRegularExpression('/(?:src|href)=[\\"\\']https?:\\/\\//i', $html);
    }

    public function test_public_directory_rejects_overlong_search_inputs(): void
    {
        $this->getJson('/directory?q='.str_repeat('x', 121))->assertUnprocessable();
        $this->getJson('/directory?locality='.str_repeat('x', 121))->assertUnprocessable();
    }

    public function test_public_responses_include_baseline_security_headers(): void
    {
        $this->get('/directory')
            ->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_empty_directory_query_count_stays_within_a_small_regression_budget(): void
    {
        $queryCount = 0;
        DB::listen(static function (QueryExecuted $query) use (&$queryCount): void {
            $queryCount++;
        });

        $this->get('/directory')->assertOk();

        // This is a regression ceiling for the current empty-directory path,
        // not a product-wide performance SLO or a load-test result.
        $this->assertLessThanOrEqual(8, $queryCount, 'Directory index query count exceeded the local regression ceiling.');
    }

    public function test_disposable_sqlite_backup_restore_preserves_schema_and_synthetic_data(): void
    {
        $databasePath = tempnam(sys_get_temp_dir(), 'listing-v2-m309-db-');
        $backupPath = tempnam(sys_get_temp_dir(), 'listing-v2-m309-backup-');
        $this->assertNotFalse($databasePath);
        $this->assertNotFalse($backupPath);

        config([
            'database.connections.m309_restore' => [
                'driver' => 'sqlite',
                'database' => $databasePath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
        DB::purge('m309_restore');

        try {
            $this->artisan('migrate:fresh', [
                '--database' => 'm309_restore',
                '--force' => true,
            ])->assertExitCode(0);

            Schema::connection('m309_restore')->create('m309_restore_probe', function ($table): void {
                $table->string('id')->primary();
                $table->string('payload');
            });
            DB::connection('m309_restore')->table('m309_restore_probe')->insert([
                'id' => 'synthetic-restore-01',
                'payload' => 'before-backup',
            ]);

            DB::purge('m309_restore');
            $this->assertTrue(copy($databasePath, $backupPath), 'The disposable SQLite backup copy must succeed.');

            DB::connection('m309_restore')->table('m309_restore_probe')
                ->where('id', 'synthetic-restore-01')
                ->update(['payload' => 'after-backup']);
            DB::purge('m309_restore');

            $this->assertTrue(copy($backupPath, $databasePath), 'Restoring the disposable SQLite backup must succeed.');

            $connection = DB::connection('m309_restore');
            $this->assertSame(
                'before-backup',
                $connection->table('m309_restore_probe')->where('id', 'synthetic-restore-01')->value('payload')
            );
            $this->assertSame('ok', $connection->selectOne('PRAGMA integrity_check')->integrity_check);
            $this->assertSame([], $connection->select('PRAGMA foreign_key_check'));
            $this->assertTrue(Schema::connection('m309_restore')->hasTable('moderation_events'));
        } finally {
            DB::purge('m309_restore');
            @unlink($databasePath);
            @unlink($backupPath);
        }
    }
}
