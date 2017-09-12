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
        if ($requestMethod == 'post' && isset($_POST['__method'])) {
            $requestMethod = strtolower($_POST['__method']);
            unset($_POST['__method']);
        }
        
        // Split uri in array of elements
        $parts = explode('/', $uri);
        $parts = array_filter($parts, function ($val) { return !empty($val); });
        $parts = array_values($parts);

        // Get controller
        if (count($parts) > 0) {
        	$tmpController = '\\Controllers\\' . ucfirst($parts[0]) . ($isAPi ? '' : 'View') . 'Controller';
        }
        
        if ($defaultController) {
        	$tmpDefaultController = '\\Controllers\\' . ucfirst($defaultController) . ($isAPi ? '' : 'View') . 'Controller';
        }
        
        if (count($parts) < 1) {
        	if (empty($defaultController) || !class_exists($tmpDefaultController)) {
        	    http_response_code(404);
        	    throw new \Exception("Class " . $tmpDefaultController . 'Controller not fund');
        	    return [];
        	}
        	
        	$result['controller'] = $tmpDefaultController;
        } else if (class_exists($tmpController)) {
            $result['controller'] = $tmpController;
            array_splice($parts, 0, 1);
        } else if (
        		class_exists($tmpDefaultController)
        		&& method_exists($tmpDefaultController, $requestMethod . ucfirst($parts[0]))
        	){
        		return [
        			'controller' => $tmpDefaultController,
        			'function' => $requestMethod . ucfirst($parts[0]),
        		];
        } else {
            http_response_code(404);
            throw new \Exception("Class " . $tmpController . 'Controller not fund');
            return [];
        }
        
        // Add item id if given
        if (count($parts) > 0 && is_numeric($parts[0])) {
        	$result['param']['id'] = $parts[0];
        	array_splice($parts, 0, 1);
        }
        
        // Get function
        if(count($parts) < 1) {
            if ($defaultFunction && method_exists($result['controller'], $requestMethod . ucfirst($defaultFunction))) {
                $result['function'] = $requestMethod . ucfirst($defaultFunction);
            } else {
                http_response_code(404);
                throw new \Exception("Function " . $requestMethod . ucfirst($defaultFunction) . "not found in class " . $result['controller']);
            }
        } else if (method_exists($result['controller'], $requestMethod . ucfirst($parts[0]))) {
            $result['function'] = $requestMethod . ucfirst($parts[0]);
            array_splice($parts, 0, 1);
        } else {
            http_response_code(404);
            return [];
        }
        
        // Get parameter
        if (count($parts) > 0) {
        	if (isset($result['param']['id'])) {
            	$result['param']['the_id'] = $parts[0];
        	} else {
        		$result['param']['id'] = $parts[0];
        	}
        }
        
        return $result;
    }
}