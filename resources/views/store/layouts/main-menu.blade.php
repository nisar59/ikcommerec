@isset($data['main_menu'])
    @if($data['main_menu']->count() > 0 )
        @if($data['agent']->isDesktop())
            <div class="navbar first navbar-expand-md bg-dark">
                <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target" ><i class="fa fa-bars"></i></button>
                <div class="container">
                    <div class="collapse navbar-collapse" id="collapse_target">
                        <ul class="navbar-nav">
                            @foreach($data['main_menu'] as $menuItem)
                                <li class="nav-item{{ $menuItem->awesome_font }} {{ ($menuItem->hasChild() ? "drpdn" : "") }}">
                                    <a href="{{ $menuItem->getAction() }}" class="nav-link active">{{ $menuItem->title }}</a>
                                    @if($menuItem->hasChild())
                                        <div class="megadrop">
                                            <div class="container">
                                                <div class="mega_menu_bg row">
                                                    @if($menuItem->childs()->get()->where('is_featured', 1)->count() == 0)
                                                        @foreach($menuItem->childs()->get()->take(3) as $subItem)
                                                            <div class="rugs_clrs mega_columns">
                                                                <ul>
                                                                    <h5>{{ $subItem->title }}</h5>
                                                                    @if($subItem->childs()->get()->count() > 0)
                                                                        @foreach($subItem->childs()->get()->take(5) as $childItem)
                                                                            <li>
                                                                                <a href="{{ $childItem->getAction() }}">
                                                                                    {{ $childItem->title }}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="rugs_colors_imgs">
                                                            <h5>{{ $menuItem->mega_menu_heading }}</h5>
                                                            <ul>
                                                                @foreach($menuItem->childs()->get()->where('is_featured', 1)->take(5) as $subItem)
                                                                    <li>
                                                                        <a href="{{ $subItem->getAction() }}">
                                                                            {{ HTML::image($subItem->getFeaturedImage('menu-item', 'thumb-1'), $subItem->title, array('class' => '')) }}
                                                                            <p>{{ $subItem->title }}</p></a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="rugs_clrs">
                                                            <ul>
                                                                @foreach($menuItem->childs()->get()->where('is_featured', '!=', 1)->take(5) as $subItem)
                                                                    <li>
                                                                        <a href="{{ $subItem->getAction() }}">
                                                                            {{ $subItem->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                                <li><a href="{{ $data['all_rugs_slug'] }}">view all {{ $menuItem->title }}</a></li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @else
            <div class="Mbl_mnu">
                <div class="container">
                    <div class="MblMenu">
                        <a href="#menu"><i class="fa fa-bars"></i></a>
                        <nav id="menu">
                            <ul>
                                <li>
                                    <h2>Navigation</h2>
                                    <a href="#" class="close"><i class="fa fa-times"></i></a>
                                </li>
                                @foreach($data['main_menu'] as $menuItem)
                                    <li>
                                        <a href="{{ ($menuItem->parent_id == 0 ? url('/'.$menuItem->url) : $menuItem->getAction()) }}" class="nav-link active">{{ $menuItem->title }}</a>
                                        @if($menuItem->hasChild())
                                            <ul class="sub-menu">
                                                @foreach($menuItem->childs()->get() as $subItem)
                                                    <li>
                                                        <a href="{{ $subItem->getAction() }}">{{ $subItem->title }}</a>
                                                        @if($subItem->childs()->get()->count() > 0)
                                                            <ul class="sub-menu">
                                                                @foreach($subItem->childs()->get()->take(5) as $childItem)
                                                                    <li>
                                                                        <a href="{{ $childItem->getAction() }}">{{ $childItem->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endisset



