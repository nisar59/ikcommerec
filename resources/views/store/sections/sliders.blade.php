<div class="mb-5">
    <div class="bg-img-hero" style="background-image: url({{url('public/assets/store/assets/img/1920X422/img1.jpg')}});">
        <div class="container min-height-420 overflow-hidden">
            <div class="js-slick-carousel u-slick"
                 data-pagi-classes="text-center position-absolute right-0 bottom-0 left-0 u-slick__pagination u-slick__pagination--long justify-content-start mb-3 mb-md-4 offset-xl-3 pl-2 pb-1">

                @foreach($data['sliders'] as $key=>$slides)
                    <div class="js-slide bg-img-hero-center" @if($key>0) data-animation-delay="0" @endif>
                        <div class="row min-height-420 py-7 py-md-0">
                            <div class="offset-xl-3 col-xl-4 col-6 mt-md-8">
                                <h1 class="font-size-64 text-lh-57 font-weight-light"
                                    data-scs-animation-in="fadeInUp">
                                    {{$slides->title}} {{--<span class="d-block font-size-55">STANDARD</span>--}}
                                </h1>
                                <h6 class="font-size-15 font-weight-bold mb-3"
                                    data-scs-animation-in="fadeInUp"
                                    data-scs-animation-delay="200">{!! $slides->description !!}
                                </h6>
                                {{--<div class="mb-4"--}}
                                {{--data-scs-animation-in="fadeInUp"--}}
                                {{--data-scs-animation-delay="300">--}}
                                {{--<span class="font-size-13">FROM</span>--}}
                                {{--<div class="font-size-50 font-weight-bold text-lh-45">--}}
                                {{--<sup class="">$</sup>749<sup class="">99</sup>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                @if(isset($slides->ex_url))
                                    <a href="{{$slides->ex_url}}" class="btn btn-primary transition-3d-hover rounded-lg font-weight-normal py-2 px-md-7 px-3 font-size-16"
                                       data-scs-animation-in="fadeInUp"
                                       data-scs-animation-delay="400">
                                        Start Buying
                                    </a>
                                @endif
                            </div>
                            @if(isset($slides->image))
                                <div class="col-xl-5 col-6  d-flex align-items-center"
                                     data-scs-animation-in="zoomIn"
                                     data-scs-animation-delay="500">
                                    <img class="img-fluid" src="{{url('public/uploads/banners/'.$slides->image)}}" alt="Image Description">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach





            </div>
        </div>
    </div>
</div>