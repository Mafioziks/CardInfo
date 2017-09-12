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

$link = $_SERVER['REQUEST_URI'];

// Edit for api calls
if (strpos($link, $apiBase)) {
    $isApi = true;
    $link = substr($link, strpos($link, $apiBase) + strlen($apiBase));
    header("Content-Type: application/json");
}

// SPlit link in callable parts
$request = Uri::splitter($link, $isApi, 'main', 'index');

// Get error page
$status = http_response_code();
if ($status == 404) {
    include 'resources/static/404.html';
    exit;
}

extract($request);

$page = new $controller();
if (method_exists($page, 'beforeAction')) {
	$page->beforeAction();
}

if (!isset($param)) {
    $page->$function();
} else if (count($param) > 1) {
	$page->$function( $param['id'], $param['the_id']);
} else {
	$page->$function(isset($param)? $param['id'] : null);
}

if (method_exists($page, 'afterAction' )) {
	$page->afterAction();
}