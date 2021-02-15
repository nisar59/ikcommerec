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
                <h4 class="font-size-18">Daily Cash Voucher</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Create New Daily Cash Voucher </li>
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

                    <h4 class="card-title">Create Daily Cash Voucher </h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}

                    {!! Form::open(array('url' => 'admin/transactions/store','method'=>'POST', "enctype"=>"multipart/form-data")) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Date:</strong>
                                {!! Form::date('date', null, array('placeholder' => 'Date','class' => 'form-control','id'=>'account_title')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Voucher Code:</strong>
                                <input name="voucher_code" type="text"      class="form-control">
                                {{--{!! Form::date('date',[], array('placeholder' => 'Date','class' => 'form-control','id'=>'account_title')) !!}--}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Transaction  type:</strong>

                                {!! Form::select('transaction_type', $data['transaction_type'],[], array('class' => 'form-control','id'=>'account_type')) !!}
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-6"    >
                            <div class="form-group">
                                <strong>Account:</strong>
                                <select name="account_id" class="form-control" id="supplier_id" required >
                                    <option value="" >Select</option>
                                    @foreach($data['accounts'] as $supplier)
                                        <option value="{{$supplier->id}}" data-fullname="{{$supplier->account_title}}" >{{$supplier->account_title}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <strong>Amount:</strong>
                                {!! Form::text('amount', null, array('placeholder' => 'Amount','class' => 'form-control','id'=>'account_title')) !!}
                            </div>
                        </div>






                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong> Description:</strong>
                                <textarea  class="form-control" name="description" rows="5"></textarea>
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