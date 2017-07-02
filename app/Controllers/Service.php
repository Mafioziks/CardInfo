<?php

namespace Controllers;

class Service {
	
	protected static $singleton = null;
	
	protected function __construct() {
		
	}
	
	public static function getInstance() {
		if (self::$singleton == null) {
			$class = get_called_class();
			return new $class();
		}
		return self::$singleton;
	}
}