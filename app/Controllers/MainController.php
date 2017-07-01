<?php

namespace Controllers;

use Models\User;

class MainController {
    public static function getIndex() {
        echo "<pre>";
        
        echo "<h3>Main page</h3>";

        echo "<h4>User list</h4>";
        
        $users = User::getAll();
        
        foreach ($users as $user) {
        	echo "<p>Name: <strong>{$user->name}</strong></p>";
        }

        echo "</pre>";
    }
}