<?php

namespace Controllers;

use Models\User;
use Views\UserView;
use Views\SiteView;

class UserViewController extends Controller{
    public static function getView($id) {
    	if ($id == null) {
    		header('Location: /user/list/');
    		exit;
    	}
        $user = User::getById($id);
        
        echo "<h3> View Class </h3>";
        
        SiteView::draw(
        	UserView::draw($user)
        );
//         if ($user) {
//             echo "Id: " . $user->id . "</br>";
//             echo "Name: " . $user->name . "</br>";
//             echo "Email: " . $user->email . "</br>";
//         } else {
//             echo "No users found";
//         }
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
        if (isset($_POST['email'])) {
            $_POST = [
                0 => json_encode($_POST)
            ];
            $result = \Controllers\UserController::postAdd();
            if ($result) {
                header('Location: /user/view/' . $result);
                exit;
            }
        }
        return "User not added succesfully";
    }
    
    public static function getList() {
    	global $auth;
    	if (!$auth->isAuthorised()) {
    		echo "<p>You are not authorised!</p>";
    		exit;
    	}
    	$userlist = UserController::getList();
    	?>
    	<!DOCTYPE html>
    	<html>
    		<head>
    			<meta charset="utf-8">
    			<title>User list</title>
    		</head>
    		<body>
    			<div class="content">
    				<ul>
    				<?php foreach ($userlist as $user): ?>
    					<li><?= $user->name ?>: <?= $user->email ?></li>
    				<?php endforeach; ?>
    				</ul>
    			</div>
    		</body>
    	</html>
    	<?php
    }
}