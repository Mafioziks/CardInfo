<?php

namespace Controllers;

use Controllers\Controller;
use Models\User;

class AuthController extends Controller {
    
    public function beforeAction() {
        if ($this->auth->isAuthorised()) {
            echo "Already authorised!";
            exit;
        }
    }

    public function optionsLogin() {
        echo "
            POST: /api/auth/ [email, password]
        ";
    }

    public function postLogin() {

        if (!isset($_POST['email']) && !isset($_POST['password'])) {
            echo "Data not provided!";
            return;
        }

        $user = User::getBy(['email' => $_POST['email'], 'password' => hash('sha256' , $_POST['password'])]);
        if ($user) {
            if (is_array($user)) {
                $user = $user[0];
            }
            global $auth;
            $auth->login($user);
            header('Location: /user/list/');
        }
    }

    public function getTest() {
        $uri = new \Controllers\Uri();
        echo "Test: " . $uri->getScheme();
    }
}