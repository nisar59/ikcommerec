<?php

namespace Modules\Suppliers\Entities;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $fillable = ['name','description','status','sort_order','user_id'];
}
