<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id','slug','parent_id','name','short_description','description','image_id','sort_order','status','meta_title','meta_description','meta_keywords','meta_schema'];

    public function childs() {
        return $this->hasMany('\Modules\Category\Entities\Category', 'parent_id', 'id');
    }
    public function parent() {
        return $this->hasOne('\Modules\Category\Entities\Category', 'parent_id');
    }

    public function permalink() {
        return $this->hasOne('Modules\CMS\Entities\Permalink', 'reference', 'id')->where('model', config('variable.CATEGORY_MODEL'))->latest();
    }
    public function products() {
        return $this->belongsToMany('Modules\Products\Entities\Products', 'product_categories' , 'category_id' , 'product_id');
    }
}
