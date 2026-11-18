<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Seeders\LocalPreviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

final class LocalPreviewSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_local_preview_seeder_refuses_the_testing_environment(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('APP_ENV=local');

        $this->seed(LocalPreviewSeeder::class);
    }
}
