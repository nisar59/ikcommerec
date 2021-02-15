<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;

class CmsBlock extends Model
{
    protected $table = 'cms_blocks';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'description', 'image', 'sort_order', 'status');

    public $timestamps = true;

    public function section() {
        return $this->belongsTo('App\Models\CmsSection', 'cms_section_id', 'id');
    }
}
