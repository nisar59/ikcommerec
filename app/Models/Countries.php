<?php

namespace App\Models;

use App\Models\BaseModel;

class Countries extends BaseModel {

    protected $table = 'countries';
    public $timestamps = false;

    public function __construct() {
        
    }

    public function states() {
        return $this->hasMany('App\Models\States');
    }

    public function getName() {
        return $this->name;
    }

    public function getCode() {
        return $this->code;
    }

    public function getPhonecode() {
        return $this->phonecode;
    }
}
