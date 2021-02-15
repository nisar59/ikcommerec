<section class="dedicated_bnr" id="getstarted" style="background-image:url({{ asset(config('thumbnails.cms_block.original').$section->image) }});">
    	<div class="container">
        	<h2>{!! $section->title !!}</h2>
            @if($section->sub_heading)
            <h5>{!! $section->sub_heading !!}</h5>
            @endif
            @php
                //$aWindowsProducts = GetProducts($section->windows_package_ids, 'plesk');
                //$aLinuxProducts = GetProducts($section->linux_package_ids, 'cpanel');
                $aWindowsProducts = GetProducts($section->windows_package_ids);
                $aLinuxProducts = GetProducts($section->linux_package_ids);
            @endphp
            <hr class="divider scnd_divider"/>
            @if($section->description)
        {!! $section->description !!}
        @endif
            <ul class="nav nav-tabs" role="tablist">
            	<li class="nav-item">
                	<a href="#linux" class="nav-link active" data-toggle="tab" role="tab" aria-selected="false"><i class="fa fa-linux"></i>linux</a>
                </li>
                <li class="nav-item">
                	<a href="#window" class="nav-link" data-toggle="tab" role="tab" aria-selected="false"><i class="fa fa-windows"></i>window</a>
                </li>
            </ul>
            <div class="tab-content pkgs_tab">
            	<div class="tab-pane active" id="linux" role="tabpanel">
                	<div class="hosting_pkgs owl-carousel owl-theme">
                        @if(count($aLinuxProducts))
                            @foreach($aLinuxProducts as $aLinuxProduct)
                                <div class="item">
                                    <li class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="dedicated_pkg_one">
                                            <div class="srvr_img">
                                                <h3>{!! $aLinuxProduct['name'] !!}</h3>
                                                <p>Generous Space & Bandwidth For Startups</p>
                                            </div>
                                            <div class="usd_price">
                                                <p class="opacity">Normal Price: PKR5500</p>
                                                <span class="us_amount">
                                                    @if(isset($aLinuxProduct['pricing']) && isset($aLinuxProduct['pricing'][session()->get('default_currency')['code']]))
                                                        <span>
                                                            {{ getPrice($aLinuxProduct['pricing'], true, false) }}.
                                                            <span class="points_amount">{{ getPrice($aLinuxProduct['pricing'], false, true) }}</span>
                                                            <span class="yr">/yr</span>
                                                        </span>
                                                    @endif
                                                    {{--<span class="usd">PKR</span>
                                                    3999.
                                                    <span class="points_amount">99</span>
                                                    <span class="month">/mo<span class="star">*</span></span>--}}
                                                </span>
                                            </div>
                                            <div class="sale">
                                                <p class="opacity">On Sale - <span>Save 33%</span></p>
                                            </div>
                                            <ul>
                                                {!! getDescription($aLinuxProduct['description']) !!}
                                            </ul>
                                            <a target="_blank" href="{{ config('variable.WHMCS_PRODUCT_DETAIL_LINK') . $aLinuxProduct['pid'] }}">Order Now</a>
                                        </div>
                                    </li>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="tab-pane" id="window" role="tabpanel">
                	<div class="hosting_pkgs owl-carousel owl-theme">
                        @if(count($aWindowsProducts))
                            @foreach($aWindowsProducts as $aWindowsProduct)
                                <div class="item">
                                    <li class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="dedicated_pkg_one">
                                            <div class="srvr_img">
                                                <h3>{!! $aWindowsProduct['name'] !!}</h3>
                                                <p>Scalable Option For Medium To Large Enterprises</p>
                                            </div>
                                            <div class="usd_price">
                                                <p class="opacity">Normal Price: PKR8500</p>
                                                <span class="us_amount">
                                                    @if(isset($aWindowsProduct['pricing']) && isset($aWindowsProduct['pricing'][session()->get('default_currency')['code']]))
                                                        <span>
                                                            {{ getPrice($aWindowsProduct['pricing'], true, false) }}.
                                                            <span class="points_amount">{{ getPrice($aWindowsProduct['pricing'], false, true) }}</span>
                                                            <span class="yr">/yr</span>
                                                        </span>
                                                    @endif
                                                    {{--<span class="usd">PKR</span>
                                                    6499.
                                                    <span class="points_amount">99</span>
                                                    <span class="month">/mo<span class="star">*</span></span>--}}
                                                </span>
                                            </div>
                                            <div class="sale">
                                                <p class="opacity">On Sale - <span>Save 33%</span></p>
                                            </div>
                                            <ul>
                                                {!! getDescription($aWindowsProduct['description']) !!}
                                            </ul>
                                            <a target="_blank" href="{{ config('variable.WHMCS_PRODUCT_DETAIL_LINK') . $aWindowsProduct['pid'] }}">Order Now</a>
                                        </div>
                                    </li>
                                </div>
                            @endforeach
                        @endif
                    </div>
            	</div>
            </div>
        </div>
    </section>
    <section class="details_button">
    	<div class="container">
        	<a href="#" id=".responsive_plans">More Details</a>
        </div>
    </section>