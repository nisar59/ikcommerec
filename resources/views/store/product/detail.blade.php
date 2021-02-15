@extends('store.layouts.inner_template')
@section('content')
	@php
		use App\Review;
	@endphp
	<!-- breadcrumb -->
	<div class="bg-gray-13 bg-md-transparent">
		<div class="container">
			<!-- breadcrumb -->
			<div class="my-md-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
						<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{url('/')}}">Home</a></li>
						{{--<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="../shop/shop.html">Accessories</a></li>--}}
						{{--<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="../shop/shop.html">Headphones</a></li>--}}
						<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{$data['product']->name}}</li>
					</ol>
				</nav>
			</div>
			<!-- End breadcrumb -->
		</div>
	</div>
	<!-- End breadcrumb -->
	<div class="container">
		<!-- Single Product Body -->
		<div class="mb-xl-14 mb-6">
			<div class="row">
				<div class="col-md-5 mb-4 mb-md-0">
					@if($data['product']->images->count()>0)

						<div id="sliderSyncingNav" class="js-slick-carousel u-slick mb-2"
						 data-infinite="true"
						 data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
						 data-arrow-left-classes="fas fa-arrow-left u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-4"
						 data-arrow-right-classes="fas fa-arrow-right u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-4"
						 data-nav-for="#sliderSyncingThumb">
							@foreach($data['product']->images as $image)
							<div class="js-slide">
							<img class="img-fluid" src="{{url('public/uploads/products/'.$image->images)}}" alt="{{ $data['product']->name  }}">
						</div>
							@endforeach

					</div>

					<div id="sliderSyncingThumb" class="js-slick-carousel u-slick u-slick--slider-syncing u-slick--slider-syncing-size u-slick--gutters-1 u-slick--transform-off"
						 data-infinite="true"
						 data-slides-show="5"
						 data-is-thumbs="true"
						 data-nav-for="#sliderSyncingNav">
						@foreach($data['product']->images as $image)
						<div class="js-slide" style="cursor: pointer;">
							<img class="img-fluid" src="{{url('public/uploads/products/'.$image->images)}}" alt="{{ $data['product']->name }}">
						</div>
						@endforeach

					</div>
						@endif
				</div>
				<div class="col-md-7 mb-md-6 mb-lg-0">
					<div class="mb-2">
						<div class="border-bottom mb-3 pb-md-1 pb-3">
							{{--<a href="#" class="font-size-12 text-gray-5 mb-2 d-inline-block">Headphones</a>--}}
							<h2 class="font-size-25 text-lh-1dot2">{{ $data['product']->name }}</h2>

						@if($data['product']->enable_reviews==1)
							<div class="mb-2">
								<a class="d-inline-flex align-items-center small font-size-15 text-lh-1" href="#">
									<div class="text-warning mr-2">
										<small class="fas fa-star"></small>
										<small class="fas fa-star"></small>
										<small class="fas fa-star"></small>
										<small class="fas fa-star"></small>
										<small class="far fa-star text-muted"></small>
									</div>
									<span class="text-secondary font-size-13">(3 customer reviews)</span>
								</a>
							</div>
						@endif
							<div class="d-md-flex align-items-center">
								{{--<a href="#" class="max-width-150 ml-n2 mb-2 mb-md-0 d-block"><img class="img-fluid" src="../../assets/img/200X60/img1.png" alt="Image Description"></a>--}}
								<div class="ml-md-3 text-gray-9 font-size-14">Availability: @if($data['product']->quantity>0)<span class="text-green font-weight-bold">{{$data['product']->quantity}} in stock</span> @else <span class="text-red font-weight-bold">Out of stock</span>  @endif</div>
							</div>
						</div>
						<div class="flex-horizontal-center flex-wrap mb-4">
							<a href="#" class="text-gray-6 font-size-13 mr-2"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
							<a href="#" class="text-gray-6 font-size-13 ml-2"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
						</div>
						<div class="mb-2">
							{!! $data['product']->short_description !!}
						</div>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
						<p><strong>SKU</strong>: {!! $data['product']->sku !!}</p>
						<div class="mb-4">
							<div class="d-flex align-items-baseline">
								@if($data['product']->sale_price)
									<del class="font-size-11 text-gray-9 d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($data['product']->price,2)}}</del>
									<ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($data['product']->sale_price,2)}}</ins>
								@else
									<ins class="font-size-15 text-red text-decoration-none d-block">{{config('variable.DEFAULT_CURRENCY')}}{{number_format($data['product']->price,2)}}</ins>
								@endif
							</div>
						</div>
                        @if((count($data['sizecheck']))>0 OR (count($data['colorcheck']))>0)
						<div class="border-top border-bottom py-3 mb-4">
							<div class="d-flex align-items-center">
								<h6 class="font-size-14 mb-0">Color</h6>
								<!-- Select -->
								<select class="js-select selectpicker dropdown-select ml-3"
										data-style="btn-sm bg-white font-weight-normal py-2 border" id="product_color_id">
                                 @php
                                $prvalue='';
                                @endphp
                                @foreach($data['provariation'] as $key=> $provari)
                                @if($provari->color!='')
                                @php
                                $varivalue=Modules\Variations\Entities\VariationValues::where('id',$provari->color)->first();
                                @endphp
                                @if( $varivalue->value!=$prvalue)
                                <option value="{{$varivalue->id}}">{{$varivalue->value}}</option>
                                @endif
                                @php
                                $prvalue=$varivalue->value;
                                @endphp
                                @endif
                                @endforeach
								</select>
								<!-- End Select -->
							</div>


                                <div class="d-flex align-items-center">
                                <h6 class="font-size-14 mb-0">Size</h6>
                                <!-- Select -->
                                <select class="js-select selectpicker dropdown-select ml-3"
                                        data-style="btn-sm bg-white font-weight-normal py-2 border" id="product_size_id">
                                  @php
                                $prvalue='';
                                @endphp
                                @foreach($data['provariation'] as $key=> $provari)
                                @if($provari->size!='')
                                @php
                                $varivalue=Modules\Variations\Entities\VariationValues::where('id',$provari->size)->first();
                                @endphp
                                @if( $varivalue->value!=$prvalue)
                                <option value="{{$varivalue->id}}">{{$varivalue->value}}</option>
                                @endif
                                @php
                                $prvalue=$varivalue->value;
                                @endphp
                                @endif
                                @endforeach
                                </select>
                               <!-- End Select -->
                            </div>

						</div>
                        @endif
						<div class="d-md-flex align-items-end mb-3">
							<div class="max-width-150 mb-4 mb-md-0">
								<h6 class="font-size-14">Quantity</h6>
								<!-- Quantity -->
								{{ Form::hidden('product_id', $data['product']->id, array('id' => 'product_id')) }}
								{{ Form::hidden('product_name', $data['product']->name, array('id' => 'product_name')) }}
								<input type="hidden" name="product_sku" value="{{ $data['product']->sku }}">
								{{ Form::hidden('product_price', $data['product']->sale_price ? $data['product']->sale_price : $data['product']->price, array('id' => 'product_price')) }}
								<div class="border rounded-pill py-2 px-3 border-color-1">
									<div class="js-quantity row align-items-center">
										<div class="col">
											<input  name="product_quantity" class="js-result form-control h-auto border-0 rounded p-0 shadow-none" type="text" value="1">
										</div>
										<div class="col-auto pr-1">
											<a class="js-minus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
												<small class="fas fa-minus btn-icon__inner"></small>
											</a>
											<a class="js-plus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
												<small class="fas fa-plus btn-icon__inner"></small>
											</a>
										</div>
									</div>
								</div>
								<!-- End Quantity -->
							</div>
							<div class="ml-md-3">
								<a href="#" id="" class="btn px-5 btn-primary-dark transition-3d-hover add_to_cart "><i class="ec ec-add-to-cart mr-2 font-size-20"></i> Add to Cart</a>
							 {{--<input type="button"  class="add_to_cart"  value="Add to cart">--}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Single Product Body -->
		<!-- Single Product Tab -->
		<div class="mb-8">
			<div class="position-relative position-md-static px-md-6">
				<ul class="nav nav-classic nav-tab nav-tab-lg justify-content-xl-center flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble border-0 pb-1 pb-xl-0 mb-n1 mb-xl-0" id="pills-tab-8" role="tablist">
					{{--<li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">--}}
						{{--<a class="nav-link active" id="Jpills-one-example1-tab" data-toggle="pill" href="#Jpills-one-example1" role="tab" aria-controls="Jpills-one-example1" aria-selected="true">Accessories</a>--}}
					{{--</li>--}}
					<li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">
						<a class="nav-link active" id="Jpills-two-example1-tab" data-toggle="pill" href="#Jpills-two-example1" role="tab" aria-controls="Jpills-two-example1" aria-selected="false">Description</a>
					</li>
					{{--<li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">--}}
						{{--<a class="nav-link" id="Jpills-three-example1-tab" data-toggle="pill" href="#Jpills-three-example1" role="tab" aria-controls="Jpills-three-example1" aria-selected="false">Specification</a>--}}
					{{--</li>--}}
					@if($data['product']->enable_reviews)
					<li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">
						<a class="nav-link" id="Jpills-four-example1-tab" data-toggle="pill" href="#Jpills-four-example1" role="tab" aria-controls="Jpills-four-example1" aria-selected="false">Reviews</a>
					</li>
					@endif
				</ul>
			</div>
			<!-- Tab Content -->
			<div class="borders-radius-17 border p-4 mt-4 mt-md-0 px-lg-10 py-lg-9">
				<div class="tab-content" id="Jpills-tabContent">
					{{--<div class="tab-pane fade active show" id="Jpills-one-example1" role="tabpanel" aria-labelledby="Jpills-one-example1-tab">--}}
						{{--<div class="row no-gutters">--}}
							{{--<div class="col mb-6 mb-md-0">--}}
								{{--<ul class="row list-unstyled products-group no-gutters border-bottom border-md-bottom-0">--}}
									{{--<li class="col-4 col-md-4 col-xl-2gdot5 product-item remove-divider-sm-down border-0">--}}
										{{--<div class="product-item__outer h-100">--}}
											{{--<div class="remove-prodcut-hover product-item__inner px-xl-4 p-3">--}}
												{{--<div class="product-item__body pb-xl-2">--}}
													{{--<div class="mb-2 d-none d-md-block"><a href="../shop/product-categories-7-column-full-width.html" class="font-size-12 text-gray-5">Speakers</a></div>--}}
													{{--<h5 class="mb-1 product-item__title d-none d-md-block"><a href="#" class="text-blue font-weight-bold">Wireless Audio System Multiroom 360 degree Full base audio</a></h5>--}}
													{{--<div class="mb-2">--}}
														{{--<a href="../shop/single-product-fullwidth.html" class="d-block text-center"><img class="img-fluid" src="../../assets/img/212X200/img1.jpg" alt="Image Description"></a>--}}
													{{--</div>--}}
													{{--<div class="flex-center-between mb-1 d-none d-md-block">--}}
														{{--<div class="prodcut-price">--}}
															{{--<div class="text-gray-100">$685,00</div>--}}
														{{--</div>--}}
													{{--</div>--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
									{{--</li>--}}
									{{--<li class="col-4 col-md-4 col-xl-2gdot5 product-item remove-divider-sm-down">--}}
										{{--<div class="product-item__outer h-100">--}}
											{{--<div class="remove-prodcut-hover add-accessories product-item__inner px-xl-4 p-3">--}}
												{{--<div class="product-item__body pb-xl-2">--}}
													{{--<div class="mb-2 d-none d-md-block"><a href="../shop/product-categories-7-column-full-width.html" class="font-size-12 text-gray-5">Speakers</a></div>--}}
													{{--<h5 class="mb-1 product-item__title d-none d-md-block"><a href="#" class="text-blue font-weight-bold">Tablet White EliteBook Revolve 810 G2</a></h5>--}}
													{{--<div class="mb-2">--}}
														{{--<a href="../shop/single-product-fullwidth.html" class="d-block text-center"><img class="img-fluid" src="../../assets/img/212X200/img2.jpg" alt="Image Description"></a>--}}
													{{--</div>--}}
													{{--<div class="flex-center-between mb-1 d-none d-md-block">--}}
														{{--<div class="prodcut-price d-flex align-items-center position-relative">--}}
															{{--<ins class="font-size-20 text-red text-decoration-none">$1999,00</ins>--}}
															{{--<del class="font-size-12 tex-gray-6 position-absolute bottom-100">$2 299,00</del>--}}
														{{--</div>--}}
													{{--</div>--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
									{{--</li>--}}
									{{--<li class="col-4 col-md-4 col-xl-2gdot5 product-item remove-divider-sm-down remove-divider">--}}
										{{--<div class="product-item__outer h-100">--}}
											{{--<div class="remove-prodcut-hover add-accessories product-item__inner px-xl-4 p-3">--}}
												{{--<div class="product-item__body pb-xl-2">--}}
													{{--<div class="mb-2 d-none d-md-block"><a href="../shop/product-categories-7-column-full-width.html" class="font-size-12 text-gray-5">Speakers</a></div>--}}
													{{--<h5 class="mb-1 product-item__title d-none d-md-block"><a href="#" class="text-blue font-weight-bold">Purple Solo 2 Wireless</a></h5>--}}
													{{--<div class="mb-2">--}}
														{{--<a href="../shop/single-product-fullwidth.html" class="d-block text-center"><img class="img-fluid" src="../../assets/img/212X200/img3.jpg" alt="Image Description"></a>--}}
													{{--</div>--}}
													{{--<div class="flex-center-between mb-1 d-none d-md-block">--}}
														{{--<div class="prodcut-price">--}}
															{{--<div class="text-gray-100">$685,00</div>--}}
														{{--</div>--}}
													{{--</div>--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
									{{--</li>--}}
								{{--</ul>--}}
								{{--<div class="form-check pl-4 pl-md-0 ml-md-4 mb-2 pb-2 pb-md-0 mb-md-0 border-bottom border-md-bottom-0">--}}
									{{--<input class="form-check-input" type="checkbox" value="" id="inlineCheckbox1" checked disabled>--}}
									{{--<label class="form-check-label mb-1" for="inlineCheckbox1">--}}
										{{--<strong>This product: </strong> Ultra Wireless S50 Headphones S50 with Bluetooth - <span class="text-red font-size-16">$35.00</span>--}}
									{{--</label>--}}
								{{--</div>--}}
								{{--<div class="form-check pl-4 pl-md-0 ml-md-4 mb-2 pb-2 pb-md-0 mb-md-0 border-bottom border-md-bottom-0">--}}
									{{--<input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option1" checked>--}}
									{{--<label class="form-check-label mb-1 text-blue" for="inlineCheckbox2">--}}
										{{--<span class="text-decoration-on cursor-pointer-on">Universal Headphones Case in Black</span> - <span class="text-red font-size-16">$159.00</span>--}}
									{{--</label>--}}
								{{--</div>--}}
								{{--<div class="form-check pl-4 pl-md-0 ml-md-4 mb-2 pb-2 pb-md-0 mb-md-0 border-bottom border-md-bottom-0">--}}
									{{--<input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option2" checked>--}}
									{{--<label class="form-check-label mb-1 text-blue" for="inlineCheckbox3">--}}
										{{--<span class="text-decoration-on cursor-pointer-on">Headphones USB Wires</span> - <span class="text-red font-size-16">$50.00</span>--}}
									{{--</label>--}}
								{{--</div>--}}
							{{--</div>--}}
							{{--<div class="col-md-auto">--}}
								{{--<div class="mr-xl-15">--}}
									{{--<div class="mb-3">--}}
										{{--<div class="text-red font-size-26 text-lh-1dot2">$244.00</div>--}}
										{{--<div class="text-gray-6">for 3 item(s)</div>--}}
									{{--</div>--}}
									{{--<a href="#" class="btn btn-sm btn-block btn-primary-dark btn-wide transition-3d-hover">Add all to cart</a>--}}
								{{--</div>--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</div>--}}
					<div class="tab-pane fade active show" id="Jpills-two-example1" role="tabpanel" aria-labelledby="Jpills-two-example1-tab">
						{!! $data['product']->description !!}
					</div>
					@if($data['product']->enable_reviews)
						<div class="tab-pane fade" id="Jpills-four-example1" role="tabpanel" aria-labelledby="Jpills-four-example1-tab">
							<div class="row mb-8">
								<div class="col-md-6">
									<div class="mb-3">
										@php
											$totalreview=0;
											$getreview=Review::where('product_id', $data['product']->id)->get();
											foreach($getreview as $reviewvalue)
											{
												$totalreview=$totalreview+1;
											}
											if(!$totalreview>0){
											$totalreview=1;
													}
											$rev=0;
											$count=0;
											$getreview=Review::where('product_id', $data['product']->id)->get();
											foreach($getreview as $reviewvalue)
											{
												$count=$count+1;
												$rev=$rev+$reviewvalue->rating;
											}
											if($count!=0){
											$ratingvalue=$rev/$count;
											}
											else{
											$ratingvalue=0;
											}
										@endphp
										<h3 class="font-size-18 mb-6">Based on {{$count}} reviews</h3>
										<h2 class="font-size-30 font-weight-bold text-lh-1 mb-0">{{number_format($ratingvalue, 1)}}</h2>
										<div class="text-lh-1">overall</div>
									</div>

									<!-- Ratings -->
									<ul class="list-unstyled">
										<li class="py-1">
											<a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
												<div class="col-auto mb-2 mb-md-0">
													<div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
														<small class="fas fa-star"></small>
														<small class="fas fa-star"></small>
														<small class="fas fa-star"></small>
														<small class="fas fa-star"></small>
														<small class="far fa-star text-muted"></small>
													</div>
												</div>
												<div class="col-auto mb-2 mb-md-0">
													<div class="progress ml-xl-5" style="height: 10px; width: 200px;">
														@php
															$count=0;
															$getreview=Review::where('product_id', $data['product']->id)->where('rating','>=','4')->get();
															foreach($getreview as $reviewvalue)
															{
																$count=$count+1;
															}

															$gain=($count/$totalreview)*100;
														@endphp
														<div class="progress-bar" role="progressbar" style="width: {{$gain}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>



													</div>
												</div>
												<div class="col-auto text-right">
													<span class="text-gray-90">{{$count}}</span>

												</div>
											</a>
										</li>
										<li class="py-1">
											<a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
												<div class="col-auto mb-2 mb-md-0">
													<div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
														<small class="fas fa-star"></small>
														<small class="fas fa-star"></small>
														<small class="fas fa-star"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
													</div>
												</div>
												<div class="col-auto mb-2 mb-md-0">
													<div class="progress ml-xl-5" style="height: 10px; width: 200px;">
														@php
															$count=0;
															$getreview=Review::where('product_id', $data['product']->id)->where('rating','3')->get();
															foreach($getreview as $reviewvalue)
															{
																$count=$count+1;
															}
															$gain=($count/$totalreview)*100;
														@endphp
														<div class="progress-bar" role="progressbar" style="width: {{$gain}}%;" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-auto text-right">
													<span class="text-gray-90">{{$count}}</span>
												</div>
											</a>
										</li>
										<li class="py-1">
											<a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
												<div class="col-auto mb-2 mb-md-0">
													<div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
														<small class="fas fa-star"></small>
														<small class="fas fa-star"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
													</div>
												</div>
												<div class="col-auto mb-2 mb-md-0">
													<div class="progress ml-xl-5" style="height: 10px; width: 200px;">
														@php
															$count=0;
															$getreview=Review::where('product_id', $data['product']->id)->where('rating','2')->get();
															foreach($getreview as $reviewvalue)
															{
																$count=$count+1;
															}
															$gain=($count/$totalreview)*100;
														@endphp


														<div class="progress-bar" role="progressbar" style="width: {{$gain}}%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-auto text-right">
													<span class="text-gray-90">{{$count}}</span>
												</div>
											</a>
										</li>
										<li class="py-1">
											<a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
												<div class="col-auto mb-2 mb-md-0">
													<div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
														<small class="fas fa-star"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
													</div>
												</div>
												<div class="col-auto mb-2 mb-md-0">
													<div class="progress ml-xl-5" style="height: 10px; width: 200px;">

														@php
															$count=0;
															$getreview=Review::where('product_id', $data['product']->id)->where('rating','1')->get();
															foreach($getreview as $reviewvalue)
															{
																$count=$count+1;
															}
															$gain=($count/$totalreview)*100;
														@endphp
														<div class="progress-bar" role="progressbar" style="width: {{$gain}}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-auto text-right">
													<span class="text-gray-90">{{$count}}</span>
												</div>
											</a>
										</li>
										<li class="py-1">
											<a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
												<div class="col-auto mb-2 mb-md-0">
													<div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
														<small class="fas fa-star"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
														<small class="far fa-star text-muted"></small>
													</div>
												</div>
												<div class="col-auto mb-2 mb-md-0">
													<div class="progress ml-xl-5" style="height: 10px; width: 200px;">
														@php
															$count=0;
															$getreview=Review::where('product_id', $data['product']->id)->where('rating','1')->get();
															foreach($getreview as $reviewvalue)
															{
																$count=$count+1;
															}
															$gain=($count/$totalreview)*100;
														@endphp
														<div class="progress-bar" role="progressbar" style="width: {{$gain}}%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>
												<div class="col-auto text-right">
													<span class="text-gray-90">{{$count}}</span>
												</div>
											</a>
										</li>
									</ul>
									<!-- End Ratings -->
								</div>
								<div class="col-md-6">
									<h3 class="font-size-18 mb-5">Add a review</h3>
									<!-- Form -->
									<form class="js-validate" action="{{url('product_review')}}" method="POST">
										<div class="row align-items-center mb-4">
											<div class="col-md-4 col-lg-3">
												<label for="rating" class="form-label mb-0">Your Review</label>
											</div>
											@csrf
											<div class="col-md-8 col-lg-9">
												<a href="javascript:;" class="d-block">
													<div class="text-warning text-ls-n2 font-size-16">
														<small class="fas fa-star text-muted review"></small>
														<small class="fas fa-star text-muted review"></small>
														<small class="fas fa-star text-muted review"></small>
														<small class="fas fa-star text-muted review"></small>
														<small class="fas fa-star text-muted review"></small>
														<input type="hidden" name="review-value" id="review-value" value="0" data-msg="Please select your Rating."
															   data-error-class="u-has-error"
															   data-success-class="u-has-success" required>
														<input type="hidden" value="{{$data['product']->id}}" name="productid">
													</div>
												</a>
											</div>
										</div>
										<div class="js-form-message form-group mb-3 row">
											<div class="col-md-4 col-lg-3">
												<label for="descriptionTextarea" class="form-label">Your Review</label>
											</div>
											<div class="col-md-8 col-lg-9">
													<textarea class="form-control" rows="3" name="review" id="descriptionTextarea"
															  data-msg="Please enter your message."
															  data-error-class="u-has-error"
															  data-success-class="u-has-success" required></textarea>
											</div>
										</div>
										<div class="js-form-message form-group mb-3 row">
											<div class="col-md-4 col-lg-3">
												<label for="inputName" class="form-label">Name <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-8 col-lg-9">
												<input type="text" class="form-control" name="name" id="inputName" aria-label="Alex Hecker" required
													   data-msg="Please enter your name."
													   data-error-class="u-has-error"
													   data-success-class="u-has-success">
											</div>
										</div>
										<div class="js-form-message form-group mb-3 row">
											<div class="col-md-4 col-lg-3">
												<label for="emailAddress" class="form-label">Email <span class="text-danger">*</span></label>
											</div>
											<div class="col-md-8 col-lg-9">
												<input type="email" class="form-control" name="emailAddress" id="emailAddress" aria-label="alexhecker@pixeel.com" required
													   data-msg="Please enter a valid email address."
													   data-error-class="u-has-error"
													   data-success-class="u-has-success">
											</div>
										</div>
										<div class="row">
											<div class="offset-md-4 offset-lg-3 col-auto">
												<button type="submit" class="btn btn-primary-dark btn-wide transition-3d-hover">Add Review</button>
											</div>
										</div>
									</form>
									<!-- End Form -->
								</div>
							</div>
							<!-- Review -->
							@php
								$count=0;
								$getreview=Review::where('product_id', $data['product']->id)->get();
							@endphp
							@foreach($getreview as $reviewvalue)
								@php
									$count=$reviewvalue->rating;
								@endphp
								<div class="border-bottom border-color-1 pb-4 mb-4">
									<!-- Review Rating -->
									<div class="d-flex justify-content-between align-items-center text-secondary font-size-1 mb-2">
										<div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">

											@for($i=1; $i<=$count; $i++)
												<small class="fas fa-star"></small>
											@endfor
										</div>
									</div>
									<!-- End Review Rating -->

									<p class="text-gray-90">{{$reviewvalue->review}}</p>

									<!-- Reviewer -->
									<div class="mb-2">
										<strong>{{$reviewvalue->name}}</strong>
										<span class="font-size-13 text-gray-23">-{{date($reviewvalue->created_at)}}</span>
									</div>
									<!-- End Reviewer -->
								</div>@endforeach
						<!-- End Review -->

						</div>
					@endif
				</div>
			</div>
			<!-- End Tab Content -->
		</div>
		<!-- End Single Product Tab -->
		<!-- Related products -->
		@if($data['product']->related_products->count()>0)
		<div class="mb-6">
			<div class="d-flex justify-content-between align-items-center border-bottom border-color-1 flex-lg-nowrap flex-wrap mb-4">
				<h3 class="section-title mb-0 pb-2 font-size-22">Related products</h3>
			</div>
			<ul class="row list-unstyled products-group no-gutters">
				@foreach($data['product']->related_products as $product)
				<li class="col-6 col-md-3 col-xl-2gdot4-only col-wd-2 product-item">
					<div class="product-item__outer h-100">
						<div class="product-item__inner px-xl-4 p-3">
							<div class="product-item__body pb-xl-2">
								{{--<div class="mb-2"><a href="{{ url($product->permalink->slug) }}" class="font-size-12 text-gray-5">Speakers</a></div>--}}
								<h5 class="mb-1 product-item__title"><a href="{{ url($product->permalink->slug) }}" class="text-blue font-weight-bold">{{ $product->name }}</a></h5>
								<div class="mb-2">
									@if($product->images->count()>0)
										@php
											$proImage= $product->images->first();
										@endphp
									<a href="{{ url($product->permalink->slug) }}" class="d-block text-center"><img class="img-fluid" src="{{url('public/uploads/products/'.$proImage->images)}}" alt="{{ $product->name }}"></a>@endif
								</div>
								<div class="flex-center-between mb-1">
									@include('store.product.blocks.price', ['type' => 'block'])
									<div class="d-none d-xl-block prodcut-add-cart">
										<a href="#" class="btn-add-cart btn-primary transition-3d-hover card_add_to_cart" data-product-id="{{ $product->id }}"><i class="ec ec-add-to-cart"></i></a>
									</div>
								</div>
							</div>
							<div class="product-item__footer">
								<div class="border-top pt-2 flex-center-between flex-wrap">
									<a href="{{ route('store-product-compare', $product->permalink->slug) }}" class="text-gray-6 font-size-13"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
									<a href="#" class="text-gray-6 font-size-13 trigger_wish_list" data-product-id="{{ $product->id }}"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
								</div>
							</div>
						</div>
					</div>
				</li>
				@endforeach

			</ul>
		</div>
		@endif
		<!-- End Related products -->
		<!-- Brand Carousel -->
	@include('store.sections.brands')
		<!-- End Brand Carousel -->
	</div>
@endsection

@push('css')

@endpush

@push('js')
	<script>

		var add_to_cart = "{{ route('store-cart-add') }}";
		var csrf_token = "{{csrf_token()}}";
		$(document).ready(function () {
			var review_value=0;
			$('.review').on('click', function(){
				if(this.className=='far fa-star text-muted review'){
			$(this).removeClass("far fa-star text-muted review").addClass("far fa-star review");
			review_value=review_value+1;
			$("#review-value").val(review_value);
				}
				else{           
			$(this).removeClass("far fa-star review").addClass("far fa-star text-muted review");
			review_value=review_value-1;
			$("#review-value").val(review_value);

				}
			});
		});
	</script>

	<script src="{{ url('public/assets/store/product/index.js')}}"></script>
@endpush

@push('metaInfo')
	{!! isset($data['product']->schema) ? $data['product']->schema : "" !!}
	<title>{{ isset($data['product']) ? $data['product']->meta_title : config('app.name') }}</title>
	<meta name="title" content="{{ isset($data['product']) ? $data['product']->meta_title : config('app.name') }}">
	<meta name="description" content="{{ isset($data['product']) ? $data['product']->meta_description : config('app.name') }}">
	<meta name="keywords" content="{{ isset($data['product']) ? $data['product']->meta_keywords : config('app.name') }}">
@endpush
