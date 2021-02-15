<?php

namespace Modules\CMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\CMS\Entities\Cms;
use Modules\CMS\Entities\Permalink;
use Modules\CMS\Entities\Silder;
use Modules\CMS\Entities\CmsSection;
use Modules\CMS\Entities\PageSection;
use Modules\CMS\Entities\CmsBlock;
use Modules\CMS\Definitions\SectionType;



use Illuminate\Routing\Controller;

class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('cms::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('cms::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('cms::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('cms::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }


    public function page_listing()

    {
       $pages =  Cms::orderby('sort_order' , 'DESC')->get();
       $sliders = Silder::all();
       return view('cms::pages.page.page_listing')->with('pages' , $pages)->with('sliders' , $sliders);
    }

    public function create_page(Request $request)
    {
        $cms = new CMS;
        $cms->name = $request->input('page_name');
        $cms->description = $request->input('description');
        $cms->banner_style = $request->input('banner_slider'); 
        $cms->slider_id =  $request->input('slider');
        $cms->banner_title =  $request->input('banner_title');
        $cms->banner_link =  $request->input('banner_link');
        $cms->banner_description =  $request->input('banner_desc');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_desc');
        $cms->meta_keywords =  $request->input('meta_keywords');
        $cms->schema =  $request->input('schema');
        $cms->status =  1;
        $input = $request->all();
        if(isset($input['image'])) {
            $input['image'] = upload_cms_image($input);

            $cms->image = $input['image'];
        }
        $cms->save();

        $permalink = new Permalink;
        $permalink->slug = $request->input('permalink');
        $permalink->reference = $cms->id;
        $permalink->model = 'PAGE';
        $permalink->save();
        return back();
    }


    public function edit_page($id)
    {       
        $sliders = Silder::all();
        $page_data = Cms::with('permalink')->where('id' , $id )->first();
       // dd($page_data);
        return view('cms::pages.page.edit_page')->with('page_data' , $page_data)->with('sliders' , $sliders);
    }

public function update_page(Request $request , $id)
{ //dd('sad');
    $cms = Cms::where('id' , $id )->first();
    $cms->name = $request->input('page_name');
    $cms->description = $request->input('description');
    $cms->banner_style = $request->input('banner_slider'); 
    $cms->slider_id =  $request->input('slider');
    $cms->banner_title =  $request->input('banner_title');
    $cms->banner_link =  $request->input('banner_link');
    $cms->banner_description =  $request->input('banner_desc');
    $cms->meta_title =  $request->input('meta_title');
    $cms->meta_description =  $request->input('meta_desc');
    $cms->meta_keywords =  $request->input('meta_keywords');
    $cms->schema =  $request->input('schema');
    $cms->status =  1;
    $input = $request->all();
    if(isset($input['image'])) {
        $input['image'] = upload_cms_image($input);

        $cms->image = $input['image'];
    }


    $cms->save();

    $permalink = Permalink::firstOrCreate(['reference' => $request->id, 'model' => config('variable.CMS_MODEL')]);
    $permalink->model = 'PAGE';
    $permalink->slug = $request->input('permalink');
    $permalink->reference = $cms->id;
    $permalink->save();

    return redirect('admin/cms/page');
}

    public function delete_page($id)
    {
        $page = Cms::where('id' , $id )->first();
        if($page->delete())
            {
                return back();
            }
    }

    public function updateOrder(Request $request)
    {
        $pages = Cms::orderby('sort_order' , 'DESC')->get();

        foreach ($pages as $page) {
            $page->timestamps = false; // To disable update_at field updation
            $sort_id = $page->sort_order;

            foreach ($request->order as $order) {
                if ($order['id'] == $sort_id) {
                  //  dd($sort_id);
                    $page->update(['sort_order' => $order['position']]);
                }
            }
        }
        
        return response('Update Successfully.', 200);
    }


    public function Section_listing()

    {
        $section_types = SectionType::getTypes();
        $sections =  CmsSection::all();
       return view('cms::pages.section.section_listing')->with('sections' , $sections)->with('section_types' , $section_types);
    }

    public function page_section_listing($id)

    {
        $section_types = SectionType::getTypes();
        $page = Cms::with('sections')->where('id', $id)->where('status', 1)->first();
        $page_sections = $page ? $page->sections()->where('status', 1)->get() : null;

        $all_sections = CmsSection::all();
       return view('cms::pages.page.page_section_listing')->with('page_sections' , $page_sections)->with('section_types' , $section_types)->with('all_sections' , $all_sections)->with('page_id' , $id);
    }


    public function create_section(Request $request)
    {
        $cms_section = new CmsSection;
        $cms_section->user_id =  1;
        $cms_section->cms_id =  0;
        $cms_section->sections_template_id =  $request->input('template');
        $cms_section->title = $request->input('title');
        $cms_section->description = $request->input('description');
        $cms_section->view = $request->input('view');
        $cms_section->sub_heading =  $request->input('sub_heading');
        $cms_section->icon =  $request->input('icon');
        $cms_section->button_text =  $request->input('button_text');
        $cms_section->button_link =  $request->input('button_link');
        $cms_section->status =  1;
        $input = $request->all();
        if(isset($input['image'])) {
            $input['image'] = upload_cms_image($input);

            $cms_section->image = $input['image'];
        }
        $cms_section->save();
        return back();
    }


    public function assign_section(Request $request)
    {
        if($request->input('section_create') == 'Existing')
        {
        $assign_section = new PageSection;
        $assign_section->page_id =  $request->input('page_id');
        $assign_section->section_id =  $request->input('section');
        $assign_section->save();
        }
        if($request->input('section_create') == 'New')
        {
            $cms_section = new CmsSection;
            $cms_section->user_id =  1;
            $cms_section->cms_id =  0;
            $cms_section->sections_template_id =  $request->input('template');
            $cms_section->title = $request->input('title');
            $cms_section->description = $request->input('description');
            $cms_section->view = $request->input('view');
            $cms_section->sub_heading =  $request->input('sub_heading');
            $cms_section->icon =  $request->input('icon');
            $cms_section->button_text =  $request->input('button_text');
            $cms_section->button_link =  $request->input('button_link');
            $cms_section->status =  1;
            $cms_section->save();


            $assign_section = new PageSection;
            $assign_section->page_id =  $request->input('page_id');
            $assign_section->section_id =  $cms_section->id;
            $assign_section->save();

        }

        
        return back();
    }


    public function edit_section($id)
    {
        $section_data = CmsSection::where('id' , $id )->first();
        return view('cms::pages.section.edit_section')->with('section_data' , $section_data);
    }

    public function update_section(Request $request , $id)
    {
        //dd('das');
        $section = CmsSection::with('page')->where('id' , $id )->first();
        $section->title = $request->input('title');
        $section->description = $request->input('description');
        $section->view = $request->input('view');
        $section->sub_heading =  $request->input('sub_heading');
        $section->icon =  $request->input('icon');
        $section->button_text =  $request->input('button_text');
        $section->button_link =  $request->input('button_link');
        $section->status =  1;
        $input = $request->all();
        if(isset($input['image'])) {
            $input['image'] = upload_cms_image($input);

            $section->image = $input['image'];
        }
        //dd($section);
        $section->save();
 //dd($section->page->first()->id);
        return redirect('admin/cms/page/section/'.$section->page->first()->id);
    }


    public function delete_section($id)
    {
        $section = CmsSection::where('id' , $id )->first();
        if($section->delete())
            {
                return redirect('admin/cms/section');
            }
    }



    public function Sub_Section_listing($id)

    {
        //$section_types = SectionType::getTypes();
        $sub_sections =  CmsBlock::where('cms_section_id' , $id)->get();
       return view('cms::pages.sub_section.sub_section_listing')->with('sub_sections' , $sub_sections)->with('section_id' , $id);
    }


    public function create_sub_section(Request $request)
    {
        $cms_sub_section = new CmsBlock;
        $cms_sub_section->user_id =  1;
        $cms_sub_section->cms_section_id =  $request->input('section_id');
        $cms_sub_section->title = $request->input('title');
        $cms_sub_section->description = $request->input('description');
        $cms_sub_section->icon =  $request->input('icon');
        $cms_sub_section->button_text =  $request->input('button_text');
        $cms_sub_section->button_link =  $request->input('button_link');
        $cms_sub_section->status =  1;

        $cms_sub_section->save();
        return back();
    }

    public function edit_sub_section($id)
    {
        $subsection_data = CmsBlock::where('id' , $id )->first();
        return view('cms::pages.sub_section.edit_subsection')->with('subsection_data' , $subsection_data);
    }
    
    
    public function update_sub_section(Request $request , $id)
    {
        $sub_section = CmsBlock::where('id' , $id )->first();
        $sub_section->title = $request->input('title');
        $sub_section->description = $request->input('description');
        $sub_section->icon =  $request->input('icon');
        $sub_section->button_text =  $request->input('button_text');
        $sub_section->button_link =  $request->input('button_link');
        $sub_section->status =  1;
        $sub_section->save();

        return back();
    }


    public function delete_sub_section($id)
    {
        $subsection = CmsBlock::where('id' , $id )->first();
        if($subsection->delete())
            {
                return back();
            }
    }



}
