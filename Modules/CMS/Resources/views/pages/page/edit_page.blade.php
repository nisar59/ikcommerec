@extends('layouts.master')

@section('css')
        <!-- datatables css -->
        <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
         <link href="{{ URL::asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

                        <!-- start page title -->
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="font-size-18">Edit Page</h4>
                                    
                                </div>

                                

                                <div class="col-sm-12"  >
                                <form action="{{url('admin/cms/update_page/'.$page_data->id)}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="page_name" name="page_name" value="{{$page_data->name}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Permalink</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="permalink" name="permalink" value="{{$page_data->permalink['slug']}}">
                                            </div>
                                        </div>

                                        {{--<div class="form-group row">--}}
                                            {{--<label class="col-sm-2 col-form-label">Banner</label>--}}
                                            {{--<div class="col-sm-6">--}}
                                                {{--<select class="form-control" name="banner_slider" id="banner_slider" onchange="banner()">--}}
                                                    {{--<option value="No Banner/Slider" {{ $page_data->banner_style == "No Banner/Slider" ? 'selected="selected"' : '' }}>No Banner/Slider</option>--}}
                                                    {{--<option value="Banner" {{ $page_data->banner_style == "Banner" ? 'selected="selected"' : '' }}>Banner</option>--}}
                                                    {{--<option value="Slider" {{ $page_data->banner_style == "Slider" ? 'selected="selected"' : '' }}>Slider</option>--}}
                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                       {{----}}
                                        <div id="slider" style="display: none">
                                            <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Slider</label>
                                            <div class="col-sm-6">
                                            <select class="form-control" name="slider" id="slider" >
                                                @if($sliders)
                                                @foreach($sliders as $slider)
                                            <option value="{{$slider->id}}" {{ $page_data->slider_id == $slider->id ? 'selected="selected"' : '' }}> {{$slider->title}} </option>
                                               @endforeach
                                               @endif
                                            </select>
                                            </div>
                                        </div>
                                        </div>



                                        <div class="form-group row" id="banner_title" >
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Banner Title</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="banner_title" name="banner_title" value="{{$page_data->banner_title}}">
                                            </div>
                                        </div>

                                        <div class="form-group row" id="banner_link">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Banner Link</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="banner_link" name="banner_link" value="{{$page_data->banner_link}}">
                                            </div>
                                        </div>

                                        <div class="form-group row" id="banner_desc" >
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Banner Description</label>
                                            <div class="col-sm-10">
                                                <textarea id="elm1" name="banner_desc">{!! $page_data->banner_description !!}</textarea>
                                            </div>
                                        </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            @if(!empty($page_data->image))
                                                <img src="{{url('public/uploads/cms/'.$page_data->image)}}"  width="150" />
                                                <br><br><br>
                                            @endif

                                            <strong>Banner:</strong>
                                            {!! Form::file('image', null, array('placeholder' => 'Upload Product Image','class' => 'form-control filestyle')) !!}
                                        </div>
                                    </div>

                                        {{--<div class="form-group row">--}}
                                            {{--<label for="example-text-input" class="col-sm-2 col-form-label">Description</label>--}}
                                            {{--<div class="col-sm-6">--}}
                                                {{--<textarea id="elm1" class="form-control" name="description">{!! $page_data->description !!}</textarea>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{-- <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Banner Image</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="file" id="example-text-input" name="banner_image">
                                            </div>
                                        </div> --}}

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Meta Title</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="meta_title" name="meta_title" value="{{$page_data->meta_title}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Meta Description</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="meta_desc" name="meta_desc" value="{{$page_data->meta_description}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Meta Keywords</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="meta_keywords" name="meta_keywords" value="{{$page_data->meta_keywords}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Schema</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="schema" name="schema" value="{{$page_data->schema}}">
                                            </div>
                                        </div>

                                        <input type="submit" value="Submit" name="submit" class="btn btn-success">
                                    </form>
                                
                                </div>

                               <div style="margin: 20px;"> </div>
                          

@endsection

@section('script')

        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

        <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
        <!--tinymce js-->
        <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

     <script>


window.onload = function() {
    var banner_style = document.getElementById("banner_slider").value;
            var banner = document.getElementById("banner");
            var slider = document.getElementById("slider");
            // var bann_desc = document.getElementById("banner_desc");
            // var bann_link = document.getElementById("banner_link");

            if(banner_style == 'Banner' )
            {
                banner.style.display = "block";
                slider.style.display = "none";
                // bann_desc.style.display = "block";
                // bann_link.style.display = "block";
            }
            if(banner_style == 'Slider' )
            {
                banner.style.display = "none";
                slider.style.display = "block";
                // bann_desc.style.display = "none";
                // bann_link.style.display = "none";
            }
            if(banner_style == 'No Banner/Slider' )
            {
                banner.style.display = "none";
                slider.style.display = "none";
                // bann_desc.style.display = "none";
                // bann_link.style.display = "none";
            }};

</script>
@endsection