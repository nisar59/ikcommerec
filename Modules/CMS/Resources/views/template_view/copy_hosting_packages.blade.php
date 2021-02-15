<section class="deny_services pt-0" style="background-image:url({{ asset('public/assets/store/images/waves_bg.png') }});">
    <h2>{!! $section->title !!}</h2>
    {!! $section->description !!}
    @php
        $aProducts = GetProducts($section->package_ids);
    @endphp
    <hr class="divider mb-4"/>
    <div class="container">
        <ul class="row">
            <div class="hosting_pkgs owl-carousel owl-theme">
                @if(count($aProducts))
                    @foreach($aProducts as $aProduct)
                        <div class="item">
                            <li class="col-md-12 col-sm-12 col-xs-12">
                                <div class="deny_one">
                                    <div class="deny_header">
                                        <h5>{!! $aProduct['name'] !!}</h5>
                                        @if(isset($aProduct['pricing']) && isset($aProduct['pricing'][session()->get('default_currency')['code']]))
                                            <span>
                                                {{ getPrice($aProduct['pricing'], true, false) }}.
                                                <span class="dot_nine">{{ getPrice($aProduct['pricing'], false, true) }}</span>
                                                <span class="yr">/yr</span>
                                            </span>
                                        @endif
                                        <a target="_blank" href="{{ config('variable.WHMCS_PRODUCT_DETAIL_LINK') . $aProduct['pid'] }}">Order Now</a>
                                    </div>
                                    <ul>
                                        {!! getDescription($aProduct['description']) !!}
                                    </ul>
                                </div>
                            </li>
                        </div>
                    @endforeach
                @endif
                {{--<div class="item">
                    <li class="col-md-12 col-sm-12 col-xs-12">
                        <div class="deny_one">
                            <div class="deny_header">
                                <h5>Business Hosting</h5>
                                <span>PKR5149.<span class="dot_nine">99</span><span class="yr">/yr</span></span>
                                <button>Order Now</button>
                            </div>
                            <ul>
                                <li>No Setup Fees</li>
                                <li>Unlimited Web Space</li>
                                <li>Unlimited Data Transfer</li>
                                <li>Free .com Domain</li>
                            </ul>
                        </div>
                    </li>
                </div>
                <div class="item">
                    <li class="col-md-12 col-sm-12 col-xs-12">
                        <div class="deny_one">
                            <div class="deny_header">
                                <h5>Business Hosting</h5>
                                <span>PKR5149.<span class="dot_nine">99</span><span class="yr">/yr</span></span>
                                <button>Order Now</button>
                            </div>
                            <ul>
                                <li>No Setup Fees</li>
                                <li>Unlimited Web Space</li>
                                <li>Unlimited Data Transfer</li>
                                <li>Free .com Domain</li>
                            </ul>
                        </div>
                    </li>
                </div>
                <div class="item">
                    <li class="col-md-12 col-sm-12 col-xs-12">
                        <div class="deny_one">
                            <div class="deny_header">
                                <h5>Business Hosting</h5>
                                <span>PKR5149.<span class="dot_nine">99</span><span class="yr">/yr</span></span>
                                <button>Order Now</button>
                            </div>
                            <ul>
                                <li>No Setup Fees</li>
                                <li>Unlimited Web Space</li>
                                <li>Unlimited Data Transfer</li>
                                <li>Free .com Domain</li>
                            </ul>
                        </div>
                    </li>
                </div>--}}
            </div>
        </ul>
    </div>
</section>