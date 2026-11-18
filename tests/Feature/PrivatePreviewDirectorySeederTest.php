<?php

declare(strict_types=1);

namespace Tests\\Feature;

use App\\Services\\Directory\\PublicDirectoryQueryService;
use Database\\Seeders\\PrivatePreviewDirectorySeeder;
use Illuminate\\Foundation\\Testing\\RefreshDatabase;
use RuntimeException;
use Tests\\TestCase;

final class PrivatePreviewDirectorySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_local_seed_creates_fictional_examples_for_all_supported_directory_categories(): void
    {
        $this->assertSame('sqlite', app('db')->connection()->getDriverName());

        $this->seed(PrivatePreviewDirectorySeeder::class);

        $result = app(PublicDirectoryQueryService::class)->search();

        $this->assertCount(7, $result['results']);
        $this->assertSame([
            'campus' => 1,
            'institution' => 2,
            'programme' => 2,
            'provider' => 1,
            'qualification' => 1,
        ], $result['facets']);

        $this->get('/directory')
            ->assertOk()
            ->assertSee('Demo Learning Network')
            ->assertSee('Example Knowledge Academy')
            ->assertSee('Sample Future College')
            ->assertSee('Synthetic North Campus')
            ->assertSee('Sample Computing Programme')
            ->assertSee('Example Business Studies Programme')
            ->assertSee('Fictional Secondary Certificate')
            ->assertSee('Fictional provider record')
            ->assertDontSee('Synthetic private-preview fixture');
    }

    public function test_reseeding_is_idempotent_and_does_not_duplicate_preview_entities(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);
        $this->seed(PrivatePreviewDirectorySeeder::class);

        $this->assertCount(7, app(PublicDirectoryQueryService::class)->search()['results']);
    }

    public function test_profile_route_displays_a_fictional_preview_record(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);
        $profile = app(PublicDirectoryQueryService::class)->search(type: 'institution')['results'][0];

        $this->get('/directory/'.$profile['id'])
            ->assertOk()
            ->assertSee('Fictional institution record');
    }

    public function test_seeder_refuses_production_environment_before_writing(): void
    {
        $this->app['env'] = 'production';
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('restricted to local and testing environments');

        (new PrivatePreviewDirectorySeeder)->run();
    }
}
