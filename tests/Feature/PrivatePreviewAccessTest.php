<?php

namespace Tests\Feature;

use Tests\TestCase;

final class PrivatePreviewAccessTest extends TestCase
{
    public function test_private_preview_gate_is_disabled_by_default(): void
    {
        $this->assertFalse(config('private_preview.enabled'));

        $this->getJson('/health')
            ->assertOk()
            ->assertExactJson([
                'status' => 'ok',
                'application' => 'estudent-institutes-v2',
                'foundation' => 'fnd-01',
            ]);
    }

    public function test_enabled_preview_gate_protects_health_directory_and_session_routes(): void
    {
        config([
            'private_preview.enabled' => true,
            'private_preview.username' => 'synthetic-preview-owner',
            'private_preview.password' => 'synthetic-only-test-password',
        ]);

        $response = $this->getJson('/health');

        $response->assertUnauthorized()
            ->assertHeader('WWW-Authenticate');

        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));

        $this->getJson('/directory')
            ->assertUnauthorized();

        $this->postJson('/account/session', [])
            ->assertUnauthorized();
    }

    public function test_valid_preview_basic_credentials_allow_requests(): void
    {
        config([
            'private_preview.enabled' => true,
            'private_preview.username' => 'synthetic-preview-owner',
            'private_preview.password' => 'synthetic-only-test-password',
        ]);

        $this->withBasicAuth('synthetic-preview-owner', 'synthetic-only-test-password')
            ->getJson('/health')
            ->assertOk();
    }

    public function test_enabled_preview_gate_fails_closed_without_configured_credentials(): void
    {
        config([
            'private_preview.enabled' => true,
            'private_preview.username' => '',
            'private_preview.password' => '',
        ]);

        $response = $this->getJson('/health');

        $response->assertStatus(503);

        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
    }

    public function test_incorrect_preview_credentials_are_rejected(): void
    {
        config([
            'private_preview.enabled' => true,
            'private_preview.username' => 'synthetic-preview-owner',
            'private_preview.password' => 'synthetic-only-test-password',
        ]);

        $this->withBasicAuth('wrong-user', 'wrong-password')
            ->getJson('/directory')
            ->assertUnauthorized();
    }
}
