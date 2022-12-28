@extends('layouts.site')
@section('title')
@lang('app/all.notifications')
@endsection
@section('content')





		<!-- Start Content Page -->
		<div id="content" class="page-content">
			{{--  <nav class="breadcrumb-sec" aria-label="breadcrumb">
				<div class="container">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">@lang('app/all.home')</a></li>
					<li class="breadcrumb-item active" aria-current="page">@lang('app/all.notifications')</li>
				  </ol>
				</div>
			</nav>  --}}
			<section id="notifications">
				<div class="container">
					<div class="noti-boxs">

						@foreach ($notifications as $noty)
						@php
							$auction = \App\Models\Auction::find(\App\Models\Biding::find($noty->type_id)->auction_id);
							$biding = \App\Models\Biding::find($noty->type_id);
						@endphp
							<a href="{{ route('client.auction.show', ['slug'=>$auction->slug]) }}" class="noti-box">
								<div class="image">
									<img src="{{ asset('assets/front/images/icons/Group 76915.svg') }}" />
								</div>
								<div class="content">
									<h3>{{ getNotificationMessage($noty->message_id) }}
										@if ($noty->message_id == 1)
											<span class="text-info">{{ $biding->value }} </span>{{ $auction->country->currency }}
										@endif
										@if ($noty->message_id == 2)
											<span class="text-success">{{ $biding->value }} </span>{{ $auction->country->currency }}
										@endif
									</h3>
									@if ($noty->sender_model == 'client' && $noty->type == 'biding')
										<p><b>@lang('app/all.from') : </b>{{ \App\Models\Client::find($noty->sender_id)->f_name }}</p>
										<p><b>@lang('app/all.auction') : </b>{{ $auction->name }}</p>
									@endif
								</div>
								<div class="date">{{ $noty->created_at }}</div>
							</a>
						@endforeach

					</div>
					@if (count($notifications) != 0)
				<div class="" style="margin: 0 auto;text-align: center;">
						{!! $notifications->links() !!}
				</div>
			@endif
				</div>
			</section>
		</div>
		<!-- End Content Page -->
			
		




@endsection

@section('scripts')

@endsection