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
						<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Wishlist</li>
					</ol>
				</nav>
			</div>
			<!-- End breadcrumb -->
		</div>
	</div>
	<!-- End breadcrumb -->

	<div class="container">
		<div class="mb-4">
			<h1 class="text-center">Wishlist</h1>
		</div>
		@if($data['products']->count())

			<div class="mb-10 cart-table">
				<form class="mb-4" action="#" method="post">
					<table class="table" cellspacing="0">
						<thead>
						<tr>
							{{--<th class="product-remove">&nbsp;</th>--}}
							<th class="product-thumbnail">&nbsp;</th>
							<th class="product-name">Product</th>
							<th class="product-price">Price</th>
							{{--<th class="product-quantity w-lg-15">Quantity</th>--}}
							<th class="product-subtotal">Total</th>
							<th class="product-subtotal">Add to cart</th>
						</tr>
						</thead>
						<tbody>
						@foreach($data['products'] as $item)

							<tr class="">
								<td class="text-center">
									<a href="#" class="text-gray-32 font-size-26 removewhishlist" data-product-id="{{ $item->id }}">×</a>
								</td>
								<td class="d-none d-md-table-cell">

									@if($item->images->count()>0)
										@php
											$proImage= $item->images->first();
                                      //  dd($proImage);
										@endphp
										<a href="{{ url($item->permalink->slug) }}"><img class="img-fluid max-width-100 p-1 border border-color-1" src="{{url('public/uploads/products/'.$proImage->images)}}" alt="{{ $item->name }}"></a>@endif
								</td>

								<td data-title="Product">
									<a href="#" class="text-gray-90">{{ $item->name }}</a>
								</td>

								<td data-title="Price">
									<span class="">{{config('variable.DEFAULT_CURRENCY')}}{{ number_format($item->price,2) }}</span>
								</td>



								<td data-title="Total">
									<span class="">{{config('variable.DEFAULT_CURRENCY')}}{{ number_format($item->quantity*$item->price,2) }}</span>
								</td>
								<td data-title="Total">
									<button type="button" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto card_add_to_cart" data-product-id="{{ $item->id }}">Add to cart</button>
								</td>
							</tr>
						@endforeach

						<tr>
							<td colspan="6" class="border-top space-top-2 justify-content-center">
								<div class="pt-md-3">
									<div class="d-block d-md-flex flex-center-between">
										<div class="mb-3 mb-md-0 w-xl-40">
											<!-- Apply coupon Form -->

											<!-- End Apply coupon Form -->
										</div>

									</div>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</form>
			</div>



		@else
			<p>Please login register to see your favourite products in your wishlist.</p>
			<a class="button btn btn-info" href="{{ url('/') }}">Continue Shopping</a>
		@endif
	</div>
@endsection

@push('css')
	<link media="all" type="text/css" rel="stylesheet" href="{{url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.css')}}">
@endpush

@push('js')
	<script>
        var remove_from_cart = "{{ route('store-cart-remove') }}";
        var update_qty_cart = "{{ route('store-cart-update') }}";
        var csrf_token = "{{csrf_token()}}";
	</script>

	<script src="{{ url('/public/assets/store/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
	<script src="{{ url('public/assets/store/product/alerts.js')}}"></script>

	<script src="{{ url('public/assets/store/js/checkout/index.js')}}"></script>
@endpush

@push('metaInfo')
	{{--{!! isset($data['product']->schema) ? $data['product']->schema : "" !!}--}}
	{{--<title>{{ isset($data['product']) ? $data['product']->meta_title : config('app.name') }}</title>--}}
	{{--<meta name="title" content="{{ isset($data['product']) ? $data['product']->meta_title : config('app.name') }}">--}}
	{{--<meta name="description" content="{{ isset($data['product']) ? $data['product']->meta_description : config('app.name') }}">--}}
	{{--<meta name="keywords" content="{{ isset($data['product']) ? $data['product']->meta_keywords : config('app.name') }}">--}}
@endpush
