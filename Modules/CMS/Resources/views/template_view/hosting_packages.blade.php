@if($section->home_packages() && $section->home_packages()->count())
    @php
        $products=GetProductsNew($data['apiPids']);
       //dd($products);
        $activePromos=GetActivePromotions();
      // dd(GetActivePromotions());
        //dd(packagePromo(125,$activePromos));

    @endphp

    <section class="deny_services pt-0" style="background-image:url({{ asset('public/assets/store/images/waves_bg.png') }});">
        <h2>{!! $section->title !!}</h2>
        @if($section->sub_heading)
        <h1>{!! $section->sub_heading !!}</h1>
        @endif
        @php

           // $aProducts = GetProducts($section->package_ids);
       // dd( $aProducts['paytype'] );
        @endphp
        <hr class="divider mb-4"/>
        @if($section->description)
        {!! $section->description !!}
        @endif
        <div class="container">
            <ul class="row">
                <div class="hosting_pkgs owl-carousel owl-theme">
                    @php
                    $r=0;
                    @endphp
                    @foreach($section->home_packages() as $key=>$package)
                    @php
                   // dd($products[$package->p_id]['pricing']);
                    $r++;
                    if(getPriceMinNew($products[$package->p_id]['pricing'], true, false, false) != '-1' ){
                    @endphp
                        <div class="item">
                            <li class="col-md-12 col-sm-12 col-xs-12">
                                <div class="dedicated_pkg_one">
                                    <div class="srvr_img">
                                        <h3>{{$package->title}}</h3>
                                        @if(isset($package->feature_1))<p>@if(isset($package->url_1))<a href="{{$package->url_1}}" > @endif{{$package->feature_1}} @if(isset($package->url_1))</a> @endif @if(isset($package->tooltip_1)) <i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_1}}</span></i>  @endif</p> @endif
                                    </div>

                                   @if($package->price_override)

                                        <div class="usd_price">

                                            <span class="us_amount">

                                                {!! $package->price_override_text !!}.
                                            <span class="points_amount"></span>
                                            <span class="month"><span class="star"></span></span>
                                        </span>
                                        </div>
                                    @else


                                    @if(isset($products[$package->p_id]['pricing']) && isset($products[$package->p_id]['pricing'][session()->get('default_currency')['code']]))

                                        @if(empty(packagePromo($package->p_id,$activePromos)))
                                            @php

                                                 $price = getPriceMin($products[$package->p_id]['pricing'], true, false, false);

                                                     if(getPriceMin($products[$package->p_id]['pricing'], true, false, false) == '$-1' || getPriceMin($products[$package->p_id]['pricing'], true, false, false) == 'Rs.-1' ){
                                                     $price = 0;

                                                     }else{
                                                     $price = getPriceMin($products[$package->p_id]['pricing'], true, false, false);

                                                     }
                                              $timePeriod=getDurationBycode(getPriceMinNotation($products[$package->p_id]['pricing']));

                                               if($package->next_currency == 1)
                                              {
                                             // dd($timePeriod);
                                              $dr =getNextCurrecny($timePeriod);
                                              //dd($dr);
                                              }else{
                                              $dr = $timePeriod;
                                              }
                                             // dd($package->next_currency);
                                              //dd ($timePeriod);
                                               $normalpricetowyears = getPriceSumary($products[$package->p_id]['pricing'], false, false, true,$dr);
                                            @endphp

                                            <div class="usd_price">

                                                <span class="us_amount">

                                                    {{ $price }}.
                                            <span class="points_amount">{{ getPriceMin($products[$package->p_id]['pricing'], false, true, false) }}</span>
                                        @if($products[$package->p_id]['paytype'] == 'onetime')
                                        <span class="month">/One time<span class="star">*</span></span>
                                          @else
                                            <span class="month">/{{getPriceMinNotation($products[$package->p_id]['pricing'])}}<span class="star">*</span></span>
                                          @endif
                                                </span>
                                            </div>
                                        @else
                       @php
                          //

                            $promotions = packagePromo($package->p_id,$activePromos);
                            $promotype = $promotions['type'];
                             $discount = $promotions['value'];
                             $promocycles = explode(',',$promotions['cycles']);
                             $basetimePeriod=getDurationBycode(getPriceMinNotation($products[$package->p_id]['pricing']));
                             $timePeriod=getDurationBycode(getPriceMinNotation($products[$package->p_id]['pricing']));
                            // dd($timePeriod);
                            // dd(ucfirst($timePeriod));

                             $base_price = getPriceMin($products[$package->p_id]['pricing'], false, false, true,$timePeriod);
                               // dd($base_price);
                             //dd($base_price);
                             if($timePeriod=='semiannually'){
                              $tr = 'Semi-Annually';
                             }else{
                             $tr = $timePeriod;
                             }
                             if(!in_array($tr,$promocycles))
                             {
                             $timePeriod = strtolower($promocycles[0]);
                             }
                            // dd(strtolower($timePeriod));
                             if($package->next_currency == 1)
                             {
                                                                  // dd($timePeriod);
                              $dr =getNextCurrecny($timePeriod);
                                                                    //dd($dr);
                              }else{
                              $dr = $timePeriod;
                              }
                             //dd($dr);
                             if($dr=='semi-annually'){
                             $dr= 'semiannually';
                             }
                                                                   // dd($package->next_currency);
                              $normalprice = getPriceMin($products[$package->p_id]['pricing'], false, false, true,$dr);                                     //dd ($normalprice);
                              $normalpricetowyears = getPriceSumary($products[$package->p_id]['pricing'], false, false, true,$dr);
                            // dd ($normalpricetowyears);
                              $promotedNormPrice = baseFactor($dr,$basetimePeriod)*$base_price;
                                                                           // dd($normalprice);
                       @endphp




                                                <div class="usd_price">
                                                <p class="opacity">Normal Price: {{ $promotedNormPrice }}</p>
                                                <span class="us_amount">

                                                   {{session()->get('default_currency')['prefix']}}{{ getPromotedPriceStraightnew($base_price,$promotype,$discount , true,false,$dr,$basetimePeriod,$promotions['cycles']) }}.
                                            <span class="points_amount">{{  getPromotedPriceStraightnew($base_price,$promotype,$discount , false,true,$dr,$basetimePeriod,$promotions['cycles']) }}</span>
                                                    @if($products[$package->p_id]['paytype'] == 'onetime')
                                                        <span class="month">/One time<span class="star">*</span></span>
                                                    @else
                                                        <span class="month">/{{getPriceMinNotation($products[$package->p_id]['pricing'])}}<span class="star">*</span></span>
                                                    @endif
                                        </span>
                                                    <p class="opacity" style="
    font-size: 12px;
    font-weight: 400;
    text-decoration: none;
">{{session()->get('default_currency')['prefix']}}{{$promotedNormPrice}}/{{getPriceMinNotation($products[$package->p_id]['pricing'])}} when you renew</p>
                                            </div>



                                        @endif

                                    @endif
                                    @if(!empty($promotions = packagePromo($package->p_id,$activePromos)))
                                        @php
                                        //dd($discount);
                                            $promo_percentage = getPromotedPercentage($promotedNormPrice,$promotype,$discount);
                                        //dd('sda');
                                        @endphp
                                        <div class="sale" >
                                            <p class="opacity">On Sale - <span>Save {{getPromotedPercentage($promotedNormPrice,$promotype,$discount)}}%</span></p>
                                        </div>
                                    @else
                                        @php
                                            $promo_percentage = null;
                                        @endphp
                                        <div class="sale" >
                                            @if(isset($package->promotional_text)) <p class="opacity">{!! $package->promotional_text !!} </p> @endif
                                        </div>
                                    @endif

                                    @endif
                                    <ul>
                                        @if(isset($package->feature_2)) <li>@if(isset($package->url_2))<a href="{{$package->url_2}}" > @endif{{$package->feature_2}} @if(isset($package->url_2))</a>   @endif @if(isset($package->tooltip_2))<i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_2}}</span></i> @endif  </li> @endif


                                        @if(isset($package->feature_3)) <li>@if(isset($package->url_3))<a href="{{$package->url_3}}" > @endif{{$package->feature_3}} @if(isset($package->url_3))</a>   @endif @if(isset($package->tooltip_3))<i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_3}}</span></i> @endif  </li> @endif

                                        @if(isset($package->feature_4)) <li>@if(isset($package->url_4))<a href="{{$package->url_4}}" > @endif{{$package->feature_4}} @if(isset($package->url_4))</a>   @endif @if(isset($package->tooltip_4)) <i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_4}}</span></i> @endif  </li> @endif


                                        @if(isset($package->feature_5)) <li>@if(isset($package->url_5))<a href="{{$package->url_5}}" > @endif{{$package->feature_5}} @if(isset($package->url_5))</a>   @endif @if(isset($package->tooltip_5)) <i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_5}}</span></i> @endif  </li> @endif


                                        @if(isset($package->feature_6)) <li>@if(isset($package->url_6))<a href="{{$package->url_6}}" > @endif {{$package->feature_6}} @if(isset($package->url_6))</a>   @endif @if(isset($package->tooltip_6)) <i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_6}}</span></i> @endif  </li> @endif



                                        @if(isset($package->feature_7)) <li> @if(isset($package->url_7))<a href="{{$package->url_7}}" > @endif {{$package->feature_7}}  @if(isset($package->url_7))</a>   @endif @if(isset($package->tooltip_7)) <i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_7}}</span></i> @endif  </li> @endif


                                        @if(isset($package->feature_8)) <li> @if(isset($package->url_8))<a href="{{$package->url_8}}" > @endif  {{$package->feature_8}}  @if(isset($package->url_8))</a>   @endif @if(isset($package->tooltip_8)) <i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_8}}</span></i> @endif  </li> @endif




                                             @if(isset($package->feature_9)) <li> @if(isset($package->url_9))<a href="{{$package->url_9}}" > @endif {{$package->feature_9}}  @if(isset($package->url_9))</a>   @endif @if(isset($package->tooltip_9)) <i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_9}}</span></i> @endif  </li> @endif




                                      @if(isset($package->feature_10)) <li> @if(isset($package->url_10))<a href="{{$package->url_10}}" > @endif {{$package->feature_10}}  @if(isset($package->url_10))</a> @endif @if(isset($package->tooltip_10)) <i class="fa fa-info-circle"><span class="litooltip">{{$package->tooltip_10}}</span></i> @endif  </li> @endif

                                    </ul>
                                    @php
                                        $queryString='/cart.php?a=add&pid='.$package->p_id.'&currency='.getCurrencyID();
                                        if(isset($promotions['code'])){
                                        $queryString.= '&promocode='.$promotions['code'];
                                        }
                                    @endphp
                                    {{--<a href="{{config('settings.config_apiweb_url')}}{{$queryString}}">order now</a>--}}
                                    {{--<a href="{{config('settings.config_apiweb_url')}}{{$queryString}}">order now</a>--}}
                                    <form action="{{url('cart/add')}}" method="post" >
                                        {{csrf_field()}}
                                        @if($package->price_override)

                                            <button type="submit" disabled>Order Now</button>
                                        @else
                                        <input type="hidden" name="product_id" value="{{$package->p_id}}">
                                        <input type="hidden" name="package_name" value="{{$package->title}}">
                                        <input type="hidden" name="package_quantitiy" value="1">
                                        @php
                                            if($normalpricetowyears == '$-1' || $normalpricetowyears == 'Rs.-1' ){
                                                     $price = 0;

                                                     }else{
                                                     $price = $normalpricetowyears;
                                                  // dd($price);
                                                     }
                                       // dd($promotions);
                                        @endphp
                                        <input type="hidden" name="package_normal_price" value="{{$price}}">
                                        <input type="hidden" name="package_promo" value="{{isset($promotions['code'])?$promotions['code']:null}}">
                                        <input type="hidden" name="package_promo_type" value="{{isset($promotions['type'])?$promotions['type']:null}}">
                                        <input type="hidden" name="package_promo_value" value="{{isset($promotions['value'])?$promotions['value']:null}}">
                                            <input type="hidden" name="package_promo_cycle" value="{{isset($promotions['cycles'])?$promotions['cycles']:null}}">
                                        <input type="hidden" name="package_currency" value="{{session()->get('default_currency')['code']}}">
                                        <input type="hidden" name="currncy_code" value="{{getCurrencyID()}}">
                                        @if(!empty($promotions = packagePromo($package->p_id,$activePromos)))
                                            <input type="hidden" name="package_promoted_price"
                   value="{{ getPromotedPriceStraightnew($base_price,$promotype,$discount , true,false,$dr,$basetimePeriod,$promotions['cycles']) }}.{{getPromotedPriceStraightnew($base_price,$promotype,$discount , false,true ,$dr,$basetimePeriod,$promotions['cycles']) }}">
                                                <input type="hidden" name="package_base_price" value="{{$base_price}}">
                                                <input type="hidden" name="package_base_duration" value="{{getDurationBycode(getPriceMinNotation($products[$package->p_id]['pricing']))}}">
                                        @else
                                            <input type="hidden" name="package_promoted_price" value="{{$price}}">
                                        @endif
                                        <input type="hidden" name="package_percentage" value="{{isset($promo_percentage)?$promo_percentage:null}}">

                                            <input type="hidden" name="package_billingcycle" value="{{$dr}}">
                                        <button type="submit">Order Now</button>
                                           @endif

                                    </form>
                                </div>
                            </li>
                        </div>
                     @php
                     }
                     @endphp
                    @endforeach

                </div>
            </ul>
        </div>
    </section>

@endif

@push('css')

@if(isset($r) && $r<=3)


<style>
   .deny_services .owl-carousel .owl-nav button.owl-prev  {
      display: none;
    }
    .deny_services .owl-carousel .owl-nav button.owl-next  {
        display: none;
    }



</style>
@endif
@endpush
