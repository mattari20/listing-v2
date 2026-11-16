<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

final class I7DisposableSqliteMigrationTest extends TestCase
{
    public function test_complete_migration_sequence_rolls_back_and_reinstalls_on_a_disposable_sqlite_file(): void
    {
        $databasePath = tempnam(sys_get_temp_dir(), 'listing-v2-i7-');
        $this->assertNotFalse($databasePath);

        config([
            'database.connections.i7_disposable' => [
                'driver' => 'sqlite',
                'database' => $databasePath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);
        DB::purge('i7_disposable');

        try {
            $this->artisan('migrate:fresh', [
                '--database' => 'i7_disposable',
                '--force' => true,
            ])->assertExitCode(0);

            $connection = DB::connection('i7_disposable');
            $schema = Schema::connection('i7_disposable');
            $expectedTables = [
                'directory_entities',
                'claims',
                'claim_versions',
                'field_definitions',
                'field_definition_versions',
                'governance_outbox',
                'field_definition_review_cases',
                'field_definition_review_decisions',
                'public_projections',
            ];

            $this->assertSame(10, (int) $connection->table('migrations')->count());
            foreach ($expectedTables as $table) {
                $this->assertTrue($schema->hasTable($table), $table.' must exist after a fresh migration.');
            }
            $this->assertSame([], $connection->select('PRAGMA foreign_key_check'));

            $this->artisan('migrate:reset', [
                '--database' => 'i7_disposable',
                '--force' => true,
            ])->assertExitCode(0);

            $this->assertSame(0, (int) $connection->table('migrations')->count());
            foreach ($expectedTables as $table) {
                $this->assertFalse($schema->hasTable($table), $table.' must be removed by a complete rollback.');
            }

            $this->artisan('migrate', [
                '--database' => 'i7_disposable',
                '--force' => true,
            ])->assertExitCode(0);

            $this->assertSame(10, (int) $connection->table('migrations')->count());
            foreach ($expectedTables as $table) {
                $this->assertTrue($schema->hasTable($table), $table.' must be recreated by re-migration.');
            }
            $this->assertSame([], $connection->select('PRAGMA foreign_key_check'));
        } finally {
            DB::purge('i7_disposable');
            @unlink($databasePath);
        }
    }
}
