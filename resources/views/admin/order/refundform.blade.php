@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Order Management</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Order Management </li>
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

                {!! Form::model($data['user'], ['method' => 'POST','url' => ['admin/ordered/updateperforma/'.$data['user']->id],"enctype"=>"multipart/form-data"]) !!}
                <h4 class="card-title">Order Management</h4>


                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">General</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#categories" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Prodcuts</span>
                        </a>
                    </li>


                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="general" role="tabpanel">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>First Name:</strong>
                                    {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control' ,'readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Last Name:</strong>
                                    {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    {!! Form::text('billing_email', null, array('placeholder' => 'Email','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Phone:</strong>
                                    {!! Form::text('billing_phone', null, array('placeholder' => 'Phone','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Order Status:</strong>
                                    {!! Form::select('order_status', $data['order_status'],[], array('class' => 'form-control','disabled'=>'disabled')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Order Note:</strong>
                                    {!! Form::text('order_note', null, array('placeholder' => 'Order Note','class' => 'form-control','readonly'=>'readonly')) !!}

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Restock Items:</strong>
                                    <br/>

                                    <label>{{ Form::radio('restock', '1', false, array('class' => 'name')) }}
                                        Yes {{ Form::radio('restock', '0', false, array('class' => 'name')) }}
                                        No</label>
                                    <br/>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Refund reason:</strong>
                                    {!! Form::text('refund_reason', null, array('placeholder' => 'Refund Reason','class' => 'form-control')) !!}

                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Billing Address:</strong>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Address:</strong>
                                    {!! Form::text('billing_address_1', null, array('placeholder' => 'Address','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>City:</strong>
                                    {!! Form::text('billing_city', null, array('placeholder' => 'Billing City','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>State:</strong>
                                    {!! Form::text('billing_state', null, array('placeholder' => 'Billing State','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Post Code:</strong>
                                    {!! Form::text('billing_postal_code', null, array('placeholder' => 'Billing PostCode','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Country:</strong>
                                    {!! Form::text('billing_country', null, array('placeholder' => 'Billing City','class' => 'form-control','readonly'=>'readonly')) !!}


                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-12">
                                <div class="form-group">
                                    <strong>Shipping Address:</strong>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Ship Full Name:</strong>
                                    {!! Form::text('ship_full_name', null, array('placeholder' => 'Ship Full Name','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>



                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Address:</strong>
                                    {!! Form::text('ship_address_1', null, array('placeholder' => 'Shipping Address','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>City:</strong>
                                    {!! Form::text('ship_city', null, array('placeholder' => 'Shipping City','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>State:</strong>
                                    {!! Form::text('ship_state', null, array('placeholder' => 'Shipping State','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Post Code:</strong>
                                    {!! Form::text('ship_postal_code', null, array('placeholder' => 'Shipping PostCode','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Country:</strong>
                                    {!! Form::text('ship_country', null, array('placeholder' => 'Shipping City','class' => 'form-control','readonly'=>'readonly')) !!}
                                </div>
                            </div>




                        </div>
                    </div>
                    <div class="tab-pane p-3" id="categories" role="tabpanel">
                        <div class="col-xs-12 col-sm-12 col-md-12">




                            <div class="form-group">
                                <table id="datatable" class="table table-striped ">
                                    <thead>
                                    <tr>

                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>

                                        {{--<th>Sub Categories</th>--}}




                                    </tr>
                                    </thead>


                                    <tbody>
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach ($data['user']->orderProducts as $key => $userPro)
                                        @php
                                            $i++;


                                        @endphp
                                        <tr>
                                            <td>{{$userPro->product->name}}</td>
                                            <td>{{$userPro->price}} </td>
                                            <td>{{$userPro->quantity}} </td>
                                            <td>{{$userPro->total_price}} </td>


                                            {{--<td>{{$user->first_name}} {{$user->last_name}}</td>--}}



                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>




                    </div>



                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>


    </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    {{--<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>--}}
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
    <!-- form repeater -->
    <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>

    <!-- form repeater init js -->
    <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
    <!-- Summernote js -->
    <script src="{{ URL::asset('assets/libs/summernote/summernote.min.js')}}"></script>

    <!-- demo js -->
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

@endsection