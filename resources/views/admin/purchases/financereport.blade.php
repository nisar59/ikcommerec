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

                    <li class="breadcrumb-item active">Finance Reports</li>
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

                    <h4 class="card-title">Finance Report</h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled bdxdeedececedeccecdey--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    {{--<div class="pull-right">--}}
                    {{--<a class="btn btn-success" href="{{ url('admin/transactions/create') }}"> Create New Cash Voucher</a>--}}
                    {{--</div>--}}

                    <table id="financereport" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>SKU </th>
                            <th>Product </th>
                            <th>Quantity</th>
                            
                            <th>Sale Price</th>
                            <th>Total Sales Price</th>
                            <th>Purcahse Price</th>
                            <th>Profit</th>
                            {{--<th>Status</th>--}}

                            <th>Date</th>
                            {{--<th>Sub Categories</th>--}}



                            {{--<th>Action</th>--}}
                        </tr>
                        </thead>


                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($data['orderproducts'] as $key => $user)
                            @php
                                $i++;
                                $proname=Modules\Products\Entities\Products::where('id',$user->product_id)->first();
                                $ps=$user->total_price-$proname->purchase_price;
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$proname->sku}} </td>
                                <td>{{$proname->name}} </td>
                                <td>{{$user->quantity}} </td>

                                <td>{{number_format($user->price,2)}}</td>
                                <td>{{number_format($user->total_price,2)}}</td>
                                <td>{{number_format($proname->purchase_price,2)}} </td>
                                <td>{{number_format($ps,2)}}</td>
                                <td> {{ date("d-m-Y", strtotime($user->created_at))}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <th colspan="3" style="text-align:left">Total:</th>
                        <th></th>
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
    
    
    <script>
        $(document).ready(function() {
    $('#financereport').DataTable( {
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
          
            totalquantity = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
                  totalpurchase = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                  totalsale = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                  totaltotal = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                  totalprofit = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over this page
           

            pageTotalquantity = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotalpurchase = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotalsale = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotaltotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pageTotalprofit = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer

            $( api.column( 3 ).footer() ).html(
                ''+pageTotalquantity +' ( '+ totalquantity +' total)'
            );
            
           
            $( api.column( 4 ).footer() ).html(
                ''+pageTotalpurchase +' ( '+ totalpurchase +' total)'
            );
            
           
            $( api.column( 5 ).footer() ).html(
                ''+pageTotalsale +' ( '+ totalsale +' total)'
            );
            
           
            $( api.column( 6 ).footer() ).html(
                ''+pageTotaltotal +' ( '+ totaltotal +' total)'
            );
            
           
            $( api.column( 7 ).footer() ).html(
                ''+pageTotalprofit +' ( '+ totalprofit +' total)'
            );
            
            
            
        }
    } );
} );

    </script>

@endsection