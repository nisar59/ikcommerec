<?php

namespace Modules\MediaLibrary\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MediaLibrary\Entities\File;
use Auth ;
use Image;
use File as file1;


class MediaLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('medialibrary::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('medialibrary::create');
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
        return view('medialibrary::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('medialibrary::edit');
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


    public function Library()
    {
        $files = File::all();
        return view('medialibrary::backend.library')->with('files' , $files);
    }

    public function SaveFile(Request $request)
    {
        if($request->file('file'))
        {
            $i = 0;
            $year = date('Y');
            $month = date('m');
            $image = $request->file('file');
            $fileNameWithExt = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $request->file('file')->getClientOriginalExtension();
             $check = File::where('title' , 'LIKE' ,  $fileName.'%')->count();
             //dd($check);
             if($check > 0)
             {
                 $i= $check;
                 $fileNameToStore = $fileName.'_'.$i.'.'.$fileExt;
                 $fileName = $fileName.'_'.$i;
             }
             else{
                $fileNameToStore = $fileName.'.'.$fileExt;
                $fileName = $fileName;
             }
            
            $media_thumb = 'media_thumb_'.$fileNameToStore;
            if($fileExt == 'jpg' || $fileExt == 'jpeg' || $fileExt == 'png' || $fileExt == 'webp' || $fileExt == 'svg' )
            {

                $folder = public_path('/assets/uploads/'.$year.'/'.$month.'/images/');
                if (!file1::exists($folder)) {
                    file1::makeDirectory($folder, 0775, true, true);
                }
                Image::make($image)->fit(150, 150)->save(public_path('/assets/uploads/'.$year.'/'.$month.'/images/'.$media_thumb));
                $path = $request->file('file')->move(public_path().'/assets/uploads/'.$year.'/'.$month.'/images' , $fileNameToStore);
                $url = url('public/assets/uploads/'.$year.'/'.$month.'/images/'. $fileNameToStore);
                
            }
            else
            {
                $folder = public_path('/assets/uploads/'.$year.'/'.$month.'/files/');
                if (!file1::exists($folder)) {
                    file1::makeDirectory($folder, 0775, true, true);
                }
                $path = $request->file('file')->move(public_path().'/assets/uploads/'.$year.'/'.$month.'/files' , $fileNameToStore);  
                $url = url('public/assets/uploads/'.$year.'/'.$month.'/files/'. $fileNameToStore);
                
            }

        }else
        {
            $fileName = "";
            $fileExt ="";
            $fileNameToStore = "";
            $path = "";
        }

        $file = new File;
        $file->title = $fileNameToStore;
        $file->extension = $fileExt;
        $file->alt_text = $fileName;
        $file->description = "";
        $file->uploaded_by = Auth::user()->id;
        $file->link = $url;
        $file->caption = "image caption";
        $file->save();

        $all_files = File::all();

        $image_html = "";
        
      
        if($all_files)
        {
        foreach($all_files as $file)
        {
            if($file->extension == 'jpg' || $file->extension == 'jpeg' || $file->extension == 'png' || $file->extension == 'gif' || $file->extension == 'svg'  )
            {
            $image_html .= ' <a class="float-left " onclick="modal(this)" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'.$file->id.'" href="#MyModal" title="'.$file->alt_text.'">
            <div class="img-responsive" style="margin:10px;  border: solid darkslategrey ;">
                <img src="'.$file->link.'" alt="'.$file->alt_text.'" width="120">
            </div>
        </a>   ';
            }
            else{
                $image_html .= '<a class="float-left " onclick="modal(this)" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'.$file->id.'" href="#MyModal" title="'.$file->alt_text.'">
                <div class="img-responsive" style="margin:10px;  border: solid darkslategrey ;">
                    <img src="'.url('assets/images/File.png').'" alt="'.$file->alt_text.'" width="120">
                </div>
            </a>  ';
            }
        }
    }

    $buttons_div ='
    <select class="form-control  select2" onchange="filteration()" style="width: 30%; display:inline-block;">
                            <option value="">Select</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="file">File</option>
                        </select>
    <button class="btn btn-primary" id="add_button" onclick="myFunction()">Add New </button>
    <button class="btn btn-warning " id="bulk_button" onclick="blurSelect()">Bulk Select </button>';


        $this->response['Result'] = "OK";
        $this->response['Record1'] = $image_html;
        $this->response['Record2'] = $buttons_div;
        // $this->response['Record3'] = $form_html;
    
        // Commit the transaction
        return json_encode($this->response);

       // return response()->json(['success'=>$fileNameToStore]);

    }


    public function modal(Request $request)
    {
        if ($request->isMethod('post')) {
            $year = date('Y');
            $month = date('m');
            $data = File::where('id' , $request->data_id)->first();

            if($data->extension == 'jpg' || $data->extension == 'jpeg' || $data->extension == 'png' || $data->extension == 'gif' || $data->extension == 'svg'  )
        {
           $image_html = ' <img src="'.$data->link.'" alt="'.$data->alt_text.'">';
        }
        else{
            $image_html = ' <img src="'.url('assets/images/File.png').'" alt="'.$data->alt_text.'">';
        }

$detail_html= '<p><h5 style="font-size:13px;">Title: </h5>'.$data->title.'</p>
<p><h5 style="font-size:13px;">File Type: </h5>'.$data->extension.'</p>
<p><h5 style="font-size:13px;">Uploaded on: </h5>'.$data->created_at.'</p>

';
            $form_html = ' <div class="form-group row">
            <div class="col-sm-4">
            <label for="example-text-input" class=" col-form-label">Alt. Text</label>
            </div>
            <div class="col-sm-8">
                <input class="form-control " onfocusout="updateonfocus()" type="text" value="'.$data->alt_text.'" id="alt" name= "alt">
            </div>
        </div>
        <div class="form-group row">
        <div class="col-sm-4">
            <label for="example-text-input" class=" col-form-label">Title</label>
            </div>
            <div class="col-sm-8">
                <input class="form-control focus" onfocusout="updateonfocus()" type="text" value="'.$data->title.'" id="title" name = "title">
            </div>
        </div>
        <input type=hidden name="hidden" id="hidden" value="'.$data->id.'">
        <div class="form-group row">
        <div class="col-sm-4">
            <label for="example-text-input" class="col-form-label">Caption</label>
            </div>
            <div class="col-sm-8">
                <input class="form-control " onfocusout="updateonfocus()" type="text" value="'.$data->caption.'" id="caption" name="caption">
            </div>
        </div>

        <div class="form-group row">
        <div class="col-sm-4">
        <label for="example-text-input" class="col-form-label">Description</label>
        </div>
        <div class="col-sm-8">
            <input class="form-control " onfocusout="updateonfocus()" type="text" value="'.$data->description.'" id="description" name="description">
        </div>
    </div>
        <div class="form-group row">
        <div class="col-sm-4">
            <label for="example-text-input" class=" col-form-label">Copy Link</label>
            </div>
            <div class="col-sm-8">
                <input class="form-control" type="text" value="'.$data->link.'" readonly id="link" name = "link">
            </div>
        </div>
        <hr>
        <a class="btn btn-danger" href="'.url('admin/medialibrary/delete/image/'.$data->id).'" > Delete </a>
        ';


            $this->response['Result'] = "OK";
            $this->response['Record1'] = $image_html;
            $this->response['Record2'] = $detail_html;
            $this->response['Record3'] = $form_html;
        
            // Commit the transaction
            return json_encode($this->response);
        
        }
        $this->response['Result'] = "ERROR";
        $this->response['Message'] = "Error";
        return json_encode($this->response);
    }


    public function UpdateImage(Request $request)
    {
        if ($request->isMethod('post')) {
           // dd($request->all());
          $data = File::find($request->data_id);
//dd($data);
          $data->title = $request->title;
          $data->alt_text = $request->alt;
          $data->caption = $request->caption;
          $data->description = $request->description;
          $year = date('Y');
          $month = date('m');
          $file_chk = File::where('id' , $request->data_id)->first();
         
          if(file_exists('public/assets/uploads/'.$year.'/'.$month.'/images/'.$file_chk->title))
          {
            if($file_chk->extension == 'jpg' || $file_chk->extension == 'jpeg' || $file_chk->extension == 'png' || $file_chk->extension == 'gif' || $file_chk->extension == 'svg'  )
            {
           // $media_thumb = 'media_thumb_'.$file_chk->title;
            file1::move(public_path('assets/uploads/'.$year.'/'.$month.'/images/'.$file_chk->title),public_path('assets/uploads/'.$year.'/'.$month.'/images/'.$request->title));
            file1::move(public_path('assets/uploads/'.$year.'/'.$month.'/images/media_thumb_'.$file_chk->title),public_path('assets/uploads/'.$year.'/'.$month.'/images/media_thumb_'.$request->title));
            }
            else
            {
                file1::move(public_path('assets/uploads/'.$year.'/'.$month.'/files/'.$file_chk->title),public_path('assets/uploads/'.$year.'/'.$month.'/files/'.$request->title));
            }

          }
        //   $year = date('Y');
        //   $month = date('m');
        //   $path = public_path('assets/uploads/'.$year.'/'.$month.'/images/'.$request->title);
        //   $files = file1::files($path);
      
        //   dd($files);


        $data->save();
       
        $year = date('Y');
        $month = date('m');
        $data_image = File::where('id' , $request->data_id)->first();
        if($data_image->extension == 'jpg' || $data_image->extension == 'jpeg' || $data_image->extension == 'png' || $data_image->extension == 'gif' || $data_image->extension == 'svg'  )
        {
       $image_html = ' <img src="'.$data_image->link.'" alt="'.$data_image->alt_text.'">';
        }
        else{
            $image_html = ' <img src="'.url('assets/images/File.png').'" alt="'.$data_image->alt_text.'">';
        }

$detail_html= '<br><p><h5 style="font-size:13px;">Title: </h5>'.$data_image->title.'</p>
<p><h5 style="font-size:13px;">File Type: </h5>'.$data_image->extension.'</p>
<p><h5 style="font-size:13px;">Uploaded on: </h5>'.$data->created_at.'</p>

';
        $form_html = ' <div class="form-group row">
        <div class="col-sm-4">
        <label for="example-text-input" class=" col-form-label">Alt. Text</label></div>
        <div class="col-sm-8">
            <input class="form-control " onfocusout="updateonfocus()" type="text" value="'.$data_image->alt_text.'" id="alt" name= "alt">
        </div>
    </div>
    <div class="form-group row">
    <div class="col-sm-4">
        <label for="example-text-input" class=" col-form-label">Title</label></div>
        <div class="col-sm-8">
            <input class="form-control " onfocusout="updateonfocus()" type="text" value="'.$data_image->title.'" id="title" name = "title">
        </div>
    </div>
    <input type=hidden name="hidden" id="hidden" value="'.$data_image->id.'">
    <div class="form-group row">
    <div class="col-sm-4">
        <label for="example-text-input" class=" col-form-label">Caption</label></div>
        <div class="col-sm-8">
            <input class="form-control " onfocusout="updateonfocus()" type="text" value="'.$data_image->caption.'" id="caption" name="caption">
        </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-4">
        <label for="example-text-input" class=" col-form-label">Description</label></div>
        <div class="col-sm-8">
            <input class="form-control " onfocusout="updateonfocus()" type="text" value="'.$data_image->description.'" id="description" name="description">
        </div>
    </div>

    <div class="form-group row">
    <div class="col-sm-4">
        <label for="example-text-input" class="col-form-label">Copy Link</label></div>
        <div class="col-sm-8">
            <input class="form-control" type="text" value="'.$data_image->link.'" readonly id="link" name = "link">
        </div>
    </div>
    <hr>
    <a class="btn btn-danger" href="'.url('admin/medialibrary/delete/image/'.$data_image->id).'" > Delete </a>
    ';


        $this->response['Result'] = "OK";
        $this->response['Record1'] = $image_html;
        $this->response['Record2'] = $detail_html;
        $this->response['Record3'] = $form_html;
    
        // Commit the transaction
        return json_encode($this->response);
    }


}

    public function DeleteImage($id)
    {
        $record = File::where('id' , $id)->first();
        $year = date('Y');
        $month = date('m');
        if($record->extension == 'jpg' || $record->extension == 'jpeg' || $record->extension == 'png' || $record->extension == 'gif' || $record->extension == 'svg'  )
        {
          
          $image =  public_path('assets/uploads/'.$year.'/'.$month.'/images/'.$record->title);
          $thumb_file =  public_path('assets/uploads/'.$year.'/'.$month.'/images/media_thumb_'.$record->title);
          $record->delete();
          file1::delete($image, $thumb_file);
          return redirect()->back();
        }
        else
        {
           
            $file =  public_path('assets/uploads/'.$year.'/'.$month.'/files/'.$record->title);
            file1::delete($file);
            $record->delete();
            return redirect()->back();
        }



    }


    public function bulkSelect(Request $request)
    {
        if ($request->isMethod('post')) {
            $year = date('Y');
            $month = date('m');
            $files = File::all();

            $image_html = "";
            $i=1;
            if($files)
            {
            foreach($files as $file)
            {
            if($file->extension == 'jpg' || $file->extension == 'jpeg' || $file->extension == 'png' || $file->extension == 'gif' || $file->extension == 'svg'  )
        {
           $image_html .= '
           <input type="checkbox" id="cb'.$i.'" name="cb[]" value="'.$file->id.'" />
             <label for="cb'.$i.'"> <img src="'.$file->link.'" alt="'.$file->alt_text.'" width="120"></label>';
        }
        else{
            $image_html .= ' <input type="checkbox" id="cb'.$i.'" name="cb[]" value="'.$file->id.'"  />
            <label for="cb'.$i.'"> <img src="'.url('assets/images/File.png').'" alt="'.$file->alt_text.'" width="120"></label>';
        }
    $i++;}
            }

            $buttons_div ='
            
            <button class="btn btn-danger" onclick = "Bulk_delete()" id="add_button" >Delete</button>
                           <button class="btn btn-warning " onclick="all_data()" id="bulk_button" >Cancel</button>';
          


            $this->response['Result'] = "OK";
            $this->response['Record1'] = $image_html;
            $this->response['Record2'] = $buttons_div;
            // $this->response['Record3'] = $form_html;
        
            // Commit the transaction
            return json_encode($this->response);
        
        }
        $this->response['Result'] = "ERROR";
        $this->response['Message'] = "Error";
        return json_encode($this->response);
    }


    public function DeleteBulk(Request $request)
    {
//dd($request->all());
if ($request->isMethod('post')) {
        $year = date('Y');
        $month = date('m');
        $array = explode('|' ,$request->ab );
        $count = (count($array)-2);

        for($i=0 ; $i < $count ; $i++)
        {
            $record = File::find($array[$i]);
            if($record->extension == 'jpg' || $record->extension == 'jpeg' || $record->extension == 'png' || $record->extension == 'gif' || $record->extension == 'svg'  )
        {
          
          $image =  public_path('assets/uploads/'.$year.'/'.$month.'/images/'.$record->title);
          $thumb_file =  public_path('assets/uploads/'.$year.'/'.$month.'/images/media_thumb_'.$record->title);
          $record->delete();
          file1::delete($image, $thumb_file);
         
        }
        else
        {
           
            $file =  public_path('assets/uploads/'.$year.'/'.$month.'/files/'.$record->title);
            file1::delete($file);
            $record->delete();
            
        }

        }

        $all_files = File::all();

        $image_html = "";
        $year = date('Y');
        $month = date('m');
      
        if($all_files)
        {
        foreach($all_files as $file)
        {
            if($file->extension == 'jpg' || $file->extension == 'jpeg' || $file->extension == 'png' || $file->extension == 'gif' || $file->extension == 'svg'  )
            {
            $image_html .= ' <a class="float-left " onclick="modal(this)" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'.$file->id.'" href="#MyModal" title="'.$file->alt_text.'">
            <div class="img-responsive" style="margin:10px;  border: solid darkslategrey ;">
                <img src="'.$file->link.'" alt="'.$file->alt_text.'" width="120">
            </div>
        </a>   ';
            }
            else{
                $image_html .= '<a class="float-left " onclick="modal(this)" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'.$file->id.'" href="#MyModal" title="'.$file->alt_text.'">
                <div class="img-responsive" style="margin:10px;  border: solid darkslategrey ;">
                    <img src="'.url('assets/images/File.png').'" alt="'.$file->alt_text.'" width="120">
                </div>
            </a>  ';
            }
        }
    }

    $buttons_div ='
    <select class="form-control  select2" onchange="filteration()" style="width: 30%; display:inline-block;">
                            <option value="">Select</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="file">File</option>
                        </select>
    <button class="btn btn-primary" id="add_button" onclick="myFunction()">Add New </button>
    <button class="btn btn-warning " id="bulk_button" onclick="blurSelect()">Bulk Select </button>';


        $this->response['Result'] = "OK";
        $this->response['Record1'] = $image_html;
        $this->response['Record2'] = $buttons_div;
        // $this->response['Record3'] = $form_html;
    
        // Commit the transaction
        return json_encode($this->response);
    }

    $this->response['Result'] = "ERROR";
    $this->response['Message'] = "Error";
    return json_encode($this->response);

    }


    public function MediaFilteration(Request $request)
    {
        if ($request->isMethod('post')) {

            if($request->input('filter') == "")
            {
              
                $filters = File::all();
            }
            elseif($request->input('filter') == "image")
            {
                $images=array("jpg", "png", "jpeg", "svg", "gif");
                $filters = File::whereIn('extension', $images)->get();
               
            }
           elseif($request->input('filter') == "video")
            {
                $video=array("mp4", "mkv", "avi", "mpeg", "webm");
                $filters = File::whereIn('extension', $video)->get();
            }
            else{
                $file=array("pdf", "csv", "docx", "txt");
                $filters = File::whereIn('extension', $file)->get();
            }
            $buttons_div ="";
            $image_html = "";
            $year = date('Y');
            $month = date('m');
foreach($filters as $filter)
{
    if($filter->extension == 'jpg' || $filter->extension == 'jpeg' || $filter->extension == 'png' || $filter->extension == 'gif' || $filter->extension == 'svg'  )
    {
    $image_html .= ' <a class="float-left " onclick="modal(this)" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'.$filter->id.'" href="#MyModal" title="'.$filter->alt_text.'">
    <div class="img-responsive" style="margin:10px;  border: solid darkslategrey ;" >
        <img src="'.$filter->link.'" alt="'.$filter->alt_text.'" width="120">
    </div>
</a>   ';
    }
    else{
        $image_html .= '<a class="float-left " onclick="modal(this)" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'.$filter->id.'" href="#MyModal" title="'.$filter->alt_text.'">
        <div class="img-responsive" style="margin:10px;  border: solid darkslategrey ;">
            <img src="'.url('assets/images/File.png').'" alt="'.$filter->alt_text.'" width="120">
        </div>
    </a>  ';
    }
}

$buttons_div .='
<select class="form-control  select2" id="filter" onchange="filteration()" style="width: 30%; display:inline-block;">
';
if($request->input('filter') == "")
{
    $buttons_div .= '
    <option value="" selected>Select</option>
    <option value="image" >Image</option>
    <option value="video" >Video</option>
    <option value="file" >File</option>';
}
if($request->input('filter') == "image"){
    $buttons_div .= '
    <option value="">Select</option>
    <option value="image" selected>Image</option>
    <option value="video" >Video</option>
    <option value="file" >File</option>';
}
if($request->input('filter') == "video"){
    $buttons_div .= ' <option value="">Select</option>
    <option value="image" >Image</option>
    <option value="video" selected>Video</option>
    <option value="file" >File</option>';
}
if($request->input('filter') == "file"){
    $buttons_div .= '  <option value="">Select</option>
    <option value="image" >Image</option>
    <option value="video" >Video</option>
    <option value="file" selected>File</option>';
}
$buttons_div .= '</select>

<button class="btn btn-primary" id="add_button" onclick="myFunction()">Add New </button>
<button class="btn btn-warning " id="bulk_button" onclick="blurSelect()">Bulk Select </button>';

$this->response['Result'] = "OK";
$this->response['Record1'] = $image_html;
$this->response['Record2'] = $buttons_div;
// $this->response['Record3'] = $form_html;

// Commit the transaction
return json_encode($this->response);

        }
        $this->response['Result'] = "ERROR";
        $this->response['Message'] = "Error";
        return json_encode($this->response);
    }



    public function all_data(Request $request)
    {
        if ($request->isMethod('post')) {
            $year = date('Y');
            $month = date('m');
            $files = File::all();

            $image_html = "";
            $i=1;
            if($files)
            {
            foreach($files as $file)
            {
            if($file->extension == 'jpg' || $file->extension == 'jpeg' || $file->extension == 'png' || $file->extension == 'gif' || $file->extension == 'svg'  )
        {
           $image_html .= '
           <a class="float-left " onclick="modal(this)" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'.$file->id.'" href="#MyModal" title="'.$file->alt_text.'">
         
    <div class="img-responsive" style="margin:10px;  border: solid darkslategrey ;">
        <img src="'.$file->link.'" alt="'.$file->alt_text.'" width="120">
    </div>
</a>   ';
        }
        else{
            $image_html .= ' <a class="float-left " onclick="modal(this)" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="'.$file->id.'" href="#MyModal" title="'.$file->alt_text.'">
            <div class="img-responsive" style="margin:10px;  border: solid darkslategrey ;">
                <img src="'.url('assets/images/File.png').'" alt="'.$file->alt_text.'" width="120">
            </div>
        </a>  ';
        }
   }
            }

            $buttons_div ='
            <select class="form-control  select2" onchange="filteration()" style="width: 30%; display:inline-block;">
                            <option value="">Select</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="file">File</option>
                        </select>
    <button class="btn btn-primary" id="add_button" onclick="myFunction()">Add New </button>
    <button class="btn btn-warning " id="bulk_button" onclick="blurSelect()">Bulk Select </button>';
          


            $this->response['Result'] = "OK";
            $this->response['Record1'] = $image_html;
            $this->response['Record2'] = $buttons_div;
            // $this->response['Record3'] = $form_html;
        
            // Commit the transaction
            return json_encode($this->response);
        
        }
        $this->response['Result'] = "ERROR";
        $this->response['Message'] = "Error";
        return json_encode($this->response);
    }

}
