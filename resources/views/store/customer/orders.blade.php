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
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{Auth::guard('user')->user()->first_name}}'s Orders</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="mb-4">
            <h1 class="text-center">{{Auth::guard('user')->user()->first_name}}'s Orders</h1>
        </div>
        @if($data['order']->count()>0)

            <div class="mb-10 cart-table">
                <form class="mb-4" action="#" method="post">
                    <table class="table" cellspacing="0">
                        <thead>
                        <tr>

                            <th class="product-thumbnail">Order No.</th>
                            <th class="product-name">Name</th>
                            <th class="product-price">Email</th>
                            <th class="product-quantity w-lg-15">Quantity</th>
                            <th class="product-subtotal">Amount</th>
                            <th class="product-subtotal">Date</th>
                            <th class="product-subtotal">Order Status</th>
                            <th class="product-subtotal">Order Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['order'] as $user)

                            <tr class="border_bottom">
                                <td class="d-none d-md-table-cell">{{$user->id}} </td>
                                <td class="d-none d-md-table-cell">{{$user->first_name}} {{$user->last_name}} </td>

                                <td data-title="Product">
                                    <a href="#" class="text-gray-90">{{ $user->billing_email }}</a>
                                </td>

                                <td data-title="Price">
                                    <span class="">{{$user->getOrderTotalItems()}}</span>
                                </td>

                                <td data-title="Quantity">

                                    <span class="">{{config('variable.DEFAULT_CURRENCY')}}{{$user->total}}</span>
                                </td>

                                <td data-title="Total">
                                    <span class="">{{ date("d-m-Y", strtotime($user->created_at))}}</span>
                                </td>
                                <td data-title="Total">
                                    <span class="">{{ isset($user->order_status)?$user->order_status:'Pending'}}</span>
                                </td>
                                <td data-title="Total">
                                    <span class=""><a class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto " href="{{url('customer/order-details/'.$user->id)}}">Order details</a></span>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </form>
            </div>
            <p>&nbsp;</p> <p>&nbsp;</p>

        @else
            <p class="pt-2 pb-2">There are no items in this cart.</p>
            <a class="btn btn-primary-dark-w px-5" href="{{ url('/') }}">Continue Shopping</a>
            <p>&nbsp;</p>
        @endif
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
