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
                <div class="text-right">
                <button class="btn btn-success">
                <a href="daily-cash-voucher-csv" style="color:white;">Export CSV</a>
                </button>
                </div>
                    <h4 class="card-title">Daily Cash Vouchers Report</h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    {{--<div class="pull-right">--}}
                        {{--<a class="btn btn-success" href="{{ url('admin/transactions/create') }}"> Create New Cash Voucher</a>--}}
                    {{--</div>--}}



                    <table id="vouchersereport" class="table table-striped ">
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
                        </tbody>
                        <tfoot>
                              <th colspan="6" style="text-align:left">Total:</th>
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

    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
    <script>

        var add_to_cart = "{{ url('admin/transactions/ajaxpost') }}";
        var csrf_token = "{{csrf_token()}}";
    </script>
<script>
    
    $(document).ready(function() {
    $('#vouchersereport').DataTable( {
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
          
            totalprice = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over this page
           

            pageTotalPrice = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer

            $( api.column( 6 ).footer() ).html(
                ''+pageTotalPrice +' ( '+ totalprice +' total)'
            );
        }
    } );
} );


</script>

@endsection