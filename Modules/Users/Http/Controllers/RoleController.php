<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Entities\User;
//  use App\Http\Controllers\Controller;
//use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use Illuminate\Support\Arr;

class RoleController extends Controller
{
    protected $guard_name = 'web';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use  ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    { //dd(\Route::current()->getName());
       $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
       if(!empty($link)){
           return redirect($link);
       }

        $this->data['roles'] = Role::orderBy('id','DESC')->get();
        // dd($this->data);
        return view('users::backend.roles.index')->with('data', $this->data);
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
        $this->data['permissions'] = Permission::get();
        return view('users::backend.roles.create')->with('data', $this->data);
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
            'name' => 'required',

            'permission' => 'required'
        ]);


        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect('admin/users/roles')
            ->with('success','Role created successfully');
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
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['role'] = Role::find($id);

        $this->data['permission'] = Permission::get();
        $this->data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('users::backend.roles.edit')->with('data', $this->data);
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
            'name' => 'required',
            'permission' => 'required',
        ]);


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();


        $role->syncPermissions($request->input('permission'));

        return redirect('admin/users/roles')
            ->with('success','Role updated successfully');
    }
    public function statusUpdate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = User::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('admin/users/roles')
            ->with('success','User updated successfully');
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
        DB::table("roles")->where('id',$id)->delete();
        return redirect('admin/users/roles')
            ->with('success','Role updated successfully');
    }
}
