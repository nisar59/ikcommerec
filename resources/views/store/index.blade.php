@extends('store.layouts.template')
@section('content')

    <!-- Slider Section -->
    @include('store.sections.sliders')

    <!-- End Slider Section -->
    <div class="container">
        <!-- Banner -->

    @include('store.sections.home_below_banner_cats')
     <!-- End Banner -->
        <!-- Deals-and-tabs -->
        <div class="mb-5">
            <div class="row">
                <!-- Deal -->
               @if(config('settings.config_home_page_special_offer'))
                   @php
                   $sproduct = offerProduct(config('settings.config_home_page_special_offer'));
                 //  dd($sproduct);
                   @endphp
                <div class="col-md-auto mb-6 mb-md-0">
                    <div class="p-3 border border-width-2 border-primary borders-radius-20 bg-white min-width-370">
                        <div class="d-flex justify-content-between align-items-center m-1 ml-2">
                            <h3 class="font-size-22 mb-0 font-weight-normal text-lh-28 max-width-120">Special Offer</h3>
                          @if($sproduct->sale_price>0)
                           @php
                           $pr = $sproduct->price - $sproduct->sale_price
                           @endphp
                            <div class="d-flex align-items-center flex-column justify-content-center bg-primary rounded-pill height-75 width-75 text-lh-1">
                                <span class="font-size-12">Save</span>
                                <div class="font-size-20 font-weight-bold">{{config('variable.DEFAULT_CURRENCY')}}{{$pr}}</div>
                            </div>
                           @endif
                        </div>
                        <div class="mb-4">
                            @if($sproduct->images->count()>0)
                                @php
                                    $proImage= $sproduct->images->first();
                                @endphp  <a href="{{ url($sproduct->permalink->slug) }}" class="d-block text-center"><img class="img-fluid" src="{{url('public/uploads/products/'.$proImage->images)}}" alt="{{ $sproduct->name }}"></a>@endif
                        </div>
                        <h5 class="mb-2 font-size-14 text-center mx-auto max-width-180 text-lh-18"><a href="{{ url($sproduct->permalink->slug) }}" class="text-blue font-weight-bold">{{ $sproduct->name }}</a></h5>
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            @if($sproduct->sale_price)
                                <del class="font-size-11 text-gray-9 d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($sproduct->price,2)}}</del>
                                <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($sproduct->sale_price,2)}}</ins>
                            @else
                                <ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($sproduct->price,2)}}</ins>
                            @endif
                        </div>
                        <div class="mb-3 mx-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="">Availavle: <strong>{{$sproduct->quantity}}</strong></span>
                                <span class="">Already Sold: <strong>{{$sproduct->sold}}</strong></span>
                            </div>
                            <div class="rounded-pill bg-gray-3 height-20 position-relative">
                                <span class="position-absolute left-0 top-0 bottom-0 rounded-pill w-30 bg-primary"></span>
                            </div>
                        </div>

                    </div>
                </div>

                @endif
                <!-- End Deal -->
                <!-- Tab Prodcut -->
                <div class="col">
                    <!-- Features Section -->
                    <div class="">
                        <!-- Nav Classic -->

                        <div class="position-relative bg-white text-center z-index-2">

                            <ul class="nav nav-classic nav-tab justify-content-center" id="pills-tab" role="tablist">

                          @php
                          $tabHeadings = array('featured'=>'Featured','on_sale'=>'On Sale','reviewed'=>'Reviewed','recent'=>'Recent','best_seller'=>'Best Seller','viewed'=>'Most Viewed')
                          @endphp
                          @foreach(config('settings.config_home_page_section_1') as  $key=>$section1Tabs)
                                <li class="nav-item">
                                    <a class="nav-link @if($key==0) active @endif " id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1{{$section1Tabs}}" role="tab" aria-controls="pills-one-example1{{$section1Tabs}}" aria-selected="true">
                                        <div class="d-md-flex justify-content-md-center align-items-md-center">
                                           {{$tabHeadings[$section1Tabs]}}
                                        </div>
                                    </a>
                                </li>
                           @endforeach

                            </ul>
                        </div>
                        <!-- End Nav Classic -->

                        <!-- Tab Content -->
                        <div class="tab-content" id="pills-tabContent">
                            @foreach(config('settings.config_home_page_section_1') as  $key=>$section1Tabs)
                            <div class="tab-pane fade pt-2 @if($key==0) show active @endif" id="pills-one-example1{{$section1Tabs}}" role="tabpanel" aria-labelledby="pills-one-example1-tab">
                               @php
                               if($section1Tabs=='featured'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->where('featured',1)->get();
                               }
                               if($section1Tabs=='on_sale'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->where('sale_price','>',0)->get();
                               }
                               if($section1Tabs=='reviewed'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('reviewed','desc')->get();
                               }
                               if($section1Tabs=='recent'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('created_at','desc')->get();
                               }
                               if($section1Tabs=='best_seller'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('sold','desc')->get();
                               }
                               if($section1Tabs=='viewed'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('reviewed','desc')->get();
                               }

                               $r=0;
                               @endphp
                                <ul class="row list-unstyled products-group no-gutters">
                                    @foreach($products as  $product)
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
                           @endforeach


                        </div>
                        <!-- End Tab Content -->
                    </div>
                    <!-- End Features Section -->
                </div>
                <!-- End Tab Prodcut -->
            </div>
        </div>
        <!-- End Deals-and-tabs -->
    </div>
    <!-- Products-4-1-4 -->
    <div class="products-group-4-1-4 space-1 bg-gray-7">
        <h2 class="sr-only">Products Grid</h2>
        <div class="container">
            <!-- Nav Classic -->
            <div class="position-relative text-center z-index-2 mb-3">
                <ul class="nav nav-classic nav-tab nav-tab-sm px-md-3 justify-content-start justify-content-lg-center flex-nowrap flex-lg-wrap overflow-auto overflow-lg-visble border-md-down-bottom-0 pb-1 pb-lg-0 mb-n1 mb-lg-0" id="pills-tab-1" role="tablist">
                    @foreach(config('settings.config_home_page_categories') as  $key=>$sectionTabscat)
                      @php
                      $cat = \Modules\Category\Entities\Category :: find($sectionTabscat);
                      @endphp
                    <li class="nav-item flex-shrink-0 flex-lg-shrink-1">
                        <a class="nav-link @if($key==0) active @endif " id="Tpills-one-example1-tab" data-toggle="pill" href="#Tpills-one-example1{{$sectionTabscat}}" role="tab" aria-controls="Tpills-one-example1{{$sectionTabscat}}" aria-selected="true">
                            <div class="d-md-flex justify-content-md-center align-items-md-center">
                                {{$cat->name}}
                            </div>
                        </a>
                    </li>
                    @endforeach

                </ul>
            </div>
            <!-- End Nav Classic -->

            <!-- Tab Content -->

            @include('store.sections.home_categories_upper')

            <!-- End Tab Content -->
        </div>

        <!-- Features Section -->
       @include('store.sections.home_categories')

        <!-- End Features Section -->
    </div>
    <!-- End Products-4-1-4 -->
    <div class="container">
        <!-- Prodcut-cards-carousel -->
        <div class="space-top-2">


           @php
           $sectionTab2 =config('settings.config_home_page_section_2');
                               if($sectionTab2=='featured'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->where('featured',1)->get();
                               }
                               if($sectionTab2=='on_sale'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->where('sale_price','>',0)->get();
                               }
                               if($sectionTab2=='reviewed'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('reviewed','desc')->get();
                               }
                               if($sectionTab2=='recent'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('created_at','desc')->get();
                               }
                               if($sectionTab2=='best_seller'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('sold','desc')->get();
                               }
                               if($sectionTab2=='viewed'){
                               $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('reviewed','desc')->get();
                               }
          @endphp

            <div class="mb-6">
                <div class="position-relative">
                    <div class="border-bottom border-color-1 mb-2">
                        <h3 class="section-title mb-0 pb-2 font-size-22"> {{$tabHeadings[$sectionTab2]}}</h3>
                    </div>
                    <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble pb-7 pt-2 px-1"
                         data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-3 mt-md-0"
                         data-slides-show="7"
                         data-slides-scroll="1"
                         data-arrows-classes="position-absolute top-0 font-size-17 u-slick__arrow-normal top-10"
                         data-arrow-left-classes="fa fa-angle-left right-1"
                         data-arrow-right-classes="fa fa-angle-right right-0"
                         data-responsive='[{
                              "breakpoint": 1400,
                              "settings": {
                                "slidesToShow": 6
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
                        @foreach($products as  $product)

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
            </div>
        </div>
        <!-- End Prodcut-cards-carousel -->
        <!-- Full banner -->
        @if(config('settings.config_horizantal_banner'))
        <div class="mb-6">
            <a href="{{config('settings.config_home_horizantal_banner_link')}}">
                <img src="{{config('variable.LOGO_PATH').config('settings.config_horizantal_banner')}}" class="img-fluid" alt="">
            </a>
        </div>
        @endif
        <!-- End Full banner -->
        <!-- Recently viewed -->
        @php
            $sectionTab3 =config('settings.config_home_page_section_3');
                                if($sectionTab3=='featured'){
                                $products = \Modules\Products\Entities\Products::where('status',1)->where('featured',1)->get();
                                }
                                if($sectionTab3=='on_sale'){
                                $products = \Modules\Products\Entities\Products::where('status',1)->where('sale_price','>',0)->get();
                                }
                                if($sectionTab3=='reviewed'){
                                $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('reviewed','desc')->get();
                                }
                                if($sectionTab3=='recent'){
                                $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('created_at','desc')->get();
                                }
                                if($sectionTab3=='best_seller'){
                                $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('sold','desc')->get();
                                }
                                if($sectionTab3=='viewed'){
                                $products = \Modules\Products\Entities\Products::where('status',1)->orderBy('reviewed','desc')->get();
                                }
        @endphp
<div class="container">
        <div class="mb-6">
            <div class="position-relative">
                <div class="border-bottom border-color-1 mb-2">
                    <h3 class="section-title mb-0 pb-2 font-size-22"> {{$tabHeadings[$sectionTab3]}}</h3>
                </div>
                <div class="js-slick-carousel u-slick position-static overflow-hidden u-slick-overflow-visble pb-7 pt-2 px-1"
                     data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-3 mt-md-0"
                     data-slides-show="7"
                     data-slides-scroll="1"
                     data-arrows-classes="position-absolute top-0 font-size-17 u-slick__arrow-normal top-10"
                     data-arrow-left-classes="fa fa-angle-left right-1"
                     data-arrow-right-classes="fa fa-angle-right right-0"
                     data-responsive='[{
                              "breakpoint": 1400,
                              "settings": {
                                "slidesToShow": 6
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
                    @foreach($products as  $product)

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
</div>
        <!-- End Recently viewed -->
        <!-- Brand Carousel -->
       @include('store.sections.brands')
        <!-- End Brand Carousel -->
    </div>


@endsection





@push('metaInfo')
    {!! config('settings.config_schema') !!}
    <title>{{ config('settings.config_meta_title') ? config('settings.config_meta_title') : config('app.name') }}</title>
    <meta name="title" content="{{ config('settings.config_meta_title') }}">
    <meta name="description" content="{{ config('settings.config_meta_description') }}">
    <meta name="keywords" content="{{ config('settings.config_meta_keywords') }}">
@endpush




