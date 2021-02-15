<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;

class Silder extends Model
{
    protected $table = 'sliders';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'sort_order', 'status');

    public $timestamps = true;

    public function slides() {
        return $this->hasMany('App\Models\Slide', 'slider_id', 'id');
    }
}
