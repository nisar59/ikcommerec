@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Products Assign to stores</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active"><a href="{{ url()->previous() }}">{{$data['product']->name}}'</a></li>
                    <li class="breadcrumb-item active">Assign to stores</li>
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

                    <h4 class="card-title">Assign to Stores </h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    @foreach($data['warehouses'] as $warehouse)
                    {!! Form::open(array('url' => 'admin/products/assign/store/'.$warehouse->ware_house_id,'method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div  class="form-group ">
                                <label for="quantity">Quantity</label>
                                {!! Form::text('quantity',$warehouse->quantity, array('class' => 'form-control','id'=>"quantity" ,'readonly'=>'readonly')) !!}
                            </div>
                        </div>
                            <div class="col-xs-3 col-sm-3 col-md-3">
                        <div  class="form-group ">
                            <label for="warehouse_id">Ware house</label>
                            {!! Form::text('warehouse_id',wareHousetitle($warehouse->ware_house_id), array('class' => 'form-control','id'=>"quantity" ,'readonly'=>'readonly')) !!}
                        </div>
                            </div>

                        @if(empty($warehouse->store_id))
                     <div class="col-xs-3 col-sm-3 col-md-3">
                        <div  class="form-group"  >
                            <label> Assign To Store</label>
                            {!! Form::select('store_id', $data['stores'],[], array('class' => 'form-control' ,'id'=>"store_id")) !!}
                        </div>
                     </div>
                     @else
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div  class="form-group"  >
                                    <label> Assigned To Store</label><br>
                                    {{Storetitle($warehouse->store_id)}}
                                    {{--{!! Form::text('store_id',Storetitle($warehouse->store_id), array('class' => 'form-control','id'=>"quantity" ,'readonly'=>'readonly')) !!}--}}
                                </div>
                            </div>
                     @endif
                        @if(empty($warehouse->store_id))
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div  class="form-group ">
                                 <label>&nbsp;</label><br />
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        @else
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div  class="form-group ">
                                    <label>&nbsp;</label><br />
                                    <a href="{{url('products/unassigned/'.$warehouse->id)}}"><button type="button" class="btn btn-danger">Unassign</button></a>
                                </div>
                            </div>
                        @endif

<input type="hidden" name="pid" value="{{$warehouse->p_id}}">

                    </div>
                    {!! Form::close() !!}
                @endforeach

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