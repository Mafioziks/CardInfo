<?php

namespace Controllers;

use Views\AuthView;
use Models\User;

class AuthViewController {
	
	public function beforeAction() {
        global $auth;
        if ($auth->isAuthorised()) {
            header('Location: /user/view/' . $auth->getUser()->id);
            exit;
        }
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<title>Authorize</title>
				<link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" type="text/css">
				<link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css" type="text/css">
			</head>
			<body>
				<div class="container">
		<?php
	}
	
	public function afterAction() {
		?>
				</div>
			</body>
		</html>
		<?php
	}
	
    public function getLogin() {
        AuthView::loginForm();
    }
    
    public function postLogin() {
        if (isset($_POST['email']) && isset($_POST['password'])) {
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
        header('Location: /auth/login/');
    }
    
    public function getRegister() {
        global $auth;
        if ($auth->isAuthorised()) {
            header('Location: /user/view/' . $auth->getUser()->id);
        }
        AuthView::registerForm();
    }
    
    public function postRegister() {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])) {
            $user = User::getBy(['email' => $_POST['email'], 'password' => hash('sha256' , $_POST['password'])]);
            if ($user) {
                global $auth;
                $auth->login($user);
                header('Location: /user/list/');
                exit;
            }
            
            $user = new User();
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->password = hash('sha256', $_POST['password']);
            $user->save();
            
            global $auth;
            $auth->login($user);
            header('Location: /user/list/');
        }
        header('Location: /auth/register/');
    }
    
    public function postLogout() {
        global $auth;
        $auth->logout();
        header('Location: /auth/login/');
        exit;
    }
}