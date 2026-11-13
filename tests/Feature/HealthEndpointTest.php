<?php

namespace Tests\Feature;

use Tests\TestCase;

final class HealthEndpointTest extends TestCase
{
    public function test_health_endpoint_returns_only_fixed_non_sensitive_status(): void
    {
        $this->getJson('/health')
            ->assertOk()
            ->assertExactJson([
                'status' => 'ok',
                'application' => 'estudent-institutes-v2',
                'foundation' => 'fnd-01',
            ]);
    }
}
