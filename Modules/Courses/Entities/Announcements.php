<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    protected $table = 'course_announcements';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'description', 'sort_order', 'status','user_id');





}
