<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class Educations extends Model
{
    protected $fillable = ['degree_title','degree_school','degree_start_date','degree_end_date','interest','sort_order','user_id'];
}
