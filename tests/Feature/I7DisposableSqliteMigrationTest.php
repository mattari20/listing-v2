<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Database\QueryException;
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
                'users',
                'role_assignments',
                'privileged_action_audits',
                'moderation_cases',
                'moderation_appeals',
                'moderation_events',
                'programme_offer_fact_freshness_policies',
                'programme_offer_facts',
                'programme_offer_fact_versions',
                'programme_offer_fact_evidence_links',
                'programme_offer_fact_adjudication_cases',
                'programme_offer_fact_adjudication_decisions',
                'programme_offer_fact_publication_decisions',
                'programme_offer_fact_publication_snapshots',
                'programme_offer_fact_public_projections',
                'programme_offer_fact_publication_suppressions',
            ];

            $this->assertSame(14, (int) $connection->table('migrations')->count());
            foreach ($expectedTables as $table) {
                $this->assertTrue($schema->hasTable($table), $table.' must exist after a fresh migration.');
            }
            $this->assertSame([], $connection->select('PRAGMA foreign_key_check'));

            config([
                'database.connections.i7_disposable_peer' => [
                    'driver' => 'sqlite',
                    'database' => $databasePath,
                    'prefix' => '',
                    'foreign_key_constraints' => true,
                ],
            ]);
            DB::purge('i7_disposable_peer');
            $peer = DB::connection('i7_disposable_peer');
            $this->assertNotSame($connection->getPdo(), $peer->getPdo());

            $outboxId = (string) str()->uuid();
            $outboxRow = [
                'id' => $outboxId,
                'event_type' => 'i7.synthetic.cross_connection',
                'aggregate_type' => 'synthetic',
                'aggregate_id' => (string) str()->uuid(),
                'payload' => json_encode(['synthetic' => true], JSON_THROW_ON_ERROR),
                'idempotency_key' => 'i7-cross-connection-unique-key',
                'status' => 'pending',
                'attempts' => 0,
                'available_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $connection->table('governance_outbox')->insert($outboxRow);

            try {
                $peer->table('governance_outbox')->insert(array_merge($outboxRow, [
                    'id' => (string) str()->uuid(),
                ]));
                $this->fail('A second independent SQLite connection must not duplicate an outbox idempotency key.');
            } catch (QueryException) {
                $this->assertSame(
                    1,
                    (int) $connection->table('governance_outbox')
                        ->where('idempotency_key', 'i7-cross-connection-unique-key')
                        ->count()
                );
            }

            $connection->unprepared('BEGIN IMMEDIATE TRANSACTION');
            try {
                $peer->unprepared('PRAGMA busy_timeout = 0');
                $contendedRow = array_merge($outboxRow, [
                    'id' => (string) str()->uuid(),
                    'aggregate_id' => (string) str()->uuid(),
                    'idempotency_key' => 'i7-cross-connection-contention',
                ]);

                try {
                    $peer->table('governance_outbox')->insert($contendedRow);
                    $this->fail('A second SQLite writer must be blocked while the first connection holds an immediate write transaction.');
                } catch (QueryException $exception) {
                    $this->assertStringContainsString('database is locked', strtolower($exception->getMessage()));
                }
            } finally {
                $connection->unprepared('ROLLBACK');
            }

            $this->assertSame(
                0,
                (int) $connection->table('governance_outbox')
                    ->where('idempotency_key', 'i7-cross-connection-contention')
                    ->count()
            );

            DB::purge('i7_disposable_peer');

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

            $this->assertSame(14, (int) $connection->table('migrations')->count());
            foreach ($expectedTables as $table) {
                $this->assertTrue($schema->hasTable($table), $table.' must be recreated by re-migration.');
            }
            $this->assertSame([], $connection->select('PRAGMA foreign_key_check'));
        } finally {
            DB::purge('i7_disposable_peer');
            DB::purge('i7_disposable');
            @unlink($databasePath);
        }
    }
}
