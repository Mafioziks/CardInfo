<?php

namespace Services;

use Controllers\Service;
use Models\User;

class AuthorisationService extends Service {
	
	protected $user = null;
	
	public function isAuthorised() {
		if ($this->user == null) {
			if (isset($_SESSION['uid'])) {
				$this->user = User::getById($_SESSION['uid']);
				if ($this->user != null) {
					return true;
				}
			}
		} else {
			return true;
		}
		
		return false;
	}
	
	public function login(User $user) {
		$this->user = $user;
		$_SESSION['uid'] = $user->id;
	}
	
	public function logout() {
		$this->user = null;
		if (isset($_SESSION['uid'])) {
			unset($_SESSION['uid']);
		}
	}
	
	public function getUser() {
		return $this->user;
	}
}