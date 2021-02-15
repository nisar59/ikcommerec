@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Order Management</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Order Management</li>
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

                    <h4 class="card-title">Order Management</h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ url('admin/order/create-order') }}"> Create New Order</a>
                    </div>

                    <table id="datatable" class="table table-striped ">
                        <thead>
                        <tr>

                            <th>Order No.</th>
                            <th>Name</th>
                            {{--<th>Email</th>--}}
                            <th>Phone</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Order Status</th>
                            <th>Date</th>
                            {{--<th>Sub Categories</th>--}}



                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($data['orders'] as $key => $user)
                            @php
                                $i++;
                            @endphp
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->first_name}} {{$user->last_name}}</td>
                                {{--<td>{{$user->billing_email}} </td>--}}
                                <td>{{$user->billing_phone}} </td>
                                <td>{{$user->getOrderTotalItems()}} </td>
                                <td>{{$user->total}} </td>
                                <td>@if($user->status==1)
                                    Active
                                        @else
                                      Not  Active
                                        @endif
                                      </td>
                                <td>{{isset($user->order_status)?$user->order_status:'Pending'}}</td>
                                <td>{{ date("d-m-Y", strtotime($user->created_at))}} </td>
                                {{--<td>{{$user->first_name}} {{$user->last_name}}</td>--}}


                                <td>
                                   @if($user->refunded==1)
                                        <a class="btn btn-primary" href="{{ url('admin/order/refund-performa/'.$user->id) }}">Refund Performa</a>
                                    @else
                                    <a class="btn btn-primary" href="{{ url('admin/order/edit/'.$user->id) }}"><i class="fas fa-edit"></i></a>
                                    @endif
                                    <form id = "sub_form" class="form-horizontal" action="{{url('admin/order/delete/'.$user->id)}}" method="POST" enctype="multipart/form-data"  >
                                    {{csrf_field()}}
                                    {{--{!! Form::open(['method' => 'POST','action' => url('users/destroy/'.$user->id),'style'=>'display:inline']) !!}--}}
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @if(!empty($user->tracking_number))
                                            <a class="btn btn-primary" href="{{ url($user->cod_slip) }}" target="_blank">{{$user->tracking_number}}</a>
                                     @else

                                     <a class="btn btn-primary" href="{{ url('admin/order/leapord/'.$user->id) }}">Send to courior</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

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

@endsection