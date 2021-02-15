@if($product->discounted_price && $product->sale_price > 0)
    <span>Sale {{ round((100 - ($product->discounted_price/$product->sale_price)*100), 0) }}% Off</span>
@endif