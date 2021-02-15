@extends('store.layouts.inner_template')
@section('content')

    <main id="content" role="main">
        <div class="bg-img-hero mb-14" @if(isset($data['page']->image))style="background-image: url({{url('public/uploads/cms/'.$data['page']->image)}});" @endif>
            <div class="container">
                <div class="flex-content-center max-width-620-lg flex-column mx-auto text-center min-height-564">
                    <h1 class="h1 font-weight-bold">{{$data['page']->name}}</h1>
                    <p class="text-gray-39 font-size-18 text-lh-default">{!! $data['page']->description !!}</p>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
              @foreach($data['sections'] as  $section)
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card mb-3 border-0 text-center rounded-0">
                        @if(isset($section->image))  <img class="img-fluid mb-3" src="{{url('public/uploads/cms/'.$section->image)}}" alt="{{$section->title}}"> @endif
                        <div class="card-body">
                            <h5 class="font-size-18 font-weight-semi-bold mb-3">{{$section->title}}</h5>
                            <p class="text-gray-90 max-width-334 mx-auto">{!! $section->description !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
        {{--<div class="bg-gray-1 py-12 mb-10 mb-lg-15">--}}
            {{--<div class="container">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-4 mb-5 mb-xl-0 col-xl text-center">--}}
                        {{--<img class="img-fluid mb-3 rounded-circle" src="../../assets/img/300X300/img16.jpg" alt="Card image cap">--}}
                        {{--<h2 class="font-size-18 font-weight-semi-bold mb-0">Thomas Snow</h2>--}}
                        {{--<span class="text-gray-41">CEO/Founder</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mb-5 mb-xl-0 col-xl text-center">--}}
                        {{--<img class="img-fluid mb-3 rounded-circle" src="../../assets/img/300X300/img17.jpg" alt="Card image cap">--}}
                        {{--<h2 class="font-size-18 font-weight-semi-bold mb-0">Anna Baranov</h2>--}}
                        {{--<span class="text-gray-41">Client Care</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mb-5 mb-xl-0 col-xl text-center">--}}
                        {{--<img class="img-fluid mb-3 rounded-circle" src="../../assets/img/300X300/img18.jpg" alt="Card image cap">--}}
                        {{--<h2 class="font-size-18 font-weight-semi-bold mb-0">Andre Kowalsy</h2>--}}
                        {{--<span class="text-gray-41">Support Boss</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mb-5 mb-xl-0 col-xl text-center">--}}
                        {{--<img class="img-fluid mb-3 rounded-circle" src="../../assets/img/300X300/img19.jpg" alt="Card image cap">--}}
                        {{--<h2 class="font-size-18 font-weight-semi-bold mb-0">Pamela Doe</h2>--}}
                        {{--<span class="text-gray-41">Delivery Driver</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mb-5 mb-xl-0 col-xl text-center">--}}
                        {{--<img class="img-fluid mb-3 rounded-circle" src="../../assets/img/300X300/img20.jpg" alt="Card image cap">--}}
                        {{--<h2 class="font-size-18 font-weight-semi-bold mb-0">Susan McCain</h2>--}}
                        {{--<span class="text-gray-41">Packaging Girl</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mb-5 mb-xl-0 col-xl text-center">--}}
                        {{--<img class="img-fluid mb-3 rounded-circle" src="../../assets/img/300X300/img21.png" alt="Card image cap">--}}
                        {{--<h2 class="font-size-18 font-weight-semi-bold mb-0">See Details</h2>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="container mb-8 mb-lg-0">

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
