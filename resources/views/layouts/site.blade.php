<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	{{-- <title>MAZAD KNISS</title> --}}
	<title>@yield('title')</title>
	<link href="{{asset('assets/front/images/icon.ico')}}" rel="icon">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Bootstrap -->
	<script src="{{asset('assets/front/js/jquery-2.1.1.min.js')}}" type="text/javascript"></script>

	@if (app() -> getLocale() === 'ar')
	<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/bootstrap-rtl.min.css')}}">
	@else
	<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/bootstrap.min.css')}}">
	@endif
	<link rel="stylesheet" type="text/css" href="{{asset('assets/front/fonts/font-awesome/css/font-awesome.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/front/fonts/font.css')}}">
	<link href="{{asset('assets/front/css/swiper.min.css')}}" type="text/css" rel="stylesheet" media="screen" />
	<script src="{{asset('assets/front/js/swiper.min.js')}}"></script>
	<!-- Stylesheet
            ================================================== -->
	@if (app() -> getLocale() === 'ar')
	<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/style-rtl.css')}}">
	@else
	<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/style.css')}}">
	@endif

	<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/animate.min.css')}}">

	@yield('styles')

</head>

<body>
	<div class="overlapblackbg"></div>
	<!-- Start Header -->
	<div id="footer_mob">
		<a class="active" href="{{ route('client.home') }}">
			<div class="ico"><i class="fa fa-home"></i></div>
			<p>@lang('app/all.home')</p>
		</a>
		<a href="{{ route('client.profile') }}">
			<div class="ico"><i class="fa fa-user"></i></div>
			<p>@lang('app/all.profile')</p>
		</a>
		<a class="ico_add_auction" href="{{ route('client.categories') }}">
			<div class="ico"><i class="fa fa-plus"></i></div>
			<p>@lang('app/all.add_auction')</p>
		</a>
	</div>

	<nav id="top">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="head_links_l">
						<div class="language">
							<div class="dropdown">
								<button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
									aria-expanded="true">

									@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

									@if ($localeCode == App::getLocale())
									<img src="{{ asset($properties['img']) }}" /> {{ $properties['native'] }}
									@endif

									@endforeach


									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">

									@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
										<li role="presentation">
											<a role="menuitem" tabindex="-1"  hreflang="{{ $localeCode }}"
												href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
												<img src="{{ asset($properties['img']) }}" /> {{ $properties['native'] }}
											</a>
										</li>
									@endforeach

								</ul>
							</div>
						</div>
						<div class="country">
							<div class="dropdown">
							  <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">

							{{-- @if (isset($country_id) && $country_id != 0)
								<img src="{{ findCountry($country_id)->image }}" />
								{{ findCountry($country_id)->name }}
							@else --}}

								@if (auth('client')->check())
									<img src="{{ auth('client')->user()->country->image }}" />
									{{ auth('client')->user()->country->name }}
								@else
									@if(Session::get('country_id')!=null)
									<img src="{{ findCountry(Session::get('country_id'))->image }}" />
									{{findCountry(Session::get('country_id'))->name}}
									 @else
										<img src="{{ firstCountry()->image }}" />
										{{ firstCountry()->name }}
									 @endif
								@endif
							{{-- @endif --}}

								<span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
								@foreach(getCountries() as $item)
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="{{ route('client.home', ['country_id'=> $item->id]) }}"><img src="{{ $item->image }}" /> {{ $item->name }}</a>
									</li>
								@endforeach
							  </ul>
							</div>
						</div>
						<div class="head-ico_serch visible-xs-inline-block">
							<a class="ico_serch"><i class="fa fa-search"></i></a>
						</div>
					</div>
				</div>
				<div class="col-sm-6 hidden-xs">
					<div class="links_right">
                        <form method="get" action='{{route('client.auctions')}}' class="hidden-xs">
                            <div id="search-h" class="head-search">
                                <input type="text" name="search_input" value="" placeholder="@lang('app/all.search_for_items')">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>

							<ul class="top_links">
								@guest('client')
									<li><a href="{{ route('client.login') }}">@lang('app/all.login')</a></li>
									<li><a href="{{ route('client.register') }}">@lang('app/all.create_account')</a></li>
								@endguest
								@auth('client')
									<li><a href="{{ route('client.logout') }}">@lang('app/all.logout')</a></li>
								@endauth
							</ul>
						</form>
                    
					</div>
				</div>
			</div>
		</div>
	</nav>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-sm-4 hidden-xs">
					<ul class="header-links">
						<li class="active"><a href="{{ route('client.home') }}">@lang('app/all.home')</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
								aria-expanded="false">@lang('app/all.categories') <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								@foreach (getCategories() as $item)
								<li><a href="{{ route('client.auctions', ['category_id'=>$item->id]) }}"><img src="{{ $item->image }}" class="entity-img" />{{ $item->name }}</a></li>
								@endforeach
							</ul>
						</li>
						<li><a href="{{ route('about_us') }}">@lang('app/all.about')</a></li>
					</ul>
				</div>
				<div class="col-md-2 col-sm-4 col-xs-3">
					<div class="logo">
						<a href="{{ route('client.home') }}"><img src="{{getlogo()}}" /></a>
					</div>
				</div>
				<div class="col-md-5 col-sm-4 col-xs-9">
					<div class="icons-links">
						<ul>
							<li><a class="notifications" href="{{ route('notifications') }}"><i class="fa fa-bell"></i></a></li>
							<li><a class="favorite" href="{{ route('favourits.index') }}"><i class="fa fa-heart"></i></a></li>
							<li><a class="profile @auth('client') profile-name @endauth" href="{{ route('client.profile') }}">@auth('client')
								<img src="{{ auth('client')->user()->photo }}" style="width: 35px;height: 35px;border-radius: 50% 50%;" alt="">
								{{auth('client')->user()->f_name}}
							@endauth
								@guest('client')
								<i class="fa fa-user"></i>
								@endguest
							</a></li>
							<li class="visible-xs-inline-block"><a class="nav-trigger" id="nav-trigger"><i
										class="fa fa-bars"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- overlay !-->
		<form method="get" action='{{route('client.auctions')}}' id="search-pop" class="">
			<a class="close-btn" id="close-search">
				<em class="fa fa-times"></em>
			</a>
			<div id="search-t" class="head-search">
				<input type="text" name="search_input" value="" placeholder="@lang('app/all.search_for_items')">
			</div>
			<button type="submit"><i class="fa fa-search"></i></button>
		</form>
		<div id="main_menu" class="links">
			<ul>
				<li>
					<a href="{{ route('client.home') }}">@lang('app/all.home')</a>
				</li>
				<li>
					<a href="{{ route('about_us') }}">@lang('app/all.about')</a>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" id="dropdownMenu10" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="true" href="#">@lang('app/all.categories') <i class="fa fa-angle-down"></i></a>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu10">
						@foreach (getCategories() as $item)
						<li><a href="{{ route('client.auctions', ['category_id'=>$item->id]) }}"><img src="{{ $item->image }}" class="entity-img" />{{ $item->name }}</a></li>
						@endforeach
					</ul>
				</li>
				@guest('client')
				<li><a href="{{ route('client.login') }}">@lang('app/all.login')</a></li>
				<li><a href="{{ route('client.register') }}">@lang('app/all.create_account')</a></li>
				@endguest
				<li>
					<a href="{{ route('faq') }}">@lang('app/all.faq')</a>
				</li>
				<li>
					<a href="{{route('site.terms')}}">@lang('app/all.terms_conditions')</a>
				</li>
				<li>
					<a href="">@lang('app/all.privacy')</a>
				</li>
				@auth('client')
				<li><a href="{{ route('client.logout') }}">@lang('app/all.logout')</a></li>
				@endauth
			</ul>
		</div>
		<!--- /overlay -->
	</header>
	<!-- End Header -->



	<!-- Start Content Page -->

	@yield('content')

	<!-- End Content Page -->

        <div class="add_auction_link">
            <div class="add_auction_box">
                <input type="checkbox" id="auction_box" />
                <label for="auction_box"></label>
                <a href="{{ route('client.categories') }}">@lang('app/all.add_auction')</a>
            </div>
        </div>

	<!-- Start Footer -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="logo">
						<img src="{{asset('assets/front/images/logo.png')}}" alt="MAZAD KNISS" title="MAZAD KNISS" />
					</div>
				</div>
				<div class="col-sm-6">
					<div class="links">
						<a href="{{ route('about_us') }}">@lang('app/all.about')</a>
						<a href="{{ route('faq') }}">@lang('app/all.faq')</a>
						<a href="{{route('site.terms')}}">@lang('app/all.terms_conditions')</a>
						<a href="{{route('site.Privacy')}}">@lang('app/all.privacy')</a>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<div id="footer_bottom">
		<div class="social_links">
            @foreach (socialmedias() as $media)
			<a href="{{$media->url}}" target="_blank">{!! $media->icon !!}</a>
            @endforeach
		</div>
		<p>@lang('app/all.all_rights_reserved') <i class="fa fa-copyright"></i> 2022</p>
	</div>
	<!-- End Footer -->


	<!-- Latest compiled and minified JavaScript -->
	<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>


	<!-- Javascripts
            ================================================== -->
			<script>
				var icon_path = "{{ asset('assets/front/images/icons/dropdown-1.svg') }}"
			</script>
	<script type="text/javascript" src="{{asset('assets/front/js/main.js')}}"></script>

	@yield('scripts')

</body>

</html>
