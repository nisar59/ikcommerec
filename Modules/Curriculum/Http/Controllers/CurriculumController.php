<?php

namespace Modules\Curriculum\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use DB;
use Hash;
use Modules\Curriculum\Entities\Curriculums;
use Modules\CMS\Entities\Permalink;
use Modules\Curriculum\Entities\CurriculumSections;
use Modules\Curriculum\Entities\CourseLessons;

class CurriculumController extends Controller
{ use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['user'] = Curriculums::with(['curriculum_sections'])->orderBy('sort_order','DESC')->get();
        //dd($this->data['user']);
        return view('curriculum::backend.index')->with('data', $this->data);

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        return view('curriculum::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
          //  'slug' => 'required',
          //  'description' => 'required',

        ]);
        $cms = new Curriculums();
        $cms->title = $request->input('title');

        $cms->sort_order =  MaxSortorder('curriculums');

        $cms->status =  1;

        $cms->save();


        return redirect('/curriculums')
            ->with('success','Curriculum created successfully');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('curriculum::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['user'] = Curriculums::find($id);
        //  dd($this->data);
        return view('curriculum::backend.edit')->with('data', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
//            'slug' => 'required',
//            'description' => 'required',

        ]);
        $cms =Curriculums::find($id);
        $cms->title = $request->input('title');


        $cms->save();


        return redirect('/curriculums')
            ->with('success','Curriculum Updated successfully');

    }
    public function statusUpdate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = Curriculums::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('curriculums')
            ->with('success','Curriculum updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        Curriculums::find($id)->delete();
        return redirect('curriculums')
            ->with('success','Curriculum updated successfully');
    }

    public function sections($id){

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['curriculum'] = Curriculums:: find($id);
        //dd($this->data['curriculum']);
        $this->data['user'] = CurriculumSections::with('sections_lessons')->where('curriculum_id',$id)->orderBy('sort_order','DESC')->get();

        return view('curriculum::backend.sections')->with('data', $this->data);

    }

    public function sectionCreate(Request $request,$id){
      //dd($id);
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['curriculum']=Curriculums:: find($id);

        return view('curriculum::backend.sectionCreate')->with('data', $this->data);
    }

    public function sectionStore(Request $request)
    {
       // dd('sdf');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',

           // 'slug' => 'required',
           // 'description' => 'required',

        ]);
        $cms = new CurriculumSections();
        $cms->title = $request->input('title');
        $cms->curriculum_id = $request->input('id');
        $cms->user_id = auth()->user()->id;
        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();


        return redirect('/curriculums/sections/'.$cms->curriculum_id)
            ->with('success','Section  created successfully');

    }
    public function sectionEdit($id){

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }

        $this->data['user']=CurriculumSections:: find($id);
        $this->data['curriculum']=Curriculums:: find($this->data['user']->curriculum_id);
        //  dd($this->data);
        return view('curriculum::backend.sectionEdit')->with('data', $this->data);
    }
    public function sectionUpdate(Request $request,$id){

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
//            'slug' => 'required',
//            'description' => 'required',

        ]);
        $cms =CurriculumSections::find($id);
        $cms->title = $request->input('title');


        $cms->save();


        return redirect('/curriculums/sections/'.$cms->curriculum_id)
            ->with('success','Section updated successfully');
    }

    public function sectionDestroy($id){


        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        CurriculumSections::find($id)->delete();
        return redirect()->back()
            ->with('success','Section updated successfully');
    }


    public function statusSectionUpdate($id){
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = CurriculumSections::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Section updated successfully');

    }


    public function lessons($id){
         //dd('sda');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['section'] = CurriculumSections:: find($id);

        $this->data['curriculum'] = Curriculums:: find($this->data['section']->curriculum_id);
        //dd($this->data['curriculum']);
        $this->data['user'] = CourseLessons::where('section_id',$id)->orderBy('sort_order','DESC')->get();

        return view('curriculum::backend.lessons')->with('data', $this->data);

    }

    public function lessonCreate(Request $request,$id){
        //dd($id);
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['tm'] = ['minute'=>'Minute(s)','hour'=>'Hour(s)','day'=>'Day(s)','week'=>'Week(s)'];

        $this->data['section'] = CurriculumSections:: find($id);

        $this->data['curriculum'] = Curriculums:: find($this->data['section']->curriculum_id);

        return view('curriculum::backend.lessonCreate')->with('data', $this->data);
    }

    public function lessonStore(Request $request)
    {
        // dd('sdf');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',

            // 'slug' => 'required',
            // 'description' => 'required',

        ]);
        $sction = CurriculumSections::find($request->id);

        $cms = new CourseLessons();
        $duration = $request->duration.' '.$request->tm;

        $cms->title = $request->input('title');
        $cms->description = $request->input('description');
        $cms->slug = make_permalink($request->input('slug'),'permalinks');

        $cms->preview =  $request->input('preview');
        $cms->duration =  $duration;
        $cms->section_id =  $request->id;

        $cms->user_id =  auth()->user()->id;

        $cms->sort_order =  MaxSortorder('course_lessons');

        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();
        //$cms->categories()->delete();


        $permalink = Permalink::firstOrCreate(['reference' => $cms->id, 'model' =>'LESSON']);
        $permalink->slug = make_permalink($request->input('slug'),'permalinks');
        $permalink->reference = $cms->id;
        $permalink->model = 'LESSON';
        $permalink->save();


        return redirect('/curriculums/sections/lesson/'.$sction->id)
            ->with('success','Lesson  created successfully');

    }

    public function lessonEdit($id){

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['tm'] = ['minute'=>'Minute(s)','hour'=>'Hour(s)','day'=>'Day(s)','week'=>'Week(s)'];
        $this->data['user']=CourseLessons:: find($id);
        $this->data['dur'] = explode(' ' ,$this->data['user']->duration);

        $this->data['section'] = CurriculumSections::find($this->data['user']->section_id);
        $this->data['curriculum']=Curriculums:: find($this->data['section']->curriculum_id);
        //  dd($this->data);
        return view('curriculum::backend.lessonEdit')->with('data', $this->data);
    }
    public function lessonUpdate(Request $request,$id){

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
//            'slug' => 'required',
//            'description' => 'required',

        ]);
        $cms =CourseLessons::find($id);
       // $section = CurriculumSections::find($cms->section_id);
        //$curriculum = Curriculums::find($section->curriculum_id);

        $duration = $request->duration.' '.$request->tm;

        $cms->title = $request->input('title');
        $cms->description = $request->input('description');
        $cms->slug = make_permalink($request->input('slug'),'permalinks');

        $cms->preview =  $request->input('preview');
        $cms->duration =  $duration;
        $cms->section_id =  $request->id;

        $cms->user_id =  auth()->user()->id;

        //$cms->sort_order =  MaxSortorder('course_lessons');

        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();
        //$cms->categories()->delete();


        $permalink = Permalink::firstOrCreate(['reference' => $cms->id, 'model' =>'LESSON']);
        $permalink->slug = make_permalink($request->input('slug'),'permalinks');
        $permalink->reference = $cms->id;
        $permalink->model = 'LESSON';
        $permalink->save();


        return redirect('/curriculums/sections/lesson/'.$cms->section_id)
            ->with('success','Lesson updated successfully');
    }

    public function statusLessonUpdate($id){
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = CourseLessons::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Lesson updated successfully');

    }

}
