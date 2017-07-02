<?php

namespace Controllers\Helpers;

class Uri {
	
	/**
	 * Split uri into controller / function / parameters
	 * 
	 * @param string $uri
	 * @return array
	 */
	public static function splitter($uri, $isAPi, $defaultController = null, $defaultFunction = null) {
		$result = [];
		
		$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
		
		// Split uri in array of elements
		$parts = explode('/', $uri);
		$parts = array_filter($parts, function ($val) { return !empty($val); });
		$parts = array_values($parts);
				
		// Get controller
		if (class_exists('\\Controllers\\' . ucfirst($parts[0]) . ($isAPi ? '' : 'View') . 'Controller')) {
			$result['controller'] = '\\Controllers\\' . ucfirst($parts[0]) . ($isAPi ? '' : 'View') . 'Controller';
			array_splice($parts, 0, 1);
		} else if ($defaultController && class_exists('\\Controllers\\' . ucfirst($defaultController) . ($isAPi ? '' : 'View') . 'Controller')) {
			$result['controller'] = '\\Controllers\\' . ucfirst($defaultController) . ($isAPi ? '' : 'View') . 'Controller';
		} else {
			http_response_code(404);
			return [];
		}
		
		// Get function
		if(count($parts) < 1) {
			if ($defaultFunction && method_exists($result['controller'], $requestMethod . ucfirst($defaultFunction))) {
				$result['function'] = $requestMethod . ucfirst($defaultFunction);
			} else {
				http_response_code(404);
			}
		} else if (method_exists($result['controller'], $requestMethod . ucfirst($parts[0]))) {
			$result['function'] = $requestMethod . ucfirst($parts[0]);
			array_splice($parts, 0, 1);
		} else if ($defaultFunction) {
			$result['function'] = $requestMethod . ucfirst($defaultFunction);
		} else {
			http_response_code(404);
			return [];
		}
		
		// Get parameter
		if (count($parts) > 0) {
			$result['param'] = $parts[0];
		}
		
		return $result;
	}
}