<div class="d-xl-none col col-xl-auto text-right text-xl-left pl-0 pl-xl-3 position-static">
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
            <li class="col d-xl-none px-2 px-sm-3"><a href="dashboard" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="My Account"><i class="font-size-22 ec ec-user"></i></a></li>
            <li class="col pr-xl-0 px-2 px-sm-3"><a href="{{ url('cart') }}" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="Cart"></a></li>
        </ul>
    </div>
</div>