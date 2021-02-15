<div class="mb-8 cart-total">
    <div class="row">
        <div class="col-xl-5 col-lg-6 offset-lg-6 offset-xl-7 col-md-8 offset-md-4">
            <div class="border-bottom border-color-1 mb-3">
                <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Cart totals</h3>
            </div>
            <table class="table mb-3 mb-md-0">
                <tbody>
                @if(getCoupon())
                <tr class="cart-subtotal">
                    <th>Discount ({{ getCoupon()->getName() }})</th>
                    <td data-title="Subtotal">

                        @if(strpos(getCoupon()->getValue(), '%') !== false)
                        <span class="amount">{{(getCoupon()->getValue() ? str_replace('-', '', getCoupon()->getValue()) : 0) }}</span>
                        @else
                            <span class="amount">{{config('variable.DEFAULT_CURRENCY')}}{{(getCoupon()->getValue() ? str_replace('-', '', getCoupon()->getValue()) : 0) }}</span>
                        @endif

                    </td>
                </tr>
                @endif
                <tr class="cart-subtotal">
                    <th>Subtotal</th>
                    <td data-title="Subtotal"><span class="amount">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($data['cart_sub_total'],2)}}</span></td>
                </tr>




                <tr class="order-total">
                    <th>Total</th>
                    <td data-title="Total"><strong><span class="amount">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($data['cart_total'],2)}}</span></strong></td>
                </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-md-none">Proceed to checkout</button>
        </div>
    </div>
</div>
