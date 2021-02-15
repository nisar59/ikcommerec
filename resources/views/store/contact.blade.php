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
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Contact-us</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->


        <div class="container">
            <div class="mb-5">
                <h1 class="text-center">Contact-Us</h1>
            </div>
            <div class="row mb-10">
                <div class="col-lg-7 col-xl-6 mb-8 mb-lg-0">
                    <div class="mr-xl-6">
                        <div class="border-bottom border-color-1 mb-5">
                            <h3 class="section-title mb-0 pb-2 font-size-25">Leave us a Message</h3>
                        </div>
                        {{--<p class="max-width-830-xl text-gray-90">Aenean massa diam, viverra vitae luctus sed, gravida eget est. Etiam nec ipsum porttitor, consequat libero eu, dignissim eros. Nulla auctor lacinia enim id mollis. Curabitur luctus interdum eleifend. Ut tempor lorem a turpis fermentum.</p>--}}
                        <form class="js-validate" novalidate="novalidate">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Input -->
                                    <div class="js-form-message mb-4">
                                        <label class="form-label">
                                            First name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="firstName" placeholder="" aria-label="" required="" data-msg="Please enter your frist name." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off">
                                    </div>
                                    <!-- End Input -->
                                </div>

                                <div class="col-md-6">
                                    <!-- Input -->
                                    <div class="js-form-message mb-4">
                                        <label class="form-label">
                                            Last name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="lastName" placeholder="" aria-label="" required="" data-msg="Please enter your last name." data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>
                                    <!-- End Input -->
                                </div>

                                <div class="col-md-12">
                                    <!-- Input -->
                                    <div class="js-form-message mb-4">
                                        <label class="form-label">
                                            Subject
                                        </label>
                                        <input type="text" class="form-control" name="Subject" placeholder="" aria-label="" data-msg="Please enter subject." data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>
                                    <!-- End Input -->
                                </div>
                                <div class="col-md-12">
                                    <div class="js-form-message mb-4">
                                        <label class="form-label">
                                            Your Message
                                        </label>

                                        <div class="input-group">
                                            <textarea class="form-control p-5" rows="4" name="text" placeholder=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary-dark-w px-5">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-6">
                    <div class="mb-6">
                        <iframe src="{!! strip_tags($data['page']->banner_description) !!}" width="100%" height="288" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                    @foreach($data['sections'] as  $key=>$section)
                    <div class="border-bottom border-color-1 mb-5">
                        <h3 class="section-title mb-0 pb-2 font-size-25">{{$section->title}}</h3>
                    </div>
                       {!! $section->description !!}
                @endforeach
                </div>
            </div>
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
