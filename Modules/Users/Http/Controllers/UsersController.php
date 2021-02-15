<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Entities\User;
//  use App\Http\Controllers\Controller;
//use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use Illuminate\Support\Arr;

class UsersController extends Controller
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
        $this->data['user'] = User::where('user_type','admin')->orderBy('id','DESC')->get();
       // dd($this->data);
        return view('users::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->data['roles'] = Role::pluck('name','name')->all();
        return view('users::backend.create')->with('data', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['user_type']= 'admin';
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect('admin/users')
            ->with('success','User created successfully');
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

        $this->data['roles'] = Role::pluck('name','name')->all();
        $this->data['userRole'] = $this->data['user']->roles->pluck('name','name')->all();
        return view('users::backend.edit')->with('data', $this->data);
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
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect('admin/users')
            ->with('success','User updated successfully');
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
        return redirect('admin/users')
            ->with('success','User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('admin/users')
            ->with('success','User updated successfully');
    }


}
