<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;

class CurriculumSections extends Model
{
    protected $table = 'curriculum_sections';

    protected $primaryKey = 'id';

    protected $fillable = array('title' ,'sort_order', 'status','user_id','curriculum_id');



    public function sections_lessons() {
        return $this->hasMany('Modules\Curriculum\Entities\CourseLessons' , 'section_id','id');
    }




}
