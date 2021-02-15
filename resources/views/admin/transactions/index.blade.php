@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/store/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Daily Cash Vouchers</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Daily Cash Vouchers</li>
                </ol>
            </div>
        </div>


    </div>      @if ($message = Session::get('success'))<div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        </div></div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Daily Cash Vouchers</h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    {{--<div class="pull-right">--}}
                        {{--<a class="btn btn-success" href="{{ url('admin/transactions/create') }}"> Create New Cash Voucher</a>--}}
                    {{--</div>--}}

                    {{--{!! Form::open(array('url' => 'admin/transactions/store','method'=>'POST', "enctype"=>"multipart/form-data")) !!}--}}
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-2">
                            <div class="form-group">
                                <strong>Date:</strong>
                                {!! Form::date('date', null, array('placeholder' => 'Date','class' => 'form-control','id'=>'theAnyDate')) !!}
                            </div>
                        </div>



                        <div class="col-xs-3 col-sm-3 col-md-2"    >
                            <div class="form-group">
                                <strong>Account/Jamah:</strong>
                                <select name="jamah" class="form-control" id="jamah" required >
                                    <option value="" >Select</option>
                                
                                    @foreach($data['accounts'] as $supplier)
                                        <option value="{{$supplier->id}}" data-fullname="{{$supplier->account_title}}" >{{$supplier->account_title}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-2"    >
                            <div class="form-group">
                                <strong>Account/Banam:</strong>
                                <select name="banam" class="form-control" id="banam" required >
                                    <option value="" >Select</option>
                                    @foreach($data['accounts'] as $supplier)
                                        <option value="{{$supplier->id}}" data-fullname="{{$supplier->account_title}}" >{{$supplier->account_title}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-2">
                            <div class="form-group">
                                <strong>Amount:</strong>
                                {!! Form::number('amount', null, array('placeholder' => 'amount','class' => 'form-control','id'=>'amount','required'=>'required')) !!}
                            </div>
                        </div>






                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <strong> Description:</strong>
                                {!! Form::text('description', null, array('placeholder' => 'Description','class' => 'form-control','id'=>'description')) !!}
                                {{--<textarea  class="form-control" id="description" name="description" rows="5"></textarea>--}}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="button" id="cashbutton" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    {{--{!! Form::close() !!}--}}


                    <table id="datatable" class="table table-striped ">
                        <thead>
                        <tr>

                            <th>Sr No.</th>
                            <th>Date</th>
                            <th>Voucher Code</th>
                           <th>Jamah</th>
                            <th>Banam</th> 
                            <th>Description</th>
                            <th>Amount</th>
                            {{--<th>Status</th>--}}


                            {{--<th>Sub Categories</th>--}}



                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>

                        @foreach ($data['orders'] as $key => $user)

                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{ date("d-m-Y", strtotime($user->date))}} </td>
                                <td>{{config('settings.config_voucher_pre_fix')}}{{$user->voucher_code}} </td>
                                <td>{{$user->jamah}} </td>
                                <td>{{$user->banam}} </td>


                                <td>{{$user->description}} </td>
                                <td>  {{$user->amount}} </td>




                                {{--<td>{{$user->first_name}} {{$user->last_name}}</td>--}}


                                <td>

                                    <a class="btn btn-primary" href="{{ url('admin/transactions/edit/'.$user->id) }}"><i class="fas fa-edit"></i></a>
                                   

                                    <form id = "sub_form" class="form-horizontal" action="{{url('admin/transactions/destroy/'.$user->id)}}" method="POST" enctype="multipart/form-data"  >
                                    {{csrf_field()}}
                                    {{--{!! Form::open(['method' => 'POST','action' => url('users/destroy/'.$user->id),'style'=>'display:inline']) !!}--}}
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                                    {!! Form::close() !!}</td>
                               
                            </tr>
                         
                        @endforeach
                        <tr>
                            <td>Total</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                            <td>
                          
                                {{$data['orders']->sum('amount')}}
                       
                                </td>
                        </tr>

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
    <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    {{--<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>--}}

    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script>

        var add_to_cart = "{{ url('admin/transactions/ajaxpost') }}";
        var csrf_token = "{{csrf_token()}}";
    </script>

    <script>

        $(document).ready(function(e) {
            var anydate = new Date("{{date("m/d/Y")}}");

            $("#theAnyDate").val(getFormattedDate(anydate));
            function getFormattedDate (date) {
                return date.getFullYear()
                    + "-"
                    + ("0" + (date.getMonth() + 1)).slice(-2)
                    + "-"
                    + ("0" + date.getDate()).slice(-2);
            }

            $(document).on('click', "#cashbutton", function(e){
                e.preventDefault();
                 //alert('asd');
                var date = $('#theAnyDate').val();
                var amount = $('#amount').val();

                var banam = $('#banam').val();
                var jamah = $('#jamah').val();
                
                var description = $('#description').val();
                var token = csrf_token;
                var url = add_to_cart;

                   // $(".bg").show();
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: { date: date, amount:amount, banam: banam, jamah: jamah,description:description, _token: token },
                        success: function (data) {
                            $(".bg").fadeOut('slow');
                            console.log(data);
                            var obj = JSON.parse(data);
                            if(obj.status){
                                $('span.cart_items').html(obj.items);
                                if(obj.items > 0){
                                    $('span.cart_items').css('opacity', 1);
                                }else{
                                    $('span.cart_items').css('opacity', 0);
                                }
                               
                                success_alert(obj.message,true);
                            }else{
                                error_alert(obj.message);
                                
                            }

                        },
                        error: function (data) {
                            $(".bg").fadeOut('slow');
                            console.log('Error:', data);
                            var obj = JSON.parse(data);
                            error_alert(obj.message);
                        }
                    });

            });
        });

 </script>

    <script src="{{ url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{ url('public/assets/store/product/alerts.js')}}"></script>

@endsection