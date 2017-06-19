<?php

namespace Controllers;

class DatabaseController {
    private static function connect() {
        $pdo = new \PDO('mysql:host=localhost;dbname=testdb', 'root', 'mafija');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }

    public static function query($query, $class = null) {
        $db = self::connect();
        $q = $db->prepare($query);
        $q->execute();
        if ($class == null) {
            return $q->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $q->fetchObject('\Model\\' . $class);
    }
}