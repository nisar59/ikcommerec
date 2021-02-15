
<section class="deny_services" style="background-image:url({{ asset('public/assets/store/images/waves_bg.png') }});">
    <div class="domain_searching">
        <div class="container">
            <div class="row">
                <div class="col-md-12 pl-5 pr-5 col-sm-12 col-xs-12">
                    <span>Let's get started! </span>
                    <div class="bg-dark pt-3 pl-5 pr-5 pb-3">
                        <form action="{{url('cart/addDomain')}}" method="post"  id='search-form'>
                            {{csrf_field()}}
                        <div class="input-group">
                            <input type="search"  required="" pattern="^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$"  name="domain"   class="form-control" placeholder="Search your domain here..." title="Please provide valid domain"/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary m-0  g-recaptcha" data-badge="bottomleft"  data-sitekey="6LcqVawZAAAAAMLoXFi4PcikBY_UQKl_Xdo1cCzw" data-callback='onSubmit' type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        </form>
                        <div class="row">

                            <div class="col-md-12 pr-5 pl-5 col-sm-12 col-xs-12 mt-2 domain_extntn">
                                <ul class="row">
                                    @php
                                    $aTLDs = GetTLDPricing();
                                   // dd($aTLDs);
                                    $spotLightTlds=spotLighttlds();
                                  //  dd($spotLightTlds);

                                    @endphp
                                    @if(count($aTLDs))
                                        @php
                                        $r=0;
                                        @endphp
                                        @foreach($aTLDs as $iKey => $aTLD)
                                           @php
                                          // dd($aTLD['tld']);
                                               $pkDomainTld = explode('.',$aTLD['tld']);
                                            @endphp
                                            @if(in_array('.'.$aTLD['tld'],$spotLightTlds))
                                           @if(isset($aTLD['register']))
                                            <li>
                                                <span class="domian_catgry"><font style="color:#2ed02e;">.</font>{{$aTLD['tld'] }}</span>
                                          @if(in_array('pk',$pkDomainTld))
                                                    <span class="domains_price">{!! session()->get('default_currency')['prefix'] !!}{{ getNicePrices($aTLD['register'][2]) }}/2yrs</span>
                                             @else

                                                <span class="domains_price">{!! session()->get('default_currency')['prefix'] !!}{{ getNicePrices($aTLD['register'][1]) }}/yr</span>
                                              @endif
                                            </li>
                                               @endif

                                            @endif
                                        @endforeach
                                    @endif

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
