<?php

namespace Controllers;

use Models\User;

class UserViewController {
    public static function getView($id) {
        // header('Content Type: json');
        $db = new \PDO('mysql:host=localhost;dbname=testdb', 'root', 'mafija');
        $userQuery = $db->prepare('SELECT * FROM users WHERE id = :id');
        $userQuery->bindValue(':id', $id, \PDO::PARAM_INT);
        $userQuery->execute();
        $user = $userQuery->fetchObject(User::class);
        echo "<h3> View Class </h3>";
        if ($user) {
            echo "Id: " . $user->id . "</br>";
            echo "Name: " . $user->name . "</br>";
            echo "Email: " . $user->email . "</br>";
        } else {
            echo "No users found";
        }
    }

    public static function getAdd() {
        ?>
        <html>
        <head>
            <title>Add user</title>
        </head>
        <body>
            <div>
                <form action="/user/add/" method="post">
                    <input type="text" name="name">
                    <input type="email" name="email">
                    <button>Add user</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    }

    public static function postAdd() {
        // var_export($_POST);
        if (isset($_POST['email'])) {
            $_POST = [
                0 => json_encode($_POST)
            ];
            $result = \Controllers\UserController::postAdd();
            if ($result) {
                header('Location: /user/view/' . $result);
                exit;
            }
            return "User not added succesfully";
        }
    }
}