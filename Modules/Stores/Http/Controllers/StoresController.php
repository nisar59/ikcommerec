<?php

namespace Modules\Stores\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Stores\Entities\Stores;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;


class StoresController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->data['user'] = Stores:: orderBy('sort_order')->get();
        return view('stores::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('stores::backend.create');
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
        $cms = new Stores();
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');

        $cms->sort_order =  MaxSortorder('stores');
        $cms->store_type =  $request->input('store_type');

        $cms->status =  1;

        $cms->save();
        return redirect('admin/stores')
            ->with('success','Store created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('stores::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['user'] = Stores::find($id);
        //  dd($this->data);
        return view('stores::backend.edit')->with('data', $this->data);
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
        $cms =Stores::find($id);
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->store_type =  $request->input('store_type');

        $cms->save();


        return redirect('admin/stores')
            ->with('success','Store Updated successfully');
    }
    public function statusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Stores::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('admin/stores')
            ->with('success','Store updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        Stores::find($id)->delete();
        return redirect('admin/stores')
            ->with('success','Store updated successfully');
    }
}
