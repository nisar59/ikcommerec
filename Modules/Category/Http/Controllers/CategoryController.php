<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use DB;
use Hash;
use Modules\Category\Entities\Category;
use Modules\CMS\Entities\Permalink;

class CategoryController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function subCats($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }

        $this->data['user'] = Category::with('childs')->find($id);
       //dd($this->data['user']);
        return view('category::backend.subindex')->with('data', $this->data);
    }
    public function subcatCreate($id)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['user'] = Category::with('childs')->find($id);
        return view('category::backend.subcatcreate')->with('data',$this->data);
    }
    public function subcatStore(Request $request,$id)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $input = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permalinks,slug',
            'description' => 'required',

        ]);
        $cms = new Category();
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->slug = $request->input('slug');

        $cms->short_description =  $request->input('short_description');
        if(isset($input['image_id'])) {
            $input['image_id'] = upload_category_image($input);

            $cms->image_id = $input['image_id'];
        }
        $cms->parent_id =  $id;

        $cms->sort_order =  $request->input('sort_order');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_description');
        $cms->meta_keywords =  $request->input('meta_keywords');
        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();

        $permalink = new Permalink;
        $permalink->slug = $request->input('slug');
        $permalink->reference = $cms->id;
        $permalink->model = 'CATEGORY';
        $permalink->save();
        return redirect('admin/categories/subcats/'.$id)
            ->with('success','Category created successfully');

    }
    public function subcatEdit($id)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['user'] = Category::find($id);
        $this->data['parent'] = Category::find($this->data['user']->parent_id);
        //  dd($this->data);
        return view('category::backend.subcatedit')->with('data', $this->data);
    }

    public function subcatUpdate(Request $request, $id)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $input = $request->all();
        $cms =Category::find($id);
        // dd($cms->permalink);
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permalinks,slug'.($cms->permalink && $cms->permalink->id ? ','.$cms->permalink->id : ""),
            'description' => 'required',

        ]);

        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->slug = $request->input('slug');

        $cms->short_description =  $request->input('short_description');
        if(isset($input['image_id'])) {
            $input['image_id'] = upload_category_image($input);

            $cms->image_id = $input['image_id'];
        }
        $cms->sort_order =  $request->input('sort_order');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_description');
        $cms->meta_keywords =  $request->input('meta_keywords');
        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();

        $permalink = Permalink::firstOrCreate(['reference' => $id, 'model' =>'CATEGORY']);
        $permalink->slug = $request->input('slug');
        $permalink->reference = $cms->id;
        $permalink->model = 'CATEGORY';
        $permalink->save();
        return redirect('admin/categories/subcats/'.$cms->parent_id)
            ->with('success','Category Updated successfully');

    }
    public function subcatStatusUpdate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = Category::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Category updated successfully');
    }
    public function subcatDestroy($id)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        Category::find($id)->delete();
        return redirect()->back()
            ->with('success','Category updated successfully');
    }

    public function index()
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['user'] = Category::where('parent_id',0)->orderBy('sort_order','DESC')->get();
        return view('category::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        return view('category::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $input = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permalinks,slug',
            'description' => 'required',

        ]);
        $cms = new Category();
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->slug = $request->input('slug');

        $cms->short_description =  $request->input('short_description');
        if(isset($input['image_id'])) {
            $input['image_id'] = upload_category_image($input);

            $cms->image_id = $input['image_id'];
        }
        //$cms->image_id =  $request->input('image_id');
        $cms->sort_order =  $request->input('sort_order');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_description');
        $cms->meta_keywords =  $request->input('meta_keywords');
       // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();

        $permalink = new Permalink;
        $permalink->slug = $request->input('slug');
        $permalink->reference = $cms->id;
        $permalink->model = 'CATEGORY';
        $permalink->save();
        return redirect('admin/categories')
            ->with('success','Category created successfully');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $this->data['user'] = Category::find($id);
      //  dd($this->data);
        return view('category::backend.edit')->with('data', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $input = $request->all();
        $cms =Category::find($id);
       // dd($cms->permalink);
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permalinks,slug'.($cms->permalink && $cms->permalink->id ? ','.$cms->permalink->id : ""),
            'description' => 'required',

        ]);

        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->slug = $request->input('slug');

        $cms->short_description =  $request->input('short_description');
        if(isset($input['image_id'])) {
            $input['image_id'] = upload_category_image($input);

            $cms->image_id = $input['image_id'];
        }
        $cms->sort_order =  $request->input('sort_order');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_description');
        $cms->meta_keywords =  $request->input('meta_keywords');
        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();

        $permalink = Permalink::firstOrCreate(['reference' => $id, 'model' =>'CATEGORY']);
        $permalink->slug = $request->input('slug');
        $permalink->reference = $cms->id;
        $permalink->model = 'CATEGORY';
        $permalink->save();
        return redirect('admin/categories')
            ->with('success','Category Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function statusUpdate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = Category::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('admin/categories')
            ->with('success','Category updated successfully');
    }

    public function featuredUpdate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = Category::find($id);
        if($user->featured ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->featured =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    { $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        Category::find($id)->delete();
        return redirect('admin/categories')
            ->with('success','Category updated successfully');
    }

}
