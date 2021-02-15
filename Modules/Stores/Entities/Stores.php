<?php

namespace Modules\Stores\Entities;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $fillable = ['name','description','status','sort_order','user_id','store_type'];
}
