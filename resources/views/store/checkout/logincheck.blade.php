@extends('store.layouts.inner_template')
@section('content')

    <!-- breadcrumb -->
    <div class="bg-gray-13 bg-md-transparent">
        <div class="container">
            <!-- breadcrumb -->
            <div class="my-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Login check</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="mb-4">
            <h1 class="text-center">Login required</h1>
        </div>

            <p>Please login or register to proceed.</p>
            <a class="btn btn-primary-dark-w px-5" href="{{ url('/') }}">Continue Shopping</a>
             <p> &nbsp;</p>
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
