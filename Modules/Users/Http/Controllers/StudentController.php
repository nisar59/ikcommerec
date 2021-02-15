<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Entities\User;

use Modules\Users\Entities\Educations;
use Modules\Users\Entities\Experiences;
//  use App\Http\Controllers\Controller;
//use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use Illuminate\Support\Arr;

class StudentController extends Controller
{
    protected $guard_name = 'web';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use  ValidatesRequests;
    public function __construct()
    {
        //$this->middleware('auth');
        // $this->userPermission();
    }

    public function index()
    {//dd(auth()->user()->id);
        userPermissionsss(auth()->user()->id,\Route::current()->getName());
        $this->data['user'] = User::where('user_type','customer')->orderBy('id','DESC')->get();
        // dd($this->data);
        return view('users::backend.students')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->data['roles'] = Role::pluck('name','name')->all();
        return view('users::backend.studentsCreate')->with('data', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       // dd('ds');
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            //'roles' => 'required'
        ]);


        $input = $request->all();
         // dd($input);
        //dd(upload_user_image($input));
        if(isset($input['profile_picture'])){
            $input['profile_picture'] = upload_user_image($input);
        }
        $input['user_type']= 'customer';
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        //$user->assignRole($request->input('roles'));


        return redirect('admin/users/customers')
            ->with('success','Customer created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $this->data['user'] = User::find($id);

        return view('users::backend.show')->with('data', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['user'] = User::find($id);

        //$this->data['roles'] = Role::pluck('name','name')->all();
        //$this->data['userRole'] = $this->data['user']->roles->pluck('name','name')->all();
        return view('users::backend.studentsEdit')->with('data', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            //'password' => 'same:confirm-password',
            //'roles' => 'required'
        ]);
        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
        if(isset($input['profile_picture'])){
            $input['profile_picture'] = upload_user_image($input);
        }


        $user = User::find($id);
        $user->update($input);
       // DB::table('model_has_roles')->where('model_id',$id)->delete();


       // $user->assignRole($request->input('roles'));


        return redirect('admin/users/customers')
            ->with('success','Customer updated successfully');
    }
    public function statusUpdate($id)
    {

        $user = User::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Student updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back()
            ->with('success','Student updated successfully');
    }



    public function education($ID)
    {//dd(auth()->user()->id);
        userPermissionsss(auth()->user()->id,\Route::current()->getName());
        $this->data['student'] = User :: find($ID);
        $this->data['user'] = Educations::where('user_id',$ID)->orderBy('id','DESC')->get();
        //dd($this->data);
        return view('users::backend.educations')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function educationCreate($id)
    {
        $this->data['student'] = User :: find($id);
 //dd($this->data['student'] );
        return view('users::backend.educationCreate')->with('data', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function educationStore(Request $request)
    {
        $this->validate($request, [
            'degree_title' => 'required',
           // 'last_name' => 'required',
           // 'email' => 'required|email|unique:users,email',
           // 'password' => 'required|same:confirm-password',
            //'roles' => 'required'
        ]);


        $input = $request->all();
        // dd($input);
        //dd(upload_user_image($input));

       // $input['user_type']= 'students';
        //$input['password'] = Hash::make($input['password']);


        $user = Educations::create($input);
        //$user->assignRole($request->input('roles'));


        return redirect('users/students/educations/'.$input['user_id'])
            ->with('success','Record created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function educationshow($id)
    {
        $this->data['user'] = User::find($id);

        return view('users::backend.show')->with('data', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function educationEdit($id)
    {
      /// dd($id);
        $this->data['user'] = Educations::find($id);

        //$this->data['roles'] = Role::pluck('name','name')->all();
        //$this->data['userRole'] = $this->data['user']->roles->pluck('name','name')->all();
        return view('users::backend.educationEdit')->with('data', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function educationUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'degree_title' => 'required',
          //  'last_name' => 'required',
          //  'email' => 'required|email|unique:users,email,'.$id,
            //'password' => 'same:confirm-password',
            //'roles' => 'required'
        ]);
        $input = $request->all();



        $user = Educations::find($id);
        $user->update($input);
        // DB::table('model_has_roles')->where('model_id',$id)->delete();


        // $user->assignRole($request->input('roles'));


        return redirect('users/students/educations/'.$user->user_id)
            ->with('success','Record updated successfully');
    }
    public function educationStatusUpdate($id)
    {

        $user = User::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('users/students')
            ->with('success','Student updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function educationDestroy($id)
    {
        Educations::find($id)->delete();
        return redirect()->back()
            ->with('success','Record updated successfully');
    }





}
