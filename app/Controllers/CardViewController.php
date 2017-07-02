<?php

namespace Controllers;

use Models\Card;
use Views\CardView;

class CardViewController {
    public function getList() {
        $cardList = Card::getAll();
        ?>
        <!DOCTYPE hmtl>
        <html>
            <head>
                <meta charset="utf-8">
                <title>Card list</title>
            </head>
            <body>
                <div class="content">
                    <?php foreach ($cardList as $card): ?>
                        <?php CardView::draw($card) ?>
                    <?php endforeach; ?>
                </div>
            </body>
        </html>
        <?php
    }
    
    public function getAdd() {
        ?>
        <html>
            <head>
                <meta charste="utf-8">
                <title>Add Card</title>
            </head>
            <body>
                <div class="content">
                    <form action="/card/add/" method="POST">
                        <input name="name" type="text" /></br>
                        <input name="card_number" type="number" /></br>
                        <input name="owner_id" type="number" /></br>
                        <button>Add</button>
                    </form>
                </div>
            </body>
        </html>
        <?php
    }
    
    public function postAdd() {
        $set = true;
        
        foreach ($_POST as $key => $val) {
            if (empty($val)) {
                $set = false; 
            }
        }
        
        if ($set) {
            $_POST = [
                    0 => json_encode($_POST)
            ];
            $result = \Controllers\CardController::postAdd();
            if ($result) {
                header('Location: /card/view/' . $result);
                exit;
            }
        }
        return "Card not added succesfully";
    }
    
    public function getView($id) {
        // Change to use API for fetching info
        if ($id == null) {
            header('Location: /card/list/');    
            exit;
        }
        $card = Card::getById($id);
        
//         var_export($card);
        
        if (!is_array($card)) {
            $cards[] = $card;
        } else {
            $cards = $card;
        }
        
        foreach ($cards as $c) {
            echo "Name: " . $c->name . "</br>";
            echo "Card number: " . $c->card_number . "</br>";
            echo "Owner id: " . $c->owner_id . "</br>";
        }
    }
}