<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

try {
    $app = require_once __DIR__.'/bootstrap/app.php';
    $app->handleRequest(Request::capture());
} catch (Throwable $e) {
    echo "<pre>";
    echo $e->getMessage() . "\n\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
    echo "</pre>";
}