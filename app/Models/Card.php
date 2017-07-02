<?php

namespace Models;

use Controllers\Model;

class Card extends Model {
    public $id;
    public $name;
    public $cardNumber;
    public $ownerId;
    
    public function __construct() {
    	parent::__construct();
    	$this->addRelations([		
    		'user' => ['ownerId','id'],
    	]);
    }
}