<?php

namespace Controllers;

use Models\Card;

class CardsController {
    public static function getView($id) {
        $db = new \PDO('mysql:host=localhost;dbname=testdb', 'root', 'mafija');
        $cardQuery = $db->prepare('SELECT * FROM cards WHERE owner_id = :owner');
        $cardQuery->bindValue(':owner', $id, \PDO::PARAM_INT);
        $cardQuery->execute();
        $card = $cardQuery->fetchObject(Card::class);

        var_export($card);

        if (!is_array($card)) {
            $cards[] = $card;
        } else {
            $cards = $card;
        }

        foreach ($cards as $c) {
            echo "Name: " . $c->name . "</br>";
            echo "Card number: " . $c->cardNumber . "</br>";
            echo "Owner id: " . $c->ownerId . "</br>";
        }
    }

    public static function postAdd() {
        if (isset($_POST[0])) {
            $data = json_decode($_POST[0], true);
            var_export($data);

            $card = new Card();
            $card->name = $data['name'];
            $card->cardNumber = $data['card_number'];
            $card->ownerId = $data['owner_id'];

            $card->save();

            echo "\e[32;1mcard inserted\e[27;0m";
        }
    }
}