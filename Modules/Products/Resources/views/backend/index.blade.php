@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Products Management</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Dashboard</a></li>

                    <li class="breadcrumb-item active">Products Management</li>
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

                    <h4 class="card-title">Products Management</h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ url('admin/products/create') }}"> Create New Products</a>
                    </div>

                    <table id="datatable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>

                            {{--<th>Sub Categories</th>--}}

                            <th>Status</th>
                            <th>Images</th>
                            <th>Assign to Store</th>
                            <th>Reviews</th>
                            {{--<th>Stock Status</th>--}}
                            {{--<th>Enable reviews</th>--}}
                            <th>Expiry</th>
                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($data['user'] as $key => $user)
                            @php
                                $i++;
                           // dd($user->images);
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$user->name}} </td>
                                {{--<td>{{$user->first_name}} {{$user->last_name}}</td>--}}

                                <td>
                                    <a href="{{ url('admin/products/statusUpdate/'.$user->id) }}">
                                        @if($user->status==1)
                                            <button class="btn btn-success waves-effect waves-light" type="submit">Active</button>
                                        @else
                                            <button class="btn btn-danger waves-effect waves-light" type="submit">Not Active</button>
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('admin/products/images/'.$user->id) }}">

                                            <button class="btn btn-success waves-effect waves-light" type="submit">Images<span class="badge badge-pill badge-primary float-right">{{$user->images()->count()}}</span></button>

                                    </a>
                                </td>

                                <td>
                                    <a href="{{ url('admin/products/stores/'.$user->id) }}">

                                            <button class="btn btn-success waves-effect waves-light" type="submit">Assign to Stores</button>

                                    </a>
                                </td>
                                <td>
                                    @php
                                        $review=\App\Review::where('product_id', $user->id)->get();
                                        $num=count($review);
                                    @endphp
                                    <a href="{{ url('admin/products/reviews/'.$user->id) }}">
                                        <button class="btn btn-success waves-effect waves-light" type="submit">Reviews<span class="badge badge-pill badge-primary float-right">{{$num}}</span></button>

                                    </a>
                                </td>

                                {{--<td>--}}
                                    {{--<a href="{{ url('products/stocksUpdate/'.$user->id) }}">--}}
                                        {{--@if($user->stock_status==1)--}}
                                            {{--<button class="btn btn-success waves-effect waves-light" type="submit">In Stock</button>--}}
                                        {{--@else--}}
                                            {{--<button class="btn btn-danger waves-effect waves-light" type="submit">Out of Stock</button>--}}
                                        {{--@endif--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                    {{--<a href="{{ url('products/reviewsUpdate/'.$user->id) }}">--}}
                                        {{--@if($user->enable_reviews==1)--}}
                                            {{--<button class="btn btn-success waves-effect waves-light" type="submit">Yes</button>--}}
                                        {{--@else--}}
                                            {{--<button class="btn btn-danger waves-effect waves-light" type="submit">No</button>--}}
                                        {{--@endif--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                <td>
                                    {{$user->expiry}}
                                </td>
                               
                                <td>
                                    <a class="btn btn-primary" href="{{ url('admin/products/edit/'.$user->id) }}"><i class="fas fa-edit"></i></a>
                                    <form id = "sub_form" class="form-horizontal" action="{{url('admin/products/destroy/'.$user->id)}}" method="POST" enctype="multipart/form-data"  >
                                    {{csrf_field()}}
                                    {{--{!! Form::open(['method' => 'POST','action' => url('users/destroy/'.$user->id),'style'=>'display:inline']) !!}--}}
                                    {!! Form::button('<i class="far fa-trash-alt"></i>', array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                                    {!! Form::close() !!}</td>
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