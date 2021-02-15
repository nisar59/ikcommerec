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
                                <div class="alert alert-success text-center">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif

                                <form role="form" action="{{ url('/checkout/stripe') }}" method="post" class="require-validation"
                                      data-cc-on-file="false"
                                      data-stripe-publishable-key="{{config('settings.config_stripe_publishable_key')}}"
                                      id="payment-form">
                                    @csrf

                            <div class="shipping_address payment_card">
                                @if($data['cart_total']>0)
                                <div class='form-row'>
                                    <div class='col-xs-12 form-group required'>
                                        <label class='control-label'>Name on Card</label> <input
                                                class='form-control control-label' size='4' type='text'>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-xs-12 form-group required'>
                                        <label class='control-label'>Card Number</label> <input
                                                autocomplete='off' class='form-control control-label card-number' size='20'
                                                type='text'>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                        <label class='control-label'>CVC</label> <input autocomplete='off'
                                                                                        class='form-control control-label card-cvc' placeholder='ex. 311' size='4'
                                                                                        type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Month</label> <input
                                                class='form-control control-label card-expiry-month' placeholder='MM' size='2'
                                                type='text'>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Year</label> <input
                                                class='form-control control-label card-expiry-year' placeholder='YYYY' size='4'
                                                type='text'>
                                    </div>
                                </div>

                                <div class='form-row'>
                                    <div class='col-md-12 error form-group hide'>
                                        <div class='alert-danger alert'>Please correct the errors and try
                                            again.</div>
                                    </div>
                                </div>
                                <input type="hidden" name="order_amount" value="{{$data['cart_total']}}">
                                <input type="hidden" name="order_des" value="Online stripe payment against order id# {{$data['order']->id}} ">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button class="btn btn-lg payment_card_btn" type="submit">Pay Now (${{$data['cart_total']}})</button>
                                    </div>
                                </div>
                                    @endif
                                </form>


                            </div>




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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
@endpush

@push('js')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {
            var $form         = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {
                var $form         = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'].join(', '),
                    $inputs       = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid         = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
    {{ HTML::script('public/assets/store/js/checkout/index.js') }}
    {{ HTML::script('public/assets/store/js/checkout/coupon.js') }}
@endpush

@push('metaInfo')
    <title>Payment :: {{ config('app.name') }}</title>
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
@endpush
