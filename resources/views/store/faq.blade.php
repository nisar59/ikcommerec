@extends('store.layouts.inner_template')
@section('content')

    <main id="content" role="main">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">FAQ</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->
        <div class="bg-img-hero mb-14" @if(isset($data['page']->image))style="background-image: url({{url('public/uploads/cms/'.$data['page']->image)}});" @endif>
            <div class="container">
                <div class="flex-content-center max-width-620-lg flex-column mx-auto text-center min-height-564">
                    <h1 class="h1 font-weight-bold">{{$data['page']->name}}</h1>
                    <p class="text-gray-39 font-size-18 text-lh-default">{!! $data['page']->description !!}</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="mb-12 text-center">
                <h1>Frequently Asked Questions</h1>
                {{--<p class="text-gray-44">This Agreement was last modified on 18th february 2019</p>--}}
            </div>
            {{--<div class="border-bottom border-color-1 mb-8 rounded-0">--}}
                {{--<h3 class="section-title mb-0 pb-2 font-size-25">Shipping Information</h3>--}}
            {{--</div>--}}
            {{--<div class="row mb-8">--}}
                {{--<div class="col-lg-6 mb-5 mb-lg-8">--}}
                    {{--<h3 class="font-size-18 font-weight-semi-bold text-gray-39 mb-4">What Shipping Methods Are Available?</h3>--}}
                    {{--<p class="text-gray-90">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sapien lorem, consectetur et turpis id, blandit interdum metus. Morbi sed ligula id elit mollis efficitur ut nec ligula. Proin erat magna, pellentesque at elementum at, eleifend a tortor.</p>--}}
                {{--</div>--}}
                {{--<div class="col-lg-6 mb-5 mb-lg-8">--}}
                    {{--<h3 class="font-size-18 font-weight-semi-bold text-gray-39 mb-4">How Long Will it Take To Get My Package?</h3>--}}
                    {{--<p class="text-gray-90">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus sapien lorem, consectetur et turpis id, blandit interdum metus. Morbi sed ligula id elit mollis efficitur ut nec ligula. Proin erat magna, pellentesque at elementum at, eleifend a tortor.</p>--}}
                {{--</div>--}}
                {{--<div class="col-lg-6 mb-5 mb-lg-8">--}}
                    {{--<h3 class="font-size-18 font-weight-semi-bold text-gray-39 mb-4">How Do I Track My Order?</h3>--}}
                    {{--<p class="text-gray-90">Integer ex turpis, venenatis vitae nibh vel, vestibulum maximus quam. Ut pretium orci ac vestibulum porttitor. Fusce tempus diam quis justo porttitor gravida.</p>--}}
                {{--</div>--}}
                {{--<div class="col-lg-6 mb-5 mb-lg-8">--}}
                    {{--<h3 class="font-size-18 font-weight-semi-bold text-gray-39 mb-4">Do I Need A Account To Place Order?</h3>--}}
                    {{--<p class="text-gray-90">Integer ex turpis, venenatis vitae nibh vel, vestibulum maximus quam. Ut pretium orci ac vestibulum porttitor. Fusce tempus diam quis justo porttitor gravida.</p>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="mb-12 text-center">
                <h1>FAQ Second Version</h1>
            </div>
            <!-- Basics Accordion -->
            <div id="basicsAccordion" class="mb-12">
                <!-- Card -->

                @foreach($data['sections'] as  $key=>$section)
                <div class="card mb-3 border-top-0 border-left-0 border-right-0 border-color-1 rounded-0">
                    <div class="card-header card-collapse bg-transparent-on-hover border-0" id="basicsHeadingOne{{$section->id}}">
                        <h5 class="mb-0">
                            <button type="button" class="px-0 btn btn-link btn-block d-flex justify-content-between card-btn py-3 font-size-25 border-0"
                                    data-toggle="collapse"
                                    data-target="#basicsCollapseOner"
                                    aria-expanded="true"
                                    aria-controls="basicsCollapseOner">
                                {{$section->title}}

                                <span class="card-btn-arrow">
                                        <i class="fas fa-chevron-down text-gray-90 font-size-18"></i>
                                    </span>
                            </button>
                        </h5>
                    </div>
                    <div id="basicsCollapseOner" class="collapse @if($key==0) show @endif"
                         aria-labelledby="basicsHeadingOne"
                         data-parent="#basicsAccordion">
                        <div class="card-body pl-0 pb-8">
                            <p class="mb-0">{!! $section->description !!}</p>
                        </div>
                    </div>
                </div>

               @endforeach
                <!-- End Card -->

                {{--<!-- Card -->--}}
                {{--<div class="card mb-3 border-top-0 border-left-0 border-right-0 border-color-1 rounded-0">--}}
                    {{--<div class="card-header card-collapse bg-transparent-on-hover border-0" id="basicsHeadingTwo">--}}
                        {{--<h5 class="mb-0">--}}
                            {{--<button type="button" class="px-0 btn btn-link btn-block d-flex justify-content-between card-btn collapsed py-3 font-size-25 border-0"--}}
                                    {{--data-toggle="collapse"--}}
                                    {{--data-target="#basicsCollapseTwo"--}}
                                    {{--aria-expanded="false"--}}
                                    {{--aria-controls="basicsCollapseTwo">--}}
                                {{--How Long Will it Take To Get My Package?--}}

                                {{--<span class="card-btn-arrow">--}}
                                        {{--<i class="fas fa-chevron-down text-gray-90 font-size-18"></i>--}}
                                    {{--</span>--}}
                            {{--</button>--}}
                        {{--</h5>--}}
                    {{--</div>--}}
                    {{--<div id="basicsCollapseTwo" class="collapse"--}}
                         {{--aria-labelledby="basicsHeadingTwo"--}}
                         {{--data-parent="#basicsAccordion">--}}
                        {{--<div class="card-body pl-0 pb-8">--}}
                            {{--<p class="mb-0">In egestas, libero vitae scelerisque tristique, turpis augue faucibus dolor, at aliquet ligula massa at justo. Donec viverra tortor quis tortor pretium, in pretium risus finibus. Integer viverra pretium auctor. Aliquam eget convallis eros, varius sagittis nulla. Suspendisse potenti. Aenean consequat ex sit amet metus ultrices tristique. Nam ac nunc augue. Suspendisse finibus in dolor eget volutpat.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!-- End Card -->--}}

                {{--<!-- Card -->--}}
                {{--<div class="card mb-3 border-top-0 border-left-0 border-right-0 border-color-1 rounded-0">--}}
                    {{--<div class="card-header card-collapse bg-transparent-on-hover border-0" id="basicsHeadingThree">--}}
                        {{--<h5 class="mb-0">--}}
                            {{--<button type="button" class="px-0 btn btn-link btn-block d-flex justify-content-between card-btn collapsed py-3 font-size-25 border-0"--}}
                                    {{--data-toggle="collapse"--}}
                                    {{--data-target="#basicsCollapseThree"--}}
                                    {{--aria-expanded="false"--}}
                                    {{--aria-controls="basicsCollapseThree">--}}
                                {{--How Do I Track My Order?--}}

                                {{--<span class="card-btn-arrow">--}}
                                        {{--<i class="fas fa-chevron-down text-gray-90 font-size-18"></i>--}}
                                    {{--</span>--}}
                            {{--</button>--}}
                        {{--</h5>--}}
                    {{--</div>--}}
                    {{--<div id="basicsCollapseThree" class="collapse"--}}
                         {{--aria-labelledby="basicsHeadingThree"--}}
                         {{--data-parent="#basicsAccordion">--}}
                        {{--<div class="card-body pl-0 pb-8">--}}
                            {{--<p class="mb-0">In egestas, libero vitae scelerisque tristique, turpis augue faucibus dolor, at aliquet ligula massa at justo. Donec viverra tortor quis tortor pretium, in pretium risus finibus. Integer viverra pretium auctor. Aliquam eget convallis eros, varius sagittis nulla. Suspendisse potenti. Aenean consequat ex sit amet metus ultrices tristique. Nam ac nunc augue. Suspendisse finibus in dolor eget volutpat.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!-- End Card -->--}}

                {{--<!-- Card -->--}}
                {{--<div class="card mb-3 border-top-0 border-left-0 border-right-0 border-color-1 rounded-0">--}}
                    {{--<div class="card-header card-collapse bg-transparent-on-hover border-0" id="basicsHeadingFour">--}}
                        {{--<h5 class="mb-0">--}}
                            {{--<button type="button" class="px-0 btn btn-link btn-block d-flex justify-content-between card-btn collapsed py-3 font-size-25 border-0"--}}
                                    {{--data-toggle="collapse"--}}
                                    {{--data-target="#basicsCollapseFour"--}}
                                    {{--aria-expanded="false"--}}
                                    {{--aria-controls="basicsCollapseFour">--}}
                                {{--How Do I Place an Order?--}}

                                {{--<span class="card-btn-arrow">--}}
                                        {{--<i class="fas fa-chevron-down text-gray-90 font-size-18"></i>--}}
                                    {{--</span>--}}
                            {{--</button>--}}
                        {{--</h5>--}}
                    {{--</div>--}}
                    {{--<div id="basicsCollapseFour" class="collapse"--}}
                         {{--aria-labelledby="basicsHeadingFour"--}}
                         {{--data-parent="#basicsAccordion">--}}
                        {{--<div class="card-body pl-0 pb-8">--}}
                            {{--<p class="mb-0">In egestas, libero vitae scelerisque tristique, turpis augue faucibus dolor, at aliquet ligula massa at justo. Donec viverra tortor quis tortor pretium, in pretium risus finibus. Integer viverra pretium auctor. Aliquam eget convallis eros, varius sagittis nulla. Suspendisse potenti. Aenean consequat ex sit amet metus ultrices tristique. Nam ac nunc augue. Suspendisse finibus in dolor eget volutpat.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!-- End Card -->--}}

                {{--<!-- Card -->--}}
                {{--<div class="card mb-3 border-top-0 border-left-0 border-right-0 border-color-1 rounded-0">--}}
                    {{--<div class="card-header card-collapse bg-transparent-on-hover border-0" id="basicsHeadingFive">--}}
                        {{--<h5 class="mb-0">--}}
                            {{--<button type="button" class="px-0 btn btn-link btn-block d-flex justify-content-between card-btn collapsed py-3 font-size-25 border-0"--}}
                                    {{--data-toggle="collapse"--}}
                                    {{--data-target="#basicsCollapseFive"--}}
                                    {{--aria-expanded="false"--}}
                                    {{--aria-controls="basicsCollapseFive">--}}
                                {{--How Should I to Contact if I Have Any Queries?--}}

                                {{--<span class="card-btn-arrow">--}}
                                        {{--<i class="fas fa-chevron-down text-gray-90 font-size-18"></i>--}}
                                    {{--</span>--}}
                            {{--</button>--}}
                        {{--</h5>--}}
                    {{--</div>--}}
                    {{--<div id="basicsCollapseFive" class="collapse"--}}
                         {{--aria-labelledby="basicsHeadingFive"--}}
                         {{--data-parent="#basicsAccordion">--}}
                        {{--<div class="card-body pl-0 pb-8">--}}
                            {{--<p class="mb-0">In egestas, libero vitae scelerisque tristique, turpis augue faucibus dolor, at aliquet ligula massa at justo. Donec viverra tortor quis tortor pretium, in pretium risus finibus. Integer viverra pretium auctor. Aliquam eget convallis eros, varius sagittis nulla. Suspendisse potenti. Aenean consequat ex sit amet metus ultrices tristique. Nam ac nunc augue. Suspendisse finibus in dolor eget volutpat.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<!-- End Card -->--}}

                {{--<!-- Card -->--}}
                {{--<div class="card mb-3 border-top-0 border-left-0 border-right-0 border-color-1">--}}
                    {{--<div class="card-header card-collapse bg-transparent-on-hover border-0" id="basicsHeadingSix">--}}
                        {{--<h5 class="mb-0">--}}
                            {{--<button type="button" class="px-0 btn btn-link btn-block d-flex justify-content-between card-btn collapsed py-3 font-size-25 border-0"--}}
                                    {{--data-toggle="collapse"--}}
                                    {{--data-target="#basicsCollapseSix"--}}
                                    {{--aria-expanded="false"--}}
                                    {{--aria-controls="basicsCollapseSix">--}}
                                {{--Do I Need an Account to Place an Order?--}}

                                {{--<span class="card-btn-arrow">--}}
                                        {{--<i class="fas fa-chevron-down text-gray-90 font-size-18"></i>--}}
                                    {{--</span>--}}
                            {{--</button>--}}
                        {{--</h5>--}}
                    {{--</div>--}}
                    {{--<div id="basicsCollapseSix" class="collapse"--}}
                         {{--aria-labelledby="basicsHeadingSix"--}}
                         {{--data-parent="#basicsAccordion">--}}
                        {{--<div class="card-body pl-0">--}}
                            {{--<p class="mb-0">In egestas, libero vitae scelerisque tristique, turpis augue faucibus dolor, at aliquet ligula massa at justo. Donec viverra tortor quis tortor pretium, in pretium risus finibus. Integer viverra pretium auctor. Aliquam eget convallis eros, varius sagittis nulla. Suspendisse potenti. Aenean consequat ex sit amet metus ultrices tristique. Nam ac nunc augue. Suspendisse finibus in dolor eget volutpat.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <!-- End Card -->
            </div>
            <!-- End Basics Accordion -->
            <!-- Brand Carousel -->
        @include('store.sections.brands')
            <!-- End Brand Carousel -->
        </div>
    </main>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function(){
            function updateQueryStringParameter(uri, key, value) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                }
                else {
                    return uri + separator + key + "=" + value;
                }
            }
            function removeQueryStringParameter(uri, key) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + '$2');
                }
                else {
                    return uri;
                }
            }
            function specialCharacter(string){
                string = string.replace("/", "~");
                string = string.replace(/ /g, "^");
                return string;
            }

            $(document).on('click', '.rug_limits a', function(e){
                var limit = $(this).data('limit');
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'limit', limit);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });

            $(document).on('click', '.prices a', function(e){
                var range = $(this).find('input:checkbox:checked').val();
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'range', range ? range : "");
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;

            });

            $(document).on('click', '.sizes a', function(e){
                var sizes = $(".sizes a input:checkbox:checked").map(function(){
                    return $(this).val();
                });
                sizes = sizes.get();
                sizes = sizes.join("|");
                sizes = specialCharacter(sizes);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'size', sizes);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });

            $(document).on('click', '.colors a', function(e){
                var colors = $(".colors a input:checkbox:checked").map(function(){
                    return $(this).val();
                });
                colors = colors.get();
                colors = colors.join("|");
                colors = specialCharacter(colors);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'color', colors);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });
            $(document).on('click', '.brands', function(e){
                // alert('asd');

                var brands = $('input[name="brands[]"]:checked').map( function () {
                    return $(this).val();
                }).get()
                    .join("|");

                // var brands = $(".brands input:checkbox:checked").map(function(){
                //
                //     return $(this).val();
                // });

                // brands = brands.get();
                //  brands = brands.join("|");
                brands = specialCharacter(brands);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'brands', brands);
                var url = updateQueryStringParameter(url, 'page', 1);
                // alert(uri);
                window.location.href = url;
            });

            $(document).on('click', '.fll', function(e){
                //  alert('asd');

                var value = $('.js-range-slider').data('result-min');
                alert(value);
                // var brands = $(".brands input:checkbox:checked").map(function(){
                //
                //     return $(this).val();
                // });

                // brands = brands.get();
                //  brands = brands.join("|");
                brands = specialCharacter(brands);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'brands', brands);
                var url = updateQueryStringParameter(url, 'page', 1);
                // alert(uri);
                window.location.href = url;
            });

            $(document).on('click', '.styles a', function(e){
                var styles = $(".styles a input:checkbox:checked").map(function(){
                    return $(this).val();
                });
                styles = styles.get();
                styles = styles.join("|");
                styles = specialCharacter(styles);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'style', styles);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });

            $(document).on('click', '.materials a', function(e){
                var materials = $(".materials a input:checkbox:checked").map(function(){
                    return $(this).val();
                });
                materials = materials.get();
                materials = materials.join("|");
                materials = specialCharacter(materials);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'material', materials);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });

            $(document).on('click', '.weaves a', function(e){
                var weaves = $(".weaves a input:checkbox:checked").map(function(){
                    return $(this).val();
                });
                weaves = weaves.get();
                weaves = weaves.join("|");
                weaves = specialCharacter(weaves);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'weave', weaves);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });

            $(document).on('click', '.piles a', function(e){
                var piles = $(".piles a input:checkbox:checked").map(function(){
                    return $(this).val();
                });
                piles = piles.get();
                piles = piles.join("|");
                piles = specialCharacter(piles);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'pile', piles);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });

            $(document).on('click', '.designs a', function(e){
                var designs = $(".designs a input:checkbox:checked").map(function(){
                    return $(this).val();
                });
                designs = designs.get();
                designs = designs.join("|");
                designs = specialCharacter(designs);
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'design', designs);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });

            $(document).on('change', 'select[name=rugs_sort_order]', function(e){
                var order = $(this).val();
                var uri = window.location.href;
                var url = updateQueryStringParameter(uri, 'order', order);
                var url = updateQueryStringParameter(url, 'page', 1);
                window.location.href = url;
            });

            $(document).on('click', 'i.remove', function(e){
                var value = $(this).data('value');
                $('a[data-value="'+value+'"] input[type=checkbox]').prop( 'checked', false );
                $('a[data-value="'+value+'"]').trigger('click');
            });

        });
    </script>

    <script>

        var add_to_cart = "{{ route('store-cart-add') }}";
        var csrf_token = "{{csrf_token()}}";
    </script>
    <script src="{{ url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script src="{{ url('public/assets/store/product/alerts.js')}}"></script>
    <script src="{{ url('public/assets/store/product/index.js')}}"></script>
@endpush

@push('metaInfo')
    {{--{!! isset($data['page']->schema) ? $data['page']->schema : "" !!}--}}
    <title>{{ isset($data['page']) ? $data['page']->meta_title : config('app.name') }}</title>
    <meta name="title" content="{{ isset($data['page']) ? $data['page']->meta_title : config('app.name') }}">
    <meta name="description" content="{{ isset($data['page']) ? $data['page']->meta_description : config('app.name') }}">
    <meta name="keywords" content="{{ isset($data['page']) ? $data['page']->meta_keywords : config('app.name') }}">
@endpush
