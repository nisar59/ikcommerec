<?php

namespace Modules\Brands\Entities;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $fillable = ['name','slug','short_description','image','description','meta_title','meta_description','meta_schema','status','sort_order','user_id'];

    public function permalink() {

        return $this->hasOne('Modules\CMS\Entities\Permalink', 'reference', 'id')->where('model', "BRAND")->latest();
    }
}
