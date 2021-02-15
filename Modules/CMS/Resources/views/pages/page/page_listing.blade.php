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
                                    <h4 class="font-size-18">Page</h4>
                                    
                                </div>

                                <div class="col-sm-12 pr-0" style="text-align: right;">
                                    <div class="page-title-box">
                                        <button  class="btn btn-primary" onclick="show_form()"> Add </button>        
                                    </div>
                                </div>

                                <div class="col-sm-12" style="display:none" id="show_form" >
                                <form action="{{url('admin/cms/page_add')}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="example-text-input" name="page_name">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Permalink</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="example-text-input" name="permalink">
                                            </div>
                                        </div>

                                        {{--<div class="form-group row">--}}
                                            {{--<label class="col-sm-2 col-form-label">Banner/Slider</label>--}}
                                            {{--<div class="col-sm-6">--}}
                                                {{--<select class="form-control" name="banner_slider" id="banner_slider" onchange="banner()">--}}
                                                    {{--<option value="No Banner/Slider">No Banner/Slider</option>--}}
                                                    {{--<option value="Banner">Banner</option>--}}
                                                    {{--<option value="Slider">Slider</option>--}}
                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                       
                                        <div id="slider" style="display: none">
                                            <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Slider</label>
                                            <div class="col-sm-6">
                                            <select class="form-control" name="slider" id="slider" >
                                                @if($sliders)
                                                @foreach($sliders as $slider)
                                            <option value="{{$slider->id}}"> {{$slider->title}} </option>
                                               @endforeach
                                               @endif
                                            </select>
                                            </div>
                                        </div>
                                        </div>

                                        <div id="banner" style="display: none">

                                        <div class="form-group row" id="banner_title" >
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Banner Title</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="example-text-input" name="banner_title">
                                            </div>
                                        </div>

                                        <div class="form-group row" id="banner_link">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Banner Link</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="example-text-input" name="banner_link">
                                            </div>
                                        </div>

                                        <div class="form-group row" id="banner_desc" >
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Banner Description</label>
                                            <div class="col-sm-6">
                                                <textarea id="full-featured" class="form-control" name="banner_desc"></textarea>
                                            </div>
                                        </div>

                                            </div>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Description</label>
                                            <div class="col-sm-6">
                                                <textarea id="elm1" class="form-control" name="description"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Banner Image</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="file" id="example-text-input" name="image">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Meta Title</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="example-text-input" name="meta_title">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Meta Description</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="example-text-input" name="meta_desc">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Meta Keywords</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="example-text-input" name="meta_keywords">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Schema</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" type="text" id="example-text-input" name="schema">
                                            </div>
                                        </div>

                                        <input type="submit" value="Submit" name="submit" class="btn btn-success">
                                    </form>
                                
                                </div>

                               <div style="margin: 20px;"> </div>
                          
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-striped ">
                                            <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Name</th>
                                                {{--<th>Banner Style</th>--}}
                                                <th>Action</th>
                                            </tr >
                                            </thead>


                                            <tbody id ="tablecontents">
                                                @if($pages)
                                                @foreach($pages as $page)
                                            <tr class="row1" data-id="{{ $page->sort_order }}">
                                                <td>{{$page->sort_order}}</td>
                                            <td>{{$page->name}}</td>
                                            {{--<td>{{$page->banner_style}}</td>--}}
                                            <td>
                                                <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                                <a href="{{url('admin/cms/page/section/'.$page->id)}}">   <button type="button" class="btn btn-secondary">Section</button> </a>
                                                <a href="{{url('admin/cms/edit_page/'.$page->id)}}" >  <button type="button" class="btn btn-secondary"><i class="fas fa-edit"></i></button> </a>
                                                <a href="{{url('admin/cms/delete_page/'.$page->id)}}">    <button type="button" class="btn btn-secondary"><i class="far fa-trash-alt"></i></button> </a>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

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
                //var y = document.getElementById("show");
                if (x.style.display === "none") {
                x.style.display = "block";
               // y.style.display = "none";
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







<script type="text/javascript">

var after = $('#datatable').DataTable({
  "order": [[1,"asc"]],                       // sorting 2nd column
  "columnDefs": [
    { "orderable": false, "targets": "_all" } // Applies the option to all columns
  ]
});

    $(function () {
      $("#datatable").DataTable();
  
      $( "#tablecontents" ).sortable({
        items: "tr",
        cursor: 'move',
        opacity: 0.6,
        update: function() {
            sendOrderToServer();
        }
      });
  
      function sendOrderToServer() {
  
        var order = [];
        $('tr.row1').each(function(index,element) {
          order.push({
            id: $(this).attr('data-id'),
            position: index+1
          });
        });
  
        $.ajax({
          type: "POST", 
          dataType: "json", 
          url: "{{ url('cms/sortabledatatable') }}",
          data: {
            order:order,
            _token: '{{csrf_token()}}'
          },
          success: function(response) {
              if (response.status == "success") {
                console.log(response);
              } else {
                console.log(response);
              }
          }
        });
  
      }
    });
  
  </script>




@endsection