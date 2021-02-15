@if($data['latest_products']->count()>0)
<div class="mb-8">
    <div class="border-bottom border-color-1 mb-5">
        <h3 class="section-title section-title__sm mb-0 pb-2 font-size-18">Latest Products</h3>
    </div>
    <ul class="list-unstyled">
        @foreach($data['latest_products'] as  $product)

        <li class="mb-4">
            <div class="row">
                <div class="col-auto">
                    <a href="{{ url($product->permalink->slug) }}" class="d-block width-75">
                        @if($product->images->count()>0)
                            @php
                                $proImage= $product->images->first();
                            @endphp
                        <img class="img-fluid" src="{{url('public/uploads/products/'.$proImage->images)}}" alt="{{ $product->name }}">
                          @endif
                    </a>
                </div>
                <div class="col">
                    <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="{{ url($product->permalink->slug) }}">{{ $product->name }}</a></h3>
                    <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="far fa-star text-muted"></small>
                    </div>
                    <div class="font-weight-bold">
                        @if($product->sale_price)
                        <del class="font-size-11 text-gray-9 d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($product->price,2)}}</del>
                        <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($product->sale_price,2)}}</ins>
                        @else
                            <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($product->price,2)}}</ins>
                        @endif
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>

@endif