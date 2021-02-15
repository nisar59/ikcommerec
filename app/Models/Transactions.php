<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['id', 'date','amount','account_title','account_id','description','transaction_type','voucher_code','banam','jamah'];
}
