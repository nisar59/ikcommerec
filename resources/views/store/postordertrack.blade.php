@extends('store.layouts.inner_template')
@section('content')



    <main id="content" role="main">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Track your Order</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="container">
            <div class="mx-xl-10">
                <div class="mb-6 text-center">
                    <h1 class="mb-6">Track your Order</h1>
                    <p class="text-gray-90 px-xl-10">To track your order please enter your Order ID in the box below and press the "Track" button.</p>

                    <p class="text-gray-90 px-xl-10"><strong>{!!$data['orderStatus']  !!}</strong></p>
                </div>
                <div class="my-4 my-xl-8">

                    {!! Form::open(array('class'=>'js-validate','novalidate'=>'novalidate','url' => 'track-order','method'=>'POST', "enctype"=>"multipart/form-data")) !!}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <!-- Form Group -->
                            <div class="js-form-message form-group">
                                <label class="form-label" for="orderid">Order ID
                                </label>
                                <input type="text" class="form-control" name="orderid" id="orderid" placeholder="Found in your order confirmation email." aria-label="Found in your order confirmation email."  required
                                       data-msg="Please enter a order no."
                                       data-error-class="u-has-error"
                                       data-success-class="u-has-success">
                            </div>
                            <!-- End Form Group -->
                        </div>
                        <div class="col-md-6 mb-3">
                            <!-- Form Group -->
                            <div class="js-form-message form-group">
                                <label class="form-label" for="billingemail">Billing email
                                </label>
                                <input type="email" class="form-control" name="email" id="billingemail" placeholder="Email you used during checkout." aria-label="Email you used during checkout." required
                                       data-msg="Please enter a valid email address."
                                       data-error-class="u-has-error"
                                       data-success-class="u-has-success">
                            </div>
                            <!-- End Form Group -->
                        </div>
                        <!-- Button -->
                        <div class="col mb-1">
                            <button type="submit" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">Track</button>
                        </div>
 <br/>



                        <!-- End Button -->
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
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
