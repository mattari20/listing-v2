<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Private Preview Access
    |--------------------------------------------------------------------------
    |
    | Disabled by default. When enabled, every request passing through the
    | Laravel application requires HTTP Basic credentials. Set unique values
    | outside source control and serve the preview over HTTPS.
    |
    */

    'enabled' => env('PRIVATE_PREVIEW_ENABLED', false),
    'username' => env('PRIVATE_PREVIEW_USERNAME', ''),
    'password' => env('PRIVATE_PREVIEW_PASSWORD', ''),
];
