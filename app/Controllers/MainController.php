<?php

namespace Controllers;

class MainController {
    public static function getIndex() {
        echo "<pre>";
        
        echo "<h3>Main page</h3>";

        \Migrations\InitialMigration::test();

        echo "</pre>";
    }
}