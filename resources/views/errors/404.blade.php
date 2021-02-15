@extends('store.layouts.template')
@section('content')
	<main id="main" class="withBanner">
		<div class="bannerArea big" style="background-image: url({{asset('public/assets/store/images/img1.png')}});"></div>
		<div class="p-SingleLine"></div>
		<div class="container">
			<h2>Page not found!</h2>

			<div class="simpleTextBox">
				<a href="{{ url()->previous() }}">Click here</a> to go back to previous page.
			</div>
		</div>
	</main>
@endsection


@push('css')
@endpush

@push('js')
@endpush

@push('metaInfo')
	<title>Page not found! | {{ config('app.name') }}</title>
@endpush
