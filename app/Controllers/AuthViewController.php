<?php

namespace Controllers;

use Views\AuthView;
use Models\User;

class AuthViewController {
	public static function getLogin() {
		global $auth;
		if ($auth->isAuthorised()) {
			header('Location: /user/view/' . $auth->getUser()->id);
		}
		AuthView::loginForm();
	}
	
	public static function postLogin() {
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
	
	public static function getRegister() {
		global $auth;
		if ($auth->isAuthorised()) {
			header('Location: /user/view/' . $auth->getUser()->id);
		}
		AuthView::registerForm();
	}
	
	public static function postRegister() {
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
	
	public  static function postLogout() {
		global $auth;
		$auth->logout();
		header('Location: /auth/login/');
		exit;
	}
}