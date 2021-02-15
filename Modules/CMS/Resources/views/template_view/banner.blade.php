<section class="hosting_bnr" style="background-image:url({{ asset(config('thumbnails.cms_block.original').$section->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12 ">
                <div class="hosting_txt ">
                    <h3>{!! $section->title !!}</h3>
                    <a href = "{!! $section->button_link !!}"> {!! $section->button_text !!} </a>
                </div>
               
            </div>
            {{--<div class="col-md-5 col-sm-12 col-xs-12">
                <div class="hosting_operatr">
                    {{ HTML::image('public/assets/store/images/hosting_operator.png', '', array( 'class' => '' )) }}
                </div>
            </div>--}}
        </div>
    </div>
</section>
