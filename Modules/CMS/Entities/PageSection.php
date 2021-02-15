<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $table = 'page_sections';
    protected $fillable = ['page_id', 'section_id'];
}
