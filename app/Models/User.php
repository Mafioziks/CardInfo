<?php

namespace Models;

use Controllers\Model;

class User extends Model{
    public $id;
    public $name;
    public $email;
    public $password;
    public $admin;
    
    public function __construct() {
        parent::__construct();
        $this->addRelations([
            'card' => ['id', 'ownerId'],
        ]);
    }
    
    public static function getRules() {
        return [
            'id'       => 'integer',
            'name'        => 'string',
            'email'    => 'string',
            'password' => 'string',
            'admin'    => 'boolean',
        ];
    }
}