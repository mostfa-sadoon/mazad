@extends('layouts.site')
@section('title')
@lang('app/all.my_bids')
@endsection
@section('content')




<!-- Start Content Page -->
<div id="content" class="page-content">
	
	@include('front.includes.items.profile_nav' , ['page' => 'my_bids'])

	<section class="mazadat_sec">
		<div class="mazadat">
			<div class="container">
				<div class="row">

					@foreach ($auctions as $i => $item)

						@php
							
						@endphp

						<div class="col-md-3 col-sm-6 col-xs-6">
						@include('front.includes.items.auction' , ['item' => $item , 'type'=>''])
						</div>

					@endforeach

				</div>
			</div>

			{{--  <nav class="pagination_pages" aria-label="...">
				<ul class="pagination">
					<li class="page-item disabled">
						<span class="page-link page-link_icon"><i class="fa fa-caret-left"></i></span>
					</li>
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item active">
						<span class="page-link">2</span>
					</li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item">
						<a class="page-link page-link_icon" href="#"><i class="fa fa-caret-right"></i></a>
					</li>
				</ul>
			</nav>  --}}
			<div class="" style="margin: 0 auto;text-align: center;">
					{!! $auctions->links() !!}
			</div>

		</div>

	</section>

</div>


<div class="modal fade notifications-pop" id="deleteAuction" tabindex="-1" role="dialog"
	aria-labelledby="deleteAuctionLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="image">
					<img src="images/icons/delete2.svg" />
				</div>
				<p>@lang('app/all.are_you_sure_about_deleting_your_account?')</p>
				<div class="modal-btns">
					<button type="button" class="btn btn-delete">@lang('app/all.yes')</button>
					<button type="button" class="btn btn-close" data-dismiss="modal">@lang('app/all.no'), @lang('app/all.thanks')</button>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- End Content Page -->






@endsection

@section('scripts')

@endsection