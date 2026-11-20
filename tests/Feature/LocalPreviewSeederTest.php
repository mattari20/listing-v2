<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Seeders\LocalPreviewSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Tests\TestCase;

final class LocalPreviewSeederTest extends TestCase
{
    public function test_local_preview_seeder_refuses_the_testing_environment(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('APP_ENV=local');

        $this->seed(LocalPreviewSeeder::class);
    }

    public function test_local_preview_seeder_publishes_only_fictional_institution_fixtures_on_a_dedicated_sqlite_file(): void
    {
        $directory = sys_get_temp_dir().DIRECTORY_SEPARATOR.'listing-v2-preview-'.bin2hex(random_bytes(6));
        $databasePath = $directory.DIRECTORY_SEPARATOR.'.local-preview.sqlite';

        mkdir($directory, 0700, true);
        touch($databasePath);

        $previousEnv = $_ENV['LOCAL_PREVIEW_SEED'] ?? null;
        $previousServer = $_SERVER['LOCAL_PREVIEW_SEED'] ?? null;
        $previousProcess = getenv('LOCAL_PREVIEW_SEED');

        try {
            $this->app->detectEnvironment(static fn (): string => 'local');
            $_ENV['LOCAL_PREVIEW_SEED'] = 'allow';
            $_SERVER['LOCAL_PREVIEW_SEED'] = 'allow';
            putenv('LOCAL_PREVIEW_SEED=allow');

            config([
                'database.default' => 'sqlite',
                'database.connections.sqlite.database' => $databasePath,
                'database.connections.sqlite.foreign_key_constraints' => true,
            ]);
            DB::purge('sqlite');
            DB::setDefaultConnection('sqlite');

            $migrationExitCode = Artisan::call('migrate', [
                '--database' => 'sqlite',
                '--force' => true,
            ]);

            $this->assertSame(0, $migrationExitCode, Artisan::output());

            $this->seed(LocalPreviewSeeder::class);

            $this->assertSame(
                15,
                DB::table('directory_entities')
                    ->where('label', 'like', 'LOCAL PREVIEW ONLY — FICTIONAL%')
                    ->count()
            );
            $this->assertSame(55, DB::table('claims')->count());
            $this->assertSame(55, DB::table('publication_snapshots')->count());
            $this->assertSame(55, DB::table('public_projections')->where('is_deeni_madaris', false)->count());
            $this->assertSame(0, DB::table('public_projections')->where('is_deeni_madaris', true)->count());
            $this->assertSame(5, DB::table('directory_entities')->where('entity_type', 'institution')->count());
            $this->assertSame(5, DB::table('directory_entities')->where('entity_type', 'campus')->count());
            $this->assertSame(5, DB::table('directory_entities')->where('entity_type', 'programme')->count());
            $this->assertSame(5, DB::table('directory_campuses')->where('status', 'active')->count());
            $this->assertSame(5, DB::table('programme_catalogue_entries')->where('status', 'active')->count());
            $this->assertSame(5, DB::table('programme_offers')->where('status', 'active')->count());

            $forbiddenPredicates = [
                'child',
                'student',
                'guardian',
                'staff',
                'date_of_birth',
                'age',
                'guardian_consent',
                'student_status',
            ];

            $this->assertSame(
                0,
                DB::table('claims')->whereIn('predicate', $forbiddenPredicates)->count()
            );

            $expectedProfiles = [
                [
                    'name' => 'Synthetic Crescent Learning Institute',
                    'search' => 'Crescent',
                    'locality' => 'Gulberg',
                    'city' => 'Lahore',
                ],
                [
                    'name' => 'Synthetic Riverbend College',
                    'search' => 'Riverbend',
                    'locality' => 'Gulshan',
                    'city' => 'Karachi',
                ],
                [
                    'name' => 'Synthetic Frontier Skills Academy',
                    'search' => 'Frontier',
                    'locality' => 'University Road',
                    'city' => 'Peshawar',
                ],
                [
                    'name' => 'Synthetic Makran Science College',
                    'search' => 'Makran',
                    'locality' => 'Jinnah Town',
                    'city' => 'Quetta',
                ],
                [
                    'name' => 'Synthetic Capital Research Institute',
                    'search' => 'Capital',
                    'locality' => 'G-10',
                    'city' => 'Islamabad',
                ],
            ];

            $allInstitutions = $this->get('/directory?type=institution')->assertOk();
            foreach ($expectedProfiles as $profile) {
                $allInstitutions->assertSee($profile['name']);

                $this->get('/directory?'.http_build_query([
                    'q' => $profile['search'],
                    'type' => 'institution',
                ]))
                    ->assertOk()
                    ->assertSee($profile['name']);

                $this->get('/directory?'.http_build_query(['locality' => $profile['locality']]))
                    ->assertOk()
                    ->assertSee($profile['name']);

                $entityId = DB::table('directory_entities')
                    ->where('label', 'LOCAL PREVIEW ONLY — FICTIONAL '.$profile['name'])
                    ->value('id');

                $this->assertIsString($entityId);
                $this->get('/directory/'.$entityId)
                    ->assertOk()
                    ->assertSee($profile['name'])
                    ->assertSee($profile['city'])
                    ->assertSee($profile['locality'])
                    ->assertSee('Campuses')
                    ->assertSee('Synthetic '.$profile['city'].' Campus')
                    ->assertSee('Programmes and admission offers')
                    ->assertSee('Synthetic '.$profile['city'].' Computing Programme')
                    ->assertSee('Synthetic 2027 Intake');
            }
        } finally {
            DB::disconnect('sqlite');
            @unlink($databasePath);
            @rmdir($directory);

            if ($previousEnv === null) {
                unset($_ENV['LOCAL_PREVIEW_SEED']);
            } else {
                $_ENV['LOCAL_PREVIEW_SEED'] = $previousEnv;
            }

            if ($previousServer === null) {
                unset($_SERVER['LOCAL_PREVIEW_SEED']);
            } else {
                $_SERVER['LOCAL_PREVIEW_SEED'] = $previousServer;
            }

            if ($previousProcess === false) {
                putenv('LOCAL_PREVIEW_SEED');
            } else {
                putenv('LOCAL_PREVIEW_SEED='.$previousProcess);
            }
        }
    }
}
