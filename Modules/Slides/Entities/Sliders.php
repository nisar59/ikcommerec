<?php

namespace Modules\Slides\Entities;

use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    protected $fillable = ['title','description','ex_url','sort_order','image','status','user_id'];

    public function permalink() {

        return $this->hasOne('Modules\CMS\Entities\Permalink', 'reference', 'id')->where('model', "BRAND")->latest();
    }
}
