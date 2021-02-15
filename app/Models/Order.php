<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Http\Helpers\NumberHelper;

class Order extends BaseModel {

    protected $table = 'orders';
	protected $fillable = ['is_paid'];
    protected $rules = [
        //'vendor_id' => 'required|integer',
        'customer_id' => 'required|integer',
        'customer_name' => 'required',
        //'quantity' => 'required|integer',
        //'total' => 'required|integer',
        'order_no' => 'required|unique:orders,order_no|max:100',
        'billing_phone' => 'required|max:100',
        //'mobile' => 'required|max:100',
        //'fax' => 'required|max:100',
        'ship_address_1' => 'required|max:255',
        //'ship_address_2' => 'required|max:255',
        'ship_city' => 'required|max:100',
        'ship_state' => 'required|max:100',
        'ship_country' => 'required|max:100',
        //'ship_email' => 'required|max:100',
        //'ship_phone' => 'required|max:100',
        'billing_address_1' => 'required|max:255',
        //'billing_address_2' => 'required|max:255',
        'billing_state' => 'required|max:100',
        'billing_city' => 'required|max:100',
        'billing_country' => 'required|max:100',
        'billing_email' => 'required|max:100',
        'billing_phone' => 'required|max:100',
    ];

    public function creator() {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function vendor() {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }

    public function orderProducts() {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function shipments() {
        return $this->hasMany('App\Models\Shipment');
    }

    public function country() {
        return $this->belongsTo('App\Models\Countries', 'billing_country', 'id');
    }

    public function state() {
        return $this->belongsTo('App\Models\States', 'billing_state', 'id');
    }

    public function city() {
        return $this->belongsTo('App\Models\Cities', 'billing_city', 'id');
    }

    public function ruleOnUpdate($id) {
        return $this->rules['order_no'] = 'required|unique:orders,order_no, ' . $id . '|max:100';
    }

    public function getOrderNum($isEdit = false) {

        if (!$isEdit) {
            return $this->getOrderNum();
        }
        return $this->order_no;
    }

    public function getOrderTotalItems() {
        return $this->orderProducts()->sum('quantity');
    }

    public function getCurrencyRate($isOrignal = false) {
        if ($isOrignal) {
            return $this->currency_rate;
        }
        return NumberHelper::money($this->currency_rate);
    }

    public function getDiscount($isOrignal = false) {
        if ($isOrignal) {
            return $this->discount;
        }
        return NumberHelper::money($this->discount);
    }

    public function getTax($isOrignal = false) {
        if ($isOrignal) {
            return $this->tax;
        }
        return NumberHelper::money($this->tax);
    }

    public function getSubTotal($isOrignal = false) {
        if ($isOrignal) {
            return $this->total;
        }
        return NumberHelper::money($this->total);
    }

    public function getTotal() {
        return ($this->total - $this->discount) + $this->tax;
    }
 

}
