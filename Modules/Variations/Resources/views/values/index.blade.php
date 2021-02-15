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

                    <li class="breadcrumb-item active">Products Variations</li>
                </ol>
            </div>
        </div>
    </div>
     @if ($message = Session::get('success'))
     <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p>{{ $message }}</p>
            </div>
        </div>
    </div>
    @endif


     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$data['vari']->name}} Variation Values</h4>
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ url('admin/variations/values/create/'.$data['vari']->id) }}">Add Value</a>
                    </div>

                    <table id="datatable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Values</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['varivalue'] as $vari)
   
                            <tr>
                                <td>{{$vari->id}}</td>
                                <td>{{$data['vari']->name}}</td>
                                <td>{{$vari->value}} </td>

                                 <td>
                                    <a class="btn btn-primary" href="{{ url('admin/variations/values/edit/'.$vari->id) }}"><i class="fas fa-edit"></i></a>
                                    <form id = "sub_form" class="form-horizontal" action="{{url('admin/variations/values/destroy/'.$vari->id)}}" method="POST" enctype="multipart/form-data"  >
                                    {{csrf_field()}}
                                   <input type="hidden" name="id" value="{{$data['vari']->id}}">
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