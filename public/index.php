<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// ✅ Attempt to create the symbolic link if it doesn't exist
$link = __DIR__ . '/storage';
$target = realpath(__DIR__ . '/../storage/app/public');



// Laravel Maintenance Mode Check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer Autoloader
require __DIR__.'/../vendor/autoload.php';

// Laravel Bootstrap
$app = require_once __DIR__.'/../bootstrap/app.php';

// Handle Request
$app->handleRequest(Request::capture());
