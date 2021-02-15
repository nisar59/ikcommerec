<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;

class CmsSection extends Model {

    protected $table = 'cms_sections';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'description', 'image', 'sort_order', 'status');

    public $timestamps = true;

    public function blocks() {
        return $this->hasMany('Modules\CMS\Entities\CmsBlock', 'cms_section_id', 'id');
    }

    public function clients() {
        return Client::where('status', 1)->where('is_featured', 1)->orderBy('sort_order', 'ASC')->get();
    }

    public function testimonials() {
        return Testimonial::where('status', 1)->where('is_featured', 1)->orderBy('sort_order', 'ASC')->get();
    }

    public function page() {
        return $this->belongsToMany('Modules\CMS\Entities\Cms', 'page_sections' , 'section_id' , 'page_id');
        }
}
