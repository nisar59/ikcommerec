<?php

namespace Modules\Variations\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Variations\Entities\VariationValues;
use Modules\Variations\Entities\Variation;
class VariationValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        $this->data['vari']=Variation::where('id',$id)->first();;
        $this->data['varivalue']=VariationValues::where('variation_id',$id)->get();
        return view('variations::values.index')->withData($this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id)
    {
        $varition=Variation::where('id',$id)->first();
        return view('variations::.values.create')->with('data',$varition);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       
        $variation=new VariationValues;
        $variation->value=$request->input('value');
        $variation->variation_id=$request->input('id');
        $variation->save();
         return redirect('admin/variations/values/'.$request->input('id'))->with('success', 'Attribute Value is Inserted Successfully');
    
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
        $varition=VariationValues::where('id',$id)->first();
        return view('variations::values.edit')->with('data', $varition);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $variation_id=$request->input('variation_id');
      $variation=VariationValues::find($id);
       $variation->value=$request->input('value');
       $variation->save();
        return redirect('admin/variations/values/'.$variation_id)->with('success', 'Attribute Value is Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        $id=$request->input('id');
       VariationValues::find($id)->delete();
        return redirect('admin/variations/values/'.$id)
            ->with('success','Attribute Value deleted successfully');
    }
}
