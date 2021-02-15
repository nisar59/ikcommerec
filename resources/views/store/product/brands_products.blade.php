@extends('store.layouts.inner_template')
@section('content')

    <!-- breadcrumb -->
    <div class="bg-gray-13 bg-md-transparent">
        <div class="container">
            <!-- breadcrumb -->
            <div class="my-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{$data['brand']->name}}'s Products</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="row mb-8">
            <div class="d-none d-xl-block col-xl-3 col-wd-2gdot5">
                <div class="mb-6 border border-width-2 border-color-3 borders-radius-6">
                    <!-- List -->
                @include('store.sections.cat_manu')
                <!-- End List -->
                </div>
                @include('store.sections.filters')
                @include('store.sections.manu_latest_products')
            </div>
            <div class="col-xl-9 col-wd-9gdot5">
                <!-- Recommended Products -->

            <!-- End Recommended Products -->
                <!-- Shop-control-bar Title -->
                <div class="flex-center-between mb-3">
                    <h3 class="font-size-25 mb-0">{{$data['brand']->name}}</h3>
                    <p class="font-size-14 text-gray-90 mb-0">Showing {{ $data['from'] }}–{{ $data['to'] }} of {{ $data['total_products'] }} results</p>
                </div>
                <!-- End shop-control-bar Title -->
                <!-- Shop-control-bar -->
                <div class="bg-gray-1 flex-center-between borders-radius-9 py-1">
                    {{--<div class="d-xl-none">--}}
                        {{--<!-- Account Sidebar Toggle Button -->--}}
                        {{--<a id="sidebarNavToggler1" class="btn btn-sm py-1 font-weight-normal" href="javascript:;" role="button"--}}
                           {{--aria-controls="sidebarContent1"--}}
                           {{--aria-haspopup="true"--}}
                           {{--aria-expanded="false"--}}
                           {{--data-unfold-event="click"--}}
                           {{--data-unfold-hide-on-scroll="false"--}}
                           {{--data-unfold-target="#sidebarContent1"--}}
                           {{--data-unfold-type="css-animation"--}}
                           {{--data-unfold-animation-in="fadeInLeft"--}}
                           {{--data-unfold-animation-out="fadeOutLeft"--}}
                           {{--data-unfold-duration="500">--}}
                            {{--<i class="fas fa-sliders-h"></i> <span class="ml-1">Filters</span>--}}
                        {{--</a>--}}
                        {{--<!-- End Account Sidebar Toggle Button -->--}}
                    {{--</div>--}}
                    <div class="px-3 d-none d-xl-block">
                        <ul class="nav nav-tab-shop" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1" role="tab" aria-controls="pills-one-example1" aria-selected="false">
                                    <div class="d-md-flex justify-content-md-center align-items-md-center">
                                        <i class="fa fa-th"></i>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-three-example1-tab" data-toggle="pill" href="#pills-three-example1" role="tab" aria-controls="pills-three-example1" aria-selected="true">
                                    <div class="d-md-flex justify-content-md-center align-items-md-center">
                                        <i class="fa fa-list"></i>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                    {{--<div class="d-flex">--}}
                        {{--<form method="get">--}}
                            {{--<!-- Select -->--}}
                            {{--<select class="js-select selectpicker dropdown-select max-width-200 max-width-160-sm right-dropdown-0 px-2 px-xl-0"--}}
                                    {{--data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0">--}}
                                {{--<option value="one" selected>Default sorting</option>--}}
                                {{--<option value="two">Newest</option>--}}
                                {{--<option value="three">Old</option>--}}

                                {{--<option value="five">Sort by price: low to high</option>--}}
                                {{--<option value="six">Sort by price: high to low</option>--}}
                            {{--</select>--}}
                            {{--<!-- End Select -->--}}
                        {{--</form>--}}
                        {{--<form method="POST" class="ml-2 d-none d-xl-block">--}}
                            {{--<!-- Select -->--}}
                            {{--<select class="js-select selectpicker dropdown-select max-width-120"--}}
                                    {{--data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0">--}}
                                {{--<option value="one" selected>Show 20</option>--}}
                                {{--<option value="two">Show 40</option>--}}
                                {{--<option value="three">Show All</option>--}}
                            {{--</select>--}}
                            {{--<!-- End Select -->--}}
                        {{--</form>--}}
                    {{--</div>--}}
                    <nav class="px-3 flex-horizontal-center text-gray-20 d-none d-xl-flex">
                        <form method="post" class="min-width-50 mr-1">
                            <input size="2" min="1" max="3" step="1" type="number" class="form-control text-center px-2 height-35" value="1">
                        </form> of 3
                        <a class="text-gray-30 font-size-20 ml-2" href="#">→</a>
                    </nav>
                </div>
                <!-- End Shop-control-bar -->
                <!-- Shop Body -->
                <!-- Tab Content -->
            @include('store.product.blocks.listing_card')
            <!-- End Tab Content -->
                <!-- End Shop Body -->
                <!-- Shop Pagination -->
                <nav class="d-md-flex justify-content-between align-items-center border-top pt-3" aria-label="Page navigation example">
                    <div class="text-center text-md-left mb-3 mb-md-0">Showing {{ $data['from'] }}–{{ $data['to'] }} of {{ $data['total_products'] }} results</div>
                    <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start">
                        {{ $data['products']->appends(request()->input())->links() }}
                        {{--<li class="page-item"><a class="page-link current" href="#">1</a></li>--}}
                        {{--<li class="page-item"><a class="page-link" href="#">2</a></li>--}}
                        {{--<li class="page-item"><a class="page-link" href="#">3</a></li>--}}
                    </ul>
                </nav>
                <!-- End Shop Pagination -->
            </div>
        </div>
        <!-- Brand Carousel -->
    @include('store.sections.brands')
    <!-- End Brand Carousel -->
    </div>
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
    {!! isset($data['content']->schema) ? $data['content']->schema : "" !!}
    <title>{{ isset($data['content']) ? $data['content']->meta_title : config('app.name') }}</title>
    <meta name="title" content="{{ isset($data['content']) ? $data['content']->meta_title : config('app.name') }}">
    <meta name="description" content="{{ isset($data['content']) ? $data['content']->meta_description : config('app.name') }}">
    <meta name="keywords" content="{{ isset($data['content']) ? $data['content']->meta_keywords : config('app.name') }}">
@endpush
