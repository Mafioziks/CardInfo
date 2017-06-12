<?php

namespace Models;

class Card {
    public $id;
    public $name;
    public $cardNumber;
    public $ownerId;

    public function save() {
        $db = new \PDO('mysql:host=localhost;dbname=testdb', 'root', 'mafija');
        $cardQuery = $db->prepare(
            'INSERT INTO cards 
                (`name`, `card_number`, `owner_id`)
             VALUES
                (:name, :card_number, :owner_id)');
        $cardQuery->bindValue(':name', $this->name, \PDO::PARAM_STR);
        $cardQuery->bindValue(':card_number', $this->cardNumber, \PDO::PARAM_INT);
        $cardQuery->bindValue(':owner_id', $this->ownerId, \PDO::PARAM_INT);
        $result = $cardQuery->execute();
        // not working ???
        // Need to update id to last inserted id
    }
}