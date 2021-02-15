<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd('sdf');
        return view('index');
    }

    public function addpermissions(){
        $permission =['role-list','role-create','role-edit','role-delete','category-list','category-create','category-edit','category-delete',
            'paymentsmethods-list','paymentsmethods-create','paymentsmethods-edit','paymentsmethods-delete','settings-list','settings-edit','stores-list','stores-edit'
        ,'stores-delete','suppliers-list','suppliers-create','suppliers-edit','suppliers-delete','user-list','user-create','user-edit','user-delete','warehouses-list',
            'warehouses-create','warehouses-edit','warehouses-delted','brands-list','brands-create','brands-edit','brands-delete'];
        // $this->data['permissions'] = Permission::get();
         //dd($this->data['permissions']);
        foreach($permission as $permission){
            $per = Permission::where('name',$permission)->first();
            if(!$per){
                Permission::create(['name'=>$permission,
                    'guard_name'=>'web']);

            }

        }
        echo 'done dana done';
    }
    public function restrictedAccess()
    {
        return view('restricted_access');
    }
}
