<?php

namespace Controllers;

use Models\User;

class UserController {
    public static function getView($id) {
        // header('Content Type: json');
        $user = User::getById($id);

//         if ($user) {
//             echo "Id: " . $user->id . "</br>";
//             echo "Name: " . $user->name . "</br>";
//             echo "Email: " . $user->email . "</br>";
//         } else {
//             echo "No users found";
//         }
        // JSON resonse
        $result = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

        var_export(json_encode($result));
    }

    public static function postAdd() {
        // var_export($_POST);
        if (isset($_POST[0])) {
            $data = json_decode($_POST[0], true);
            var_export($data);

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            
            if (!$user->save()) {
            	break;
            }
            
            var_export($user);

            echo "\e[32;1mUser inserted\e[27;0m";
            return $user->id;
        }
        return false;
    }
    
    public static function getList() {
    	return (new User())->getAll();
    }
}