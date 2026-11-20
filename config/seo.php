<?php

return [
    // Fail closed until a canonical public origin and release are separately approved.
    'indexing_enabled' => (bool) env('SEO_INDEXING_ENABLED', false),
    'canonical_origin' => env('SEO_CANONICAL_ORIGIN', ''),
];
