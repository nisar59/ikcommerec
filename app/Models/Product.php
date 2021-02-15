<?php

namespace App\Models;

use App\Model\Country;
use App\Model\Shape;
use App\Models\BaseModel;
use App\Model\Pattern;
use App\Model\MaterialPile;
use App\Model\Age;
use App\Model\Condition;

class Product extends BaseModel {

    protected $table = 'products';
    /*protected $rules = [
        'product_type_id' => 'required|integer',
        'sku' => 'required|unique:products,sku|max:100',
        'parent_id' => 'nullable|integer',
        'country_of_manufacture' => 'required',
        'title' => 'required|max:250',
        'slug' => 'required|unique:u_r_ls,slug,Product(),model',
        'cost_unit_id' => 'required|integer',
        'cost' => 'required',
        'product_quantity' => 'required',
        'sale_price' => 'required|between:0,99.99',
        'product_status_id' => 'required|integer',
        'image' => 'mimes:jpg,jpeg,png,gif|max:10240'
    ];*/



    public function uri() {
        return $this->hasOne('App\Models\URL', 'reference', 'id')->where('model', 'Product()')->latest();
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\ProductCategory', 'product_categories', 'product_id', 'category_id');
    }

    public function categoryIds() {
        return $this->hasMany('App\Models\ProductCategory', 'product_id', 'id');
    }

    public function baseColor() {
        return $this->hasOne('App\Models\BaseColor', 'id', 'base_color_id');
    }

    public function color() {
        return $this->hasOne('App\Models\Color', 'id', 'color_id');
    }

    public function borderColor() {
        return $this->hasOne('App\Models\Color', 'id', 'border_color_id');
    }

    public function vendor() {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function parent() {
        return $this->hasOne('App\Models\Product', 'id', 'parent_id');
    }

    public function childs() {
        return $this->hasMany('App\Models\Product', 'parent_id', 'id');
    }

    public function design() {
        return $this->hasOne('App\Models\Design', 'id', 'design_id');
    }

    public function style() {
        return $this->hasOne('App\Models\Style', 'id', 'style_id');
    }

    public function shape() {
        return $this->hasOne('App\Models\Shape', 'id', 'shape_id');
    }

    public function pattern() {
        return $this->hasOne('App\Models\Pattern', 'id', 'pattern_id');
    }

    public function size() {
        return $this->hasOne('App\Models\Size', 'id', 'size_id');
    }

    public function status() {
        return $this->hasOne('App\Models\ProductStatus', 'id', 'product_status_id');
    }

    public function type() {
        return $this->hasOne('App\Models\Type', 'id', 'type_id');
    }

    public function costUnit() {
        return $this->hasOne('App\Models\CostUnit', 'id', 'cost_unit_id');
    }

    public function pileHeight() {
        return $this->hasOne('App\Models\PileHeight', 'id', 'pile_height_id');
    }

    public function age() {
        return $this->hasOne('App\Models\Age', 'id', 'age_id');
    }

    public function condition() {
        return $this->hasOne('App\Models\Condition', 'id', 'condition_id');
    }

    public function productType() {
        return $this->hasOne('App\Models\ProductType', 'id', 'product_type_id');
    }

    public function pile() {
        return $this->hasOne('App\Models\Pile', 'id', 'pile_id');
    }

    public function collection() {
        return $this->hasOne('App\Models\Collection', 'id', 'collection_id');
    }

    public function material() {
        return $this->hasOne('App\Models\Material', 'id', 'material_id');
    }

    public function dye() {
        return $this->hasOne('App\Models\Dye', 'id', 'dyes_id');
    }

    public function knot() {
        return $this->hasOne('App\Models\Knot', 'id', 'knot_id');
    }

    public function weave() {
        return $this->hasOne('App\Models\Weave', 'id', 'weave_id');
    }

    public function stocks() {
        return $this->hasMany('App\Models\WarehouseProductStock', 'product_id', 'product_id');
    }

    public function inStock() {
        /*$stock = $this->stocks()->get();
        if($stock){
            return $this->stocks()->sum('quantity');
        }else{
            return 0;
        }*/
        return $this->quantity;

    }

    public function orderProducts() {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function isTypeChecked($id) {
        if ($this->types) {
            foreach ($this->types as $type) {
                if ($type->id == $id) {
                    return true;
                }
            }
        }
        return false;
    }

    public function ruleOnUpdate($id) {
        return $this->rules['sku'] = 'required|unique:products,sku, ' . $id . '|max:100';
    }
}
