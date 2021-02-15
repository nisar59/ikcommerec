<?php

namespace Modules\Curriculum\Entities;

use Illuminate\Database\Eloquent\Model;

class Curriculums extends Model
{
    protected $table = 'curriculums';

    protected $primaryKey = 'id';

    protected $fillable = array('title' ,'sort_order', 'status','user_id','course_id');





    public function curriculum_sections() {
        return $this->hasMany('Modules\Curriculum\Entities\CurriculumSections' , 'curriculum_id','id');
    }


}
