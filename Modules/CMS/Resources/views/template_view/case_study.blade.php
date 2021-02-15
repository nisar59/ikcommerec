<div class="case_study" style="background-image:url({{ asset(config('thumbnails.cms_block.original').$section->image) }});">
    <div class="container">
        <h2>{!! $section->title !!}</h2>
        @if($section->sub_heading)
        <h5>{!! $section->sub_heading !!}</h5>
        @endif
        <hr class="divider" style="background-color:#FFF;">
        @if($section->description)
        {!! $section->description !!}
        @endif
    </div>
    @if(featuredCaseStudies() && featuredCaseStudies()->count())
    <div class="owl-one owl-carousel owl-theme">
        @foreach(featuredCaseStudies() as $caseStudy)
        <div class="item">
            <div class="container">
                <div class="ograsction">
                <span>{!! $caseStudy->client->title !!}</span>
                <h3>{!! $caseStudy->title !!}</h3>
                {!! $caseStudy->summary !!}
                <ul>
                    <li><a class="active" href="{{ route('store-url', $caseStudy->permalink->slug) }}">READ MORE</a></li>
                    {{-- <li><a href="#">ALL CASE STUDIES</a></li> --}}
                </ul>
            </div>
            </div>
            <div class="ogralaptop">
                @php
                        $title = explode('.' , $caseStudy->image);                     
                        @endphp
                {{HTML::image(config('thumbnails.case_study.path').'original/'.$caseStudy->image, $title[0], array( 'class' => '' , 'title' => $title[0]  ))}}
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>