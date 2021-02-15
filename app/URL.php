<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class URL extends Model
{
    protected $table = 'permalinks';
    protected $fillable = ['model', 'slug', 'reference'];



    public function product() {
        return $this->hasOne('Modules\Products\Entities\Products', 'id', 'reference')->latest();;
    }
}
