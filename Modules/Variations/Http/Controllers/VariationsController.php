<?php

namespace Modules\Variations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Variations\Entities\Variation;
use Modules\Variations\Entities\VariationValues;
use DB;
class VariationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $varition=Variation::all();
        return view('variations::backend.index')->with('data', $varition);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('variations::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $name=$request->input('name');

        $existing=Variation::where('name',$request->input('name'))->get();
        if($existing->count()>0)
        {
              return redirect('admin/variations')->with('error', 'Attribute Already Inserted');
        }
        else{
    DB::connection('mysql')->statement('ALTER TABLE producs_warehouse_stocks ADD '.$name.' text   
   NULL AFTER updated_at');
        $variation=new Variation;
        $variation->name= $name;
        $variation->save();
        return redirect('admin/variations')->with('success', 'Attribute is Inserted Successfully');
    }  
        }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('variations::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        $varition=Variation::where('id',$id)->first();
        return view('variations::backend.edit')->with('data', $varition);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
       $variation=Variation::find($id);
       $variation->name=$request->input('name');
       $variation->save();
        return redirect('admin/variations')->with('success', 'Attribute is Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
         $name=$request->input('name');
         DB::connection('mysql')->statement('ALTER TABLE producs_warehouse_stocks DROP '.$name.'');
                VariationValues::where('variation_id',$id)->delete();
               Variation::find($id)->delete();
        return redirect('admin/variations')
            ->with('success','Attribute Value Deleted successfully');
    }
}
