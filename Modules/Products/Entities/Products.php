<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = ['id','slug','name','brand_id','short_description','description','quantity','sort_order','status','stock_status','supplier_id',
        'product_doc','sku','purchase_price','price','sale_price','weight','enable_reviews','featured','warehouse_id',
        'viewed','sold','meta_title','meta_description','meta_keywords','meta_schema','user_id','product_handling_chrages','internal_notes'];

    public function categories() {
        return $this->belongsToMany('Modules\Category\Entities\Category', 'product_categories' , 'product_id' , 'category_id');
    }

    public function related_products() {
        return $this->belongsToMany('Modules\Products\Entities\Products', 'related_products' , 'product_id' , 'p_id');
    }
    public function images() {
        return $this->hasMany('Modules\Products\Entities\ProductImages', 'p_id' );
    }
    public function permalink() {
        return $this->hasOne('Modules\CMS\Entities\Permalink', 'reference', 'id')->where('model', config('variable.PRO'))->latest();
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
}
