@if($data['cat_featured_products']->count()>0)

<div class="mb-6 d-none d-xl-block">
    <div class="position-relative">
        <div class="border-bottom border-color-1 mb-2">
            <h3 class="d-inline-block section-title section-title__full mb-0 pb-2 font-size-22">Featured Products</h3>
        </div>
        <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble pb-7 pt-2 px-1"
             data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-3 mt-md-0"
             data-slides-show="5"
             data-slides-scroll="1"
             data-arrows-classes="position-absolute top-0 font-size-17 u-slick__arrow-normal top-10"
             data-arrow-left-classes="fa fa-angle-left right-1"
             data-arrow-right-classes="fa fa-angle-right right-0"
             data-responsive='[{
                                      "breakpoint": 1400,
                                      "settings": {
                                        "slidesToShow": 4
                                      }
                                    }, {
                                        "breakpoint": 1200,
                                        "settings": {
                                          "slidesToShow": 4
                                        }
                                    }, {
                                      "breakpoint": 992,
                                      "settings": {
                                        "slidesToShow": 3
                                      }
                                    }, {
                                      "breakpoint": 768,
                                      "settings": {
                                        "slidesToShow": 2
                                      }
                                    }, {
                                      "breakpoint": 554,
                                      "settings": {
                                        "slidesToShow": 2
                                      }
                                    }]'>
            @foreach($data['cat_featured_products'] as  $product)

            <div class="js-slide products-group">
                <div class="product-item">
                    <div class="product-item__outer h-100">
                        <div class="product-item__inner px-wd-4 p-2 p-md-3">
                            <div class="product-item__body pb-xl-2">
                                <div class="mb-2"><a href="{{ url($product->permalink->slug) }}" class="font-size-12 text-gray-5">{{ isset($data['category'])?$data['category']->name :''}}</a></div>
                                <h5 class="mb-1 product-item__title"><a href="{{ url($product->permalink->slug) }}" class="text-blue font-weight-bold">{{ $product->name }}</a></h5>
                                <div class="mb-2">
                                    @if($product->images->count()>0)
                                        @php
                                            $proImage= $product->images->first();
                                        @endphp
                                    <a href="{{ url($product->permalink->slug) }}" class="d-block text-center"><img class="img-fluid" src="{{url('public/uploads/products/'.$proImage->images)}}" alt="{{ $product->name }}"></a>@endif
                                </div>
                                <div class="flex-center-between mb-1">
                                    @include('store.product.blocks.price', ['type' => 'block'])
                                    <div class="d-none d-xl-block prodcut-add-cart">
                                        <a href="#" class="btn-add-cart btn-primary transition-3d-hover card_add_to_cart" data-product-id="{{ $product->id }}"><i class="ec ec-add-to-cart"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item__footer">
                                <div class="border-top pt-2 flex-center-between flex-wrap">
                                    <a href="{{ route('store-product-compare', $product->permalink->slug) }}" class="text-gray-6 font-size-13"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                    <a href="#" class="text-gray-6 font-size-13 trigger_wish_list" data-product-id="{{ $product->id }}"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach



        </div>
    </div>
</div>

@endif