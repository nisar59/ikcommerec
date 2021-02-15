@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Sales Report</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Sales Report</li>
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
                    <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="row col-lg-5">
                    <div class="col-lg-6">
                     <label for="From">From</label>
                    <input type="date" name="from" class="form-control"></div>                   
                     <div class="col-lg-6">
                    <label for="From">To</label>
                    <input type="date" name="to" class="form-control">
                </div>
                </div>
                <div class="col-lg-3"><label for="From">Catagory</label>
                    <select name="catagory" class="form-control">
                        <option value="">Select Catagory</option>
                      @foreach($data['catagory'] as $cata)
                        <option value="{{$cata->id}}">{{$cata->name}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-lg-3"><label for="From">Order Status</label>
                   <div class="form-group">
                    <select name="orderstatus" id="" class="form-control">
                        <option value="">Select Order Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Payment Pending">Payment Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Completed">Completed</option>
                        <option value="Failed">Failed</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Refund">Refund</option>
                    </select>
                </div>
                </div>
               <div class="col-lg-1 pl-4">
                <label for="">  </label>
                   <input type="submit" class="btn btn-primary form-control ml-1">
               </div>
                    </div>
                </form>
                <div class="text-right">
                <button class="btn btn-success">
                <a href="product-sales-report-export" style="color:white;">Export CSV</a>
                </button>
                </div>
                    <h4 class="card-title">Sales Report</h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    {{--<div class="pull-right">--}}
                        {{--<a class="btn btn-success" href="{{ url('admin/brands/create') }}"> Create New Brands</a>--}}
                    {{--</div>--}}

                    <table id="salesreport" class="display table table-striped " style="width:100%">
                        <thead>
                        <tr>

                            <th>Order No.</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Date</th>
                            {{--<th>Sub Categories</th>--}}
                        </tr>
                        </thead>


                        <tbody>

                        @foreach ($data['orders'] as $key => $user)
                        @php
                          $proname=Modules\Products\Entities\Products::where('id',$user->product_id)->pluck('name')->first();
                        @endphp
                            <tr>
                                <td>{{$user->order_id}}</td>
                                <td>{{$proname}}</td>
                                <td>{{$user->quantity}} </td>
                                <td>{{$user->total_price}} </td>
                                <td>{{ date("d-m-Y", strtotime($user->created_at))}} </td>
                                {{--<td>{{$user->first_name}} {{$user->last_name}}</td>--}}

                            </tr>       
                        @endforeach
                        </tbody>
                       <tfoot>
                            <th colspan="2" style="text-align:left">Total:</th>
                            <th></th>
                            <th></th>
                           
                        </tfoot>  
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



    <script src="{{ URL::asset('assets/js/search.js')}}"></script>


@endsection