<?php

namespace Modules\Courses\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Courses\Entities\Courses;
use Modules\Courses\Entities\Faqs;
use Modules\Courses\Entities\Libraries;
use Modules\Courses\Entities\Announcements;
use Validator;
use DB;
use Hash;
use Modules\Category\Entities\Category;
use Modules\CMS\Entities\Permalink;
use Modules\Curriculum\Entities\Curriculums;

class CoursesController extends Controller
{
    use  ValidatesRequests;/**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['user'] = Courses::orderBy('sort_order','DESC')->get();
       // dd($this->data['user']);
        return view('courses::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {$link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['curriculums'] = Curriculums:: orderBy('sort_order')->get();
        $this->data['categories'] = Category::orderBy('sort_order','DESC')->pluck('name','id')->toArray();
        $this->data['tm'] = ['minute'=>'Minute(s)','hour'=>'Hour(s)','day'=>'Day(s)','week'=>'Week(s)'];
        return view('courses::backend.create')->with('data', $this->data);
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
            'slug' => 'required',
            'description' => 'required',

        ]);
        //dd($request->all());
        //dd($request->categories);
        $duration = $request->duration.' '.$request->tm;
        $cms = new Courses();
        $cms->title = $request->input('title');
        $cms->description = $request->input('description');
        $cms->slug = make_permalink($request->input('slug'),'permalinks');
        $cms->max_student =  $request->input('max_student');
        $cms->featured =  $request->input('featured');
        $cms->course_duration =  $duration;
        $cms->allowed_retake =  $request->input('allowed_retake');
        $cms->passing_condition =  $request->input('passing_condition');
        $cms->course_result =  $request->input('course_result');
        $cms->price =  $request->input('price');
        $cms->sale_price =  $request->input('sale_price');
        $cms->required_enroll =  $request->input('required_enroll');
        $cms->instructor_id =  $request->input('instructor_id');
        $cms->user_id =  auth()->user()->id;
        $cms->enrolled_students =  $request->input('enrolled_students');


        $cms->image_id =  $request->input('image_id');
        $cms->sort_order =  MaxSortorder('courses');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_description');
        $cms->meta_keywords =  $request->input('meta_keywords');
        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();
        $cms->categories()->sync($request->categories);
        $permalink = new Permalink;
        $permalink->slug = make_permalink($request->input('slug'),'permalinks');
        $permalink->reference = $cms->id;
        $permalink->model = 'COURSE';
        $permalink->save();
        if(!empty($request->curriculms)){
            foreach($request->curriculms as $curriculum){
                $curr = Curriculums:: find($curriculum);
                $curr->course_id = $cms->id;
                $curr->save();
            }

        }


        return redirect('/courses')
            ->with('success','Course created successfully');
    }

    public function statusUpdate($id)
    {

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = Courses::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('courses')
            ->with('success','Course updated successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('courses::show');
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
        $this->data['curriculums'] = Curriculums:: orderBy('sort_order')->get();
        $this->data['tm'] = ['minute'=>'Minute(s)','hour'=>'Hour(s)','day'=>'Day(s)','week'=>'Week(s)'];
        $this->data['user'] = Courses::find($id);
        $this->data['course_curriculum'] = $this->data['user']->curriculms->pluck('id')->toArray();
        //dd($this->data['course_curriculum']);

        $this->data['categories'] = Category::orderBy('sort_order','DESC')->pluck('name','id')->toArray();
        return view('courses::backend.edit')->with('data', $this->data);

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
            'slug' => 'required',
            'description' => 'required',

        ]);
        $cms =Courses::find($id);
        $duration = $request->duration.' '.$request->tm;

        $cms->title = $request->input('title');
        $cms->description = $request->input('description');
        $cms->slug = make_permalink($request->input('slug'),'permalinks');
        $cms->max_student =  $request->input('max_student');
        $cms->featured =  $request->input('featured');
        $cms->course_duration =  $duration;
        $cms->allowed_retake =  $request->input('allowed_retake');
        $cms->passing_condition =  $request->input('passing_condition');
        $cms->course_result =  $request->input('course_result');
        $cms->price =  $request->input('price');
        $cms->sale_price =  $request->input('sale_price');
        $cms->required_enroll =  $request->input('required_enroll');
        $cms->instructor_id =  $request->input('instructor_id');
        $cms->user_id =  auth()->user()->id;
        $cms->enrolled_students =  $request->input('enrolled_students');


        $cms->image_id =  $request->input('image_id');
        $cms->sort_order =  MaxSortorder('courses');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_description');
        $cms->meta_keywords =  $request->input('meta_keywords');
        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();
        //$cms->categories()->delete();
        $cms->categories()->sync($request->categories);

        $permalink = Permalink::firstOrCreate(['reference' => $id, 'model' =>'COURSE']);
        $permalink->slug = make_permalink($request->input('slug'),'permalinks');
        $permalink->reference = $cms->id;
        $permalink->model = 'COURSE';
        $permalink->save();
        //dd($cms->curriculms->count());
        if($cms->curriculms->count()>0){
            foreach($cms->curriculms as $curr){
              // dd($curr);
                //$cr= Curriculums::find($curr);
                $curr->course_id=0;
                $curr->save();
              //  dd($curr);
            }
        }
        //dd('asd');
        if(!empty($request->curriculms)){
            foreach($request->curriculms as $curriculum){
                $curr = Curriculums:: find($curriculum);
                $curr->course_id = $cms->id;
                $curr->save();
            }

        }


        //$cms->curriculms()->sync($request->curriculms);
        return redirect('/courses')
            ->with('success','Course Updated successfully');
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
        Courses::find($id)->delete();
        return redirect('courses')
            ->with('success','Course updated successfully');
    }
    public function faqs($id)
    {
       // dd($id);
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['course'] =Courses:: find($id);
        $this->data['user'] = Faqs::orderBy('sort_order','DESC')->get();
        // dd($this->data['user']);
        return view('courses::backend.faqs')->with('data', $this->data);
    }

    public function faqsCreate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['course'] = Courses:: find($id);
        return view('courses::backend.faqCreate')->with('data', $this->data);
    }
    public function faqsStore(Request $request)
    {// dd('asd');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
           // 'slug' => 'required',
            'description' => 'required',

        ]);
        //dd($request->all());
        //dd($request->categories);


        $cms = new Faqs();
        $cms->title = $request->input('title');
        $cms->description = $request->input('description');
        $cms->user_id =  auth()->user()->id;
        $cms->course_id =  $request->input('id');
        $cms->sort_order =  MaxSortorder('course_faqs');

        $cms->status =  1;

        $cms->save();




        return redirect('/courses/faqs/'.$request->id)
            ->with('success','FAQ created successfully');
    }

    public function faqsEdit($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }

        $this->data['user'] = Faqs::find($id);
        $this->data['course'] = Courses::find($this->data['user']->course_id);
        //dd($this->data['course_curriculum']);


        return view('courses::backend.faqEdit')->with('data', $this->data);

    }

    public function faqsUpdate(Request $request,$id)
    {// dd('asd');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
            // 'slug' => 'required',
            'description' => 'required',

        ]);
        $cms = Faqs::find($id);
        $course = Courses::find($cms->course_id);
        $cms->title = $request->input('title');
        $cms->description = $request->input('description');
        $cms->user_id =  auth()->user()->id;
        $cms->save();
         return redirect('/courses/faqs/'.$course->id)
            ->with('success','FAQ Updated successfully');
    }

    public function faqsDestroy($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        Faqs::find($id)->delete();
        return redirect()->back()
            ->with('success','FAQ updated successfully');
    }

    public function faqsStatusUpdate($id)
    {

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = Faqs::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','FAQ updated successfully');
    }



    public function libraries($id)
    {
        // dd($id);
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['course'] =Courses:: find($id);
        $this->data['user'] =Libraries ::orderBy('sort_order','DESC')->get();
        // dd($this->data['user']);
        return view('courses::backend.libraries')->with('data', $this->data);
    }

    public function librariesCreate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['course'] = Courses:: find($id);
        return view('courses::backend.librariesCreate')->with('data', $this->data);
    }
    public function librariesStore(Request $request)
    {// dd('asd');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
            // 'slug' => 'required',
            'description' => 'required',

        ]);
        //dd($request->all());
        //dd($request->categories);


        $cms = new Libraries();
        $cms->title = $request->input('title');
        $cms->library_url = $request->input('library_url');
        $cms->description = $request->input('description');
        $cms->user_id =  auth()->user()->id;
        $cms->course_id =  $request->input('id');
        $cms->sort_order =  MaxSortorder('couse_libraries');

        $cms->status =  1;

        $cms->save();




        return redirect('/courses/libraries/'.$request->id)
            ->with('success','Library created successfully');
    }

    public function librariesEdit($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }

        $this->data['user'] = Libraries::find($id);
        $this->data['course'] = Courses::find($this->data['user']->course_id);
        //dd($this->data['course_curriculum']);


        return view('courses::backend.librariesEdit')->with('data', $this->data);

    }

    public function librariesUpdate(Request $request,$id)
    {// dd('asd');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
            // 'slug' => 'required',
            'description' => 'required',

        ]);
        $cms = Libraries::find($id);
        $course = Courses::find($cms->course_id);
        $cms->title = $request->input('title');
        $cms->library_url = $request->input('library_url');
        $cms->description = $request->input('description');
        $cms->user_id =  auth()->user()->id;
        $cms->save();
        return redirect('/courses/libraries/'.$course->id)
            ->with('success','Library Updated successfully');
    }

    public function librariesDestroy($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        Libraries::find($id)->delete();
        return redirect()->back()
            ->with('success','Library updated successfully');
    }

    public function librariesStatusUpdate($id)
    {

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = Libraries::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Library updated successfully');
    }

    public function announcemnts($id)
    {
        // dd($id);
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['course'] =Courses:: find($id);
        $this->data['user'] =Announcements ::orderBy('sort_order','DESC')->get();
        // dd($this->data['user']);
        return view('courses::backend.announcemnts')->with('data', $this->data);
    }

    public function announcemntsCreate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['course'] = Courses:: find($id);
        return view('courses::backend.announcemntsCreate')->with('data', $this->data);
    }
    public function announcemntsStore(Request $request)
    {// dd('asd');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
            // 'slug' => 'required',
            'description' => 'required',

        ]);
        //dd($request->all());
        //dd($request->categories);


        $cms = new Announcements();
        $cms->title = $request->input('title');
       // $cms->library_url = $request->input('library_url');
        $cms->description = $request->input('description');
        $cms->user_id =  auth()->user()->id;
        $cms->course_id =  $request->input('id');
        $cms->sort_order =  MaxSortorder('couse_libraries');

        $cms->status =  1;

        $cms->save();




        return redirect('/courses/announcemnts/'.$request->id)
            ->with('success','Announcemnt created successfully');
    }

    public function announcemntsEdit($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }

        $this->data['user'] = Announcements::find($id);
        $this->data['course'] = Courses::find($this->data['user']->course_id);
        //dd($this->data['course_curriculum']);


        return view('courses::backend.announcemntsEdit')->with('data', $this->data);

    }

    public function announcemntsUpdate(Request $request,$id)
    {// dd('asd');
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->validate($request, [
            'title' => 'required',
            // 'slug' => 'required',
            'description' => 'required',

        ]);
        $cms = Announcements::find($id);
        $course = Courses::find($cms->course_id);
        $cms->title = $request->input('title');
        //$cms->library_url = $request->input('library_url');
        $cms->description = $request->input('description');
        $cms->user_id =  auth()->user()->id;
        $cms->save();
        return redirect('/courses/announcemnts/'.$course->id)
            ->with('success','Announcement Updated successfully');
    }

    public function announcemntsDestroy($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        Announcements::find($id)->delete();
        return redirect()->back()
            ->with('success','Announcement updated successfully');
    }

    public function announcemntsStatusUpdate($id)
    {

        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = Announcements::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Announcement updated successfully');
    }




}
