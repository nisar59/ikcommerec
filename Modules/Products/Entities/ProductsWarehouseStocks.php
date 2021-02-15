<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductsWarehouseStocks extends Model
{
    protected $table = 'producs_warehouse_stocks';
    protected $fillable = ['id','p_id','ware_house_id','quantity','available_quantity','store_id', 'variation_id', 'variation_value'];
}
