<?php

namespace Controllers;

use Controllers\Request;

class Controller {

    public $auth;
    public $request;

    public function __construct() {
        global $auth;
        $this->auth = $auth;
        // $this->request = Request::createFromHeaders();
    }

    public function beforeAction() {

    }

    public function afterAction() {

    }
}