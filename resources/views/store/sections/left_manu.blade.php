<div class="d-none d-xl-block container">
    <div class="row">
        <!-- Vertical Menu -->
        <div class="col-md-auto d-none d-xl-block">
            <div class="max-width-270 min-width-270">
                <!-- Basics Accordion -->
                <div id="basicsAccordion">
                    <!-- Card -->
                    <div class="card border-0">
                        <div class="card-header card-collapse border-0" id="basicsHeadingOne">
                            <button type="button" class="btn-link btn-remove-focus btn-block d-flex card-btn py-3 text-lh-1 px-4 shadow-none btn-primary rounded-top-lg border-0 font-weight-bold text-gray-90"
                                    data-toggle="collapse"
                                    data-target="#basicsCollapseOne"
                                    aria-expanded="true"
                                    aria-controls="basicsCollapseOne">
                                                <span class="ml-0 text-gray-90 mr-2">
                                                    <span class="fa fa-list-ul"></span>
                                                </span>
                                <span class="pl-1 text-gray-90">All Departments</span>
                            </button>
                        </div>
                        <div id="basicsCollapseOne" class="collapse show vertical-menu"
                             aria-labelledby="basicsHeadingOne"
                             data-parent="#basicsAccordion">
                            <div class="card-body p-0">
                                <nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space hs-menu-initialized">
                                    <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
                                        <ul class="navbar-nav u-header__navbar-nav">
                                            {{--<li class="nav-item u-header__nav-item"--}}
                                                {{--data-event="hover"--}}
                                                {{--data-position="left">--}}
                                                {{--<a href="#" class="nav-link u-header__nav-link font-weight-bold">Value of the Day</a>--}}
                                            {{--</li>--}}
                                            {{--<li class="nav-item u-header__nav-item"--}}
                                                {{--data-event="hover"--}}
                                                {{--data-position="left">--}}
                                                {{--<a href="#" class="nav-link u-header__nav-link font-weight-bold">Top 100 Offers</a>--}}
                                            {{--</li>--}}

                                            <!-- Nav Item MegaMenu -->
                                                @foreach($data['manu_categories'] as $key => $asidecat)
                                                    @if($asidecat->childs->count()>0)

                                            <li class="nav-item hs-has-mega-menu u-header__nav-item"
                                                data-event="hover"
                                                data-animation-in="slideInUp"
                                                data-animation-out="fadeOut"
                                                data-position="left">
                                                <a id="basicMegaMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false">{{$asidecat->name}}</a>

                                                <!-- Nav Item - Mega Menu -->
                                                <div class="hs-mega-menu vmm-tfw u-header__sub-menu" aria-labelledby="basicMegaMenu">
                                                    {{--<div class="vmm-bg">--}}
                                                        {{--<img class="img-fluid" src="../../assets/img/500X400/img1.png" alt="Imageccc Description">--}}
                                                    {{--</div>--}}
                                                    <div class="row u-header__mega-menu-wrapper">
                                                        <div class="col mb-3 mb-sm-0">
                                                            <span class="u-header__sub-menu-title">{{$asidecat->name}}</span>
                                                            <ul class="u-header__sub-menu-nav-group mb-3">
                                                                @foreach($asidecat->childs as $key=>$subcat)
                                                                <li><a class="nav-link u-header__sub-menu-nav-link" href="{{url($subcat->permalink->slug)}}">{{$subcat->name}}</a></li>
                                                               @php
                                                              $key++;
                                                               if($key%6==0){

                                                               echo ' </ul>
                                                        </div>

                                                        <div class="col mb-3 mb-sm-0">

                                                            <ul class="u-header__sub-menu-nav-group">';
                                                               }

                                                               @endphp



                                                                 @endforeach
                                                                {{--<li><a class="nav-link u-header__sub-menu-nav-link" href="#">Laptops, Desktops & Monitors</a></li>--}}
                                                                {{--<li><a class="nav-link u-header__sub-menu-nav-link" href="#">Printers & Ink</a></li>--}}
                                                                {{--<li><a class="nav-link u-header__sub-menu-nav-link" href="#">Networking & Internet Devices</a></li>--}}
                                                                {{--<li><a class="nav-link u-header__sub-menu-nav-link" href="#">Computer Accessories</a></li>--}}
                                                                {{--<li><a class="nav-link u-header__sub-menu-nav-link" href="#">Software</a></li>--}}
                                                                {{--<li>--}}
                                                                    {{--<a class="nav-link u-header__sub-menu-nav-link u-nav-divider border-top pt-2 flex-column align-items-start" href="#">--}}
                                                                        {{--<div class="">All Electronics</div>--}}
                                                                        {{--<div class="u-nav-subtext font-size-11 text-gray-30">Discover more products</div>--}}
                                                                    {{--</a>--}}
                                                                {{--</li>--}}
                                                            </ul>
                                                        </div>


                                                    </div>
                                                </div>
                                                <!-- End Nav Item - Mega Menu -->
                                            </li>

                                                    @else
                                                        <li class="nav-item u-header__nav-item"
                                                            data-event="hover"
                                                            data-position="left">
                                                            <a class="nav-link u-header__nav-link font-weight-bold" href="{{url($asidecat->permalink->slug)}}">{{$asidecat->name}}</a>
                                                        </li>
                                                    @endif
                                                @endforeach


                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
                <!-- End Basics Accordion -->
            </div>
        </div>
        <!-- End Vertical Menu -->
        <!-- Secondary Menu -->
        <div class="col">
            <!-- Nav -->
            <nav class="js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space">
                <!-- Navigation -->
               @php
                   $data['main_menu'] = main_manu('main_menu');
                  // dd($data['main_menu']->items()->where('status',1));

               @endphp

                <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
                    <ul class="navbar-nav u-header__navbar-nav">
                        <!-- Home -->


                        <li class="nav-item hs-has-mega-menu u-header__nav-item"
                            data-event="click"
                            data-animation-in="slideInUp"
                            data-animation-out="fadeOut"
                            data-position="left">
                            {{--<a id="homeMegaMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle text-sale" href="javascript:;" aria-haspopup="true" aria-expanded="false">{!! $data['main_menu']->title !!}</a>--}}
                            <a class="nav-link u-header__nav-link"   href="{{url('/')}}" aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu" >Home</a>
                            <!-- Home - Mega Menu -->
                            <div class="hs-mega-menu w-100 u-header__sub-menu" aria-labelledby="homeMegaMenu">
                                <div class="row u-header__mega-menu-wrapper">
                                    <div class="col-md-3">


                                        {{--<ul class="u-header__sub-menu-nav-group">--}}
                                            {{--@foreach($data['main_menu']->items()->where('status',1)->get() as $menu_item_child)--}}
                                            {{--<li><a   class="nav-link u-header__sub-menu-nav-link" target="{{ $menu_item_child->target }}" href="{{ $menu_item_child->type == 'custom_link' ? $menu_item_child->url : ($menu_item_child->type == 'page' ? url($menu_item_child->page->permalink->slug) : url( $menu_item_child->category->permalink->slug)) }}">{!! $menu_item_child->title !!}</a></li>--}}
                                            {{--@endforeach--}}
                                        {{--</ul>--}}
                                    </div>
                                    {{--<div class="col-md-3">--}}
                                        {{--<span class="u-header__sub-menu-title">Shop Pages</span>--}}
                                        {{--<ul class="u-header__sub-menu-nav-group mb-3">--}}
                                            {{--<li><a href="../shop/shop-grid.html" class="nav-link u-header__sub-menu-nav-link">Shop Grid</a></li>--}}
                                            {{--<li><a href="../shop/shop-grid-extended.html" class="nav-link u-header__sub-menu-nav-link">Shop Grid Extended</a></li>--}}
                                            {{--<li><a href="../shop/shop-list-view.html" class="nav-link u-header__sub-menu-nav-link">Shop List View</a></li>--}}
                                            {{--<li><a href="../shop/shop-list-view-small.html" class="nav-link u-header__sub-menu-nav-link">Shop List View Small</a></li>--}}
                                            {{--<li><a href="../shop/shop-left-sidebar.html" class="nav-link u-header__sub-menu-nav-link">Shop Left Sidebar</a></li>--}}
                                            {{--<li><a href="../shop/shop-full-width.html" class="nav-link u-header__sub-menu-nav-link">Shop Full width</a></li>--}}
                                            {{--<li><a href="../shop/shop-right-sidebar.html" class="nav-link u-header__sub-menu-nav-link">Shop Right Sidebar</a></li>--}}
                                        {{--</ul>--}}
                                        {{--<span class="u-header__sub-menu-title">Product Categories</span>--}}
                                        {{--<ul class="u-header__sub-menu-nav-group">--}}
                                            {{--<li><a href="../shop/product-categories-4-column-sidebar.html" class="nav-link u-header__sub-menu-nav-link">4 Column Sidebar</a></li>--}}
                                            {{--<li><a href="../shop/product-categories-5-column-sidebar.html" class="nav-link u-header__sub-menu-nav-link">5 Column Sidebar</a></li>--}}
                                            {{--<li><a href="../shop/product-categories-6-column-full-width.html" class="nav-link u-header__sub-menu-nav-link">6 Column Full width</a></li>--}}
                                            {{--<li><a href="../shop/product-categories-7-column-full-width.html" class="nav-link u-header__sub-menu-nav-link">7 Column Full width</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-3">--}}
                                        {{--<span class="u-header__sub-menu-title">Single Product Pages</span>--}}
                                        {{--<ul class="u-header__sub-menu-nav-group mb-3">--}}
                                            {{--<li><a href="../shop/single-product-extended.html" class="nav-link u-header__sub-menu-nav-link">Single Product Extended</a></li>--}}
                                            {{--<li><a href="../shop/single-product-fullwidth.html" class="nav-link u-header__sub-menu-nav-link">Single Product Fullwidth</a></li>--}}
                                            {{--<li><a href="../shop/single-product-sidebar.html" class="nav-link u-header__sub-menu-nav-link">Single Product Sidebar</a></li>--}}
                                        {{--</ul>--}}
                                        {{--<span class="u-header__sub-menu-title">Ecommerce Pages</span>--}}
                                        {{--<ul class="u-header__sub-menu-nav-group">--}}
                                            {{--<li><a href="../shop/shop.html" class="nav-link u-header__sub-menu-nav-link">Shop</a></li>--}}
                                            {{--<li><a href="../shop/cart.html" class="nav-link u-header__sub-menu-nav-link">Cart</a></li>--}}
                                            {{--<li><a href="../shop/checkout.html" class="nav-link u-header__sub-menu-nav-link">Checkout</a></li>--}}
                                            {{--<li><a href="../shop/my-account.html" class="nav-link u-header__sub-menu-nav-link">My Account</a></li>--}}
                                            {{--<li><a href="../shop/track-your-order.html" class="nav-link u-header__sub-menu-nav-link">Track your Order</a></li>--}}
                                            {{--<li><a href="../shop/compare.html" class="nav-link u-header__sub-menu-nav-link">Compare</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-3">--}}
                                        {{--<span class="u-header__sub-menu-title">Blog Pages</span>--}}
                                        {{--<ul class="u-header__sub-menu-nav-group mb-3">--}}
                                            {{--<li><a href="../blog/blog-v1.html" class="nav-link u-header__sub-menu-nav-link">Blog v1</a></li>--}}
                                            {{--<li><a href="../blog/blog-v2.html" class="nav-link u-header__sub-menu-nav-link">Blog v2</a></li>--}}
                                            {{--<li><a href="../blog/blog-v3.html" class="nav-link u-header__sub-menu-nav-link">Blog v3</a></li>--}}
                                            {{--<li><a href="../blog/blog-full-width.html" class="nav-link u-header__sub-menu-nav-link">Blog Full Width</a></li>--}}
                                            {{--<li><a href="../blog/single-blog-post.html" class="nav-link u-header__sub-menu-nav-link">Single Blog Post</a></li>--}}
                                        {{--</ul>--}}
                                        {{--<span class="u-header__sub-menu-title">Shop Columns</span>--}}
                                        {{--<ul class="u-header__sub-menu-nav-group">--}}
                                            {{--<li><a href="../shop/shop-7-columns-full-width.html" class="nav-link u-header__sub-menu-nav-link">7 Column Full width</a></li>--}}
                                            {{--<li><a href="../shop/shop-6-columns-full-width.html" class="nav-link u-header__sub-menu-nav-link">6 Column Full width</a></li>--}}
                                            {{--<li><a href="../shop/shop-5-columns-sidebar.html" class="nav-link u-header__sub-menu-nav-link">5 Column Sidebar</a></li>--}}
                                            {{--<li><a href="../shop/shop-4-columns-sidebar.html" class="nav-link u-header__sub-menu-nav-link">4 Column Sidebar</a></li>--}}
                                            {{--<li><a href="../shop/shop-3-columns-sidebar.html" class="nav-link u-header__sub-menu-nav-link">3 Column Sidebar</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                            <!-- End Home - Mega Menu -->
                        </li>


                        <!-- End Home -->
                    @php
                        $data['main_menu'] = main_manu('company');
                       // dd($data['main_menu']->items()->where('status',1));

                    @endphp
                        <!-- Featured Brands -->
                        {{--@foreach($data['main_menu']->items()->where('status',1)->get() as $menu_item_child)--}}
                        <li class="nav-item u-header__nav-item">
                            <a class="nav-link u-header__nav-link"   href="{{url('about-us')}}" aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu" >About Us</a>
                            {{--<a class="nav-link u-header__nav-link"   aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu" target="{{ $menu_item_child->target }}" href="{{ $menu_item_child->type == 'custom_link' ? $menu_item_child->url : ($menu_item_child->type == 'page' ? url($menu_item_child->page->permalink->slug) : url( $menu_item_child->category->permalink->slug)) }}">{!! $menu_item_child->title !!}</a>--}}
                        </li>
                        <li class="nav-item u-header__nav-item">
                            <a class="nav-link u-header__nav-link"   href="{{url('faq')}}" aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu" >FAQ</a>
                            {{--<a class="nav-link u-header__nav-link"   aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu" target="{{ $menu_item_child->target }}" href="{{ $menu_item_child->type == 'custom_link' ? $menu_item_child->url : ($menu_item_child->type == 'page' ? url($menu_item_child->page->permalink->slug) : url( $menu_item_child->category->permalink->slug)) }}">{!! $menu_item_child->title !!}</a>--}}
                        </li>
                        <li class="nav-item u-header__nav-item">
                            <a class="nav-link u-header__nav-link"   href="{{url('contact-us')}}" aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu" >Contact</a>
                            {{--<a class="nav-link u-header__nav-link"   aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu" target="{{ $menu_item_child->target }}" href="{{ $menu_item_child->type == 'custom_link' ? $menu_item_child->url : ($menu_item_child->type == 'page' ? url($menu_item_child->page->permalink->slug) : url( $menu_item_child->category->permalink->slug)) }}">{!! $menu_item_child->title !!}</a>--}}
                        </li>
                        {{--@endforeach--}}

                        <!-- End Featured Brands -->


                    </ul>
                </div>
                <!-- End Navigation -->
            </nav>
            <!-- End Nav -->
        </div>
        <!-- End Secondary Menu -->
    </div>
</div>