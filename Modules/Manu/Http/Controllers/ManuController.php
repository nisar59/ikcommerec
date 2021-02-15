<?php

namespace Modules\Manu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use DB;
use Hash;
use Modules\Manu\Entities\Menu;
use Modules\Manu\Entities\MenuItems;

class ManuController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->data['user'] = Menu::get();
        return view('manu::backend.index')->with('data',$this->data);
    }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('manu::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $this->validate($request, [
            'title' => 'required',
            'code' => 'required',
          //  'description' => 'required',

        ]);
        $cms = new Menu();
        $cms->title = $request->input('name');
        $cms->code = $request->input('code');

        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();


        return redirect('admin/menu')
            ->with('success','Menu created successfully');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('manu::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit()
    {dd('asd');
        $this->data['user'] = Menu::find($id);
        return view('manu::backend.edit')->with('data',$this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $cms = Menu::find($id);
        // dd($cms->permalink);
        $this->validate($request, [
            'title' => 'required',
            'code' => 'required',


        ]);

        $cms->title = $request->input('title');
        $cms->code = $request->input('code');

        $cms->save();


        return redirect('admin/menu')
            ->with('success','Menu Updated successfully');
    }

    public function statusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Menu::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('admin/menu')
            ->with('success','Menu updated successfully');
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
        Menu::find($id)->delete();
        return redirect('admin/menu')
            ->with('success','Menu updated successfully');
    }

    public function itemsIndex($id){

        $this->data['user'] = Menu::with('items')->find($id);
        // dd($this->data['user']->items()->count());
        $this->data['items'] = $this->data['user']->items;
        return view('manu::backend.items')->with('data',$this->data);
    }

    public function ItemsCreate($id)
    {
        $this->data['user'] = Menu::with('items')->find($id);
        $this->data['menutypes'] = [
            'custom_link'=>'Custom Link',
            'page'=>'Page',
          //  'blog_category'=>'Blog Category',
            'product_category'=>'Category',
            'brand'=>'Brand',

        ];
        $this->data['target'] = ['_self'=>'Self','_blank'=>'Blank'];
        return view('manu::backend.itemcreate')->with('data',$this->data);
    }

    public function getItemdData(Request $request, $type) {
        if (!$request->ajax()) {
            $response = array('Good' => false, 'Message' => 'Invalid Request');
            return \Response::json($response);
        }
       // dd($type);
        $options = null;
        if ($type == 'page') {
            $options = \Modules\CMS\Entities\Cms::where('status', 1)->orderBy('sort_order', 'ASC')->pluck('name', 'id');
        } elseif ($type == 'blog_category') {
            $options = \Modules\Category\Entities\Category::where('status', 1)->orderBy('sort_order', 'ASC')->pluck('title', 'id');
        } elseif ($type == 'product_category') {
            //dd('asd');
            $options = \Modules\Category\Entities\Category::where('status', 1)->orderBy('sort_order', 'ASC')->pluck('name', 'id');
        }elseif ($type == 'brand') {
            $options = \Modules\Brands\Entities\Brands::where('status', 1)->orderBy('sort_order', 'ASC')->pluck('name', 'id');
        }
        elseif ($type == 'color') {
            $options = $this->getColorList();
        }elseif ($type == 'size') {
            $options = $this->getSizeList();
        }elseif ($type == 'style') {
            $options = $this->getStyleList();
        }elseif ($type == 'shape') {
            $options = $this->getShapeList();
        }elseif ($type == 'material') {
            $options = $this->getMaterialList();
        }elseif ($type == 'type') {
            $options = $this->getTypeList();
        }elseif ($type == 'pile') {
            $options = $this->getPileList();
        }

        return view('manu::backend.page-category-list')->with(array(
            'options' => $options,
            'type' => $type,
        ));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function itemsStore(Request $request,$id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }

        if ($request->isMethod('post')) {
           // $validator = $this->validateMenuItem($request);
            $this->validate($request, [
                'title' => 'bail|required',
                'type' => 'bail|required',
                //'url' => $request->type == 'custom_link' ? 'bail|required' : '',
              //  'values' => $request->type != 'custom_link' ? 'bail|required' : '',

            ]);

           // dd($request->all());
                /*Insert Menu Item*/
                $display_order = MenuItems::max('sort_order');
                $record = new MenuItems();
                $record->user_id = auth()->user()->id;
                $record->menu_type = $request->menu_type;
                $record->menu_id = $id;

                $record->m_title = $request->m_title;
                $record->icon = $request->icon;
                $record->short_desc = $request->short_desc;
                $record->link = $request->link;
                $record->image = $request->image;
                $record->tagline = $request->tagline;

                $record->parent_id = isset($request->menu_item_id) ? $request->menu_item_id : null;
                $record->cms_id = $request->type == 'page' ? $request->values : null;
                $record->category_id = $request->type == 'category' ? $request->values : null;
                $record->brand_id = $request->type == 'brand' ? $request->values : null;
                //  $record->cc_id = $request->type == 'client_category' ? $request->values : null;

                $record->title = $request->title;
                $record->type = $request->type;
                $record->url = isset($request->url)?$request->url:'#';
                $record->target = $request->target;
                $record->status = 1;
                $record->sort_order = ($display_order ? $display_order + 1 : 1);
                $record->save();
                $this->response['Result'] = "OK";
                $this->response['Record'] = $record;
               // return json_encode($this->response);

        }


        return redirect('admin/menu/items/'.$id)
            ->with('success','SubMenu created successfully');

    }


    public function itemsStatusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = MenuItems::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','SubMenu updated successfully');
    }

    public function itemsDestroy($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        MenuItems::find($id)->delete();
        return redirect()->back()
            ->with('success','Menu updated successfully');
    }
    public function itemsEdit($id)
    {
        $this->data['user'] = MenuItems::find($id);
       // dd( $this->data['user']->type );
        $options = null;
        if ($this->data['user']->type == 'page') {
            $options = \Modules\CMS\Entities\Cms::where('status', 1)->orderBy('sort_order', 'ASC')->pluck('name', 'id');
        } elseif ($this->data['user']->type == 'blog_category') {
            $options = \Modules\Category\Entities\Category::where('status', 1)->orderBy('sort_order', 'ASC')->pluck('title', 'id');
        } elseif ($this->data['user']->type == 'product_category') {
            //dd('asd');
            $options = \Modules\Category\Entities\Category::where('status', 1)->orderBy('sort_order', 'ASC')->pluck('name', 'id');
        }elseif ($this->data['user']->type == 'brand') {
            $options = \Modules\Brands\Entities\Brands::where('status', 1)->orderBy('sort_order', 'ASC')->pluck('name', 'id');
        }
        $this->data['menutypes'] = [
        'custom_link'=>'Custom Link',
        'page'=>'Page',
        //  'blog_category'=>'Blog Category',
        'product_category'=>'Category',
        'brand'=>'Brand',

    ]; $this->data['target'] = ['_self'=>'Self','_blank'=>'Blank'];

        return view('manu::backend.itemsedit')->with('data',$this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function itemsUpdate(Request $request, $id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $record = MenuItems::find($id);
        // dd($cms->permalink);
        $this->validate($request, [
            'title' => 'required',
          //  'code' => 'required',


        ]);

        $record->menu_type = $request->menu_type;
        $record->menu_id = $id;

        $record->m_title = $request->m_title;
        $record->icon = $request->icon;
        $record->short_desc = $request->short_desc;
        $record->link = $request->link;
        $record->image = $request->image;
        $record->tagline = $request->tagline;

        $record->parent_id = isset($request->menu_item_id) ? $request->menu_item_id : null;
        $record->cms_id = $request->type == 'page' ? $request->values : null;
        $record->category_id = $request->type == 'category' ? $request->values : null;
       // $record->brand_id = $request->brand_id == 'brand' ? $request->brand_id : null;
        //  $record->cc_id = $request->type == 'client_category' ? $request->values : null;

        $record->title = $request->title;
        $record->type = $request->type;
        $record->url = $request->url;
        $record->target = $request->target;
        $record->status = 1;
       // $record->sort_order = ($display_order ? $display_order + 1 : 1);
        $record->save();


        return redirect('admin/menu')
            ->with('success','Menu Updated successfully');
    }


}
