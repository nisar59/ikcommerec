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
                <h4 class="font-size-18">Accounts Report</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Accounts Report</li>
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
                    <form method="post" action="individualaccountreport" id="individualaccountreport" >
                        @csrf
                    <select class="form-control" name="acnt" required>
                        <option> Select Account </option>
                        @foreach($data['accounts'] as $account)
                        <option value="{{$account->id}}"> {{$account->account_title}} </option>
                        @endforeach
                    </select>
                        <div class="text-right mt-1">
                            
                             <input type="submit" id="getreport" class="btn btn-primary">
                             <button  class="btn btn-success" id="csv">Export CSV</button>
                             </div>
                    </form> 
                    
                    <h4 class="card-title">Individual Account Report For  <span style="color:green;">{{$data['account_title']}}</span></h4>
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

                            <th>Voucher Code</th>
                            <th>Date</th>
                            <th>Accounts</th>
                            <th width="40%">Description</th>
                            <th>Amount/Jamah</th>
                            <th>Amount/Banam</th>
                            
                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        @if($data['orders']->count()>0)
                        @foreach ($data['orders'] as $key => $user)

                            <tr>
                                <td style="border-bottom:1px solid black;">{{config('settings.config_voucher_pre_fix')}}{{$user->voucher_code}}</td>
                                <td style="border-bottom:1px solid black;">{{ date("d-m-Y", strtotime($user->date))}} </td>
                                <td style="border-bottom:1px solid black;">
                                    @if($data['account_title']!=$user->jamah)
                                    {{$user->jamah}}
                                    @else
                                    {{$user->banam}}
                                    @endif
                                </td>
                                <td  style="border-bottom:1px solid black;">{{$user->description}}</td>
                                <td style="border-bottom:1px solid black;">@if($data['account_title']!=$user->jamah)  {{$user->amount}} @endif </td>
                                <td style="vertical-align: middle;border-bottom:1px solid black;"> @if($data['account_title']!=$user->banam)  {{$user->amount}} @endif </td>
                              

                                <td style="border-bottom:1px solid black;">

                                    <a class="btn btn-primary" href="{{ url('admin/transactions/edit/'.$user->id) }}"><i class="fas fa-edit"></i></a>
                                   

                                    <form id = "sub_form" class="form-horizontal" action="{{url('admin/transactions/destroy/'.$user->id)}}" method="POST" enctype="multipart/form-data"  >
                                    {{csrf_field()}}
                                    {{--{!! Form::open(['method' => 'POST','action' => url('users/destroy/'.$user->id),'style'=>'display:inline']) !!}--}}
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                                    {!! Form::close() !!}</td>
                               
                            </tr>
                         
                        @endforeach 
                      @endif
                        </tbody>
                        <tfoot>
                              <th colspan="4" style="text-align:left">Total Difference:</th>
                            <th colspan="3" style="padding-left: 119px;"></th>
                          
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
    $('#vouchersereport').DataTable({
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
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );


            totalprchase = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
        
            var d=total-totalprchase
            if(d<1){
                d='Jamah: '+d;
            }
            else{
                d='Banam: '+d;

            }
            // Update footer

            $( api.column( 4 ).footer() ).html(
                d
            );
         

        },

    });
    

    $(document).on('click','#csv', function(){

          $("#individualaccountreport").attr("action",'export');
    });
    
      $(document).on('click','#getreport', function(){

          $("#individualaccountreport").attr("action",'individualaccountreport');
    });
    
    
});


</script>

@endsection