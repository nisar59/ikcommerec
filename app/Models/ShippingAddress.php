<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $table = 'shipping_addresses';



    public function country() {
        return $this->hasOne('App\Models\Countries', 'id', 'country');
    }

    public function state() {
        return $this->hasOne('App\Models\States', 'id', 'state');
    }

    public function city() {
        return $this->hasOne('App\Models\Cities', 'id', 'city');
    }

    public function getCountry() {
        return $this->country()->first();
    }

    public function getState() {
        return $this->state()->first();
    }

    public function getCity() {
        return $this->city()->first();
    }
}
