<?php

namespace Controllers;

class MainViewController {
	public function getIndex() {
		echo "<h3>Welcome to CardInfo project</h3>";
		
		echo "<a href='/auth/login/'>Log in</a>";
	}
}