<?php

require("vendor/autoload.php");

use Controllers\MainController;

echo "<pre>";

function dump($data) {
    echo str_replace('  ', '&nbsp;', nl2br(var_export($data, true))) . "</br>";
}

// dump($_SERVER);

$method = strtolower($_SERVER['REQUEST_METHOD']);
$uriParts = explode('/', $_SERVER['REQUEST_URI']);

$uriParts = array_filter($uriParts, function ($val) { return !empty($val); });
// dump($uriParts); 
if (count($uriParts) < 1) {
    // dump($method . ucfirst('index'));
    // dump(function_exists($method . ucfirst('index')) , MainController::class);
    // if (function_exists('MainController' , $method . ucfirst('index'))) {
        call_user_func(['Controllers\MainController', $method . ucfirst('index')]);
        // call_user_func_array($method . ucfirst('index'));
    // }
    // MainController::getIndex();
} else if (count($uriParts) == 1) {
    call_user_func_array(['Controllers\\' . ucfirst(array_values($uriParts)[0]) . 'Controller', $method . 'Index']); // Call class functions
} else if (count($uriParts) >= 2) {
    // dump("-- AA --");
    $uriParts = array_values($uriParts);
    // dump($uriParts);
    call_user_func_array(['Controllers\\' . ucfirst($uriParts[0]) . 'Controller', $method . ucfirst($uriParts[1])], [isset($uriParts[2]) ? $uriParts[2] : null]); // Call class functions
    // dump($result);
    //Controllers\UserController::getUser(1);
}

echo "</pre>";