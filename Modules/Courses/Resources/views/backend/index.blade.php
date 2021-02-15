@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="font-size-18">Courses Management</h4>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>

                    <li class="breadcrumb-item active">Courses Management</li>
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

                    <h4 class="card-title">Courses Management</h4>
                    {{--<p class="card-title-desc">DataTables has most features enabled by--}}
                    {{--default, so all you need to do to use it with your own tables is to call--}}
                    {{--the construction function: <code>$().DataTable();</code>.--}}
                    {{--</p>--}}
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ url('courses/create') }}"> Create New Course</a>
                    </div>

                    <table id="datatable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Name</th>
                            <th>Price</th>

                            <th>Status</th>
                            <th>FAQs</th>
                            <th>Libraries</th>
                            <th>Announcemnets</th>

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
                            //dd($user->course_library)
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$user->title}} </td>
                                <td>{{$user->price}} </td>

                                <td>
                                    <a href="{{ url('courses/statusUpdate/'.$user->id) }}">
                                        @if($user->status==1)
                                            <button class="btn btn-success waves-effect waves-light" type="submit">Active</button>
                                        @else
                                            <button class="btn btn-danger waves-effect waves-light" type="submit">Not Active</button>
                                        @endif
                                    </a>
                                </td>
                                <td><a href="{{ url('courses/faqs/'.$user->id) }}"> <button class="btn btn-success waves-effect waves-light" type="submit">FAQs<span class="badge badge-pill badge-primary float-right">{{$user->course_faqs()->count()}}</span></button></a></td>
                                <td><a href="{{ url('courses/libraries/'.$user->id) }}"> <button class="btn btn-success waves-effect waves-light" type="submit">Libraries<span class="badge badge-pill badge-primary float-right">{{$user->course_library()->count()}}</span></button></a></td>
                                <td><a href="{{ url('courses/announcemnts/'.$user->id) }}"> <button class="btn btn-success waves-effect waves-light" type="submit">Announcements<span class="badge badge-pill badge-primary float-right">{{$user->course_announcments()->count()}}</span></button></a></td>
                                <td>
                                    <a class="btn btn-primary" href="{{ url('courses/edit/'.$user->id) }}">Edit</a>
                                    <form id = "sub_form" class="form-horizontal" action="{{url('courses/destroy/'.$user->id)}}" method="POST" enctype="multipart/form-data"  >
                                    {{csrf_field()}}
                                    {{--{!! Form::open(['method' => 'POST','action' => url('users/destroy/'.$user->id),'style'=>'display:inline']) !!}--}}
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