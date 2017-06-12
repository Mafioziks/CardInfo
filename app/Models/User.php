<?php

namespace Models;

class User {
    public $id;
    public $name;
    public $email;

    public function save() {
        $db = new \PDO('mysql:host=localhost;dbname=testdb', 'root', 'mafija');
        $userQuery = $db->prepare('INSERT INTO users (`name`, `email`) VALUES (:name, :email)');
        $userQuery->bindValue(':name', $this->name, \PDO::PARAM_STR);
        $userQuery->bindValue(':email', $this->email, \PDO::PARAM_STR);
        $userQuery->execute();
        // Need to update id to last inserted id
    }
}