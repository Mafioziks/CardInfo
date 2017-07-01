<?php

namespace Controllers;

class DatabaseController {
    private static function connect() {
        $pdo = new \PDO('mysql:host=localhost;dbname=testdb', 'root', 'mafija');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }

    /**
     * Executes query
     * 
     * @return null | object
     */
    public static function query($query, $class = null) {
        $db = self::connect();
        $q = $db->prepare($query);
        $q->execute();
        
        if (preg_match('/^SELECT\.*/', $query)) {
	        if ($class == null) {
	            return $q->fetchAll(\PDO::FETCH_ASSOC);
	        }
	        $result = [];
	        while ($object = $q->fetchObject($class)) {
	        	$result[] = $object;
	        }
	        return $result;
        }
        
        return $db->lastInsertId();
    }
}