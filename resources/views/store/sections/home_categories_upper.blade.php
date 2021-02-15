<div class="tab-content" id="Tpills-tabContent">
    @foreach(config('settings.config_home_page_categories') as  $key=>$sectionTabscat)
        <div class="tab-pane fade pt-2 show active" id="Tpills-one-example1{{$key}}" role="tabpanel" aria-labelledby="Tpills-one-example1-tab">
            <div class="row no-gutters">
                <div class="col-md-3 col-wd-4 d-md-flex d-wd-block">
                    <ul class="row list-unstyled products-group no-gutters mb-0 flex-xl-column flex-wd-row">

                        @php
                            $cat = \Modules\Category\Entities\Category :: find($sectionTabscat);

                            $pro_cat=$cat->products->take(4); //App\product_category :: where('category_id', $cat->id)->limit(4)->get();
                       // dd($pro_cat);
                        @endphp

                            @php
                               // $pro_query=\Modules\Products\Entities\Products ::where('id', $val->product_id)->get();
                            @endphp
                            @foreach($pro_cat as $pro)
                                @php
                                    $pro_image=\Modules\Products\Entities\ProductImages::where('p_id', $pro->id)->get('images')->first();
                                @endphp
                                <li class="col-xl-6 product-item max-width-xl-100 d-md-none d-wd-block product-item remove-divider">
                                    <div class="product-item__outer h-100 w-100 prodcut-box-shadow">
                                        <div class="product-item__inner bg-white p-3">
                                            <div class="product-item__body pb-xl-2">
                                                <div class="mb-2"><a href="{{url($cat->permalink->slug)}}" class="font-size-12 text-gray-5">{{$cat->name}}</a></div>
                                                <h5 class="mb-1 product-item__title"><a href="{{url($cat->permalink->slug)}}" class="text-blue font-weight-bold">{{$pro->name}}</a></h5>
                                                <div class="mb-2">
                                                    <a href="{{url($cat->permalink->slug)}}" class="d-block text-center"><img class="img-fluid" src="{{url('/public/uploads/products/'.$pro_image['images'])}}" alt="Image Description"></a>
                                                </div>
                                                <div class="flex-center-between mb-1">
                                                    <div class="prodcut-price">
                                                        @if($pro->sale_price)
                                                            <del class="font-size-11 text-gray-9 d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->price,2)}}</del>
                                                            <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->sale_price,2)}}</ins>
                                                        @else
                                                            <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->price,2)}}</ins>
                                                        @endif
                                                    </div>
                                                    <div class="d-none d-xl-block prodcut-add-cart">
                                                        <a href="#" class="btn-add-cart  card_add_to_cart btn-primary transition-3d-hover" data-product-id="{{$pro->id}}"><i class="ec ec-add-to-cart"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item__footer">
                                                <div class="border-top pt-2 flex-center-between flex-wrap">
                                                    <a href="{{ route('store-product-compare', $pro->slug) }}" class="text-gray-6 font-size-13"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                                    <a href="#" class="text-gray-6 font-size-13  trigger_wish_list" data-product-id="{{$pro->id}}"><i class="ec ec-favorites mr-1 font-size-15"></i> Add to Wishlist</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach





                    </ul>
                </div>





                <div class="col-md-6 col-wd-4 products-group-1">
                    <ul class="row list-unstyled products-group no-gutters bg-white h-100 mb-0">
                        @php
                            $cat = \Modules\Category\Entities\Category :: find($sectionTabscat);
                            $pro_cat=  $pro_cat=$cat->products->skip(4)->take(1); //App\product_category :: where('category_id', $cat->id)->skip(4)->limit(1)->get();
                        @endphp

                            @php
                              //  $pro_query=\Modules\Products\Entities\Products ::where('id', $val->product_id)->get();
                            @endphp
                            @foreach($pro_cat as $pro)
                                @php
                                    $pro_image=\Modules\Products\Entities\ProductImages::where('p_id', $pro->id)->get('images')->first();
                                @endphp
                                <li class="col product-item remove-divider">
                                    <div class="product-item__outer h-100 w-100 prodcut-box-shadow">
                                        <div class="product-item__inner bg-white p-3">
                                            <div class="product-item__body d-flex flex-column">
                                                <div class="mb-1">
                                                    <div class="mb-2"><a href="{{url($cat->permalink->slug)}}" class="font-size-12 text-gray-5">{{$cat->name}}</a></div>
                                                    <h5 class="mb-0 product-item__title"><a href="{{url($cat->permalink->slug)}}" class="text-blue font-weight-bold">{{$pro->name}}</a></h5>
                                                </div>
                                                <div class="mb-1 min-height-4-1-4">
                                                    <a href="{{url($cat->permalink->slug)}}" class="d-block text-center"><img class="img-fluid" src="{{url('/public/uploads/products/'.$pro_image['images'])}}" alt="Image Description"></a>
                                                    <!-- Gallery -->
                                                    <div class="row mx-gutters-2 mb-3">
                                                        <div class="col-auto">
                                                            <!-- Gallery -->
                                                            <a class="js-fancybox max-width-60 u-media-viewer" href="javascript:;"
                                                               data-src="{{url('/public/uploads/products/'.$pro_image['images'])}}"
                                                               data-fancybox="fancyboxGallery6"
                                                               data-caption="{{$pro->name}}"
                                                               data-speed="700"
                                                               data-is-infinite="true">
                                                                <img class="img-fluid border" src="{{url('/public/uploads/products/'.$pro_image['images'])}}" alt="Image Description">

                                                                <span class="u-media-viewer__container">
                                                                            <span class="u-media-viewer__icon">
                                                                                <span class="fas fa-plus u-media-viewer__icon-inner"></span>
                                                                            </span>
                                                                        </span>
                                                            </a>
                                                            <!-- End Gallery -->
                                                        </div>

                                                        <div class="col-auto">
                                                            <!-- Gallery -->
                                                            <a class="js-fancybox max-width-60 u-media-viewer" href="javascript:;"
                                                               data-src="{{url('/public/uploads/products/'.$pro_image['images'])}}"
                                                               data-fancybox="fancyboxGallery6"
                                                               data-caption="{{$pro->name}}"
                                                               data-speed="700"
                                                               data-is-infinite="true">
                                                                <img class="img-fluid border" src="{{url('/public/uploads/products/'.$pro_image['images'])}}">

                                                                <span class="u-media-viewer__container">
                                                                            <span class="u-media-viewer__icon">
                                                                                <span class="fas fa-plus u-media-viewer__icon-inner"></span>
                                                                            </span>
                                                                        </span>
                                                            </a>
                                                            <!-- End Gallery -->
                                                        </div>

                                                        <div class="col-auto">
                                                            <!-- Gallery -->
                                                            <a class="js-fancybox max-width-60 u-media-viewer" href="javascript:;"
                                                               data-src="{{url('/public/uploads/products/'.$pro_image['images'])}}"
                                                               data-fancybox="fancyboxGallery6"
                                                               data-caption="{{$pro->name}}"
                                                               data-speed="700"
                                                               data-is-infinite="true">
                                                                <img class="img-fluid border" src="{{url('/public/uploads/products/'.$pro_image['images'])}}">

                                                                <span class="u-media-viewer__container">
                                                                            <span class="u-media-viewer__icon">
                                                                                <span class="fas fa-plus u-media-viewer__icon-inner"></span>
                                                                            </span>
                                                                        </span>
                                                            </a>
                                                            <!-- End Gallery -->
                                                        </div>
                                                        <div class="col"></div>
                                                    </div>
                                                    <!-- End Gallery -->
                                                </div>
                                                <div class="flex-center-between">
                                                    <div class="prodcut-price">
                                                        @if($pro->sale_price)
                                                            <del class="font-size-11 text-gray-9 d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->price,2)}}</del>
                                                            <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->sale_price,2)}}</ins>
                                                        @else
                                                            <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->price,2)}}</ins>
                                                        @endif
                                                    </div>
                                                    <div class="d-none d-xl-block prodcut-add-cart">
                                                        <a href="#" class="btn-add-cart btn-add-cart__wide btn-primary transition-3d-hover card_add_to_cart" data-product-id="{{$pro->id}}"><i class="ec ec-add-to-cart mr-2"></i> Add to Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item__footer">
                                                <div class="border-top pt-2 flex-center-between flex-wrap">
                                                    <a href="{{ route('store-product-compare', $pro->slug) }}" class="text-gray-6 font-size-13"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                                    <a href="#" class="text-gray-6 font-size-13 trigger_wish_list" data-product-id="{{$pro->id}}"><i class="ec ec-favorites mr-1 font-size-15"></i> Add to Wishlist</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                    </ul>
                </div>




                <div class="col-md-3 col-wd-4 d-md-flex d-wd-block">
                    <ul class="row list-unstyled products-group no-gutters mb-0 flex-xl-column flex-wd-row">
                        @php
                            $cat = \Modules\Category\Entities\Category :: find($sectionTabscat);
                            $pro_cat=$cat->skip(5)->take(4); //App\product_category :: where('category_id', $cat->id)->skip(5)->limit(4)->get();
                        @endphp

                            @php
                             //   $pro_query=\Modules\Products\Entities\Products :: where('id', $val->product_id)->get();
                            @endphp
                            @foreach($pro_cat as $key=>$pro)

                                @php
                                    $pro_image=\Modules\Products\Entities\ProductImages::where('p_id', $pro->id)->get('images')->first();

                                @endphp
                                <li class="col-xl-6 product-item max-width-xl-100 d-md-none d-wd-block product-item remove-divider">
                                    <div class="product-item__outer h-100 w-100 prodcut-box-shadow">
                                        <div class="product-item__inner bg-white p-3">
                                            <div class="product-item__body pb-xl-2">
                                                <div class="mb-2"><a href="{{url($cat->permalink->slug)}}" class="font-size-12 text-gray-5">{{$cat->name}}</a></div>
                                                <h5 class="mb-1 product-item__title"><a href="{{url($cat->permalink->slug)}}" class="text-blue font-weight-bold">{{$pro->name}}</a></h5>
                                                <div class="mb-2">
                                                    <a href="{{url($cat->permalink->slug)}}" class="d-block text-center"><img class="img-fluid" src="{{url('/public/uploads/products/'.$pro_image['images'])}}" alt="Image Description"></a>
                                                </div>
                                                <div class="flex-center-between mb-1">
                                                    <div class="prodcut-price">
                                                        @if($pro->sale_price)
                                                            <del class="font-size-11 text-gray-9 d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->price,2)}}</del>
                                                            <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->sale_price,2)}}</ins>
                                                        @else
                                                            <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($pro->price,2)}}</ins>
                                                        @endif
                                                    </div>
                                                    <div class="d-none d-xl-block prodcut-add-cart">
                                                        <a href="#" class="btn-add-cart btn-primary card_add_to_cart transition-3d-hover" data-product-id="{{$pro->id}}"><i class="ec ec-add-to-cart" ></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-item__footer">
                                                <div class="border-top pt-2 flex-center-between flex-wrap">
                                                    <a href="{{ route('store-product-compare', $pro->slug) }}" class="text-gray-6 font-size-13"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                                    <a href="#" class="text-gray-6 font-size-13 trigger_wish_list" data-product-id="{{$pro->id}}"><i class="ec ec-favorites mr-1 font-size-15"></i> Add to Wishlist</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            @endforeach

                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>