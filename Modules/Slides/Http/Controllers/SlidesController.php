<?php

namespace Modules\Slides\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Slides\Entities\Sliders;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use Modules\CMS\Entities\Permalink;

class SlidesController extends Controller
{  use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->data['user'] = Sliders:: orderBy('sort_order')->get();
        return view('slides::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('slides::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
          //  'slug' => 'required|unique:permalinks,slug',
            //  'description' => 'required',

        ]);

        // dd($request->all());
        $input = $request->all();
        $cms = new Sliders();
        $cms->title = $request->input('title');

        $cms->description = $request->input('description');

        $cms->ex_url = $request->input('ex_url');
        $cms->user_id = auth()->user()->id;

        $cms->sort_order =  MaxSortorder('sliders');
        //  $cms->store_type =  $request->input('store_type');
//
        $cms->status =  1;
        if(isset($input['image'])) {
            $input['image'] = upload_banner_image($input);

            $cms->image = $input['image'];
        }

        $cms->save();





        return redirect('admin/slides')
            ->with('success','Banner created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('slides::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['user'] = Sliders::find($id);
        //  dd($this->data);
        return view('slides::backend.edit')->with('data', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $cms =Sliders::find($id);
        // dd($cms->permalink);
        $input = $request->all();
        $this->validate($request, [
            'title' => 'required',
           // 'slug' => 'required|unique:permalinks,slug'.($cms->permalink && $cms->permalink->id ? ','.$cms->permalink->id : ""),
//            'description' => 'required',

        ]);
        $cms->title = $request->input('title');
         $cms->description = $request->input('description');

        $cms->ex_url = $request->input('ex_url');
        if(isset($input['image'])) {
            $input['image'] = upload_banner_image($input);

            $cms->image = $input['image'];
        }

        $cms->save();


        return redirect('admin/slides')
            ->with('success','Banner Updated successfully');
    }
    public function statusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Sliders::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Brand updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Sliders::find($id)->delete();
        return redirect()->back()
            ->with('success','Banner updated successfully');
    }
}
