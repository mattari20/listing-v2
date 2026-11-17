<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

final class ModerationPrivacyBoundaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_public_moderation_or_review_routes_are_registered(): void
    {
        $routes = collect(Route::getRoutes()->getRoutes());

        $this->assertFalse($routes->contains(static fn ($route): bool => str_contains($route->uri(), 'moderation')));
        $this->assertFalse($routes->contains(static fn ($route): bool => str_contains($route->uri(), 'appeal')));
        $this->assertFalse($routes->contains(static fn ($route): bool => str_contains($route->uri(), 'rating')));

        $reviewRoutes = $routes->filter(
            static fn ($route): bool => str_contains($route->uri(), 'review')
        );

        $this->assertCount(2, $reviewRoutes);
        foreach ($reviewRoutes as $route) {
            $this->assertContains('auth', $route->gatherMiddleware());
            $this->assertStringStartsWith('institutions/{institution}/editorial-cases/{case}/review', $route->uri());
        }
    }

    public function test_moderation_persistence_contains_no_user_generated_content_or_identity_document_fields(): void
    {
        $caseColumns = Schema::getColumnListing('moderation_cases');
        $appealColumns = Schema::getColumnListing('moderation_appeals');
        $eventColumns = Schema::getColumnListing('moderation_events');
        $userColumns = Schema::getColumnListing('users');
        $allColumns = array_merge($caseColumns, $appealColumns, $eventColumns, $userColumns);

        foreach (['body', 'content', 'message', 'text', 'attachment_path', 'identity_document', 'enrollment_document', 'birth_date', 'age', 'age_verified_at', 'guardian_consent', 'student_status', 'phone'] as $forbidden) {
            $this->assertNotContains($forbidden, $allColumns);
        }

        $this->assertContains('synthetic_reference', $caseColumns);
        $this->assertContains('reason_code', $caseColumns);
        $this->assertContains('event_type', $eventColumns);
        $this->assertContains('from_state', $eventColumns);
        $this->assertContains('to_state', $eventColumns);
    }
}
