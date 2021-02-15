<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseLessons extends Model
{
    protected $table = 'course_lessons';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'slug', 'section_id', 'sort_order', 'status', 'duration', 'preview','slug','user_id');

    public function permalink() {
        return $this->hasOne('Modules\CMS\Entities\Permalink', 'reference', 'id')->where('model', "LESSON")->latest();
    }

    public function categories() {
        return $this->belongsToMany('Modules\Category\Entities\Category', 'course_categories' , 'course_id' , 'category_id');
    }

    public function course_reviews() {
        return $this->hasMany('Modules\Courses\Entities\Reviews' , 'course_id');
    }


}
