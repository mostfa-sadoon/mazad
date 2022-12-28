@extends('layouts.site')

@section('title')
@lang('app/all.add_auction')
@endsection

@section('styles')
@endsection

@section('content')




		<div id="content" class="page-content offwhite-page">
			<section class="add-auction">

				<form action="{{ route('auction.create') }}" method="get">
					{{--  @csrf  --}}

					<div class="container">

			<div class="col-sm-8 col-sm-offset-2 includes"  >
				@include('front.includes.alerts.success')
				@include('front.includes.alerts.errors')
			  </div>

						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<div class="head-steps">
									<div class="step-one active"><span>1</span><p>@lang('app/all.category')</p></div>
									<div class="step-tow"><span>2</span><p>@lang('app/all.details')</p></div>
									<div class="step-three"><span>3</span><p>@lang('app/all.done')</p></div>
								</div>

								@isset($categories)

								<div class="card">
									<h3 class="card-head">@lang('app/all.category') <p>@lang('app/all.choose_your_category')</p></h3>
									<div class="card-body">
									<div class="bs-form-control">
										<div class="dropdown dropdown-select">
											<button class="btn btn-default dropdown-toggle" type="button" id="input-category" data-toggle="dropdown" aria-expanded="true">@lang('app/all.choose_your_category') <i class="fa fa-chevron-down"></i>
											</button>
											<ul class="dropdown-menu" role="menu" aria-labelledby="input-category">
												@foreach ($categories as $category)
												<li role="presentation"><label role="menuitem" tabindex="-1" for="category{{$category->id}}"><img src="{{ $category->image }}" alt="{{$category->name}}" /> {{$category->name}}</label></li>
												@endforeach
											</ul>
										</div>
									</div>


										<div class="sub_category-list">
											@foreach ($categories as $category)
											<input class="category_radio" type="radio" name="category_id" id="category{{$category->id}}" value="{{$category->id}}" title="{{$category->name}}">
											@if($category->childrens && count($category->childrens) != 0)
											<div class="childrens-list">
												<div class="bs-form-control">
													<div class="hidden">
														@foreach ($category->childrens as $children)
														<input class="category_radio" type="radio" name="sub_category_id" id="sub_category{{$children->id}}" value="{{$children->id}}" title="{{$children->name}}">
														@endforeach
													</div>
													<div class="dropdown dropdown-select">
														<button class="btn btn-default dropdown-toggle" type="button" id="input-sub_category" data-toggle="dropdown" aria-expanded="true">@lang('app/all.sub_cats0')<i class="fa fa-chevron-down"></i>
														</button>
														<ul class="dropdown-menu" role="menu" aria-labelledby="input-sub_category">
															@foreach ($category->childrens as $children)
															<li role="presentation"><label role="menuitem" tabindex="-1" for="sub_category{{$children->id}}"><img src="{{ $children->image }}" alt="{{$children->name}}" /> {{$children->name}}</label></li>
															@endforeach
														</ul>
													</div>
												</div>
											</div>
											@endif


											@endforeach
										</div>
									</div>
								</div>

								<div class="foot">
									<button type="submit" class="btn btn-primary">@lang('app/all.next')</button>
								</div>

								@endisset

							</div>
						</div>
					</div>
				</form>
			</section>
		</div>

		<!-- End Content Page -->


<script>
//get all the radio buttons
var radios = document.querySelectorAll('input[type=radio]');
//get only the checked radio button
var checked = document.querySelectorAll('input[type=radio]:checked');
//get the submit button
var btn = document.querySelector('[type=submit]');
//disable the button on page load by checking the length
if(!checked.length){
  btn.setAttribute("disabled", "disabled");
}
//attach the event handler to all the radio buttons with forEach and addEventListener
radios.forEach(function(el){
  el.addEventListener('click', function(){
    checked = document.querySelectorAll('input[type=radio]:checked');
    if(checked.length){
      //enable the button by removing the attribute
      btn.removeAttribute("disabled");
    }
  });
});
</script>


@endsection

@section('scripts')

@endsection
