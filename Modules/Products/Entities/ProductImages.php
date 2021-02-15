<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'product_images';
    protected $fillable = ['id','p_id','images','sort_order'];


}
