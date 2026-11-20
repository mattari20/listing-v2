<?php

declare(strict_types=1);

namespace App\Services\Directory;

use Illuminate\Http\Request;

final class DirectorySeoMetadata
{
    /** @return array{robots: string, canonical: ?string, alternates: array<string, string>} */
    public function forDirectoryLanding(Request $request, string $locale): array
    {
        $indexable = $this->isStableRoute($request, 'directory.index');

        return $this->metadata('/directory', $locale, $indexable, $this->robotsDirective($request));
    }

    /** @return array{robots: string, canonical: ?string, alternates: array<string, string>} */
    public function forProfile(Request $request, string $entity, string $locale): array
    {
        $indexable = $this->isStableRoute($request, 'directory.show');

        return $this->metadata('/directory/'.$entity, $locale, $indexable, $this->robotsDirective($request));
    }

    /** @return array{robots: string, canonical: null, alternates: array{}} */
    public function forComparison(): array
    {
        return ['robots' => 'noindex, nofollow', 'canonical' => null, 'alternates' => []];
    }

    public function robotsDirective(Request $request): string
    {
        if ((bool) config('private_preview.enabled', false)) {
            return 'noindex, nofollow';
        }

        if (! $this->indexingIsConfigured()) {
            return 'noindex, follow';
        }

        $routeName = $request->route()?->getName();

        if (! in_array($routeName, ['directory.index', 'directory.show'], true)) {
            return 'noindex, nofollow';
        }

        if (! $this->hasOnlyLanguageQueryParameter($request)) {
            return 'noindex, follow';
        }

        return 'index, follow';
    }

    public function indexingIsConfigured(): bool
    {
        return (bool) config('seo.indexing_enabled', false) && $this->trustedOrigin() !== null;
    }

    private function isStableRoute(Request $request, string $expectedRoute): bool
    {
        return $this->indexingIsConfigured()
            && $request->route()?->getName() === $expectedRoute
            && $this->hasOnlyLanguageQueryParameter($request)
            && ! (bool) config('private_preview.enabled', false);
    }

    private function hasOnlyLanguageQueryParameter(Request $request): bool
    {
        return array_diff(array_keys($request->query()), ['lang']) === [];
    }

    /** @return array{robots: string, canonical: ?string, alternates: array<string, string>} */
    private function metadata(string $path, string $locale, bool $indexable, string $robots): array
    {
        if (! $indexable || ! in_array($locale, ['en', 'ur'], true)) {
            return ['robots' => $robots, 'canonical' => null, 'alternates' => []];
        }

        $origin = $this->trustedOrigin();
        if ($origin === null) {
            return ['robots' => 'noindex, follow', 'canonical' => null, 'alternates' => []];
        }

        $alternates = [];
        foreach (['en', 'ur'] as $language) {
            $alternates[$language] = $origin.$path.'?'.http_build_query(['lang' => $language]);
        }

        return [
            'robots' => $robots,
            'canonical' => $alternates[$locale],
            'alternates' => $alternates,
        ];
    }

    private function trustedOrigin(): ?string
    {
        $configured = trim((string) config('seo.canonical_origin', ''));
        if ($configured === '') {
            return null;
        }

        $parts = parse_url($configured);
        if (! is_array($parts) || strtolower((string) ($parts['scheme'] ?? '')) !== 'https') {
            return null;
        }

        $host = (string) ($parts['host'] ?? '');
        $validHost = filter_var($host, FILTER_VALIDATE_IP) !== false
            || filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) !== false;

        if (
            ! $validHost
            || isset($parts['user'])
            || isset($parts['pass'])
            || ! in_array($parts['path'] ?? '', ['', '/'], true)
            || isset($parts['query'])
            || isset($parts['fragment'])
            || (isset($parts['port']) && ($parts['port'] < 1 || $parts['port'] > 65535))
        ) {
            return null;
        }

        $origin = 'https://'.$host;
        if (isset($parts['port'])) {
            $origin .= ':'.$parts['port'];
        }

        return $origin;
    }
}
