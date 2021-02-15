@extends('layouts.master')

@section('css')
        <!-- datatables css -->
        <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

                        <!-- start page title -->
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="font-size-18">Sections</h4>
                                    
                                </div>
                                <div class="row" style="padding: 0 15px;">
                                    <div class="col-sm-10"></div>
                                    <div class="page-title-box col-sm-1" style="text-align: right;">
                                    <button  class="btn btn-primary" id="show" onclick="show()"> Add Section </button>     
                                    <button  class="btn btn-primary" id="hide" onclick="show()" style="display: none;"> Hide Form </button>      
                                </div>
                                <div class="page-title-box col-sm-1" style="text-align: right;">
                                    <a href="{{ url()->previous() }}" > <button  class="btn btn-primary"  > Back </button>  </a>     
                                    </div>
                                </div>

                                </div>
                                
                                </div>
                                





                                <form action="{{url('admin/cms/assign_section')}}" method="POST" style="display: none" id="show_form" enctype="multipart/form-data" >
                               
                                   
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">Existing/New</label>
                                            <div class="col-md-6">
                                                <select class="form-control" name="section_create" id="section_create" onchange="show_form()">
                                                    <option value="">Select</option>
                                                    {{--<option value="Existing">Existing Section</option>--}}
                                                    <option value="New">New Section</option>
                                                </select>
                                            </div>
                                        </div>
                                
                                  <div class="form-group row" style="display:none" id="show_exist_form">
                                    <input type="hidden" value="{{$page_id}}" id="page_id" name="page_id">
                                    <div class="col-sm-2">        
                                    <label class="control-label">Single Select</label>
                                    </div>
                                    <div class="col-sm-6">
                                              <select class="form-control select2 " name="section" id="section" style="width: 100%;">
                                                    <option>Select</option>
                                                    @if($all_sections)
                                                    @foreach($all_sections as  $all_section)
                                                <option value="{{$all_section->id}}"> {{$all_section->title}} </option>
                                                   @endforeach
                                                   @endif
                                                </select>
                                    </div>
                                    </div>
                                    <input type="submit" value="Submit" name="submit" class="btn btn-success">
                               
                                            </div>
                                        
                                
                                

                                <div class="col-sm-12" style="display:none" id="show_new_form" >
                                 
                                        @csrf
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="title" name="title">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Sub Heading</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="sub_heading" name="sub_heading">
                                                </div>
                                            </div>
    
                                            {{--<div id="slider" >--}}
                                                {{--<div class="form-group row">--}}
                                                {{--<label class="col-sm-2 col-form-label">Template</label>--}}
                                                {{--<div class="col-sm-6">--}}
                                                {{--<select class="form-control" name="template" id="template" >--}}
                                                    {{--<option value=""> Select </option>--}}
                                                    {{--@if($section_types)--}}
                                                    {{--@foreach($section_types as $key => $section_type)--}}
                                                {{--<option value="{{$key}}"> {{$section_type}} </option>--}}
                                                   {{--@endforeach--}}
                                                   {{--@endif--}}
                                                {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
    

                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">View</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="view" name="view">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Icon</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="icon" name="icon">
                                                </div>
                                            </div>

                                                
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-6">
                                                    <textarea id="elm1" name="description"></textarea>
                                                </div>
                                            </div>
    
                                             <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label"> Image</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="file" id="example-text-input" name="image">
                                                </div>
                                            </div>
    
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Button Text</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="button_text" name="button_text">
                                                </div>
                                            </div>
    
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Button Link</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="button_link" name="button_link">
                                                </div>
                                            </div>
    
                                        <input type="hidden" name="page_id" id="page_id" value="{{$page_id}}">

                                            <input type="submit" value="Submit" name="submit" class="btn btn-success">
                                       
                                       
                                    </div>
                                </form>

                        <!-- end page title -->

                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-striped ">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>View</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                                @if($page_sections)
                                                @foreach($page_sections as $page_section)
                                            <tr>
                                            <td>{{$page_section->title}}</td>
                                            <td>{{$page_section->view}}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                                    <a href="{{url('admin/cms/subsection/'.$page_section->id)}}">   <button type="button" class="btn btn-secondary">Sub Section</button> </a>
                                                    <a href="{{url('admin/cms/edit_section/'.$page_section->id)}}" >  <button type="button" class="btn btn-secondary"><i class="fas fa-edit"></i></button> </a>
                                                <a href="{{url('admin/cms/delete_section/'.$page_section->id)}}">    <button type="button" class="btn btn-secondary"><i class="far fa-trash-alt"></i></button> </a>
                                                </div>
                                            </td>
                                            </tr>
                                           @endforeach
                                           @endif
                                           
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

@endsection

@section('script')

        <!-- Plugins js -->
        <script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>

        <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
        <!--tinymce js-->
        <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>

        <script>
            function show_form()
            {
                var banner_style = document.getElementById("section_create").value;
                var existing_form = document.getElementById("show_exist_form");
                var new_form = document.getElementById("show_new_form");
                

                if(banner_style == 'Existing' )
                {
                    existing_form.style.display = "flex";
                    new_form.style.display = "none";
                    
                }
                if(banner_style == 'New' )
                {
                    existing_form.style.display = "none";
                    new_form.style.display = "block";
                   
                }
                if(banner_style == '' )
                {
                    existing_form.style.display = "none";
                    new_form.style.display = "none";
                   
                }
            }

            function show()
            {
                var x = document.getElementById("show_form");
                var y = document.getElementById("show");
                var z = document.getElementById("hide");

                if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
                z.style.display = "block";
                }
                else if (x.style.display === "block"){
                    x.style.display = "none";
                y.style.display = "block";
                z.style.display = "none";
                }
            }


        </script>


@endsection