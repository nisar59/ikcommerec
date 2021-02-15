<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;

class Libraries extends Model
{
    protected $table = 'couse_libraries';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'description', 'sort_order','library_url', 'status','user_id');





}
