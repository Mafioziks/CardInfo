<?php

namespace Controllers;

use Models\User;

class UserController {
	
	private $result = [];
	
	public function afterAction() {
		return json_encode($this->result);
	}
	
    public function getView($id) {
        // header('Content Type: json');
        if ($id == null) {
        	return null;
        }
        $user = User::getById($id);

        $this->result = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

        echo json_encode($this->result);
    }

    public function postAdd() {
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
    
    public function getList() {
    	echo json_encode(User::getAll());
    	return;
    }
    
    public function getIndex($id = null) {
    	if ($id == null) {
    		$this->getList();
    	}
    	
    	$this->getView($id);
    }
    
    public function getCards($id) {
    	$user = User::getById($id);
    	$cards = $user->card;
    	echo json_encode($cards);
    }
    
    public function getCard($id, $card_id = null) {
    	if ($card_id == null) {
    		echo json_encode(["error" => "no card id provided"]);
    		return;
    	}
    	
    	$cards = User::getById($id)->card;
    	
    	$c = null;
    	
    	foreach ($cards as $card) {
    		if ($card->id == $card_id) {
    			echo json_encode($card);
    			return;
    		}
    	}
    	
    	echo json_encode(["error" => "wrong card id provided"]);
    	return;
    }
}