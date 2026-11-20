<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Services\Directory\PublicDirectoryQueryService;
use Database\Seeders\PrivatePreviewDirectorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

final class AccountSavedItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_read_save_or_remove_account_saved_items(): void
    {
        $entity = (string) Str::uuid();

        $this->getJson('/account/saved-items')->assertUnauthorized();
        $this->postJson('/account/saved-items/'.$entity)->assertUnauthorized();
        $this->deleteJson('/account/saved-items/'.$entity)->assertUnauthorized();
    }

    public function test_owner_can_save_view_and_remove_a_currently_published_entity_idempotently(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);
        [$entity, $name] = $this->publishedInstitution();
        $owner = $this->makeUser('saved-owner@example.test');

        $this->actingAs($owner)->from('/directory')
            ->post('/account/saved-items/'.$entity)
            ->assertRedirect('/directory');
        $this->assertDatabaseHas('saved_directory_items', [
            'user_id' => $owner->getKey(),
            'entity_id' => $entity,
        ]);

        $this->actingAs($owner)->from('/directory')
            ->post('/account/saved-items/'.$entity)
            ->assertRedirect('/directory');
        $this->assertDatabaseCount('saved_directory_items', 1);

        $this->actingAs($owner)->get('/account/saved-items')
            ->assertOk()
            ->assertSee($name)
            ->assertSee('noindex, nofollow')
            ->assertHeader('Cache-Control', 'private, no-store, max-age=0')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');

        $this->actingAs($owner)->from('/account/saved-items')
            ->delete('/account/saved-items/'.$entity)
            ->assertRedirect('/account/saved-items');
        $this->assertDatabaseMissing('saved_directory_items', [
            'user_id' => $owner->getKey(),
            'entity_id' => $entity,
        ]);
    }

    public function test_one_account_cannot_read_or_remove_another_accounts_saved_item(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);
        [$entity, $name] = $this->publishedInstitution();
        $owner = $this->makeUser('owner-a@example.test');
        $other = $this->makeUser('owner-b@example.test');

        $this->actingAs($owner)->post('/account/saved-items/'.$entity);

        $this->actingAs($other)->get('/account/saved-items')
            ->assertOk()
            ->assertDontSee($name);

        $this->actingAs($other)->from('/account/saved-items')
            ->delete('/account/saved-items/'.$entity)
            ->assertRedirect('/account/saved-items');

        $this->assertDatabaseHas('saved_directory_items', [
            'user_id' => $owner->getKey(),
            'entity_id' => $entity,
        ]);
    }

    public function test_only_currently_approved_public_entities_can_be_saved(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);
        $owner = $this->makeUser('save-invalid@example.test');
        $unpublished = (string) Str::uuid();
        DB::table('directory_entities')->insert([
            'id' => $unpublished,
            'entity_type' => 'institution',
            'label' => 'Synthetic unpublished entity',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($owner)->post('/account/saved-items/'.$unpublished)->assertNotFound();
        $this->assertDatabaseMissing('saved_directory_items', ['entity_id' => $unpublished]);
    }

    public function test_saved_list_rechecks_public_projection_and_does_not_expose_stale_entity_details(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);
        $owner = $this->makeUser('stale-save@example.test');
        $unpublished = (string) Str::uuid();
        DB::table('directory_entities')->insert([
            'id' => $unpublished,
            'entity_type' => 'institution',
            'label' => 'Synthetic private internal label',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('saved_directory_items')->insert([
            'user_id' => $owner->getKey(),
            'entity_id' => $unpublished,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($owner)->get('/account/saved-items')
            ->assertOk()
            ->assertSee('This item is no longer available in the approved public directory.')
            ->assertDontSee('Synthetic private internal label');
    }

    public function test_saved_item_limit_is_enforced_server_side(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);
        config(['directory.saved_items_limit' => 1]);
        $entities = DB::table('directory_entities')
            ->where('entity_type', 'institution')
            ->orderBy('id')
            ->limit(2)
            ->pluck('id')
            ->all();
        $this->assertCount(2, $entities);
        $owner = $this->makeUser('save-limit@example.test');

        $this->actingAs($owner)->post('/account/saved-items/'.$entities[0]);
        $this->actingAs($owner)->from('/directory')
            ->post('/account/saved-items/'.$entities[1])
            ->assertRedirect('/directory')
            ->assertSessionHas('saved_items_status', 'Your saved items are full (maximum 1). Remove an item before saving another.');
        $this->assertDatabaseCount('saved_directory_items', 1);
    }

    public function test_deleting_an_account_row_cascades_its_saved_items(): void
    {
        $this->seed(PrivatePreviewDirectorySeeder::class);
        [$entity] = $this->publishedInstitution();
        $owner = $this->makeUser('deleted-owner@example.test');
        $this->actingAs($owner)->post('/account/saved-items/'.$entity);
        $this->assertDatabaseHas('saved_directory_items', ['user_id' => $owner->getKey(), 'entity_id' => $entity]);

        $owner->delete();

        $this->assertDatabaseMissing('saved_directory_items', ['user_id' => $owner->getKey(), 'entity_id' => $entity]);
    }

    /** @return array{0: string, 1: string} */
    private function publishedInstitution(): array
    {
        $entity = (string) DB::table('directory_entities')
            ->where('entity_type', 'institution')
            ->orderBy('id')
            ->value('id');
        $profile = app(PublicDirectoryQueryService::class)->find($entity);
        $this->assertNotNull($profile);

        return [$entity, (string) $profile['name']];
    }

    private function makeUser(string $email): User
    {
        return User::query()->create([
            'email' => $email,
            'password' => 'synthetic-password',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
    }
}
