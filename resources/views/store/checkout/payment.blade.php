@extends('store.layouts.template')
@section('content')
    <section class="checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="shipping_signin">
                                <ul>
                                    <li class="active">
                                        <span></span>
                                        <i class="fa fa-check"></i>
                                        <p>Cart Detail</p>
                                    </li>
                                    <li class="active">
                                        <span></span>
                                        <i class="fa fa-check"></i>
                                        <p>Shipping</p>
                                    </li>
                                    <li class="active">
                                        <span></span>
                                        <i class="fa fa-check"></i>
                                        <p>Review & Pay</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            @if (Session::has('success'))
                                <p>{!! Session::get('success') !!}</p>
                            @endif

                            @if (Session::has('error'))
                                <p>{!! Session::get('error') !!}</p>
                            @endif
                            {!! Form::open(['url' => route('store-payment'), 'class' => 'payment_form']) !!}


                                    <div class="shipping_address">
                                        <h3>Payment Method</h3>
                                        @if(config('settings.config_paypal_status')=='active')
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="payment_method payment_method_li pt-0">
                                            <ul>
                                                <li><input type="radio" name="payment_method" value="paypal" checked/></li>
                                                <li><img src="{{ asset('public/assets/store') }}/images/paypal_credit.png"/></li>
                                            </ul>
                                        </div> 
                                            </div>
                                        @endif
                                        @if(config('settings.config_stripe_status')=='active')
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="payment_method payment_method_li pt-0">
                                                    <ul>
                                                        <li><input type="radio" name="payment_method" value="stripe" /></li>
                                                        <li><img src="{{ asset('public/assets/store') }}/images/stripe.png"/></li>
                                                    </ul>
                                                </div> 
                                            </div>
                                            @endif

                                        </div>
                                    </div>


                                <div class="promo_code">
                                    @include('store.checkout.blocks.promo_form')
                                </div>
                                <div class="shipping_method">
                                    @if(request()->order)
                                        <a class="button btn" href="{{ route('store-payment-process', request()->order) }}">Confirm<i class="fa fa-arrow-right"></i></a>
                                    @else
                                        <input class="button btn" type="submit" value="Confirm" />
                                    @endif
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-md-4 col-sm-8 col-xs-12">
                            @include('store.checkout.blocks.cart_summary', ['data' => $data, 'type' => 'payment'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
@endpush

@push('js')
    {{ HTML::script('public/assets/store/js/checkout/index.js') }}
    {{ HTML::script('public/assets/store/js/checkout/coupon.js') }}
@endpush

@push('metaInfo')
    <title>Payment :: {{ config('app.name') }}</title>
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
@endpush
