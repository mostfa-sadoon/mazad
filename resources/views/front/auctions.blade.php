@extends('layouts.site')
@section('title')
@lang('app/all.main_cats')
@endsection
@section('content')




<!-- Start Content Page -->
<div id="content" class="page-content">



	<div id="search-control">
		<div class="container">
			<form class="search-form" action="{{ route('client.auctions') }}" method="GET">
				<div class="row">

					<div class="col-sm-3">
						<div class="bs-form-control">
							<div class="form-group"> <span class="text-info loading"
									style="display: none">loading...</span>
								<select class="form-control my_custom_select" id="category_id" name="category_id">
									<option value="">@lang('app/all.all-category')</option>
									@foreach ($categories as $level)
									<option @if ($category_id && $category_id == $level->id) selected @endif value="{{ $level->id }}">{{$level->name }}</option>
									@endforeach

									{{-- @if ($req_category_id == null) --}}
									{{-- <optgroup label="@lang('app/all.main_cats')">
										@foreach ($categories->where('parent_id' , null) as $level)
										<option value="{{ $level->id }}">{{$level->name }}</option>
										@endforeach
									</optgroup>
									<optgroup label="@lang('app/all.sub_cats')">
										@foreach ($categories->where('parent_id' , '<>' , null) as $level)
											<option value="{{ $level->id }}">{{$level->name }}</option>
											@endforeach
									</optgroup> --}}
									{{-- @else
									@endif --}}

								</select>
							</div>
						</div>


							<div id="category" class="bs-form-control @if (count($sub_categories) == 0) hidden @endif">
								<select class="form-control my_custom_select" name="sub_category_id" id="dependent" >
									<option value="">@lang("app/all.select_value")</option>

									@if (count($sub_categories) != 0)
										@foreach ($sub_categories as $level)
										<option @if ($sub_category_id && $sub_category_id == $level->id) selected @endif value="{{ $level->id }}">{{$level->name }}</option>
										@endforeach
									@endif

								</select>
								@error("nds")
								<span class="text-danger">{{$message}}</span>
								@enderror
							</div>


					</div>

					<script>
						$(document).ready(function () {

							$('select[id=category_id]').on('change', function () {
								//alert($(this).val())
								if ($(this).val() != '') {
									$('.loading').fadeIn(500)
									//console.log($('.loading'))
									var select = $(this).attr("id");
									var value = $(this).val();
									var _token = "{{ csrf_token() }}";
									$.ajax({
										url: "{{ route('sub_category.fetch') }}",
										method: "POST",
										data: { select: select, value: value, _token: _token },
										success: function (result) {
											//alert(result)
											if(result){
												$('#category').attr('class' , 'bs-form-control')
												$('#dependent').html(result);
											}else{
												$('#category').attr('class' , 'bs-form-control hidden')
												$('#dependent').val('');
											}
											$('.loading').fadeOut(500)
										}

									})
								}

							});


						});
					</script>

					<div class="col-sm-3">
						<div class="bs-form-control">
							<div class="form-group">
								<select class="form-control my_custom_select" name="city_id">
									<option selected disabled>@lang('app/all.all-city')</option>
									@foreach ($cities as $level)
									<option @if ($city_id && $city_id == $level->id) selected @endif value="{{ $level->id }}">{{$level->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="bs-form-control">
							<div class="form-group">
								<select class="form-control my_custom_select" name="auction_type">
									<option selected disabled>@lang('app/all.all-auctions')</option>
									<option @if ($auction_type && $auction_type == 1) selected @endif value="1">@lang('app/all.latest_auctions')</option>
									<option @if ($auction_type && $auction_type == 2) selected @endif value="2">@lang('app/all.soon_auctions')</option>
									<option @if ($auction_type && $auction_type == 3) selected @endif value="3">@lang('app/all.closed_auctions')</option>
								</select>
								@error("country_id")
								<span class="text-danger">{{$message}}</span>
								@enderror
							</div>
						</div>
					</div>

					<div class="col-sm-3">
						<button type="submit" class="btn btn-block btn-primary"
							style="margin-top: 16px;">@lang('app/all.search0')</button>
					</div>
				</div>
			</form>
		</div>
	</div>


	<section class="mazadat_sec">
		<div class="mazadat">
			<div class="container">
				<div class="row">

                    @if($search=false)
                        @foreach ($marked_auctions as $i => $item)
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            @include('front.includes.items.auction' , ['item' => $item , 'type'=>''])
                        </div>
                        @endforeach
                    @endif
					@foreach ($auctions as $i => $item)

					<div class="col-md-3 col-sm-6 col-xs-6">
						@include('front.includes.items.auction' , ['item' => $item , 'type'=>''])
					</div>

					@endforeach


				</div>
			</div>

			{{-- <nav class="pagination_pages" aria-label="...">
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
			</nav> --}}

			@if (count($auctions) != 0)
			<div class="" style="margin: 0 auto;text-align: center;">
				{!! $auctions->links() !!}
			</div>
			@endif

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
