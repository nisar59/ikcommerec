@extends('store.layouts.inner_template')
@section('content')

    <div class="bg-gray-13 bg-md-transparent">
        <div class="container">
            <!-- breadcrumb -->
            <div class="my-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{Auth::guard('user')->user()->first_name}}'s Dashbaord</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="mb-5">
            <h1 class="text-center">{{Auth::guard('user')->user()->first_name}}'s Dashbaord</h1>
        </div>
        <!-- Accordion -->
        @if (Session::has('error'))
            <div data-alert class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
    @endif
        @if ($message = Session::get('success'))<div class="row">
            <div class="col-12">
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            </div></div>
        @endif
        


        {{--<form class="js-validate" novalidate="novalidate"  action="{{url('customer/update-profile')}}" method="post">--}}

           
            <div class="row">

                
                
                {!! Form::model($data['user'], ['class'=>'js-validate','method' => 'POST','url' => ['customer/update-profile/'.$data['user']->id]]) !!}
                <div class="col-lg-12 order-lg-12">
                    <div class="pb-7 mb-7">
                        <!-- Title -->
                        <div class="border-bottom border-color-1 mb-5">
                            <h3 class="section-title mb-0 pb-2 font-size-25">Profile details</h3>
                        </div>
                        <!-- End Title -->

                        <!-- Billing Form -->
                        <div class="row">
   
                            <div class="col-md-6">
                                <!-- Input -->
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        First name
                                        <span class="text-danger">*</span>
                                    </label>
                                    {{--<input type="text" class="form-control" name="first_name" placeholder="Jack" aria-label="Jack" required="" data-msg="Please enter your frist name." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">--}}
                                    {!! Form::text('first_name', null, array('data-msg'=>'Please enter your first name.','data-error-class'=>'u-has-error', 'data-success-class'=>'u-has-success' ,'autocomplete'=>'off' ,'placeholder' => 'First Name','class' => 'form-control')) !!}
                                </div>
                                <!-- End Input -->
                            </div>

                            <div class="col-md-6">
                                <!-- Input -->
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Last name
                                        <span class="text-danger">*</span>
                                    </label>

                                    {!! Form::text('last_name', null, array('data-msg'=>'Please enter your lastst name.','data-error-class'=>'u-has-error', 'data-success-class'=>'u-has-success' ,'autocomplete'=>'off' ,'placeholder' => 'First Name','class' => 'form-control')) !!}
                                </div>
                                <!-- End Input -->
                            </div>

                            <div class="w-100"></div>

                            <div class="col-md-12">
                                <!-- Input -->
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                       Email
                                    </label>
                                    {!! Form::text('email', null, array('readonly'=>'readonly','data-msg'=>'Please enter your frist name.','data-error-class'=>'u-has-error', 'data-success-class'=>'u-has-success' ,'autocomplete'=>'off' ,'placeholder' => 'First Name','class' => 'form-control')) !!}
                                </div>
                                <!-- End Input -->
                            </div>
                            <div class="col-md-12">
                                <!-- Input -->
                                <div class="js-form-message mb-6 otherinput">
                                    <label class="form-label">
                                        Passwrod leave it blank if do not want to change
                                    </label>
                                    {!! Form::password('password', null, array('data-msg'=>'Please enter your passwrod.','data-error-class'=>'u-has-error', 'data-success-class'=>'u-has-success' ,'autocomplete'=>'off' ,'placeholder' => 'Password','class' => 'form-control otherclass')) !!}
                                    
                                <!-- End Input -->
                            </div>
                            <div class="col-md-12">
                                <!-- Input -->
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Gender
                                    </label>
                                    {{ Form::radio('gender', 'Male', false, array('class' => 'name')) }}
                                    Male {{ Form::radio('gender', 'Female', false, array('class' => 'name')) }}
                                    Female
                                </div>
                                <!-- End Input -->
                            </div>
                            <div class="col-md-12">
                                <!-- Input -->
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Mobile
                                    </label>
                                    {!! Form::text('mobile_no', null, array('data-msg'=>'Please enter your Mobile No.','data-error-class'=>'u-has-error', 'data-success-class'=>'u-has-success' ,'autocomplete'=>'off' ,'placeholder' => 'Mobile No.','class' => 'form-control')) !!}
                                </div>
                                <!-- End Input -->
                            </div>
                            <div class="col-md-12">
                                <!-- Input -->
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        City
                                    </label>
                                    {!! Form::text('city', null, array('data-msg'=>'Please enter your city','data-error-class'=>'u-has-error', 'data-success-class'=>'u-has-success' ,'autocomplete'=>'off' ,'placeholder' => 'City','class' => 'form-control')) !!}
                                </div>
                                <!-- End Input -->
                            </div>
                            <div class="col-md-12">
                                <!-- Input -->
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Country
                                    </label>
                                    {!! Form::text('country', null, array('data-msg'=>'Please enter your country','data-error-class'=>'u-has-error', 'data-success-class'=>'u-has-success' ,'autocomplete'=>'off' ,'placeholder' => 'Country','class' => 'form-control')) !!}
                                </div>
                                <!-- End Input -->
                            </div>



                            <div class="col-md-12">
                                <!-- Input -->
                                <div class="js-form-message mb-6">
                                    <label class="form-label">
                                        Address
                                    </label>
                                    {!! Form::text('address', null, array('data-msg'=>'Please enter your address','data-error-class'=>'u-has-error', 'data-success-class'=>'u-has-success' ,'autocomplete'=>'off' ,'placeholder' => 'Address','class' => 'form-control')) !!}
                                </div>
                                <!-- End Input -->
                            </div>
                            <div class="col-md-12">
                                <!-- Input -->
                                <div class="js-form-message mb-6">

                                    <button type="submit" class="btn btn-primary-dark-w btn-block btn-pill font-size-20 mb-3 py-3" >Update Profile</button>
                                </div>
                                <!-- End Input -->
                            </div>


                        </div>
                        <!-- End Billing Form -->

                        <!-- Accordion -->

                    <!-- End Accordion -->
                        <!-- Title -->

                        <!-- End Accordion -->
                        <!-- Input -->

                        <!-- End Input -->
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <link media="all" type="text/css" rel="stylesheet" href="{{url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.css')}}">
@endpush

@push('js')
    <script>
        var remove_from_cart = "{{ route('store-cart-remove') }}";
        var update_qty_cart = "{{ route('store-cart-update') }}";
        var csrf_token = "{{csrf_token()}}";
    </script>

    <script src="{{ url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{ url('public/assets/store/product/alerts.js')}}"></script>

    <script src="{{ url('public/assets/store/js/checkout/index.js')}}"></script>
@endpush

@push('metaInfo')
    {{--{!! isset($data['product']->schema) ? $data['product']->schema : "" !!}--}}
    {{--<title>{{ isset($data['product']) ? $data['product']->meta_title : config('app.name') }}</title>--}}
    {{--<meta name="title" content="{{ isset($data['product']) ? $data['product']->meta_title : config('app.name') }}">--}}
    {{--<meta name="description" content="{{ isset($data['product']) ? $data['product']->meta_description : config('app.name') }}">--}}
    {{--<meta name="keywords" content="{{ isset($data['product']) ? $data['product']->meta_keywords : config('app.name') }}">--}}
@endpush
