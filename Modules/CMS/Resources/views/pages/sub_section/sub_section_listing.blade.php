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
                                    <h4 class="font-size-18">Sub Sections</h4>
                                    
                                </div>

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-9"></div>
                                    <div class="page-title-box col-sm-2" style="text-align: right;">
                                        <button  class="btn btn-primary" id="show" onclick="show_form()"> Add Sub Section </button>     
                                        <button  class="btn btn-primary" id="hide" onclick="show_form()" style="display: none;"> Hide Form </button>      
                                    </div>
                                   
                                             
                                   
                                    <div class="page-title-box col-md-1" style="text-align: right;">
                                        <a href="{{ url()->previous() }}" > <button  class="btn btn-primary"  > Back </button>  </a>     
                                        </div>
                                </div>
                                </div>

                                <div class="col-sm-12" style="display:none" id="show_form" >
                                    <form action="{{url('admin/cms/subsection_add')}}" method="POST" enctype="multipart/form-data" >
                                        @csrf
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="title" name="title">
                                                </div>
                                            </div>
       
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-6">
                                                    <textarea id="elm1" name="description"></textarea>
                                                </div>
                                            </div>
    
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Icon</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="icon" name="icon">
                                                </div>
                                            </div>
                                            {{-- <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Banner Image</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="file" id="example-text-input" name="banner_image">
                                                </div>
                                            </div> --}}
    
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
    
                                            <input type="hidden" name="section_id" id="section_id" value="{{$section_id}}">

                                            <input type="submit" value="Submit" name="submit" class="btn btn-success">
                                        </form>
                                    
                                    </div>

                        <!-- end page title -->

                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Action </th>
                                                
                                            </tr>
                                            </thead>


                                            <tbody>
                                                @if($sub_sections)
                                                @foreach($sub_sections as $sub_section)
                                            <tr>
                                            <td>{{$sub_section->title}}</td>
                                            
                                            <td>
                                                
                                                <a href="{{url('admin/cms/edit_subsection/'.$sub_section->id)}}" >  <button type="button" class="btn btn-secondary"><i class="fas fa-edit"></i></button> </a>
                                                <a href="{{url('admin/cms/delete_subsection/'.$sub_section->id)}}">    <button type="button" class="btn btn-secondary"><i class="far fa-trash-alt"></i></button> </a>
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

        <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
        <!--tinymce js-->
        <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

        <script>
            function show_form()
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

            function banner()
            {
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
                }
            }

        </script>


@endsection