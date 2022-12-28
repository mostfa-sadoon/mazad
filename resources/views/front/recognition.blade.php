@extends('layouts.site')
@section('title')
@lang('app/all.Your_Auction_added_successfully')
@endsection
@section('content')





		
		<!-- Start Content Page -->
		<div id="content" class="page-content">
			<div class="auction_added_successfully">
				<div class="container">
					
			<div class="includes container" style="margin: 0 auto;" >
				@include('front.includes.alerts.success')
				@include('front.includes.alerts.errors')
			</div>

			
			<div class="head-steps">
				<div class="step-one active"><span>1</span><p>@lang('app/all.category')</p></div>
				<div class="step-tow active"><span>2</span><p>@lang('app/all.details')</p></div>
				<div class="step-three active"><span>3</span><p>@lang('app/all.done')</p></div>
			</div>
			
					<div class="col-sm-8 col-sm-offset-2">
						<div class="added_successfully">
							<div class="image"><img src="{{ asset('assets/front/images/icons/delete-1.svg') }}" /></div>
							<p>@lang('app/all.Your_Auction_added_successfully')</p>
							<div class="foot-btns">
								<a href="{{ route('client.auction.show', ['slug'=>$slug]) }}" class="btn btn-success">@lang('app/all.View_auction')</a>
							</div>
						</div>
						<div class="add-primary">
							<h3>@lang('app/all.Make_your_auction_special')</h3>

							<form action="{{ route('auction.recognition', ['id'=> $auction_id]) }}" method="post">
								@csrf
								{{--  <input type="text" name="auction_id" value="{{ $auction_id }}">  --}}

								<div class="primary-boxs">
									<ul>

										@foreach ($recognitions as $i=>$item)
											<li>
												<label>
													<input type="radio" id="offer_2" value="{{ $item->id }}" name="recognition_id" class="offer_checkbox" @if($i==0) checked @endif >
													<div class="primary-box">
														<div class="image"><img src="{{ asset('assets/front/images/logo.png') }}" /></div>
														<div class="offer">
															<b>{{ $item->name }}</b>
															<p>{{ $item->days }} @lang('app/all.Days')</p>
														</div>
														<div class="box-right">
															<div class="ico"><img src="{{ asset('assets/front/images/icons/Icon ionic-md-checkmark.svg') }}" /></div>
															<div class="price">{{ $item->price }}$</div>
														</div>
													</div>
												</label>
											</li>
										@endforeach
										
									</ul>
									<div class="foot-btns">
										<button type="submit" class="btn btn-success">@lang('app/all.PAY_AND_PUBLISH')</button>
									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Content Page -->






@endsection

@section('scripts')

@endsection