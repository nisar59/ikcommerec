<?php

namespace Modules\Brands\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Brands\Entities\Brands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use Modules\CMS\Entities\Permalink;

class BrandsController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->data['user'] = Brands:: orderBy('sort_order')->get();
        return view('brands::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('brands::backend.create');
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
            'slug' => 'required|unique:permalinks,slug',
            //  'description' => 'required',

        ]);

       $input = $request->all();
        $cms = new Brands();
        $cms->name = $request->input('name');
        $cms->slug = $request->input('slug');
        $cms->description = $request->input('description');
        $cms->short_description = $request->input('short_description');
        $cms->meta_title = $request->input('meta_title');
        $cms->meta_description = $request->input('meta_description');
        $cms->meta_keywords = $request->input('meta_keywords');
        $cms->meta_schema = $request->input('meta_schema');

        $cms->sort_order =  MaxSortorder('brands');
        //  $cms->store_type =  $request->input('store_type');
//
        $cms->status =  1;
        if(isset($input['image'])) {
            $input['image'] = upload_brand_image($input);

            $cms->image = $input['image'];
        }
        $cms->save();

        $permalink = new Permalink;
        $permalink->slug = $request->input('slug');
        $permalink->reference = $cms->id;
        $permalink->model = 'BRAND';
        $permalink->save();


        return redirect('admin/brands')
            ->with('success','Brand created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('brands::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['user'] = Brands::find($id);
        //  dd($this->data);
        return view('brands::backend.edit')->with('data', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $cms =Brands::find($id);
       // dd($cms->permalink);
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permalinks,slug'.($cms->permalink && $cms->permalink->id ? ','.$cms->permalink->id : ""),
//            'description' => 'required',

        ]);
        $input = $request->all();
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->short_description = $request->input('short_description');
        $cms->meta_title = $request->input('meta_title');
        $cms->meta_description = $request->input('meta_description');
        $cms->meta_keywords = $request->input('meta_keywords');
        $cms->meta_schema = $request->input('meta_schema');
        if(isset($input['image'])) {
            $input['image'] = upload_brand_image($input);

            $cms->image = $input['image'];
        }
        $cms->save();

        $permalink = Permalink::firstOrCreate(['reference' => $id, 'model' =>'BRAND']);
        $permalink->slug = $request->input('slug');
        $permalink->reference = $cms->id;
        $permalink->model = 'BRAND';
        $permalink->save();


        return redirect('admin/brands')
            ->with('success','Brand Updated successfully');
    }

    public function statusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Brands::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('admin/brands')
            ->with('success','Brand updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //$link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        Brands::find($id)->delete();
        return redirect('admin/brands')
            ->with('success','Brand updated successfully');
    }
}
