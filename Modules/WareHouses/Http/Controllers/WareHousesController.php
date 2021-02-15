<?php

namespace Modules\WareHouses\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\WareHouses\Entities\WareHouses;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;

class WareHousesController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->data['user'] = WareHouses:: orderBy('sort_order')->get();
        return view('warehouses::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('warehouses::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            //  'slug' => 'required',
            //  'description' => 'required',

        ]);
        $cms = new WareHouses();
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');

        $cms->sort_order =  MaxSortorder('ware_houses');

        $cms->status =  1;

        $cms->save();
        return redirect('admin/warehouses')
            ->with('success','Ware house created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('warehouses::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['user'] = WareHouses::find($id);
        //  dd($this->data);
        return view('warehouses::backend.edit')->with('data', $this->data);
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
            'name' => 'required',
//            'slug' => 'required',
//            'description' => 'required',

        ]);
        $cms =WareHouses::find($id);
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');


        $cms->save();


        return redirect('admin/warehouses')
            ->with('success','Ware Huose Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function statusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = warehouses::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('admin/warehouses')
            ->with('success','Ware house updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        WareHouses::find($id)->delete();
        return redirect('admin/warehouses')
            ->with('success','ware House updated successfully');
    }
}
