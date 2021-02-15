<span>${{ number_format($item->getPriceSumWithConditions(), 2) }}</span>
@if($item->product->discounted_price)
    <p>${{ number_format($item->product->sale_price*$item->quantity, 2) }}</p>
@endif