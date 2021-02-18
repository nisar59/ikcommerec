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
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="mb-4">
            <h1 class="text-center">Cart</h1>
        </div>
        @if($data['items']->count()>0)

        <div class="mb-10 cart-table">
            <form class="mb-4" action="#" method="post">
                <table class="table" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">&nbsp;</th>
                        <th class="product-name">Product</th>
                        <th class="product-price">Price</th>
                        <th class="product-quantity w-lg-15">Quantity</th>
                        <th class="product-subtotal">Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['items'] as $item)

                        <tr class="">
                        <td class="text-center">
                            <a href="#" class="text-gray-32 font-size-26 remove" data-product-id="{{ $item->id }}">×</a>
                        </td>
                        <td class="d-none d-md-table-cell">
                            
                            
                                @php
                                    $pro= Modules\Products\Entities\Products::where('id', $item->id)->first();
                                   //dd($pro->images[0]['images']);
                                @endphp
                            <a href="{{ url($pro->slug) }}"><img class="img-fluid max-width-100 p-1 border border-color-1" src="{{url('public/uploads/products/'.$pro->images[0]['images'])}}" alt="{{ $item->name }}"></a>
                        </td>

                        <td data-title="Product">
                            <a href="#" class="text-gray-90">{{ $item->name }}</a>
                        </td>

                        <td data-title="Price">
                            <span class="">{{config('variable.DEFAULT_CURRENCY')}}{{ number_format($item->price,2) }}</span>
                        </td>

                        <td data-title="Quantity">
                            <span class="sr-only">Quantity</span>
                            <!-- Quantity -->
                            <div class="border rounded-pill py-1 width-122 w-xl-80 px-3 border-color-1">
                                <div class="js-quantity row align-items-center">
                                    <div class="col">
                                        <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none cart_quantity" type="text" value="{{ $item->quantity }}">
                                    </div>
                                    <div class="col-auto pr-1">
                                        <a class="js-minus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
                                            <small class="fas fa-minus btn-icon__inner"></small>
                                        </a>
                                        <a class="js-plus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
                                            <small class="fas fa-plus btn-icon__inner"></small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Quantity -->
                        </td>

                        <td data-title="Total">
                            <span class=""   >{{config('variable.DEFAULT_CURRENCY')}}{{ number_format($item->quantity*$item->price,2) }}</span>
                        </td>
                            <td data-title="Action">
                                 <div class="d-md-flex"><button  data-product-id="{{ $item->id }}" type="button" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto cartupdate" data-cartproduct-id="{{ $item->id }}">Update cart</button></div>
                            </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="6" class="border-top space-top-2 justify-content-center">
                            <div class="pt-md-3">
                                <div class="d-block d-md-flex flex-center-between">
                                    <div class="mb-3 mb-md-0 w-xl-40">
                                        <!-- Apply coupon Form -->
                                        <form class="js-focus-state">
                                            <label class="sr-only" for="subscribeSrEmailExample1">Coupon code</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="coupon_code" id="subscribeSrEmailExample1" placeholder="Coupon code" aria-label="Coupon code" aria-describedby="subscribeButtonExample2" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-block btn-dark px-4 coupon_apply" type="button" id="subscribeButtonExample2"><i class="fas fa-tags d-md-none coupon_apply"></i><span class="d-none d-md-inline">Apply coupon</span></button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- End Apply coupon Form -->
                                    </div>
                                    <div class="d-md-flex">
                                        <button type="button" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">Update cart</button>
                                        <a href="{{ route('store-shipping-address') }}" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block">Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
            @include('store.checkout.blocks.cart_summary', ['data' => $data, 'type' => 'cart'])


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
        var coupon_apply = "{{ route('store-coupon-apply') }}";
        var csrf_token = "{{csrf_token()}}";
    </script>

    <script src="{{ url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{ url('public/assets/store/product/alerts.js')}}"></script>

    <script src="{{ url('public/assets/store/js/checkout/index.js')}}"></script>
    <script src="{{ url('public/assets/store/js/checkout/coupon.js')}}"></script>
@endpush

@push('metaInfo')
    {{--{!! isset($data['product']->schema) ? $data['product']->schema : "" !!}--}}
    {{--<title>{{ isset($data['product']) ? $data['product']->meta_title : config('app.name') }}</title>--}}
    {{--<meta name="title" content="{{ isset($data['product']) ? $data['product']->meta_title : config('app.name') }}">--}}
    {{--<meta name="description" content="{{ isset($data['product']) ? $data['product']->meta_description : config('app.name') }}">--}}
    {{--<meta name="keywords" content="{{ isset($data['product']) ? $data['product']->meta_keywords : config('app.name') }}">--}}
@endpush
