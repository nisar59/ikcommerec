@extends('store.layouts.template')
@section('content')
    @if(Route::is('store-colors'))
        <!-- Colors -->
        @if($data['colors'])
            <section class="rugs_colors">
                <div class="container">
                    <h2>Shop Rugs By Color</h2>
                    <hr class="divider"/>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                @include('store.sections.blocks.color')
                            </div>
                        </div>
                        <div class="col-md-12 mt-5 col-sm-12 col-xs-12">
                            <div class="row">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="view">
                                <a href="#">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @elseif(Route::is('store-shapes'))
        <!-- Shapes -->
        @if($data['shapes'])
            <section class="rugs_shape">
                <div class="container">
                    <h2>Shop Rugs By Shapes</h2>
                    <hr class="divider"/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                @include('store.sections.blocks.shape')
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="view">
                                <a href="#">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @elseif(Route::is('store-sizes'))
        <!-- Sizes -->
        @if($data['sizes']->count())
            <section class="rugs_size">
                <div class="container">
                    <h2>Shop Rugs By Size</h2>
                    <hr class="divider"/>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                @include('store.sections.blocks.size')
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="view">
                                <a href="#">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
@endsection

@push('css')
@endpush

@push('js')
@endpush

@push('metaInfo')
	<title>{{ $data['title'] }} :: {{ config('app.name') }}</title>
	<meta name="title" content="{{ $data['meta']['title'] }}">
    <meta name="description" content="{{ $data['meta']['description'] }}">
    <meta name="keywords" content="{{ $data['meta']['keywords'] }}">
@endpush
