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

                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        
                                       
                                        <div class="page-title-box col-md-8" style="text-align: right; padding-right: 15px;">
                                            <a href="{{ url()->previous() }}" > <button  class="btn btn-primary"  > Back </button>  </a>     
                                            </div>
                                        </div>
                                        </div>

                                <div class="col-sm-12"  >
                                    <form action="{{url('admin/cms/update_subsection/'.$subsection_data->id)}}" method="POST" enctype="multipart/form-data" >
                                        @csrf
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                                <div class="col-sm-6">
                                                <input class="form-control" type="text" id="title" name="title" value="{{$subsection_data->title}}">
                                                </div>
                                            </div>

                                        
                                            
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-6">
                                                    <textarea id="elm1" name="description">{!! $subsection_data->description !!}</textarea>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Icon</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="icon" name="icon" value="{{$subsection_data->icon}}">
                                                </div>
                                            </div>
    
    
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Button Text</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="button_text" name="button_text" value="{{$subsection_data->button_text}}">
                                                </div>
                                            </div>
    
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">Button Link</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="button_link" name="button_link" value="{{$subsection_data->button_link}}">
                                                </div>
                                            </div>
    
                                            <input type="submit" value="Submit" name="submit" class="btn btn-success">
                                        </form>
                                    
                                    </div>

                      

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

      


@endsection