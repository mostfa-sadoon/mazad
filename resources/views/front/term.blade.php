@extends('layouts.site')
@section('title')
@lang('app/all.terms_conditions')
@endsection
@section('content')






		<!-- Start Content Page -->
		<div id="content" class="page-content">
			{{--  <nav class="breadcrumb-sec" aria-label="breadcrumb">
				<div class="container">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">@lang('app/all.home')</a></li>
					<li class="breadcrumb-item active" aria-current="page">@lang('app/all.terms_conditions')</li>
				  </ol>
				</div>
			</nav>  --}}
			<div class="text-page">
				<div class="container">
					<h2 class="title_sec">@lang('app/all.terms_conditions')</h2>


					<p>{{$term->translateOrDefault()->desc}}</p>
				</div>
			</div>
			<section id="contact">
				<div class="container">
					<div class="contact_icons">
						<div class="contact-box">
							<div class="image"><img src="{{ asset('assets/front/images/icons/call-1.svg') }}" /></div>
							<div class="content">
								<b>@lang('app/all.location')</b>
								<p>Wahran, Algeria</p>
							</div>
						</div>
						<div class="contact-box">
							<div class="image"><img src="{{ asset('assets/front/images/icons/call.svg') }}" /></div>
							<div class="content">
								<b>@lang('app/all.Contact')</b>
								<p class="direction-ltr"><a href="tel:{{$ContactUs->number}}">{{$ContactUs->number}}</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- End Content Page -->





@endsection

@section('scripts')

@endsection
