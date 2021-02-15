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

                    <li class="breadcrumb-item active"><a href="{{ url()->previous() }}">{{$data['product']->name}}'s Images </a></li>
                    <li class="breadcrumb-item active"><a href="{{ url()->previous() }}">Products Management</a></li>
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
                  
                    <table id="datatable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>Star Rating</th>
                            <th>Review</th>
                            <th>status</th>
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
                            @endphp
                            <tr>
                                <td>{{$i}}</td>

                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->rating}}</td>
                                <td>{{$user->review}}</td>
                                <td>  
                                    <a href="{{ url('admin/products/ReviewstatusUpdate/'.$user->id) }}">
                                        @if($user->status==1)
                                            <button class="btn btn-success waves-effect waves-light" type="submit">Active</button>
                                        @else
                                            <button class="btn btn-danger waves-effect waves-light" type="submit">Not Active</button>
                                        @endif
                                    </a>
                                </td>




                                <td>
                                    <form id = "sub_form" class="form-horizontal" action="{{url('admin/products/review/destroy/'.$user->id)}}" method="POST" enctype="multipart/form-data"  >
                                    {{csrf_field()}}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
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