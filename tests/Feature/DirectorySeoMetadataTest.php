<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\Directory\DirectorySeoMetadata;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Tests\TestCase;

final class DirectorySeoMetadataTest extends TestCase
{
    public function test_indexing_is_disabled_by_default_and_responses_are_marked_noindex(): void
    {
        $this->assertFalse(config('seo.indexing_enabled'));
        $this->assertSame('', config('seo.canonical_origin'));

        $this->getJson('/health')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, follow');
    }

    public function test_private_preview_denial_response_is_noindex_and_nofollow(): void
    {
        config([
            'private_preview.enabled' => true,
            'private_preview.username' => 'synthetic-preview-owner',
            'private_preview.password' => 'synthetic-preview-password',
        ]);

        $this->getJson('/health')
            ->assertUnauthorized()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_stable_directory_landing_uses_trusted_origin_and_verified_language_alternates(): void
    {
        config([
            'seo.indexing_enabled' => true,
            'seo.canonical_origin' => 'https://directory.example.test',
        ]);

        $request = $this->requestWithRoute('https://attacker.example/directory?lang=en', 'directory.index');
        $metadata = app(DirectorySeoMetadata::class)->forDirectoryLanding($request, 'en');

        $this->assertSame('index, follow', $metadata['robots']);
        $this->assertSame('https://directory.example.test/directory?lang=en', $metadata['canonical']);
        $this->assertSame('https://directory.example.test/directory?lang=en', $metadata['alternates']['en']);
        $this->assertSame('https://directory.example.test/directory?lang=ur', $metadata['alternates']['ur']);
        $this->assertStringNotContainsString('attacker.example', $metadata['canonical']);
    }

    public function test_stable_profile_uses_the_same_verified_resource_path_for_both_languages(): void
    {
        config([
            'seo.indexing_enabled' => true,
            'seo.canonical_origin' => 'https://directory.example.test/',
        ]);

        $entity = '11111111-2222-4333-8444-555555555555';
        $request = $this->requestWithRoute('https://attacker.example/directory/'.$entity.'?lang=ur', 'directory.show');
        $metadata = app(DirectorySeoMetadata::class)->forProfile($request, $entity, 'ur');

        $this->assertSame('index, follow', $metadata['robots']);
        $this->assertSame('https://directory.example.test/directory/'.$entity.'?lang=ur', $metadata['canonical']);
        $this->assertSame('https://directory.example.test/directory/'.$entity.'?lang=en', $metadata['alternates']['en']);
        $this->assertSame('https://directory.example.test/directory/'.$entity.'?lang=ur', $metadata['alternates']['ur']);
    }

    public function test_search_and_filter_query_variants_are_noindex_and_have_no_canonical(): void
    {
        config([
            'seo.indexing_enabled' => true,
            'seo.canonical_origin' => 'https://directory.example.test',
        ]);

        $request = $this->requestWithRoute('https://directory.example.test/directory?q=biology&lang=en', 'directory.index');
        $metadata = app(DirectorySeoMetadata::class)->forDirectoryLanding($request, 'en');

        $this->assertSame('noindex, follow', $metadata['robots']);
        $this->assertNull($metadata['canonical']);
        $this->assertSame([], $metadata['alternates']);
    }

    public function test_invalid_canonical_origin_fails_closed_even_when_indexing_flag_is_enabled(): void
    {
        config([
            'seo.indexing_enabled' => true,
            'seo.canonical_origin' => 'http://directory.example.test/path',
        ]);

        $request = $this->requestWithRoute('https://attacker.example/directory?lang=en', 'directory.index');
        $metadata = app(DirectorySeoMetadata::class)->forDirectoryLanding($request, 'en');

        $this->assertSame('noindex, follow', $metadata['robots']);
        $this->assertNull($metadata['canonical']);
        $this->assertSame([], $metadata['alternates']);
    }

    public function test_comparison_is_always_noindex_nofollow_without_canonical_metadata(): void
    {
        config([
            'seo.indexing_enabled' => true,
            'seo.canonical_origin' => 'https://directory.example.test',
        ]);

        $metadata = app(DirectorySeoMetadata::class)->forComparison();

        $this->assertSame('noindex, nofollow', $metadata['robots']);
        $this->assertNull($metadata['canonical']);
        $this->assertSame([], $metadata['alternates']);
    }

    private function requestWithRoute(string $uri, string $routeName): Request
    {
        $request = Request::create($uri);
        $route = new RoutingRoute(['GET'], (string) parse_url($uri, PHP_URL_PATH), ['uses' => static fn (): null => null]);
        $route->name($routeName);
        $request->setRouteResolver(static fn (): RoutingRoute => $route);

        return $request;
    }
}
