<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\RoleAssignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AccountSessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_active_synthetic_account_can_start_a_session(): void
    {
        $user = $this->makeUser('verified@example.test');

        $this->postJson('/account/session', [
            'email' => ' VERIFIED@example.test ',
            'password' => 'synthetic-password',
        ])->assertOk()->assertExactJson(['authenticated' => true]);

        $this->assertAuthenticatedAs($user, 'web');
    }

    public function test_unverified_account_is_denied_with_non_enumerating_response(): void
    {
        $this->makeUser('unverified@example.test', verified: false);

        $this->postJson('/account/session', [
            'email' => 'unverified@example.test',
            'password' => 'synthetic-password',
        ])->assertUnprocessable()
            ->assertExactJson(['message' => 'The supplied credentials are invalid or the account is unavailable.']);

        $this->assertGuest('web');
    }

    public function test_inactive_account_is_denied(): void
    {
        $this->makeUser('inactive@example.test', active: false);

        $this->postJson('/account/session', [
            'email' => 'inactive@example.test',
            'password' => 'synthetic-password',
        ])->assertUnprocessable();

        $this->assertGuest('web');
    }

    public function test_service_identity_cannot_open_an_interactive_session(): void
    {
        $user = $this->makeUser('service@example.test');
        RoleAssignment::query()->create([
            'user_id' => $user->getKey(),
            'role' => 'service_identity',
        ]);

        $this->postJson('/account/session', [
            'email' => 'service@example.test',
            'password' => 'synthetic-password',
        ])->assertUnprocessable();

        $this->assertGuest('web');
    }

    public function test_unknown_account_and_wrong_password_share_the_same_response(): void
    {
        $this->makeUser('known@example.test');

        $payload = ['email' => 'known@example.test', 'password' => 'wrong-password'];

        $this->postJson('/account/session', $payload)
            ->assertUnprocessable()
            ->assertExactJson(['message' => 'The supplied credentials are invalid or the account is unavailable.']);

        $this->postJson('/account/session', ['email' => 'missing@example.test', 'password' => 'wrong-password'])
            ->assertUnprocessable()
            ->assertExactJson(['message' => 'The supplied credentials are invalid or the account is unavailable.']);
    }

    public function test_authenticated_session_can_be_destroyed(): void
    {
        $user = $this->makeUser('logout@example.test');

        $this->actingAs($user, 'web')
            ->deleteJson('/account/session')
            ->assertOk()
            ->assertExactJson(['authenticated' => false]);

        $this->assertGuest('web');
    }

    private function makeUser(string $email, bool $verified = true, bool $active = true): User
    {
        return User::query()->create([
            'email' => $email,
            'password' => 'synthetic-password',
            'email_verified_at' => $verified ? now() : null,
            'is_active' => $active,
        ]);
    }
}
