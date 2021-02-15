@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Purchases</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                    <li class="breadcrumb-item active">Purchases Reports</li>
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
                <form action="purchases" method="POST">
                <div class="row">
                    @csrf
                    <div class="col-lg-3">
                    <select name="catagory" class="form-control">
                        <option value="">Catagory</option>
                        @foreach($data['catagory'] as $cata)
                        <option value="{{$cata->id}}">{{$cata->name}}</option>
                        @endforeach
                    </select>                    
                    </div>
                    <div class="col-lg-3">
                    <select name="warehouse" class="form-control">
                        <option value="">Warehouse</option>
                        @foreach($data['warehouse'] as $warehouse)
                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                        @endforeach
                    </select>  
                    </div>
                    <div class="col-lg-3">
                        <select name="supplier" class="form-control">
                        <option value="">Supplier</option>
                        @foreach($data['supplier'] as $supplier)
                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                        @endforeach
                    </select> 
                    </div>
                <div class="col-lg-3">
                <input type="submit" class="btn btn-primary">
                <span class="btn btn-success">
                <a href="purchases-report-csv" style="color:white;">Export CSV</a>
                </span>
                </div>
            </div>
                </form>
                





                <div class="card-body">
                    <h4 class="card-title">Purchases</h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled bdxdeedececedeccecdey--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    {{--<div class="pull-right">--}}
                    {{--<a class="btn btn-success" href="{{ url('admin/transactions/create') }}"> Create New Cash Voucher</a>--}}
                    {{--</div>--}}

                    <table id="purchasereport" class="table table-striped ">
                        <thead>
                        <tr>
                           <th>Date</th>
                            <th>SKU </th>
                            <th>Product </th>
                            <th>Catagory </th>
                            <th>Supplier</th>
                            <th>Warehouse</th>
                            <th>Quantity</th>
                            <th>Purcahse Price</th>
                            <th>Total Price</th>
                            {{--<th>Status</th>--}}

                            {{--<th>Sub Categories</th>--}}



                            {{--<th>Action</th>--}}
                        </tr>
                        </thead>


                        <tbody>

                        @foreach ($data['orders'] as $key => $user)
                           
                            <tr>
                              <td> {{ date("d-m-Y", strtotime($user->created_at))}}</td>
                                <td>{{$user->sku}} </td>
                                <td>{{$user->name}} </td>
                                @php
                                $catagory_id=Modules\Category\Entities\ProductCatagory::where('product_id', $user->id)->pluck('category_id')->first();
                                $catagory_name=Modules\Category\Entities\Category::where('id', $catagory_id)->pluck('name')->first();
                                @endphp
                                <td>{{$catagory_name}}</td>
                                <td>{{SupplierName($user->supplier_id)}} </td>
                                @php
                                $warehouse_id=Modules\Products\Entities\ProductsWarehouseStocks::where('p_id',$user->id)->pluck('ware_house_id')->first();
                                $warehouse_name=Modules\WareHouses\Entities\WareHouses::where('id',$warehouse_id)->pluck('name')->first();
                                @endphp
                                <td>{{$warehouse_name}}</td>
                                <td>{{$user->quantity}} </td>



                                <td>{{number_format($user->purchase_price,2)}} </td>


                                <td>{{number_format($user->purchase_price*$user->quantity,2)}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <th colspan="5" style="text-align:left">Total:</th>
                        <th></th>
                        <th></th>
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