@extends('layouts.site')

@section('title')
@lang('app/all.add_auction')
@endsection
@section('content')
@section('styles')
<style>
	.attr-lbls{
		font-weight: 600;
    	font-size: 16px;
	}
</style>
@endsection



<!-- Start Content Page -->
<div id="content" class="page-content offwhite-page">
	<section class="add-auction">
		<div class="container">
			<div class="includes container" style="margin: 0 auto;" >
				@include('front.includes.alerts.success')
				@include('front.includes.alerts.errors')
			</div>
			<form action="{{ route('auction.insert') }}" method="post" enctype="multipart/form-data">
				@csrf

				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="head-steps">
							<div class="step-one step-done"><span>1</span><p><a href="{{ route('client.categories') }}">@lang('app/all.category')</a></p></div>
							<div class="step-tow active"><span>2</span><p>@lang('app/all.details')</p></div>
							<div class="step-three"><span>3</span><p>@lang('app/all.done')</p></div>
						</div>
						{{--  ____________________________________________ Auction Detail ________________________________________________________  --}}
						<div class="card">
							<h3 class="card-head">@lang('app/all.add_auction')</h3>
							<div class="card-body">
								<div class="bs-form-control">
									<input type="text" class="input-form-control" name="name" placeholder="@lang('app/all.title')"
										value="{{ old('name') }}" required>
										@error("name")
											<span class="text-danger">{{$message}}</span>
										@enderror
								</div>
								<div class="bs-form-control">
									<textarea class="input-form-control" placeholder="@lang('app/all.description')" name="description"
										 required>{{ old('description') }}</textarea>
										@error("description")
											<span class="text-danger">{{$message}}</span>
										@enderror
								</div>
								<div class="bs-form-control form-control-currency">
									<input type="number" class="input-form-control CurrencyInput" name="min_price"
										value="{{ old('min_price') }}" placeholder="@lang('app/all.reservation_price')" onkeypress="return onlyNumberKey(event)"  required>
										@error("min_price")
											<span class="text-danger">{{$message}}</span>
										@enderror
									{{--  <span class="currency">DZD</span>  --}}
								</div>
								<div class="bs-form-control form-control-currency">
									<input type="number" class="input-form-control CurrencyInput" name="max_price"
										value="{{ old('max_price') }}" placeholder="@lang('app/all.closing_price')" onkeypress="return onlyNumberKey(event)"  required>
										@error("max_price")
											<span class="text-danger">{{$message}}</span>
										@enderror
									{{--  <span class="currency">DZD</span>  --}}
								</div>

								{{--  <div class="bs-form-control">
									loading
									<i class="fa fa-spinner fa-spin fa-2x text-info" style="">
								</div>  --}}

								<div class="bs-form-control"> <span class="text-info loading" style="display: none">loading...</span>
									<select class="form-control my_custom_select" name="country_id" required>
										<option value="">@lang('app/all.select_country')</option>
										@foreach ($countries as $level)
											<option value="{{$level->id}}" >{{ $level->name }}</option>
										@endforeach
									</select>
									@error("country_id")
										<span class="text-danger">{{$message}}</span>
									@enderror
								</div>

								<div class="bs-form-control" >
									<select class="form-control my_custom_select" name="city_id" id="dependent" required>
										<option value="">@lang('app/all.select_city')</option>
									</select>
									@error("city_id")
										<span class="text-danger">{{$message}}</span>
									@enderror
								</div>

							</div>
						</div>
						{{--  ____________________________________________ End of Auction Detail ________________________________________________________  --}}
						{{--  _______________________________________ Category ______________________________________________  --}}
                        {{-- {{dd($category[0])}} --}}
                        {{-- @if (count($category[0]->attributes) == 0) hidden @endif --}}
						<div class="card"  @if (count($category[1]->attributes) ==0) hidden @endif >
							<h3 class="card-head">@lang('app/all.features')</h3>
							{{--  <p>{{ $category->_parent->name }} >> <span class="text-info">{{ $category->name }}</span></p>  --}}
							<div class="card-body">
								@php
									$cats =[];
									$attributes_ids =[];
									$types =[];
								@endphp
								@foreach ($category as $cat)
									@php
										$cats[] = $cat->id;
										$attributes_ids = array_merge($attributes_ids , $cat->attributes()->pluck('id')->toArray());
                                        $types = array_merge($types , $cat->attributes()->pluck('type')->toArray());
									@endphp
								@endforeach
								<input type="hidden" name="category_id" value="{{ $category_id }}">
								<input type="hidden" name="attributes_ids" value="{{ implode('-' , $attributes_ids) }}">
								<input type="hidden" name="types" value="{{ implode('-' , $types) }}">
								@foreach ($category as $cat)
								@foreach ($cat->attributes as $attr)
									@if ($attr->type == 0)
										<div class="form-group">
											<label class="attr-lbls" for="{{$attr->id}}">{{$attr->name}}</label>
											<select class="form-control my_custom_select" name="features[]" id="{{$attr->id}}" required>
												<option value="">@lang('app/all.select_value')</option>
												@foreach ($attr->sub_attributes as $sub_attr)
													<option value="{{ $sub_attr->id }}" >{{ $sub_attr->name }}</option>
												@endforeach
											</select>
											{{--  @error("features")
												<span class="text-danger">{{$message}}</span>
											@enderror  --}}
										</div>
									@else
										<div class="form-group">
											<label class="attr-lbls" for="{{$attr->id}}">{{$attr->name}}</label>
											<input @if ($attr->type == 1)
															type="number"
														@else
															type="text"
														@endif  name="features[]" id="{{$attr->id}}" class="form-control my_custom_input" placeholder="@lang('app/all.enter_value')" required>
										</div>
									@endif
								@endforeach
								@endforeach
								@if(session()->has('error_attributes'))
									<div class="col-md-12">
										<span class="text-danger" style="font-weight: bold;">{{session()->get('error_attributes')}}</span>
									</div>
								@endif
								@error("features")
									<span class="text-danger">{{$message}}</span>
								@enderror

							</div>
						</div>

						{{--  _______________________________________ End of Category ______________________________________________  --}}


						{{--  _______________________________________ Date and Time Ending Auction ______________________________________________  --}}
						<div class="card">
							<h3 class="card-head">@lang('app/all.date_and_time_ending_auction')</h3>
							<div class="card-body">

									<div class="bs-form-control date" data-date-format="yyyy-mm-dd">
										<input id="datetimepicker6" type="text" name="start_date" class="btn btn-default" placeholder="@lang('app/all.start_date')" value="{{ old('start_date') }}" required>
										<img src="{{ asset('assets/front/images/icons/Calendar.svg')}}" />
										@error("start_date")
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>

								<div class="bs-form-control date" data-date-format="yyyy-mm-dd">
									<input id="datetimepicker7" type="text" name="end_date" class="btn btn-default"
										placeholder="@lang('app/all.end_date_time')" value="{{ old('end_date') }}" required>
									<img src="{{ asset('assets/front/images/icons/Calendar.svg')}}" />
									@error("end_date")
										<span class="text-danger">{{$message}}</span>
									@enderror
								</div>

							</div>
						</div>
						{{--  _______________________________________ End of Date and Time Ending Auction ______________________________________________  --}}


						{{--  ____________________________________________ Images ________________________________________________________  --}}
						<div class="card">
							<h3 class="card-head">@lang('app/all.images')</h3>
							<div class="card-body">
								<div class="images-upload">

									<div class="image main_image">
										<label for="imgMain">
											<input type="file" name="cover" id="imgMain"  />
											<img id="mainImage" src="{{ asset('assets/front/images/transparent.png')}}" />
											<span>
												<img src="{{ asset('assets/front/images/icons/Icon feather-upload-cloud.svg')}}" />
												<p>@lang('app/all.upload_main_image')</p>
											</span>
										</label>
										<div class="image-here"></div>
									</div>

									<div class="image">
										<label for="imgOther1">
											<input type="file" name="images[]" id="imgOther1">
											<img id="imgOther-1" src="{{ asset('assets/front/images/transparent.png')}}" />
											<span>
												<img src="{{ asset('assets/front/images/icons/Icon feather-upload-cloud.svg')}}" />
												<p>@lang('app/all.upload_others')</p>
											</span>
										</label>
										<div class="image-here"></div>
									</div>
									<div class="image">
										<label for="imgOther2">
											<input type="file" name="images[]" id="imgOther2" />
											<img id="imgOther-2" src="{{ asset('assets/front/images/transparent.png')}}" />
											<span>
												<img src="{{ asset('assets/front/images/icons/Icon feather-upload-cloud.svg')}}" />
												<p>@lang('app/all.upload_others')</p>
											</span>
										</label>
									</div>
									<div class="image">
										<label for="imgOther3">
											<input type="file" name="images[]" id="imgOther3" />
											<img id="imgOther-3" src="{{ asset('assets/front/images/transparent.png')}}" />
											<span>
												<img src="{{ asset('assets/front/images/icons/Icon feather-upload-cloud.svg')}}" />
												<p>@lang('app/all.upload_others')</p>
											</span>
										</label>
									</div>
									<div class="image">
										<label for="imgOther4">
											<input type="file" name="images[]" id="imgOther4" />
											<img id="imgOther-4" src="{{ asset('assets/front/images/transparent.png')}}" />
											<span>
												<img src="{{ asset('assets/front/images/icons/Icon feather-upload-cloud.svg')}}" />
												<p>@lang('app/all.upload_others')</p>
											</span>
										</label>
									</div>
									<div class="image">
										<label for="imgOther5">
											<input type="file" name="images[]" id="imgOther5" />
											<img id="imgOther-5" src="{{ asset('assets/front/images/transparent.png')}}" />
											<span>
												<img src="{{ asset('assets/front/images/icons/Icon feather-upload-cloud.svg')}}" />
												<p>@lang('app/all.upload_others')</p>
											</span>
										</label>
									</div>
									<div class="image">
										<label for="imgOther6">
											<input type="file" name="images[]" id="imgOther6" />
											<img id="imgOther-6" src="{{ asset('assets/front/images/transparent.png')}}" />
											<span>
												<img src="{{ asset('assets/front/images/icons/Icon feather-upload-cloud.svg')}}" />
												<p>@lang('app/all.upload_others')</p>
											</span>
										</label>
									</div>
								</div>
								@error("cover")
									<span class="text-danger">{{$message}}</span>
									<br>
								@enderror
								@error("images")
									<span class="text-danger">{{$message}}</span>
								@enderror
							</div>
						</div>
						{{--  ____________________________________________ End of Images ________________________________________________________  --}}

						{{--  ____________________________________________ Video ________________________________________________________  --}}
						<div class="card">
							<h3 class="card-head">@lang('app/all.video') <span>@lang('app/all.optional')</span></h3>
							<div class="card-body">
								<div class="video-upload">
									<div class="video_youtube">
										<label for="video_url">
											<span>
												<img src="{{ asset('assets/front/images/icons/Group 76916.svg')}}" />
												<input type="url" name="video" placeholder="@lang('app/all.youtube_video_url')"  value="{{ old('video') }}"
													id="video_url" class="video_url" />
											</span>
										</label>
										@error("video")
											<span class="text-danger">{{$message}}</span>
										@enderror
									</div>
								</div>
							</div>
						</div>
						{{--  ____________________________________________ End of Video ________________________________________________________  --}}


						{{--  ____________________________________________ Map ________________________________________________________  --}}




							<div class="card">
								<h3 class="card-head">@lang('app/all.location')</h3>
								<div class="card-body">
									<input type="text" id="pac-input" class="form-control" name="address" required>
									<div id="map" style="height: 300px;"></div>
								</div>
							</div>










						<!--<div class="card">-->

						<!--	<h3 class="card-head">@lang('app/all.location')</h3>-->

						<!--	@error("longitude")-->
						<!--		<span class="text-danger">{{$message}}</span>-->
						<!--	@enderror-->

						<!--	@error("longitude")-->
						<!--		<span class="text-danger">{{$message}}</span>-->
						<!--	@enderror-->

						<!--	<div class="row hidden">-->

						<!--		<div class="col-md-3">-->
						<!--			<div class="form-group">-->
						<!--				<label for="latitude"> {{ __('admin/forms.latitude') }} </label>-->
						<!--				<input type="text" id="latitude" class="form-control"-->
						<!--					name="latitude" value="{{ old('latitude') }}" required>-->
						<!--				@error("latitude")-->
						<!--				<span class="text-danger">{{$message}}</span>-->
						<!--				@enderror-->
						<!--			</div>-->
						<!--		</div>-->

						<!--		<div class="col-md-3">-->
						<!--			<div class="form-group">-->
						<!--				<label for="longitude"> {{ __('admin/forms.longitude') }} </label>-->
						<!--				<input type="text" id="longitude" class="form-control"-->
						<!--					name="longitude" value="{{ old('longitude') }}" required>-->
						<!--				@error("longitude")-->
						<!--				<span class="text-danger">{{$message}}</span>-->
						<!--				@enderror-->
						<!--			</div>-->
						<!--		</div>-->


								@error("address")
								<span class="text-danger"> {{$message}}</span>
								@enderror

							</div>



						</div>
						{{--  ____________________________________________ End of Map ________________________________________________________  --}}

						<div class="foot">
							<button type="submit" class="btn btn-primary">@lang('app/all.submit_auction')</button>
						</div>

					</div>
				</div>
			</form>
		</div>
	</section>
</div>

<!-- End Content Page -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
	$(function () {
		$('#datetimepicker6').datetimepicker({
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			minDate: new Date()
		});
		$('#datetimepicker7').datetimepicker({
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			},
			useCurrent: false //Important! See issue #1075
		});
		$("#datetimepicker6").on("dp.change", function (e) {
			$('#datetimepicker7').data("DateTimePicker").minDate(e.date);
		});
		$("#datetimepicker7").on("dp.change", function (e) {
			$('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
		});
	});


	{{--  $(document).ready(function () {
		var specifications = document.getElementById('Specifications-form');
		$('.category_radio').change(function () {
			if ($('#optionsRadios1').is(':checked')) {
				specifications.innerHTML = '<div class="bs-form-control"><input type="text" class="input-form-control" name="View" placeholder="View" value="" ></div><div class="bs-form-control"><input type="number" class="input-form-control" id="Number_bath_rooms" name="Number_bath_rooms" placeholder="Number of bath rooms" value="" onkeypress="return isNumberKey(event)" ></div><div class="bs-form-control"><select class="input-form-control" ><option value="" disabled selected hidden>Area</option><option>Area 1</option><option>Area 2</option><option>Area 3</option><option>Area 4</option></select></div><div class="bs-form-control"><select class="input-form-control" ><option value="" disabled selected hidden>Number of Bed rooms</option><option>1</option><option>2</option><option>3</option><option>4</option></select></div>';
			}
		});
		$('.category_radio').change(function () {
			if ($('#optionsRadios2').is(':checked')) {
				specifications.innerHTML = '<div class="bs-form-control"><input type="text" class="input-form-control" name="View" placeholder="View 2" value="" ></div><div class="bs-form-control"><input type="number" class="input-form-control" id="Number_bath_rooms" name="Number_bath_rooms" placeholder="Number of bath rooms 2" value="" onkeypress="return isNumberKey(event)" ></div><div class="bs-form-control"><input type="text" class="input-form-control" name="Area" placeholder="Area 2" value="" ></div><div class="bs-form-control"><input type="number" class="input-form-control" id="Number_bed_rooms" name="Number_bed_rooms" placeholder="Number of Bed rooms 2" value="" onkeypress="return isNumberKey(event)" ></div>';
			}
		});
		$('.category_radio').change(function () {
			if ($('#optionsRadios3').is(':checked')) {
				specifications.innerHTML = '<div class="bs-form-control"><input type="text" class="input-form-control" name="View" placeholder="View 3" value="" ></div><div class="bs-form-control"><input type="number" class="input-form-control" id="Number_bath_rooms" name="Number_bath_rooms" placeholder="Number of bath rooms 3" value="" onkeypress="return isNumberKey(event)" ></div><div class="bs-form-control"><input type="text" class="input-form-control" name="Area" placeholder="Area 3" value="" ></div><div class="bs-form-control"><input type="number" class="input-form-control" id="Number_bed_rooms" name="Number_bed_rooms" placeholder="Number of Bed rooms 3" value="" onkeypress="return isNumberKey(event)" ></div>';
			}
		});
		$('.category_radio').change(function () {
			if ($('#optionsRadios4').is(':checked')) {
				specifications.innerHTML = '<div class="bs-form-control"><input type="text" class="input-form-control" name="View" placeholder="View" value="" ></div><div class="bs-form-control"><input type="number" class="input-form-control" id="Number_bath_rooms" name="Number_bath_rooms" placeholder="Number of bath rooms" value="" onkeypress="return isNumberKey(event)" ></div><div class="bs-form-control"><select class="input-form-control" ><option value="" disabled selected hidden>Area</option><option>Area 1</option><option>Area 2</option><option>Area 3</option><option>Area 4</option></select></div><div class="bs-form-control"><select class="input-form-control" ><option value="" disabled selected hidden>Number of Bed rooms</option><option>1</option><option>2</option><option>3</option><option>4</option></select></div>';
			}
		});
	});  --}}




</script>

<script>
var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script>


<script>
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
</script>




{{--  @section('scripts')  --}}

<script>
    $(document).ready(function(){

     $('select[name=country_id]').on('change', function() {
		console.log($(this).val())
      if($(this).val() != '')
      {
        $('.loading').fadeIn(500)
        console.log($('.loading'))
       var select = $(this).attr("id");
       var value = $(this).val();
       var _token = "{{ csrf_token() }}";
       $.ajax({
        url:"{{ route('dynamic_dependent_countries.fetch') }}",
        method:"POST",
        data:{select:select, value:value, _token:_token},
        success:function(result)
        {
			console.log(result)
         $('#dependent').html(result);
		 $('.loading').fadeOut(500)
        }

       })
      }

     });


     $('#type').change(function(){
      $('#type_id').val('');
     });


    });
    </script>

{{--  @stop  --}}


@section('scripts')

<script>
    var map, infoWindow;
    var geocoder;
    function initMap() {

        // Display a map on the page
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 24.740691, lng: 46.6528521 },
            mapTypeId: 'roadmap',
            zoom: 13
        });

        map.setTilt(45);

        // Try HTML5 geolocation to get location
          infoWindow = new google.maps.InfoWindow;
          geocoder = new google.maps.Geocoder;
        var  input = document.getElementById('pac-input');

        var autocomplete = new google.maps.places.Autocomplete(
            input, {place_id: true});
            autocomplete.bindTo('bounds', map);


//
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(pos),
                    map: map,
                    draggable: true,
					animation: google.maps.Animation.DROP,
					icon: "{{asset('assets/images/markers/status1.svg')}}" ,
                    title: 'Position'
                });
                /*infoWindow.setPosition(pos);
                infoWindow.setContent('Your position');
                marker.addListener('click', function() {
                  infoWindow.open(map, marker);
                });
                infoWindow.open(map, marker);*/
                map.setCenter(pos);

                updateMarkerPosition(marker.getPosition());
                geocodePosition(pos);

                // Add dragging event listeners.
                google.maps.event.addListener(marker, 'dragstart', function() {
                    updateMarkerAddress('Dragging...');
                });

                google.maps.event.addListener(marker, 'drag', function() {
                    updateMarkerStatus('Dragging...');
                    updateMarkerPosition(marker.getPosition());
                });

                google.maps.event.addListener(marker, 'dragend', function() {
                    updateMarkerStatus('Drag ended');
                    geocodePosition(marker.getPosition());
                    map.panTo(marker.getPosition());
                });

                google.maps.event.addListener(map, 'click', function(e) {
                    updateMarkerPosition(e.latLng);
                    geocodePosition(marker.getPosition());
                    marker.setPosition(e.latLng);
                    map.panTo(marker.getPosition());
                    //updateMarkerAddress('jbbjbjb')
                });

            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }

        //
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();

            if (!place.place_id) {
                return;
            }
            geocoder.geocode({'placeId': place.place_id}, function (results, status) {

                if (status !== 'OK') {
                    window.alert('Geocoder failed due to: ' + status);
                    return;
                }
                map.setZoom(13);
                map.setCenter(results[0].geometry.location);
                // Set the position of the marker using the place ID and location.

            });
        });
    }

    //
    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        }, function(responses) {
            if (responses && responses.length > 0) {
                updateMarkerAddress(responses[0].formatted_address);
            } else {
                updateMarkerAddress('Cannot determine address at this location.');
            }
        });
    }
    function updateMarkerStatus(str) {
      //  document.getElementById('markerStatus').innerHTML = str;
    }
    function updateMarkerPosition(latLng) {
        $("#latitude").val(latLng.lat());
        $("#longitude").val(latLng.lng());

    }
    function updateMarkerAddress(str) {
        //$("#address").val(str);
        //$("#pac-input").val(str);
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
