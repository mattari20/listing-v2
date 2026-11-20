<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Directory\DirectorySeoMetadata;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SearchEngineVisibility
{
    public function __construct(private readonly DirectorySeoMetadata $metadata) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->headers->set('X-Robots-Tag', $this->metadata->robotsDirective($request));

        return $response;
    }
}
