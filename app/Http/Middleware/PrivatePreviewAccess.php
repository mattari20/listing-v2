<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class PrivatePreviewAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('private_preview.enabled')) {
            return $next($request);
        }

        $username = (string) config('private_preview.username', '');
        $password = (string) config('private_preview.password', '');

        if ($username === '' || $password === '') {
            return response('Private preview access is not configured.', 503)
                ->header('Cache-Control', 'no-store');
        }

        $providedUsername = (string) $request->getUser();
        $providedPassword = (string) $request->getPassword();

        if (
            $providedUsername === ''
            || $providedPassword === ''
            || ! hash_equals($username, $providedUsername)
            || ! hash_equals($password, $providedPassword)
        ) {
            return response('Authentication required.', 401)
                ->header('WWW-Authenticate', 'Basic realm="eStudent V2 Private Preview", charset="UTF-8"')
                ->header('Cache-Control', 'no-store')
                ->header('Pragma', 'no-cache');
        }

        return $next($request);
    }
}
