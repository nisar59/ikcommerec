@if($type == 'detail')
    <div class="product_price">
        @if($product->discounted_price)
            <h5>
                {{ formatCurrency($product->discounted_price, config('variable.DEFAULT_CURRENCY')) }}
                <p>{{ formatCurrency($product->sale_price, config('variable.DEFAULT_CURRENCY')) }}</p>
            </h5>
            <span>You save {{ formatCurrency($product->sale_price - $product->discounted_price, config('variable.DEFAULT_CURRENCY')) }}</span>
        @else
            <h5>{{ formatCurrency($product->sale_price, config('variable.DEFAULT_CURRENCY')) }}</h5>
        @endif
        <div class="col-md-12 p-0 mt-1">
            <span class="sku">SKU # {{ $data['product']->sku }}</span>
        </div>
    </div>
@elseif($type == 'block')
    @if($product->sale_price)
        <div class="prodcut-price d-flex align-items-center position-relative">
            <ins class="font-size-20 text-red text-decoration-none">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($product->price,2)}}</ins>
            <del class="font-size-12 tex-gray-6 position-absolute bottom-100">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($product->sale_price,2)}}</del>
        </div>
    @else
    <div class="prodcut-price">
        <div class="text-gray-100">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($product->price,2)}}</div>
    </div>
    @endif

    {{--<h5>--}}
        {{--@if($product->discounted_price)--}}
            {{--<span>{{ formatCurrency($product->sale_price, config('variable.DEFAULT_CURRENCY')) }}</span>--}}
            {{--{{ formatCurrency($product->discounted_price, config('variable.DEFAULT_CURRENCY')) }}--}}
        {{--@else--}}
            {{--{{ formatCurrency($product->sale_price, config('variable.DEFAULT_CURRENCY')) }}--}}
        {{--@endif--}}
    {{--</h5>--}}
@endif
