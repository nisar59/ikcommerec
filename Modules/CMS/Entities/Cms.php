<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    protected $table = 'cms';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'permalink', 'short_description', 'description', 'image', 'sort_order', 'status', 'meta_title', 'meta_description', 'meta_keywords', 'schema');

    public $timestamps = true;

    public function permalink() {
        return $this->hasOne('Modules\CMS\Entities\Permalink', 'reference', 'id')->where('model', config('variable.CMS_MODEL'))->latest();
    }

    public function sections() {
        return $this->belongsToMany('Modules\CMS\Entities\CmsSection', 'page_sections' , 'page_id' , 'section_id');
        }

    public function slider() {
        return $this->hasOne('App\Models\Slider', 'id', 'slider_id')->where('status', 1);
    }
}
