@php

@endphp

@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Stock Report</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Stock Report</li>
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
                <form action="stock-report" method="POST" id="filter">
                    @csrf
                    <div class="row">
                       <div class="col-lg-1"><h4>Filters</h4></div>
                       <div class="col-lg-2">
                        <select name="warehouse" class="form-control filter">
                            <option value="">Select Warehouse</option>
                            @php
                             $warehouse=Modules\WareHouses\Entities\WareHouses::all();
                              @endphp
                              @foreach($warehouse as $name)@endphp
                            <option value="{{$name->id}}">{{$name->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select name="stock" class="form-control filter">
                            <option value="">Select Status</option>
                            <option value="1">In Stock</option>
                            <option value="5">Low Stock</option>
                            <option value="0">Out Of Stock</option>
                        </select>
                    </div>   
                </div>

            </form>
                    <h4 class="card-title"></h4>
                

                    <table id="stocks" class="display table table-striped " style="width:100%">

                        <thead>
                        <tr>
                            <th>Sku</th>
                            <th>Product Name</th>
                            <th>Wharehouse</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            {{--<th>Sub Categories</th>--}}
                        </tr>
                        </thead>


                        <tbody>

                        @foreach ($data['orders'] as $key => $user)
                        @php
                          $proname=Modules\Products\Entities\Products::where('id',$user->p_id)->first();
                          $warehouse=Modules\WareHouses\Entities\WareHouses::where('id',$user->ware_house_id)->pluck('name')->first();
                        @endphp
                            <tr>
                                <td>{{$proname['sku']}}</td>
                                <td>{{$proname['name']}}</td>
                                <td>{{$warehouse}}</td>
                                <td>{{$user->quantity}} </td>
                                <td>
                                    @if($user->quantity<1)
                                <span class="badge badge-pill badge-danger">Out of stock</span>
                                   @elseif($user->quantity<5)
                                 <span class="badge badge-pill badge-warning">Low stock</span>
                                   @else
                                  <span class="badge badge-pill badge-success">in stock</span>
                                    @endif
                                    

                                </td>
<!--                                 <td>{{ date("d-m-Y", strtotime($user->created_at))}} </td>
 -->
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
<script>
    $(document).ready(function(){

        $(document).on('change','.filter', function(){
            $('#filter').submit();
        });

    });


</script>

@endsection