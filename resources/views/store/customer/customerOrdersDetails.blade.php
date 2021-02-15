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
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('/customer/orders')}}">{{Auth::guard('user')->user()->first_name}}'s Orders</a></li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Order No. {{$data['order']->id}}</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="row">
            <div class="mb-4">
            <h1 class="text-center">Order Details</h1>
            <h5  >Order No. {{$data['order']->id}}</h5>
            <h5  >Order Date {{ date("d-m-Y", strtotime($data['order']->created_at))}}</h5>
        </div>
        </div>
        <div class="row">
            <div class="mb-4">
                <h3  >Shipping Address</h3>
                <h5  > {{$data['order']->ship_full_name}}<br/>
                    {{$data['order']->ship_email}}<br/>
                    Phone : {{$data['order']->ship_phone}}<br/>
                    {{$data['order']->ship_address_1}}<br/>
                    City : {{$data['order']->ship_city}}, State :{{$data['order']->ship_state}} <br/>
                    Post Code : {{$data['order']->ship_postal_code}}, Country :{{$data['order']->ship_country}} <br/></h5>

            </div>
            <div class="mb-4">
                <h3  >Billing Address</h3>
                <h5  > {{$data['order']->first_name}} {{$data['order']->last_name}}<br/>
                    {{$data['order']->billing_email}}<br/>
                    Phone : {{$data['order']->billing_phone}}<br/>
                    {{$data['order']->billing_address_1}}<br/>
                    City : {{$data['order']->billing_city}}, State : {{$data['order']->billing_state}} <br/>
                    Post Code : {{$data['order']->billing_postal_code}}, Country :{{$data['order']->billing_country}} <br/></h5>

            </div>

        </div>

        @if($data['orderProducts']->count()>0)

            <div class="mb-10 cart-table">
                <form class="mb-4" action="#" method="post">
                    <table class="table" cellspacing="0">
                        <thead>
                        <tr>

                            <th class="product-thumbnail">&nbsp;Order No.</th>
                            <th class="product-name">Product</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity w-lg-15">Quantity</th>
                            <th class="product-subtotal">Total</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data['orderProducts'] as $item)

                            <tr class="">
                                <td class="text-center">
                                  {{$data['order']->id}}
                                </td>
                                <td class="d-none d-md-table-cell">
                                   @php
                                   $productImages = \Modules\Products\Entities\ProductImages::where('p_id',$item->product_id)->orderBy('sort_order')->first();
                                   @endphp
                                    <img class="img-fluid max-width-100 p-1 border border-color-1" src="{{url('public/uploads/products/'.$productImages->images)}}" alt="{{ $item->product->name }}">


                                </td>

                                <td data-title="Price">
                                    <span class="">{{config('variable.DEFAULT_CURRENCY')}}{{ number_format($item->price,2) }}</span>
                                </td>

                                <td data-title="Quantity">

                                    <!-- Quantity -->
                                {{$item->quantity}}
                                    <!-- End Quantity -->
                                </td>

                                <td data-title="Total">
                                    <span class="">{{config('variable.DEFAULT_CURRENCY')}}{{ number_format($item->quantity*$item->price,2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="" >


                            <td class="text-center">

                            </td>
                            <td class="d-none d-md-table-cell">


                            </td>

                            <td data-title="Price">

                            </td>

                            <td data-title="Quantity" class="text-right">

                            Total
                            </td>

                            <td data-title="Total"  >
                                <span class="">   {{config('variable.DEFAULT_CURRENCY')}}{{ number_format($data['order']->total,2) }}</span>
                            </td>
                        </tr>

                    </table>
                </form>
            </div>

            <p>&nbsp;<hr></p>

        @else
            <p class="pt-2 pb-2">There are no items found.</p>
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
