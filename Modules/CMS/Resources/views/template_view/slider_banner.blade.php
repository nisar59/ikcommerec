@if(isset($data['page']) && $data['page']->banner_style != 'No Banner/Slider')
    @if($data['page']->banner_style == 'Slider' && $data['page']->slider && $data['page']->slider->slides->where('status', 1)->count())
        @foreach($data['page']->slider->slides->where('status', 1) as $slide)
            <section class="bnr" style="background-image:url({{ asset(config('thumbnails.slide.original').$slide->image) }});">
                <!-- @if(config('settings.config_hiring_tag')==1)
                    <a class="we_are_hiring" href="{{url('team#hiring')}}"><i class="fa fa-caret-left"></i>We are hiring.</a>
                @endif -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-{{ $slide->is_default ? "12" : "7" }} col-sm-12 col-xs-12">
                            <div class="bnr_txt">
                                <h3>{!! $slide->description !!}</h3>
                                @if($slide->button_link)
                                    <a href="{{ $slide->button_link }}">{{ $slide->button_text }}</a>
                                    {{--<button>search domain</button>--}}
                                 @endif
                            </div>
                        </div>
                        @if($slide->is_default == 0)
                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="bnr_txt clrchnge">
                                    <h3>{!! $slide->description_1 !!}</h3>
                                    @if($slide->button_link_1)
                                        <a href="{{ $slide->button_link_1 }}">{{ $slide->button_text_1 }}</a>
                                        {{--<button>search domain</button>--}}
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endforeach
    @elseif($data['page']->banner_style == 'Banner')

        <section class="about_bnr" style="background-image:url({{ asset(config('thumbnails.cms.original').$data['page']->image) }});">

            <!-- @if(config('settings.config_hiring_tag')==1)
                <a class="we_are_hiring" href="{{url('team#hiring')}}"><i class="fa fa-caret-left"></i>We are hiring.</a>
            @endif -->
            <div class="align_about_text">
                <h2>{!! $data['page']->banner_title !!}</h2>
                <p>{!! $data['page']->banner_description !!}</p>

                @if($data['page']->name == 'Pk Domain' || $data['page']->name == 'AE Domain' || $data['page']->name == 'Domain Pricing')
                    <form action="{{url('cart/addDomain')}}" method="post" id='search-form'>
                        {{csrf_field()}}
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group pl-5 pr-5 mt-3">
                                    <input type="search"  id="name" name="domain" required="" pattern="^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$"  class="form-control" placeholder="Find your perfect domain name..." title="Please provide valid domain"/>
                                    <div class="input-group-append">


                                        <button class="btn m-0 g-recaptcha" type="submit" data-badge="bottomleft"  data-sitekey="6LcqVawZAAAAAMLoXFi4PcikBY_UQKl_Xdo1cCzw" data-callback='onSubmit' >Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                        @else
                <hr class="divider" style="background-color:#FFF;">
                   @endif
            </div>
        </section>
    @endif
@endif
