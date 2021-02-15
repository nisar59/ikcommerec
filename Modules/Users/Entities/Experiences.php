<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class Experiences extends Model
{
    protected $fillable = ['job_title','job_organization','job_description','job_start_date','job_end_date','sort_order','user_id'];
}
