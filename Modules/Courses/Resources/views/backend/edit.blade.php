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

                    <li class="breadcrumb-item active">Edit Course </li>
                    <li class="breadcrumb-item active">{{$data['user']->title}} </li>
                </ol>
            </div>
        </div>
        @if (count($errors) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div></div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">

                {!! Form::model($data['user'], ['method' => 'POST','url' => ['courses/update/'.$data['user']->id]]) !!}
                <h4 class="card-title">Update {{$data['user']->title}} course</h4>


                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#general" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">General</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#assessment" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Assessment</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pricing" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Pricing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#categories" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#instructor" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Instructor</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Reviews</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#curriculum" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Curriculum</span>
                        </a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="general" role="tabpanel">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {!! Form::text('title', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Slug:</strong>
                                    {!! Form::text('slug', null, array('placeholder' => 'Slug','class' => 'form-control')) !!}
                                </div>
                            </div>



                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong> Description:</strong>

                                    {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','id'=>'elm1')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Duration:</strong>
                                    {!! Form::number('duration', null, array('placeholder' => 'Duration','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Time:</strong>
                                    {!! Form::select('tm', $data['tm'],[], array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                            {{--<div class="form-group">--}}
                            {{--<strong>Block this course:</strong>--}}
                            {{--{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'form-control')) }}--}}
                            {{--{{ $value->name }}--}}
                            {{--</div>--}}
                            {{--</div>--}}


                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Maximum Students</strong>
                                    {!! Form::number('max_student', null, array('placeholder' => 'Maximum Students','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Enrolled Students</strong>
                                    {!! Form::number('enrolled_students', null, array('placeholder' => 'Enrolled Students','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Re-take Course</strong>
                                    {!! Form::number('allowed_retake', null, array('placeholder' => 'Re-Take Course','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Featured this course:</strong><br>

                                    <label>  {{ Form::checkbox('featured','1', false, array('class' => 'name')) }}
                                        Set as featured
                                    </label>

                                </div>
                            </div>




                        </div>
                    </div>
                    <div class="tab-pane p-3" id="assessment" role="tabpanel">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Course result:</strong><br>

                                <label>  {{ Form::radio('course_result','Evaluate via lessions', false, array('class' => 'name')) }}
                                    Evaluate via lessions
                                </label>
                                <label>  {{ Form::radio('course_result','Evaluate via final qiuz', false, array('class' => 'name')) }}
                                    Evaluate via final qiuz
                                </label>

                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Passing Condition value</strong>
                                {!! Form::number('passing_condition', null, array('placeholder' => 'Passing Condition Value','class' => 'form-control')) !!}%
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="pricing" role="tabpanel">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Price</strong>
                                {!! Form::number('price', null, array('placeholder' => 'Course Price','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Sale Price</strong>
                                {!! Form::number('sale_price', null, array('placeholder' => 'Sale Price','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Requiremet to Enroll:</strong><br>

                                <label>  {{ Form::checkbox('required_enroll','1', false, array('class' => 'name')) }}
                                    Required to enroll
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="categories" role="tabpanel">
                        <div class="col-xs-12 col-sm-12 col-md-12">




                            <div class="form-group">
                                <strong>Categories:</strong>
                                {!! Form::select('categories[]', $data['categories'],$data['user']->categories, array('class' => 'form-control','multiple'=>'multiple')) !!}


                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="instructor" role="tabpanel">
                        <p class="mb-0">
                            Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                            art party before they sold out master cleanse gluten-free squid
                            scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                            art party locavore wolf cliche high life echo park Austin. Cred
                            vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                            farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral,
                            mustache readymade thundercats keffiyeh craft beer marfa
                            ethical. Wolf salvia freegan, sartorial keffiyeh echo park
                            vegan.
                        </p>
                    </div>
                    <div class="tab-pane p-3" id="reviews" role="tabpanel">
                       @if(count($data['user']->course_reviews))
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>User Name</th>
                                    <th>Review</th>

                                    <th>Ratings</th>

                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($data['user']->course_reviews as $key => $user)
                                    @php
                                        $i++;
                                   // dd($user->course_reviews)
                                    @endphp
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{userDetailName($user->user_id)}} </td>
                                        <td>{{$user->description}} </td>

                                        <td>
                                            {{$user->rating}}
                                            {{--<a href="{{ url('courses/statusUpdate/'.$user->id) }}">--}}
                                                {{--@if($user->status==1)--}}
                                                    {{--<button class="btn btn-success waves-effect waves-light" type="submit">Active</button>--}}
                                                {{--@else--}}
                                                    {{--<button class="btn btn-danger waves-effect waves-light" type="submit">Not Active</button>--}}
                                                {{--@endif--}}
                                            {{--</a>--}}
                                        </td>
                                        <td>
                                            {{--<a class="btn btn-primary" href="{{ url('courses/edit/'.$user->id) }}">Edit</a>--}}
                                            {{--<form id = "sub_form" class="form-horizontal" action="{{url('courses/destroy/'.$user->id)}}" method="POST" enctype="multipart/form-data"  >--}}
                                            {{--{{csrf_field()}}--}}
                                            {{--{!! Form::open(['method' => 'POST','action' => url('users/destroy/'.$user->id),'style'=>'display:inline']) !!}--}}
                                            {{--{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}--}}
                                            {{--{!! Form::close() !!}</td>--}}
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                           @else
                            <p class="mb-0">
                                No review has been given yet .
                            </p>
                           @endif
                    </div>
                    <div class="tab-pane p-3" id="curriculum" role="tabpanel">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Curriculum:</strong>
                                <br/>
                                @foreach($data['curriculums'] as $value)
                                    <label>{{ Form::checkbox('curriculms[]', $value->id, in_array($value->id, $data['course_curriculum']) ? true : false, array('class' => 'name')) }}
                                        {{ $value->title }}</label>
                                    <br/>
                                @endforeach
                            </div>
                        </div>

                       @if($data['user']->curriculms->count()>0)
<hr>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">{{$data['user']->title}}'s Curriculum </h4>
                                    {{--<p class="card-title-desc">Extend the default collapse behavior to create an--}}
                                        {{--accordion.</p>--}}


                                    <div id="accordion">
                                      @foreach($data['user']->curriculms as $key=>$curriculm)

                                        <div class="card mb-1">
                                            <div class="card-header p-3" id="cuheadingOne{{$curriculm->id}}">
                                                <h6 class="m-0 font-14">
                                                    <a href="#cucollapseOne{{$curriculm->id}}" class="text-dark" data-toggle="collapse"
                                                       aria-expanded="true" aria-controls="cucollapseOne{{$curriculm->id}}">
                                                        {{$curriculm->title}}
                                                    </a>
                                                </h6>
                                            </div>

                                            <div id="cucollapseOne{{$curriculm->id}}" class="collapse @if($key==0) show @endif" aria-labelledby="cuheadingOne{{$curriculm->id}}"
                                                 data-parent="#accordion">
                                                <div class="card">

                                                   @if($curriculm->curriculum_sections->count()>0)
                                                    <div class="card-body">

                                                        <h4 class="card-title">{{$curriculm->title}}'s Sections</h4>
                                                        {{--<p class="card-title-desc">Extend the default collapse behavior to create an--}}
                                                            {{--accordion.</p>--}}


                                                        <div id="accordion{{$curriculm->id}}">

                                                          @foreach($curriculm->curriculum_sections as $keys=>$sections)
                                                            <div class="card mb-1">
                                                                <div class="card-header p-3" id="headingOne{{$sections->id}}">
                                                                    <h6 class="m-0 font-14">
                                                                        <a href="#collapseOne{{$sections->id}}" class="text-dark" data-toggle="collapse"
                                                                           aria-expanded="true" aria-controls="collapseOne{{$sections->id}}">
                                                                            {{$sections->title}}
                                                                        </a>
                                                                    </h6>
                                                                </div>

                                                                <div id="collapseOne{{$sections->id}}" class="collapse @if($keys==0) show @endif" aria-labelledby="headingOne{{$sections->id}}"
                                                                     data-parent="#accordion{{$curriculm->id}}">

                                                                     @if($sections->sections_lessons->count()>0)
                                                                    <div class="card">
                                                                        <div class="card-body">

                                                                            <h4 class="card-title">{{$sections->title}}'s lessons</h4>

                                                                            <div class="pull-right">
                                                                                <a class="btn btn-success" href="{{ url('curriculums/sections/lesson/create/'.$sections->id) }}" target="_blank"> Create New Lesson </a>
                                                                            </div>

                                                                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Name</th>

                                                                                    <th>Preview</th>
                                                                                    <th>Status</th>

                                                                                    <th>Action</th>
                                                                                </tr>
                                                                                </thead>


                                                                                <tbody>
                                                                                @php
                                                                                    $i=0;
                                                                                @endphp
                                                                                @foreach ($sections->sections_lessons as $key => $user)
                                                                                    @php
                                                                                        $i++;
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>{{$i}}</td>
                                                                                        <td>{{$user->title}} </td>
                                                                                        <td>@if($user->preview)  <label class="badge badge-success">Yes</label> @else  <label class="badge badge-danger">No</label> @endif </td>

                                                                                        {{--<td><a href="{{ url('curriculums/sections/lesson/'.$user->id) }}"> <button class="btn btn-success waves-effect waves-light" type="submit">Lessons<span class="badge badge-pill badge-primary float-right">{{$user->sections_lessons()->count()}}</span></button></a> </td>--}}

                                                                                        <td>
                                                                                            <a href="{{ url('curriculums/sections/lesson/statusUpdate/'.$user->id) }}" target="_blank">
                                                                                                @if($user->status==1)
                                                                                                    <button class="btn btn-success waves-effect waves-light" type="submit">Active</button>
                                                                                                @else
                                                                                                    <button class="btn btn-danger waves-effect waves-light" type="submit">Not Active</button>
                                                                                                @endif
                                                                                            </a>
                                                                                        </td>
                                                                                        <td>
                                                                                            <a class="btn btn-primary" href="{{ url('curriculums/sections/lesson/edit/'.$user->id) }}" target="_blank">Edit</a>
                                                                                            <form target="_blank" id = "sub_form" class="form-horizontal" action="{{url('curriculums/sections/lesson/destroy/'.$user->id)}}" method="POST" enctype="multipart/form-data"  >
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
                                                                     @endif
                                                                </div>
                                                            </div>
                                                           @endforeach
                                                        </div>

                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                       @endforeach

                                    </div>

                                </div>
                            </div>

                        </div>
                       @endif
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>


    </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    {{--<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js')}}"></script>--}}
    <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>

    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>

    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>

@endsection