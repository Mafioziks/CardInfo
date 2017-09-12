<?php

namespace Controllers;

use Models\Card;

class CardController {
    public static function getView($id) {
        $card = Card::getById($id);
        
        echo json_encode(['id' => $card->id, 'name' => $card->name, 'cardNumber' => $card->cardNumber, 'ownerId' => $card->ownerId]);
    }

    public static function postAdd() {
        if (isset($_POST[0])) {        	
            $data = json_decode($_POST[0], true);
            
            $card = new Card();
            $card->name = $data['name'];
            $card->cardNumber = $data['card_number'];
            $card->ownerId = $data['owner_id'];

            $card->save();
            
            echo "\e[32;1Card inserted\e[27;0m";
            return $card->id;
        }
    }
    
    public function getList() {
    	$cards = Card::getAll();
    	
    	$result = [];
    	
    	foreach ($cards as $card) {
    		$result[] = ['id' => $card->id, 'name' => $card->name, 'cardNumber' => $card->cardNumber, 'ownerId' => $card->ownerId];
    	}
    	
    	echo json_encode($result);
    }
}