<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    protected $primaryKey = 'id';

    protected $fillable = array('code', 'key', 'value');

    public $timestamps = true;


    public static function getValue($key){
        return Self_::where('key', $key)->pluck('value');
    }
}
