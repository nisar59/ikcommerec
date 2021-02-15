<?php

namespace App;

use App\Models\BaseModel;

class Compare extends BaseModel {

    protected $table = 'compare_products';
    public $timestamps = true;

    protected $fillable = [
        'p_id'
    ];

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
