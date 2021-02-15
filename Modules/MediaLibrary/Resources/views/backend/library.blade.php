@extends('layouts.master')

@section('css')
        <!-- Dropzone css -->
        <link href="{{ URL::asset('assets/libs/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('content')


<div class="col-sm-12 col-md-12 mt-4">
    


    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-lg" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Edit Image Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="modal-body">
                           
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6" style="border-left: solid 0.5px #b5b8bb;">
                        <div class="modal-body-1" style="border-bottom: solid 0.5px #b5b8bb;">
                            
                        </div>
                        <div class="modal-body-2" >
                            
                        </div>
                    </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>


           <!-- start page title -->
           <div class="row align-items-center">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                    <div class="col-md-6">
                        <h4 class="font-size-18">Media Library</h4>
                    </div>
                    <div class="col-md-6 text-right bulk_div" >
                        <select class="form-control  select2" id="filter" onchange="filteration()" style="width: 30%; display:inline-block;">
                            <option>Select</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="file">File</option>
                        </select>
                    <button class="btn btn-primary" id="add_button" onclick="myFunction()">Add New </button>
                    <button class="btn btn-warning " id="bulk_button" onclick="blurSelect()">Bulk Select </button>

                    </div>
                    </div>
                </div>
            </div>

        </div>     
        <!-- end page title -->

        <div class="row" id="show_upload" style="display:none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        
                        {{-- <p class="card-title-desc">DropzoneJS is an open source library
                            that provides drag’n’drop file uploads with image previews.
                        </p> --}}

                        <div class="mb-5">
                        <form action="{{url('admin/medialibrary/save-file')}}" class="dropzone" method="POST" id="dropzone" enctype="multipart/form-data">
                            @csrf
                                <div class="fallback">
                                    <input name="file" type="file" multiple="multiple">
                                </div>
                               
                                {{-- <div class="text-center mt-3">
                                    <input type="submit" class="btn btn-primary waves-effect waves-light" value="Upload Files">
                                </div> --}}
                            </form>
                        </div>

                       
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            {{-- <h4 class="card-title">Media Library</h4> --}}
            {{-- <p class="card-title-desc">In this example lazy-loading of images is enabled for the next image based on move direction. </p> --}}

            <div class="popup-gallery">

                    @if ($files)
                    @foreach ($files as $file)
                        @php
                            $year = date('Y');
                            $month = date('m');
                        @endphp
                   
                   @if ( $file->extension == 'jpg' || $file->extension == 'jpeg' || $file->extension == 'png' || $file->extension == 'webp' || $file->extension == 'svg'  )
            <a class="float-left modalLink" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="{{$file->id}}" href="#MyModal" title="{{$file->alt_text}}">
                    <div class="img-responsive" style="margin:10px; border: solid darkslategrey ;">
                        <img src="{{ $file->link}}" alt="{{$file->alt_text}}" width="120">
                    </div>
                </a>   

                   @else

                   <a class="float-left modalLink" data-toggle="modal" data-target=".bs-example-modal-lg" data-id="{{$file->id}}" href="#MyModal" title="{{$file->alt_text}}">
                    <div class="img-responsive"  style="margin:10px; border: solid darkslategrey ;">
                        <img src="{{ URL::asset('assets/images/File.png')}}" alt="{{$file->alt_text}}" width="120">
                    </div>
                </a>  
                       
                   @endif
                    
                    @endforeach       
                    @endif
                   
                
               
            </div>

        </div>
    </div>
</div> <!-- end col -->

@endsection

@section('script')
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/libs/moment/min/moment.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>



        
        <script>

            $('.modalLink').click(function(){
                var AJAX_URL = {!! json_encode(url('admin/medialibrary/modal')) !!}
               
                var dataId=$(this).attr('data-id');

                console.log('dataId');
                $.ajax({url:AJAX_URL,
                    method:"post",
                    dataType: 'json',
                    data: {
              "_token": "{{ csrf_token() }}",
               "data_id" : dataId ,

           },
                success:function(result){
                    console.log(result);
                    $(".modal-body").empty();
                    $(".modal-body-1").empty();
                    $(".modal-body-2").empty();
                    $(".modal-body").append(result.Record1);
                    $(".modal-body-1").append(result.Record2);
                    $(".modal-body-2").append(result.Record3);
                    
                }});
            });


function modal(lnk)
{
    var AJAX_URL = {!! json_encode(url('admin/medialibrary/modal')) !!}
               
               var dataId=lnk.dataset.id;

               //console.log(dataId);
               $.ajax({url:AJAX_URL,
                   method:"post",
                   dataType: 'json',
                   data: {
             "_token": "{{ csrf_token() }}",
              "data_id" : dataId ,

          },
               success:function(result){
                   console.log(result);
                   $(".modal-body").empty();
                   $(".modal-body-1").empty();
                   $(".modal-body-2").empty();
                   $(".modal-body").append(result.Record1);
                   $(".modal-body-1").append(result.Record2);
                   $(".modal-body-2").append(result.Record3);
                   
               }});
}
            function updateonfocus()
            {
             //alert('abc');
            var AJAX_URL = {!! json_encode(url('admin/medialibrary/update/image_details')) !!}
            var alt =$('#alt').val();
            var title =$('#title').val();
            var caption =$('#caption').val();
            var description =$('#description').val();
            var dataId=$('#hidden').val();
console.log(dataId);


            $.ajax({url:AJAX_URL,
                method:"post",
                dataType: 'json',
                data: {
          "_token": "{{ csrf_token() }}",
           "data_id" : dataId ,
           "alt": alt,
           "title": title,
           "caption": caption,
           "description": description,
       },
            success:function(result){
              //  console.log(result);
                $(".modal-body").empty();
                $(".modal-body-1").empty();
                $(".modal-body-2").empty();
                $(".modal-body").append(result.Record1);
                $(".modal-body-1").append(result.Record2);
                $(".modal-body-2").append(result.Record3);
                
            }});
        }

  function blurSelect()
  {
       //alert('abc');
       var AJAX_URL = {!! json_encode(url('admin/medialibrary/bulk_select')) !!}
           
            $.ajax({url:AJAX_URL,
                method:"post",
                dataType: 'json',
                data: {
          "_token": "{{ csrf_token() }}",
       },
            success:function(result){
              //  console.log(result);
                $(".popup-gallery").empty();
                // $(".modal-body-1").empty();
                // $(".modal-body-2").empty();
                $(".popup-gallery").append(result.Record1);
                // $(".modal-body-1").append(result.Record2);
                // $(".modal-body-2").append(result.Record3);
                $(".bulk_div").empty();
                $(".bulk_div").append(result.Record2);
                
                   
            }});
  }



function Bulk_delete()
{
    var AJAX_URL = {!! json_encode(url('admin/medialibrary/delete_bulk')) !!}
           var checkbox_value = "";
    $(":checkbox").each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            checkbox_value += $(this).val() + "|";
        }
    });
  //  alert(checkbox_value);
            $.ajax({url:AJAX_URL,
                method:"post",
                dataType: 'json',
                
                data: {
          "_token": "{{ csrf_token() }}",
          "ab" : checkbox_value,
       },
            success:function(result){
              //  console.log(result);
                $(".popup-gallery").empty();
                // $(".modal-body-1").empty();
                // $(".modal-body-2").empty();
                $(".popup-gallery").append(result.Record1);
                // $(".modal-body-1").append(result.Record2);
                // $(".modal-body-2").append(result.Record3);
                $(".bulk_div").empty();
                $(".bulk_div").append(result.Record2);
                
                   
            }});
}

    function filteration()
    {
        var AJAX_URL = {!! json_encode(url('admin/medialibrary/filter')) !!}
        var filter =$('#filter').val();
  //  alert(checkbox_value);
            $.ajax({url:AJAX_URL,
                method:"post",
                dataType: 'json',
                
                data: {
          "_token": "{{ csrf_token() }}",
          "filter" : filter,
       },
            success:function(result){
              //  console.log(result);
                $(".popup-gallery").empty();
                // $(".modal-body-1").empty();
                // $(".modal-body-2").empty();
                $(".popup-gallery").append(result.Record1);
                // $(".modal-body-1").append(result.Record2);
                // $(".modal-body-2").append(result.Record3);
                $(".bulk_div").empty();
                $(".bulk_div").append(result.Record2);
                
                   
            }});

    }
      
  function myFunction() {
  var x = document.getElementById("show_upload");
  var y = document.getElementById("add_button");
  if (x.style.display === "none") {
    x.style.display = "block";
  }
  else
  {
    x.style.display = "none";
  }
}



function all_data()
  {
       //alert('abc');
       var AJAX_URL = {!! json_encode(url('admin/medialibrary/all_data')) !!}
           
            $.ajax({url:AJAX_URL,
                method:"post",
                dataType: 'json',
                data: {
          "_token": "{{ csrf_token() }}",
       },
            success:function(result){
              //  console.log(result);
                $(".popup-gallery").empty();
                // $(".modal-body-1").empty();
                // $(".modal-body-2").empty();
                $(".popup-gallery").append(result.Record1);
                // $(".modal-body-1").append(result.Record2);
                // $(".modal-body-2").append(result.Record3);
                $(".bulk_div").empty();
                $(".bulk_div").append(result.Record2);
                
                   
            }});
  }

 
 



</script>
<script type="text/javascript">
    Dropzone.options.dropzone =
             {
                maxFilesize: 12,
               // acceptedFiles: ".jpeg,.jpg,.png,.gif",
                //addRemoveLinks: true,
                timeout: 5000,
                success: function(file, result) 
                {
             // console.log(Record1);
             var rep = JSON.parse(result);

                $(".popup-gallery").empty();
                $(".popup-gallery").append(rep.Record1);
                $(".bulk_div").empty();
                $(".bulk_div").append(rep.Record2);
                },
                error: function(file, response)
                {
                   return false;
                }
    };
    </script>

@endsection