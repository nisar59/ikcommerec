@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Accounts Management</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Edit Account </li>
                </ol>
            </div>
        </div>
        @if (count($errors) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div></div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Edit Account </h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}


                    {!! Form::model($data['user'], ['method' => 'POST', "enctype"=>"multipart/form-data",'url' => ['admin/transactional-accounts/update/'.$data['user']->id]]) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Account Title:</strong>
                                {!! Form::text('account_title', null, array('placeholder' => 'Account title','class' => 'form-control','id'=>'account_title')) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Account  type:</strong>

                                {!! Form::select('account_type', $data['accounts_type'],$data['user']->account_type, array('class' => 'form-control','id'=>'account_type')) !!}
                            </div>
                        </div>

                        @php
                        if($data['user']->account_type==1){
                        $scls = 'block';
                        $sdis = '';
                        }else{
                        $scls = 'none';
                        $sdis = 'disabled';
                        }
                         if($data['user']->account_type==2){
                        $ccls = 'block';
                        $cdis = '';
                        }else{
                        $ccls = 'none';
                        $cdis = 'disabled';
                        }

                        @endphp


                        <div class="col-xs-12 col-sm-12 col-md-6" id="show_suppliers" style="display: {{$scls}};">
                            <div class="form-group">
                                <strong>Suppliers:</strong>
                                <select name="supplier_id" class="form-control" id="supplier_id" required {{$sdis}}>
                                    <option value="" >Select</option>
                                    @foreach($data['suppliers'] as $supplier)
                                        <option value="{{$supplier->id}}" data-fullname="{{$supplier->name}}"  @if($data['user']->supplier_id==$supplier->id) selected @endif>{{$supplier->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6" id="show_customers" style="display: {{$ccls}};"  >
                            <div class="form-group">
                                <strong>Customers:</strong>
                                <select name="customer_id" class="form-control" id="customer_id" required {{$cdis}}>
                                    <option value="" >Select</option>
                                    @foreach($data['customers'] as $customers)
                                        <option value="{{$customers->id}}"  data-fullname="{{$customers->first_name}} {{$customers->last_name}}" @if($data['user']->customer_id==$customers->id) selected @endif>{{$customers->first_name}} {{$customers->last_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>





                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong> Address:</strong>
                                <textarea  class="form-control" name="address" rows="5">{{$customers->address}}</textarea>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')

    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    {{--<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>--}}
    <!--tinymce js-->
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <!-- demo js -->
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>


    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

    <script>
        $(document).ready(function(e) {
            $(document).on('change', "#account_type", function(e){
                e.preventDefault();

                var account_type = $(this).val();
                if(account_type==1){
                    $("#show_suppliers").show();
                    $("#show_customers").hide();

                    $('#supplier_id').removeAttr("disabled");
                    $('#customer_id').attr("disabled",'disabled');
                }
                else if(account_type==2){
                    $("#show_customers").show();
                    $("#show_suppliers").hide();
                    $('#supplier_id').attr("disabled",'disabled');
                    $('#customer_id').removeAttr("disabled");
                }else{
                    $("#show_suppliers").hide();
                    $("#show_customers").hide();
                    $('#supplier_id').attr("disabled");
                    $('#customers_id').attr("disabled");
                }

                //alert(account_type);

                //  var token = csrf_token;
                $(".loader_bg").show();

            });



        });

    </script>

@endsection