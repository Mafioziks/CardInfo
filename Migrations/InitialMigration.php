<?php

namespace Migrations;

use \Controllers\DatabaseController;

class InitialMigration {
    public static function test () {
        echo "MIGRATION CALLED ";
    }

    public static function up () {
        $result[] = DatabaseController::query(
            "CREATE TABLE IF NOT EXISTS `users` 
            (
                id integer not null auto_increment primary key,
                name varchar(250),
                email varchar(250)
            )"
        );

        $result[] = DatabaseController::query(
            "CREATE TABLE IF NOT EXISTS `cards`
            (
                id integer not null auto_increment primary key,
                name varchar(250),
                card_number integer,
                owner_id integer
            )"
        );

        $result = array_filter($result, function ($val) {
            if (!empty($val)) {
                return true;
            }
        });

        if (empty($result)) {
            var_dump("> Migration set up successfully");
        } else {
            var_export($result);
        }
    }

    public static function down() {
        $result[] = DatabaseController::query(
            "DROP TABLE IF EXISTS cards"
        );

        $result[] = DatabaseController::query(
            "DROP TABLE IF EXISTS users"
        );

        $result = array_filter($result, function ($val) {
            if (!empty($val)) {
                return true;
            }
        });

        if (empty($result)) {
            var_dump("> Migration removed successfully");
        } else {
            var_export($result);
        }
    }
}