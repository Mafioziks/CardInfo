<?php

require("vendor/autoload.php");

use Controllers\MainController;

// Manages cli
if (isset($argv[1]) && isset($argv[2])) {
    $class = "\\Migrations\\" . $argv[1];
    call_user_func([$class, $argv[2]]);
    exit;
}

// Get request method
$method = strtolower($_SERVER['REQUEST_METHOD']);
// Get routing parts from request uri
$uriParts = explode('/', $_SERVER['REQUEST_URI']);
// Remove empty variablies
$uriParts = array_filter($uriParts, function ($val) { return !empty($val); });
// Reindex valriables
$uriParts = array_values($uriParts);

// Routing - place where all of the magic happens
if (count($uriParts) < 1) {
    call_user_func(['Controllers\MainController', $method . ucfirst('index')]);
} else if ($uriParts[0] == "api") { // API requests
    echo "<pre>";
    call_user_func_array(['Controllers\\' . ucfirst($uriParts[1]) . 'Controller', $method . ucfirst(isset($uriParts[2]) && !is_numeric($uriParts[2])? $uriParts[2] : 'view')], [isset($uriParts[2]) && is_numeric($uriParts[2]) ? $uriParts[2] : (isset($uriParts[3]) ? $uriParts[3] : null)]); // Call class functions
    echo "</pre>";
} else if (count($uriParts) == 1) {
    var_dump("HERE");
    call_user_func_array(['Controllers\\' . ucfirst($uriParts[0]) . 'ViewController', $method . 'Index']); // Call class functions
} else if (count($uriParts) >= 2) {
    call_user_func_array(['Controllers\\' . ucfirst($uriParts[0]) . 'ViewController', $method . ucfirst($uriParts[1])], [isset($uriParts[2]) ? $uriParts[2] : null]); // Call class functions
}