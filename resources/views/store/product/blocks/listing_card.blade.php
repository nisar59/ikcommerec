
@if($data['products'])
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab" data-target-group="groups">
        <ul class="row list-unstyled products-group no-gutters">
            @php
                $r=0;
            @endphp
            @foreach($data['products'] as  $product)
                @php
                    $r++;
                $cls = 'col-6 col-md-3 col-wd-2gdot4 product-item';
                if($r%4==0){
                $cls.=' remove-divider-md-lg remove-divider-xl';
                }
                @endphp
                <li class="{{$cls}}">
                    <div class="product-item__outer h-100">
                        <div class="product-item__inner px-xl-4 p-3">
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
                </li >
            @endforeach

        </ul>
    </div>
    @if($data['products'])
    <div class="tab-pane fade pt-2" id="pills-three-example1" role="tabpanel" aria-labelledby="pills-three-example1-tab" data-target-group="groups">
        <ul class="d-block list-unstyled products-group prodcut-list-view">
            @php
                $r=0;
            @endphp
            @foreach($data['products'] as  $product)
                @php
                    $r++;
                $cls = 'col-6 col-md-3 col-wd-2gdot4 product-item';
                if($r%4==0){
                $cls.=' remove-divider-md-lg remove-divider-xl';
                }
                @endphp
            <li class="product-item remove-divider">
                <div class="product-item__outer w-100">
                    <div class="product-item__inner remove-prodcut-hover py-4 row">
                        <div class="product-item__header col-6 col-md-4">
                            <div class="mb-2">
                                @if($product->images->count()>0)
                                    @php
                                        $proImage= $product->images->first();
                                    @endphp
                                <a href="{{ url($product->permalink->slug) }}" class="d-block text-center"><img class="img-fluid" src="{{url('public/uploads/products/'.$proImage->images)}}" alt="{{ $product->name }}"></a>  @endif
                            </div>
                        </div>
                        <div class="product-item__body col-6 col-md-5">
                            <div class="pr-lg-10">
                                <div class="mb-2"><a href="{{ url($product->permalink->slug) }}" class="font-size-12 text-gray-5">{{ isset($data['category'])?$data['category']->name :'' }}</a></div>
                                <h5 class="mb-2 product-item__title"><a href="{{ url($product->permalink->slug) }}" class="text-blue font-weight-bold">{{ $product->name }}</a></h5>
                                @include('store.product.blocks.price', ['type' => 'block'])
                                @if($product->enable_reviews)
                                <div class="mb-3 d-none d-md-block">
                                    <a class="d-inline-flex align-items-center small font-size-14" href="#">
                                        <div class="text-warning mr-2">
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="far fa-star text-muted"></small>
                                        </div>
                                        <span class="text-secondary">(40)</span>
                                    </a>
                                </div>
                                @endif
                              {!! $product->short_description !!}
                            </div>
                        </div>
                        <div class="product-item__footer col-md-3 d-md-block">
                            <div class="mb-3">
                                @include('store.product.blocks.price', ['type' => 'block'])
                                <div class="prodcut-add-cart">
                                    <a href="#" class="btn btn-sm btn-block btn-primary-dark btn-wide transition-3d-hover card_add_to_cart" data-product-id="{{ $product->id }}">Add to cart</a>
                                </div>
                            </div>
                            <div class="flex-horizontal-center justify-content-between justify-content-wd-center flex-wrap">
                                <a href="{{ route('store-product-compare', $product->permalink->slug) }}" class="text-gray-6 font-size-13 mx-wd-3"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                <a href="#" class="text-gray-6 font-size-13 mx-wd-3 trigger_wish_list" data-product-id="{{ $product->id }}"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
           @endforeach
        </ul>
    </div>
     @endif
</div>
@endif