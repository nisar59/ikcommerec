@if($section->testimonials() && $section->testimonials()->count())
    <section class="new_testimonials">
        <div class="container">
            <h2>{!! $section->title !!}</h2>
            @if($section->sub_heading)
            <h5>{!! $section->sub_heading !!}</h5>
            @endif
            <hr class="divider scnd_divider"/>
            @if($section->description)
            {!! $section->description !!}
            @endif
            <div class="row">
                <div class="clients_testimonials owl-carousel owl-theme">
                    @foreach($section->testimonials() as $testimonial)
                        <div class="item">
                            <div class="col-md-12">
                                <div class="testimonial_one">
                                    <div class="client_comment">
                                        <div class="icon ws-comas"></div>
                                        <p class="show-read-more">{!! str_replace(['<p>', '</p>'], '', $testimonial->detail) !!} </p>
                                    </div>
                                    <div class="client_img">
                                        <div class="img_block">
                                            @php
                                            $title = explode('.' , $testimonial->image);
                                            @endphp
                                            {{ HTML::image(config('thumbnails.testimonial.original').$testimonial->image, $title[0], array( 'class' => '' , 'title' => $title[0] )) }}
                                        </div>
                                        <div class="client_name">
                                            <h4>{!! $testimonial->title !!}</h4>
                                            <p>{!! $testimonial->designation.' '.$testimonial->website !!}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

@push('js')
<script>
$(document).ready(function(){
	var maxLength = 115;
	$(".show-read-more").each(function(){
		var myStr = $(this).text();
		if($.trim(myStr).length > maxLength){
			var newStr = myStr.substring(0, maxLength);
			var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
			$(this).empty().html(newStr);
			$(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
			$(this).append('<span class="more-text">' + removedStr + '</span>');
		}
	});
	$(".read-more").click(function(){
		$(this).siblings(".more-text").contents().unwrap();
		$(this).remove();
	});
});
</script>
@endpush
