<?php

namespace Modules\MediaLibrary\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'file';
    protected $primaryKey = 'id';
    
    protected $fillable = [];
}
