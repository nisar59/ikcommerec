@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')




<div class="clearfix header">
      <div id="logo">
        <img src="logo.png">
      </div>
      <div id="company">
        <h2 class="name">Company Name</h2>
        <div>455 Foggy Heights, AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      </div>
    </div>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">INVOICE TO:</div>
          <h2 class="name">John Doe</h2>
          <div class="address">796 Silver Harbour, TX 79273, US</div>
          <div class="email"><a href="mailto:john@example.com">john@example.com</a></div>
        </div>
        <div id="invoice">
          <h1>INVOICE 3-2-1</h1>
          <div class="date">Date of Invoice: 01/06/2014</div>
          <div class="date">Due Date: 30/06/2014</div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">UNIT PRICE</th>
            <th class="qty">QUANTITY</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="no">01</td>
            <td class="desc"><h3>Website Design</h3></td>
            <td class="unit">$40.00</td>
            <td class="qty">30</td>
            <td class="total">$1,200.00</td>
          </tr>
          <tr>
            <td class="no">02</td>
            <td class="desc"><h3>Website Development</h3></td>
            <td class="unit">$40.00</td>
            <td class="qty">80</td>
            <td class="total">$3,200.00</td>
          </tr>
          <tr>
            <td class="no">03</td>
            <td class="desc"><h3>Search Engines Optimization</h3></td>
            <td class="unit">$40.00</td>
            <td class="qty">20</td>
            <td class="total">$800.00</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"></td>
            <td colspan="1">SUBTOTAL</td>
            <td>$5,200.00</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td colspan="1">Delivery / Charges</td>
            <td>$1,300.00</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td colspan="1">Discount</td>
            <td>$1,300.00</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td colspan="1">GRAND TOTAL</td>
            <td>$6,500.00</td>
          </tr>
        </tfoot>
      </table>
    </main>
    <br/>
    <br/>
    <br/>





    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Invoice Management</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">View Invoice: INV-{{$data['user']->id}} </li>
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

                {!! Form::model($data['user'], ['method' => 'POST','url' => ['admin/ordered/update/'.$data['user']->id],"enctype"=>"multipart/form-data"]) !!}
                <h4 class="card-title">Invoice INV-{{$data['user']->id}}</h4>


                <!-- Nav tabs -->

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3">

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Name: {{$data['user']->first_name}} {{$data['user']->last_name}}<br />{{$data['user']->billing_email}}
                                    <br />
                                        {{$data['user']->billing_phone}}
                                        <br />
                                        Billing Address:
                                        <br />
                                        {{$data['user']->billing_address_1}},{{$data['user']->billing_city}}, ,{{$data['user']->post_code}}
                                    </strong>

                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Shipping Address:
                                        <br />
                                        Name: {{$data['user']->ship_full_name}} <br />{{$data['user']->ship_email}}
                                        <br />
                                        {{$data['user']->billing_phone}}
                                        <br />

                                        {{$data['user']->ship_address_1}},{{$data['user']->ship_city}},{{$data['user']->ship_state}},{{$data['user']->ship_postal_code}}
                                    </strong>

                                </div>
                            </div>
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
                                   
                                    @foreach ($data['user']->orderProducts as $key => $userPro)
                                     @php
                                    $pname=Modules\Products\Entities\Products::where('id',$userPro->product_id)->pluck('name')->first();
                                    @endphp
                                        <tr> 
                                            <td>{{$pname}}</td>
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
                    



                </div>
                {{--<div class="col-xs-12 col-sm-12 col-md-12 text-center">--}}
                    {{--<button type="submit" class="btn btn-primary">Update</button>--}}
                {{--</div>--}}
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