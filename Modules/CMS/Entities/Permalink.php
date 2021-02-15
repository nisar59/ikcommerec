<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;

class Permalink extends Model
{
    protected $table = 'permalinks';
    protected $fillable = ['model', 'slug', 'reference'];
}
