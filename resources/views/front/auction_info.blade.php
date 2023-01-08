@extends('layouts.site')

@section('title')
{{$auction->name}}
@endsection

@section('content')

<!-- Start Content Page -->
<div id="content" class="page-content">

	{{--  <nav class="breadcrumb-sec" aria-label="breadcrumb">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Realestates</li>
			</ol>
		</div>
	</nav>  --}}

	<div class="banner-head-auction">
		<div class="container">

			@include('front.includes.alerts.success')
			@include('front.includes.alerts.errors')

<div class="col-md-12 col-xs-12">
				<div class="banner">
					@foreach($header_auctions as $banner)
					<a href="{{ $banner->url }}"><img src="{{ asset('assets/images/banner/'.Config::get('app.locale') .'/'. $banner->img)}}" /></a>
					@endforeach
				</div>
			</div>

		</div>
	</div>
	<div class="auction_info">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<div class="auction-left">
						<div class="name">
							<h2>{{ $auction->name }}</h2>

							@include('front.includes.items.heart_icon' , ['auction'=> $auction , 'client_favourite'=> $client_favourite])

						</div>
						<ul class="auction-about">
							<li><a href="{{ route('client.auctions', ['city_id'=> $auction->city->id]) }}"><img src="{{ asset('assets/front/images/icons/location.svg')}}" /> {{
									$auction->city->name }}, </a>{{ $auction->city->country->name }}</li>
							<li><a href="{{ route('client.auctions', ['category_id'=> $auction->category->id]) }}"><img src="{{ asset('assets/front/images/icons/tag.svg')}}" /> {{
									$auction->category->name }}</a></li>
							<li><img src="{{ asset('assets/front/images/icons/id.svg')}}" /> {{ $auction->id }}</li>
						</ul>
						<p class="short-des" style="display:none;">{{ $auction->description }}</p>
						<div class="gallery">

							<div class="master-img">
								<a class="example-image-link" data-fslightbox="gallery" href="{{ $auction->cover }}" data-title="{{ $auction->name }}"><img src="{{ $auction->cover }}" /></a>
								@if (getAuctionStatus($auction)[0] != 3)
									<div class="sold">{{ getAuctionStatus($auction)[1] }}</div>
								@endif
							</div>


							<div class="swiper-small-images small-images loading">
								<i class="fa fa-caret-left"></i>
								<i class="fa fa-caret-right"></i>
								<div class="swiper-wrapper">
									<div class="swiper-slide"><img src="{{ $auction->cover }}" alt="image" ></div>
									@foreach ($auction->images as $item)

									<div class="swiper-slide"><a class="example-image-link" data-fslightbox="gallery" href="{{ $item->image }}" data-title="{{ $auction->name }}"><img src="{{ $item->image }}" /></a></div>
									@endforeach
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="auction-right">
						<div class="auction-box">
							<div class="top">
								<div class="minimum">
									<img src="{{ asset('assets/front/images/icons/money.svg')}}" />
									<span style="margin-top: 10px;">
										<p class="price">
											@if ($auction->bidings && count($auction->bidings) != 0)
											{{ number_format($auction->bidings()->max('value')) }}
											@else
											{{ number_format($auction->min_price) }}
											@endif
											<span class="currency">{{ $auction->country->currency }}</span></p>
										<p class="tx-current">@lang('app/all.current_highest_bid')</p>
									</span>
									<!--
											<p class="congratulations">Congratulations!</p>
											<p class="accept_bid">Accept Bid and End Auction</p>
											-->
								</div>

								<div class="end-time">
									<h3>
										<img src="{{ asset('assets/front/images/icons/timer.svg')}}" />
										@if (getAuctionStatus($auction)[0] != 4)
											<div id="time-end"></div>
										@else
											<div class="countdown">
												<div id="time-id-001">@lang('app/all.start_in') {{ $auction->start_date }}</div>
											</div>
										@endif

										<script>
											function countDownMain() {
												// Set the date we're counting down to
												let countDownDate = new Date("{{ $auction->end_date }} {{ $auction->end_time }}").getTime();

												// Update the count down every 1 second
												let x = setInterval(function () {

													// Get today's date and time
													let now = new Date().getTime();

													// Find the distance between now and the count down date
													let distance = countDownDate - now;

													// Time calculations for days, hours, minutes and seconds
													let days = Math.floor(distance / (1000 * 60 * 60 * 24));
													let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
													let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
													let seconds = Math.floor((distance % (1000 * 60)) / 1000);

													// Output the result in an element with id="demo"
													document.getElementById("time-end").innerHTML = "@lang('app/all.ends_at') &nbsp " + days + " : " + hours + " : "
														+ minutes + " : " + seconds + " ";

													// If the count down is over, write some text
													if (distance < 0) {
														clearInterval(x);
														document.getElementById("time-end").innerHTML = "The Auction Has Ended";
													}
												}, 1000);
											}
											countDownMain()
										</script>

									</h3>
								</div>
							</div>
							{{--  <p class="buyer"><img
									src="{{ asset('assets/front/images/icons/Icon ionic-md-information-circle.svg')}}" />
								There is a buyers fee of 1.5% if applicable</p>  --}}
							<div class="history">@lang('app/all.bid_history') (<span>{{ $auction->bidings_count }} @lang('app/all.bid')</span>)</div>
							<div class="offers">
								<div class="offer-head">
									<div class="colm">@lang('app/all.bid') (ZDZ)</div>
									<div class="colm">@lang('app/all.time')</div>
									<div class="colm">@lang('app/all.id')</div>
								</div>
								<ul class="offers-boxs">

									@foreach ($auction->bidings as $bid)
									<li>
										<a href="#" class="offer-box">
											<div class="colms"
											@if ($bid->win == 0)
												@if (auth('client') && (auth('client')->id() == $bid->client_id)) style="color: #000 !important;" @endif
											@else
												@if ($bid->win == 1) style="color: #17b150 !important;" @endif
											@endif >
												<div class="colm">{{ number_format($bid->value) }}</div>
												<div class="colm">{{ $bid->created_at->diffForHumans() }}</div>
												<div class="colm">{{ $bid->client_id }}</div>
											</div>
											@if (!in_array(getAuctionStatus($auction)[0] , [1,2]) && auth('client') && auth('client')->id() == $auction->client_id && $auction->bidings()->where('win' , 1)->count() == 0)
												<div data-toggle="modal" data-target="#acceptBid-{{$bid->id}}" class="offer-box-hover"> @lang('app/all.accept_offer')</div>
											@endif
										</a>
									</li>


									<div class="modal fade notifications-pop" id="acceptBid-{{$bid->id}}" tabindex="-1" role="dialog" aria-labelledby="acceptBidLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-body">
													<div class="image">
														<img src="{{ asset('assets/front/images/icons/delete-2.svg')}}" />
													</div>
													<p>@lang('app/all.are_you_sure_you_want_to_accept_this_bid_nom:') {{$bid->id}} @lang('app/all.and_end_this_auction?')</p>
													<div class="modal-btns" style="display: inline-flex;">
														<form action="{{ route('auction.accept_bid', ['id'=>$bid->id]) }}" method="post" style="text-align: right">
															@csrf
															<button type="submit" class="btn btn-accept">@lang('app/all.yes')</button>
														</form>
														<div style="text-align: left">
															<button type="button" class="btn btn-close" data-dismiss="modal">@lang('app/all.no'), @lang('app/all.thanks')</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									@endforeach

								</ul>

							</div>
						</div>
						<div class="auction-right-bottom">
							{{--  <div class="minbid">
								<div class="minbidno">
									<img src="{{ asset('assets/front/images/icons/money-1.svg')}}" /> Min Bid 10 DZD
								</div>
							</div>  --}}

								@if (getAuctionStatus($auction)[0] == 3 && auth('client') && auth('client')->id() != $auction->client_id)
									<form id="addmybid" class="addmybid" method="POST" action="#">
										<button type="button" class="cashminus cash-btn" field="money"><i
												class="fa fa-minus"></i></button>

										<input type="text" name="money" id="currency-field"
										 data-type="currency" value="{{ ($auction->bidings && count($auction->bidings) != 0) ?$auction->bidings()->max('value') : $auction->min_price }}"
											min="{{ $auction->min_price }}" class="money " onkeypress="return onlyNumberKey(event)" />
										<button type="button" class="cashplus cash-btn" field="money"><i
												class="fa fa-plus"></i></button>
									</form>
								@endif

							<div class="foot">

									@if (getAuctionStatus($auction)[0] == 3 && auth('client') && auth('client')->id() != $auction->client_id)
										<form action="{{ route('auction.bid', ['id'=> $auction->id]) }}" method="post">
											@csrf
											<input type="hidden" name="price" id="price-input">
											<button type="submit" class="btn btn-add_bid" style="width: 100%;">@lang('app/all.place_a_bid')</button>
										</form>
									@endif

									@if (auth('client') && auth('client')->id() == $auction->client_id)
										<a data-toggle="modal" data-target="#deletedBid-{{$auction->id}}" class="btn btn-delete" href="#">@lang('app/all.delete_auction')</a>

										<a class="btn btn-add_to_fav" href="{{ route('auction.recognition.page', ['slug'=>$auction->slug]) }}">@lang('app/all.recognize')</a>

										<div class="modal fade notifications-pop" id="deletedBid-{{$auction->id}}" tabindex="-1" role="dialog" aria-labelledby="deletedBidLabel">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-body">
														<div class="image">
															<img src="{{ asset('assets/front/images/icons/delete2.svg')}}" />
														</div>
														<p>@lang('app/all.are_You_Sure_you_want_to_delete_your_auction_nom') {{$auction->id}} !</p>

														<div class="modal-btns" style="display: inline-flex;">
															<form action="{{ route('auction.delete', ['id'=>$auction->id]) }}" method="post" style="text-align: right">
																@csrf
																<button type="submit" class="btn btn-accept">@lang('app/all.yes'), @lang('app/all.delete')</button>
															</form>
															<div style="text-align: left">
																<button type="button" class="btn btn-close" data-dismiss="modal">@lang('app/all.no'), @lang('app/all.thanks')</button>
															</div>
														</div>

														{{--  <div class="modal-btns">
															<button type="button" class="btn btn-delete">YES, DELETE</button>
															<button type="button" class="btn btn-close" data-dismiss="modal">@lang('app/all.no'), @lang('app/all.thanks')</button>
														</div>  --}}
													</div>
												</div>
											</div>
										</div>
									@endif

							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="auction-description">
						<h2>@lang('app/all.description')</h2>
						<p>{{ $auction->description }}</p>
					</div>
					<div class="features-boxs">

						@isset($auction->features)
							@foreach ($auction->features as $feature)
								<div class="features-box">
									<b>{{ $feature->attribute->name }}</b>
									@if ($feature->sub_attribute_id == null)
										<p>{{ $feature->value }}</p>
									@else
										<p>{{ $feature->sub_attribute->name }}</p>
									@endif
								</div>
							@endforeach
						@endisset

					</div>
				</div>

				@if ($auction->video != null)
				<div class="col-sm-8">
					<div class="iframe_embed">
						<iframe width="" height="350" src="{{ $auction->video }}"
							title="Auction Video / {{ $auction->name }}" frameborder="0"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
							allowfullscreen></iframe>
					</div>
				</div>
				@endif


				@if ($auction->lat != null && $auction->lng != null)
				<div class="@if ($auction->video != null) col-sm-4 @else col-sm-12 @endif">
					<div class="iframe_embed">
						<div id="map" style="height: 350px;"></div>
					</div>
				</div>
				@endif


				@if ($auction->bidings()->where('win' , 1)->count() > 0)
				@php
				$win_biding = $auction->bidings()->where('win' , 1)->first();
				@endphp
				<div class="col-sm-12">
					<div class="winner_info">
						<h2 class="title_sec">@lang('app/all.winner_of_the_auction')</h2>
						<div class="winner-box">
							<div class="win_content">
								<div class="image"><img src="{{ $win_biding->client->photo }}" /></div>
								<h3 class="name">{{ $win_biding->client->f_name }} {{ $win_biding->client->l_name }}</h3>
							</div>
							<div class="win_location"><img
									src="{{ asset('assets/front/images/icons/Group 76292.svg')}}" /> {{ $win_biding->client->country->name }}, {{ $win_biding->client->city->name }}
							</div>
							<div class="win_phone"><img src="{{ asset('assets/front/images/icons/Group 76291.svg')}}" />
								<a href="tel:{{ $win_biding->client->country_code }}{{ $win_biding->client->phone }}">{{ $win_biding->client->country_code }}{{ $win_biding->client->phone }}  </a>
							</div>
						</div>
					</div>
				</div>
				@endif


				<div class="col-md-12 col-xs-12">
				<div class="banner">
					@foreach($footer_auctions as $banner)
					<a href="{{ $banner->url }}"><img src="{{ asset('assets/images/banner/'.Config::get('app.locale') .'/'. $banner->img)}}" /></a>
					@endforeach
			</div>

				<div class="col-sm-12">
					<div class="similar_auctions">
						<h2 class="title_sec">@lang('app/all.you_might_be_interested_in')</h2>
						<div class="row">
							<div class="mazadat">
								<section class="swiper-auctions loading">
									<div class="swiper-wrapper">

										@foreach ($interested_auctions as $item)
										<div class="swiper-slide">
											@include('front.includes.items.auction' , ['item' => $item , 'type'=>'intersted'])
										</div>
										@endforeach

									</div>
								</section>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>





@include('front.includes.items.success_model')

<!-- End Content Page -->

	<script src="{{asset('assets/front/js/fslightbox.js')}}"></script>

<script>
	jQuery(document).ready(function () {

		$(".ok").click(function(){
			$("#successfullyBid").fadeOut(200);
		})

		let min_price = "{{ ($auction->bidings && count($auction->bidings) != 0) ? $auction->bidings()->max('value') : $auction->min_price }}"

		console.log(min_price)
		$('#price-input').val(min_price);

		 $('#currency-field').keyup(function(){
              	$('#price-input').val($('#currency-field').val());
         });

		// This button will increment the value
		$('.cashplus').click(function (e) {
             $('#price-input').val($('#currency-field').val());
			// Stop acting like a button
			e.preventDefault();
			// Get the field name
			fieldName = $(this).attr('field');
			// Get its current value
			var currentVal = parseInt($('input[name=' + fieldName + ']').val());
			// If is not undefined
			if (!isNaN(currentVal)) {
				// Increment
				$('input[name=' + fieldName + ']').val(currentVal + 1);
				$('#price-input').val(currentVal + 1);
			} else {
				// Otherwise put a 0 there
				$('input[name=' + fieldName + ']').val(min_price);
				$('#price-input').val(min_price);
			}
		});
		// This button will decrement the value till 0
		$(".cashminus").click(function (e) {

			// Stop acting like a button
			e.preventDefault();
			// Get the field name
			fieldName = $(this).attr('field');
			// Get its current value
			var currentVal = parseInt($('input[name=' + fieldName + ']').val());
			// If it isn't undefined or its greater than 0
			if (!isNaN(currentVal) && currentVal > min_price) {
				// Decrement one
				$('input[name=' + fieldName + ']').val(currentVal - 1);
				$('#price-input').val(currentVal - 1);
			} else {
				// Otherwise put a 0 there
				$('input[name=' + fieldName + ']').val(min_price);
				$('#price-input').val(min_price);
			}
		});


	});



</script>



@section('scripts')

<script>
    var map, infoWindow;
    // function initMap() {

        // Display a map on the page
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 24.740691, lng: 46.6528521 },
            mapTypeId: 'roadmap',
            zoom: 13
        });

        map.setTilt(45);

        // Try HTML5 geolocation to get location
          infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: {{ $auction->lat }},
                    lng: {{ $auction->lng }}
                };

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(pos),
                    map: map,
					animation: google.maps.Animation.DROP,
					icon: "{{asset('assets/images/markers/status1.svg')}}" ,
                    title: 'Position'
                });

                map.setCenter(pos);

            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }


    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
</script>
<script>
function onlyNumberKey(evt) {

// Only ASCII character in that range allowed
var ASCIICode = (evt.which) ? evt.which : evt.keyCode
if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
return false;
return true;
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBGU2IkihGELeWGQSzgz0n8yQUvulrmvBM&libraries=places&callback=initMap" async defer></script>

@endsection

@endsection
