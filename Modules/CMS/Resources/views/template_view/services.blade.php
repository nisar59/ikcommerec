<section class="why_us_simple">
    <div class="container">
        <h2>{!! $section->title !!}</h2>
        @if($section->sub_heading)
        <h5>{!! $section->sub_heading !!}</h5>
        @endif
        <hr class="divider mb-4"/>
        @if($section->description)
        {!! $section->description !!}
        @endif
        <div class="row">
            @if($section->blocks()->where('status', 1)->count())
                @foreach($section->blocks()->where('status', 1)->orderBy('sort_order', 'ASC')->get() as $block)
                    <div class="col-md-4 brdr_lft_rght">
                        <div class="serving_since">
                            <div class="img_circle">
                              @if($block->icon)
                      <div class="icon {{$block->icon}}"></div>
                          @else
                                @php
                                $title = explode('.' , $block->image);
                                @endphp
                                {{HTML::image(config('thumbnails.cms_block.path').'85x85/'.$block->image, $title[0], array( 'class' => '' , 'title' => $title[0] ))}}
                                  @endif
                            </div>
                            <hr class="img_btm"/>
                            <h4>{!! $block->title !!}</h4>
                            {!! $block->description !!}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
