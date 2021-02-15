@extends('store.layouts.template')
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
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Compare</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="container">
            <div class="table-responsive table-bordered table-compare-list mb-10 border-0">
                <table class="table">
                    <tbody>
                    <tr>
                        <th class="min-width-200">Product</th>
                        @foreach($data['products'] as $key)
                            <td>
                                <a href="{{url($key->slug)}}" class="product d-block">
                                    <div class="product-compare-image">
                                        @php
                                            $img=\Modules\Products\Entities\ProductImages::where('p_id',$key->id)->pluck('images')->first();
                                        @endphp
                                        <div class="d-flex mb-3">
                                            <img class="img-fluid mx-auto" src="{{url('/public/uploads/products/'.$img)}}" alt="Image Description">
                                        </div>

                                    </div>
                                    <h3 class="product-item__title text-blue font-weight-bold mb-3">{{$key->name}}</h3>
                                </a>

                                <div class="text-warning mb-2">
                                    @php
                                        $review=App\Review::where('product_id',$key->id)->pluck('rating')->first();
                                    @endphp
                                    @for($i=1; $i<=$review; $i++)
                                        <small class="fas fa-star"></small>
                                    @endfor
                                </div>
                            </td> @endforeach

                    </tr>

                    <tr>
                        <th>Price</th>
                        @foreach($data['products'] as $key)
                            <td>
                                <div class="product-price">${{number_format($key->price,2)}}</div>
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <th>Availability</th>
                        @foreach($data['products'] as $key)
                            @if($key->stock_status==1)
                                <td><span>{{$key->quantity}} In stock</span></td>
                            @else
                                <td><span>out of stock</span></td>
                            @endif
                        @endforeach
                    </tr>

                    <tr>
                        <th>Description</th>
                        @foreach($data['products'] as $key)
                            <td>{!! $key->short_description !!}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <th>Add to cart</th>
                        @foreach($data['products'] as $key)
                            <td>
                                <div class=""><a href="#"  class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-3 px-xl-5 card_add_to_cart" data-product-id="{{$key->id}}">Add to cart</a></div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>Sku</th>
                        @foreach($data['products'] as $key)
                            <td>{{$key->sku}}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>Weight</th>
                        @foreach($data['products'] as $key)
                            <td>{{$key->weight}}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>brands</th>
                        @foreach($data['products'] as $key)
                            @php
                                $brand= \Modules\Brands\Entities\Brands::where('id', $key->brand_id)->pluck('name')->first();
                            @endphp
                            <td>{{$brand}}</td>
                        @endforeach

                    </tr>
                    <tr>
                        <th>Price</th>
                        @foreach($data['products'] as $key)
                            <td>
                                <div class="product-price price">${{number_format($key->price,2)}}</div>
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <th>Remove</th>
                        @foreach($data['products'] as $key)
                            <td class="text-center">
                                <a href="{{url('compare/remove/'.$key->id)}}" data-product-id="{{$key->id}}" class="text-gray-90 remove-compare" ><i class="fa fa-times"></i></a>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        var compare_route = '{{ route('store-product-compare') }}';
    </script>
@endpush

@push('metaInfo')
    <title>{{ $data['title'] }} :: {{ config('app.name') }}</title>
    <meta name="title" content="{{ $data['title'] }}">
    <meta name="description" content="{{ $data['title'] }}">
    <meta name="keywords" content="{{ $data['title'] }}">
@endpush
