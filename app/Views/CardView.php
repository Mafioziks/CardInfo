<?php

namespace Views;

use Models\Card;

class CardView {
    public static function draw(Card $card) {
        ?>
        <style>
            .card {
                border: 1px solid black;
                margin: 5px;
                padding: 5px;
                border-radius: 5px;
                float: left;
                width: 250px;
            }
        </style>
        <div class="card">
            <header>
                <h3><?= $card->name ?></h3>
            </header>
            <section>
                <p>ID: <strong><?= $card->cardNumber ?></strong></p>
                <p>Owner: <strong><?= $card->user->name ?></strong></p>
            </section>
        </div>
        <?php
    }
}