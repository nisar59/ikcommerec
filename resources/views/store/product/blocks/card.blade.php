<div class="item">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="clean_buy">
            <div class="clean_img">
                <a href="{{ route('store-url', $product->uri->slug) }}">
                    {{ HTML::image(config('image.product.small').$product->sku.'/'.$product->image, $product->title, array('class' => '')) }}
                    {{--<img src="{{url('small/'.$product->image)}}" />--}}
                </a>
            </div>
            <div class="clean_detail">
                <p>
                    <a href="{{ route('store-url', $product->uri->slug) }}">{{ $product->title }}</a>
                </p>
                @include('store.product.blocks.price', ['type' => 'block'])
                <div class="add_cart">
                    <ul>
                        <li><a href="{{ route('store-product-compare', $product->uri->slug) }}">{{ HTML::image('public/assets/store/images/compare.png', config('app.name'), array('class' => '')) }}</a></li>
                        <li><a href="javascript:void(0)" class="card_add_to_cart" data-product-id="{{ $product->id }}">Add to Cart</a></li>
                        <li><a href="javascript:void(0)" class="trigger_wish_list" data-product-id="{{ $product->id }}"><i class="fa {{ in_array($product->id, getWishListIds()) ? "fa-heart" : "fa-heart-o" }}"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
