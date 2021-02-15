<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $table = 'courses';

    protected $primaryKey = 'id';

    protected $fillable = array('title', 'slug', 'short_description', 'description', 'image_id', 'sort_order', 'status', 'featured','course_duration','max_student','allowed_retake','passing_condition','course_result','price','sale_price','required_enroll','instructor_id','user_id','meta_title', 'meta_description', 'meta_keywords', 'schema');

    public function permalink() {
        return $this->hasOne('Modules\CMS\Entities\Permalink', 'reference', 'id')->where('model', "COURSE")->latest();
    }

    public function categories() {
        return $this->belongsToMany('Modules\Category\Entities\Category', 'course_categories' , 'course_id' , 'category_id');
    }

    public function course_reviews() {
        return $this->hasMany('Modules\Courses\Entities\Reviews' , 'course_id');
    }

    public function curriculms() {
        return $this->hasMany('Modules\Curriculum\Entities\Curriculums' , 'course_id');
    }


    public function course_faqs() {
        return $this->hasMany('Modules\Courses\Entities\Faqs' , 'course_id');
    }

    public function course_library() {
        return $this->hasMany('Modules\Courses\Entities\Libraries' , 'course_id');
    }

    public function course_announcments() {
        return $this->hasMany('Modules\Courses\Entities\Announcements' , 'course_id');
    }


}
