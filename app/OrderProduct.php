<?php

namespace App\Models;

use App\Models\BaseModel;

class OrderProduct extends BaseModel {

    protected $table = 'order_products';
    protected $rules = [
        'order_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity' => 'required|integer',
        'price' => 'required',
        'total_price' => 'required',
    ];

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function getProductTotal() {
        return $this->quantity * $this->price;
    }

    public function getProductDiscountTotal() {
        return ($this->quantity * $this->price) - $this->discount;
    }

    public function isShipped($itemId, $items) {

        if ($items) {
            foreach ($items as $item) {
                echo $item->item_id;
                if ($item->id == $itemId) {
                    return true;
                }
            }
        }
        return false;
    }

}
