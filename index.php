<?php
session_start();
require("vendor/autoload.php");

use Services\AuthorisationService;
use Controllers\Helpers\Uri;

$apiBase = 'api';
$isApi = false;

// Manages cli
if (isset($argv[1]) && isset($argv[2])) {
    $class = "\\Migrations\\" . $argv[1];
    call_user_func([$class, $argv[2]]);
    exit;
}

// Initialize service
$auth = AuthorisationService::getInstance();

// Get request method
$method = strtolower($_SERVER['REQUEST_METHOD']);

$link = $_SERVER['REQUEST_URI'];

// Edit for api calls
if (strpos($link, $apiBase)) {
    $isApi = true;
    $link = substr($link, strpos($link, $apiBase) + strlen($apiBase));
}

// SPlit link in callable parts
$request = Uri::splitter($link, $isApi, 'main', 'index');

// Get error page
$status = http_response_code();
if ($status == 404) {
    include 'resources/static/404.html';
    exit;
}

// Call controller
if ($isApi) {
    echo "<pre>";
}

call_user_func_array([$request['controller'], $request['function']], (isset($request['param']) ? [$request['param']] : []));

if ($isApi) {
    echo "</pre>";
}