<div class="col col-xl-auto text-right text-xl-left pl-0 pl-xl-3 position-static">
    <div class="d-inline-flex">
        <ul class="d-flex list-unstyled mb-0 align-items-center">
            <!-- Search -->
            <li class="col d-xl-none px-2 px-sm-3 position-static">
                <a id="searchClassicInvoker" class="font-size-22 text-gray-90 text-lh-1 btn-text-secondary" href="javascript:;" role="button"
                   data-toggle="tooltip"
                   data-placement="top"
                   title="Search"
                   aria-controls="searchClassic"
                   aria-haspopup="true"
                   aria-expanded="false"
                   data-unfold-target="#searchClassic"
                   data-unfold-type="css-animation"
                   data-unfold-duration="300"
                   data-unfold-delay="300"
                   data-unfold-hide-on-scroll="true"
                   data-unfold-animation-in="slideInUp"
                   data-unfold-animation-out="fadeOut">
                    <span class="ec ec-search"></span>
                </a>

                <!-- Input -->
                <div id="searchClassic" class="dropdown-menu dropdown-unfold dropdown-menu-right left-0 mx-2" aria-labelledby="searchClassicInvoker">
                    <form class="js-focus-state input-group px-3">
                        <input class="form-control" type="search" placeholder="Search Product">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-3" type="button"><i class="font-size-18 ec ec-search"></i></button>
                        </div>
                    </form>
                </div>
                <!-- End Input -->
            </li>
            <!-- End Search -->
            <li class="col d-none d-xl-block"><a href="{{url('compare')}}" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Compare"><i class="font-size-22 ec ec-compare"></i></a></li>
            <li class="col d-none d-xl-block"><a href="{{ route('store-wishlist') }}" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Favorites"><i class="font-size-22 ec ec-favorites"></i></a></li>
            <li class="col d-xl-none px-2 px-sm-3"><a href="customer/dashboard" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="My Account"><i class="font-size-22 ec ec-user"></i></a></li>
            <li class="col pr-xl-0 px-2 px-sm-3 d-xl-none">
                <a href="{{url('cart')}}" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="Cart">
                    <i class="font-size-22 ec ec-shopping-bag"></i>
                    <span class="bg-lg-down-black width-22 height-22 bg-primary position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12">2</span>
                    <span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3">$1785.00</span>
                </a>
            </li>
            <li class="col pr-xl-0 px-2 px-sm-3 d-none d-xl-block">
                <a href="{{ url('cart') }}">
                <div id="basicDropdownHoverInvoker" class="text-gray-90 position-relative d-flex" data-toggle="tooltip" data-placement="top" title="Cart"
                     aria-controls="basicDropdownHover"
                     aria-haspopup="true"
                     aria-expanded="false"
                     data-unfold-event="click"
                     data-unfold-target="#basicDropdownHover"
                     data-unfold-type="css-animation"
                     data-unfold-duration="300"
                     data-unfold-delay="300"
                     data-unfold-hide-on-scroll="true"
                     data-unfold-animation-in="slideInUp"
                     data-unfold-animation-out="fadeOut">
                    <i class="font-size-22 ec ec-shopping-bag"></i>
                    <span class="bg-lg-down-black width-22 height-22 bg-primary position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12">{{ getCartTotalItems() }}</span>
                    <span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3">{{config('variable.DEFAULT_CURRENCY')}}{{getCartTotal()}}</span>
                </div></a>
                {{--<div id="basicDropdownHover" class="cart-dropdown dropdown-menu dropdown-unfold border-top border-top-primary mt-3 border-width-2 border-left-0 border-right-0 border-bottom-0 left-auto right-0" aria-labelledby="basicDropdownHoverInvoker">--}}
                    {{--<ul class="list-unstyled px-3 pt-3">--}}
                        {{--<li class="border-bottom pb-3 mb-3">--}}
                            {{--<div class="">--}}
                                {{--<ul class="list-unstyled row mx-n2">--}}
                                    {{--<li class="px-2 col-auto">--}}
                                        {{--<img class="img-fluid" src="../../assets/img/75X75/img1.jpg" alt="Image Description">--}}
                                    {{--</li>--}}
                                    {{--<li class="px-2 col">--}}
                                        {{--<h5 class="text-blue font-size-14 font-weight-bold">Ultra Wireless S50 Headphones S50 with Bluetooth</h5>--}}
                                        {{--<span class="font-size-14">1 × $1,100.00</span>--}}
                                    {{--</li>--}}
                                    {{--<li class="px-2 col-auto">--}}
                                        {{--<a href="#" class="text-gray-90"><i class="ec ec-close-remove"></i></a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="border-bottom pb-3 mb-3">--}}
                            {{--<div class="">--}}
                                {{--<ul class="list-unstyled row mx-n2">--}}
                                    {{--<li class="px-2 col-auto">--}}
                                        {{--<img class="img-fluid" src="../../assets/img/75X75/img2.jpg" alt="Image Description">--}}
                                    {{--</li>--}}
                                    {{--<li class="px-2 col">--}}
                                        {{--<h5 class="text-blue font-size-14 font-weight-bold">Widescreen NX Mini F1 SMART NX</h5>--}}
                                        {{--<span class="font-size-14">1 × $685.00</span>--}}
                                    {{--</li>--}}
                                    {{--<li class="px-2 col-auto">--}}
                                        {{--<a href="#" class="text-gray-90"><i class="ec ec-close-remove"></i></a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<div class="flex-center-between px-4 pt-2">--}}
                        {{--<a href="{{url('cart')}}" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5">View cart</a>--}}
                        {{--<a href="{{url('checkout')}}" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5">Checkout</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </li>
        </ul>
    </div>
</div>