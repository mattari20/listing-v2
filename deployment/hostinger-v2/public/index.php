<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$appRoot = __DIR__.'/_app';

// The application source must be placed in the sibling _app directory.
// This entry point is intentionally separate from the repository's default
// public/index.php and must only be published as part of the Hostinger V2
// deployment package.
if (file_exists($maintenance = $appRoot.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appRoot.'/vendor/autoload.php';

/** @var Application $app */
$app = require $appRoot.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
