<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    protected $table = 'course_faqs';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'description', 'sort_order', 'status','user_id');

}
 