<ul id="sidebarNav" class="list-unstyled mb-0 sidebar-navbar view-all">
    <li><div class="dropdown-title">Browse Categories</div></li>

    @foreach($data['manu_categories'] as $key => $asidecat)
        @if($asidecat->childs->count()>0)

    <li>
        <a class="dropdown-toggle dropdown-toggle-collapse" href="javascript:;" role="button" data-toggle="collapse"
           aria-expanded="false" aria-controls="sidebarNav1Collapse" data-target="#sidebarNav1Collapse{{$asidecat->id}}">
            {{$asidecat->name}}<span class="text-gray-25 font-size-12 font-weight-normal"> ({{CatePoducts($asidecat->id)}})</span>
        </a>

        <div id="sidebarNav1Collapse{{$asidecat->id}}" class="collapse" data-parent="#sidebarNav">
            <ul id="sidebarNav1" class="list-unstyled dropdown-list">
                <!-- Menu List -->
                @foreach($asidecat->childs as $subcat)
                <li><a class="dropdown-item" href="{{$subcat->permalink->slug}}">{{$subcat->name}}<span class="text-gray-25 font-size-12 font-weight-normal"> ({{CatePoducts($subcat->id)}})</span></a></li>
               @endforeach
                <!-- End Menu List -->
            </ul>
        </div>
    </li>
        @else
            <li class="">
                <a class="u-header-collapse__nav-link font-weight-bold" href="{{$asidecat->permalink->slug}}">{{$asidecat->name}}</a>
            </li>
     @endif

     @endforeach

</ul>