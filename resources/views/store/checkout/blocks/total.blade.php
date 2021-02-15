<p>Subtotal:<span class="amount">${{ number_format($data['cart_sub_total'], 2) }}</span></p>
@if(getCoupon())
    <p>Discount <span class="fedex">({{ getCoupon()->getName() }})</span>:
        @if(strpos(getCoupon()->getValue(), '%') !== false)
            <span class="amount">{{(getCoupon()->getValue() ? str_replace('-', '', getCoupon()->getValue()) : 0) }}</span>
        @else
            <span class="amount">${{(getCoupon()->getValue() ? str_replace('-', '', getCoupon()->getValue()) : 0) }}</span>
        @endif
    </p>
@endif
@if(getShipping())
    <p>Shipping <span class="amount">${{ number_format((getShipping()->getValue() > 0 ? getShipping()->getValue() : 0), 2) }}</span>:<span class="fedex">({{ getShipping()->getName() }})</span></p>
@endif
<div class="usd_amount">
    <h5>USD{{ number_format($data['cart_total'], 2) }} <span>Total Due Today</span></h5>
</div>