<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionalAccounts extends Model
{
    protected $table = 'transactional_accounts';
    protected $fillable = ['id', 'account_type','account_title','address','status','supplier_id','customer_id'];
}
