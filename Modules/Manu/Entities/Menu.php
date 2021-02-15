<?php

namespace Modules\Manu\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'code', 'status');

    public $timestamps = true;

    public function items() {
        return $this->hasMany('Modules\Manu\Entities\MenuItems', 'menu_id', 'id');
    }
}
