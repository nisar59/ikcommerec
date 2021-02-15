<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table = 'course_reviews';

    protected $primaryKey = 'id';

    protected $fillable = array('course_id', 'title', 'description', 'user_id', 'rating', 'status');



    public function course() {
        return $this->belongsTo('Modules\Courses\Entities\Courses');
    }



}
