<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Http\Helpers\StringHelper;
use Booleanlogics\MultiCurrency\Model\CurrencyRate;

class Coupon extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupons';
    private $rate;

    public function __construct() {
        //$this->rate = CurrencyRate::getRate();
    }

    public function brand() {
        return $this->belongsTo('App\Models\Brand');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function getDiscount($amount, $isBasedDiscount = false, $isDisplay = false) {

        $discount = ($this->discount_type == 1) ? ($amount * $this->discount) / 100 : $this->discount * $this->rate;

        if ($isBasedDiscount) {
            $discount = ($this->discount_type == 1) ? ($amount * $this->discount) / 100 : $this->discount;
        }

        if ($isDisplay) {
            return CurrencyRate::getPrefix() . '' . StringHelper::formatMoney($discount) . CurrencyRate::getSufix();
        }
        return StringHelper::formatMoney($discount);
    }

}
