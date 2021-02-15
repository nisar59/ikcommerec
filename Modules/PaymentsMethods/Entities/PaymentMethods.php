<?php

namespace Modules\PaymentsMethods\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    protected $fillable = ['name','description','status','sort_order','user_id'];
}
