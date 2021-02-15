<aside id="sidebarHeader1" class="u-sidebar u-sidebar--left" aria-labelledby="sidebarHeaderInvoker">
    <div class="u-sidebar__scroller">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">
                <!-- Toggle Button -->
                <div class="position-absolute top-0 right-0 z-index-2 pt-4 pr-4 bg-white">
                    <button type="button" class="close ml-auto"
                            aria-controls="sidebarHeader"
                            aria-haspopup="true"
                            aria-expanded="false"
                            data-unfold-event="click"
                            data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarHeader1"
                            data-unfold-type="css-animation"
                            data-unfold-animation-in="fadeInLeft"
                            data-unfold-animation-out="fadeOutLeft"
                            data-unfold-duration="500">
                        <span aria-hidden="true"><i class="ec ec-close-remove text-gray-90 font-size-20"></i></span>
                    </button>
                </div>
                <!-- End Toggle Button -->

                <!-- Content -->
                <div class="js-scrollbar u-sidebar__body">
                    <div id="headerSidebarContent" class="u-sidebar__content u-header-sidebar__content">
                        <!-- Logo -->
                        <a class="navbar-brand u-header__navbar-brand u-header__navbar-brand-center mb-3" href="{{url('/')}}" aria-label="{{config('settings.config_site_title')}}">
                            <img src="{{url(config('variable.LOGO_PATH').config('settings.config_site_logo'))}}"  alt="{{config('settings.config_site_title')}}"  title="{{config('settings.config_site_title')}}">
                        </a>
                        <!-- End Logo -->

                        <!-- List -->
                        <ul id="headerSidebarList" class="u-header-collapse__nav">



                          @foreach($data ['manu_categories'] as $key => $asidecat)
                            @if($asidecat->childs->count()>0)

                            <li class="u-has-submenu u-header-collapse__submenu">
                                <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" data-target="#headerSidebarComputersCollapse{{$asidecat->id}}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarComputersCollapse">
                                    {{$asidecat->name}}
                                </a>

                                <div id="headerSidebarComputersCollapse{{$asidecat->id}}" class="collapse" data-parent="#headerSidebarContent">
                                    <ul class="u-header-collapse__nav-list">
                                       @foreach($asidecat->childs as $subcat)
                                        {{--<li><span class="u-header-sidebar__sub-menu-title">Computers &amp; Accessories</span></li>--}}
                                        <li class=""><a class="u-header-collapse__submenu-nav-link" href="{{url($subcat->permalink->slug)}}">{{$subcat->name}}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </li>
                                 @else
                            <li class="">
                            <a class="u-header-collapse__nav-link font-weight-bold" href="{{url($asidecat->permalink->slug)}}">{{$asidecat->name}}</a>
                            </li>
                             @endif

                            @endforeach
 </ul>
<!-- End List -->
</div>
</div>
<!-- End Content -->
</div>
<!-- Footer -->
<footer id="SVGwaveWithDots" class="svg-preloader u-header-sidebar__footer">
<ul class="list-inline mb-0">
<li class="list-inline-item pr-3">
<a class="u-header-sidebar__footer-link text-gray-90" href="#">Privacy</a>
</li>
<li class="list-inline-item pr-3">
<a class="u-header-sidebar__footer-link text-gray-90" href="#">Terms</a>
</li>
<li class="list-inline-item">
<a class="u-header-sidebar__footer-link text-gray-90" href="#">
<i class="fas fa-info-circle"></i>
</a>
</li>
</ul>

<!-- SVG Background Shape -->
<div class="position-absolute right-0 bottom-0 left-0 z-index-n1">
<img class="js-svg-injector" src="{{url('public/assets/store/assets/svg/components/wave-bottom-with-dots.svg')}}" alt="Image Description"
data-parent="#SVGwaveWithDots">
</div>
<!-- End SVG Background Shape -->
</footer>
<!-- End Footer -->
</div>
</div>
</aside>