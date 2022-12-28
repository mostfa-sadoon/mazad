@extends('layouts.site')

@section('title')
@lang('app/all.profile')
@endsection

@section('styles')
	
@endsection

@section('content')


@include('front.includes.items.success_model')


<!-- Start Content Page -->
<div id="content" class="page-content">
	
	{{--  <nav class="breadcrumb-sec" aria-label="breadcrumb">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Profile</li>
			</ol>
		</div>
	</nav>  --}}

	@include('front.includes.items.profile_nav' , ['page' => 'profile'])

	<div class="page_form">
		<div class="container">
			<h2 class="title_sec">@lang('app/all.your_personal_information')</h2>
			<div class="form-sign">
				<form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="image_profile">
						<label for="imgprofile">
							<input type="file" name="photo" id="imgprofile" />
							<img id="myprofile" src="{{ $client->photo }}" alt="mohamed ahmed" />
							<span>
								<img src="{{ asset('assets/front/images/icons/Camera.svg')}}" />
							</span>
						</label>
					</div>
					<h2 class="name">{{ $client->f_name }} {{ $client->l_name }}</h2>




					<div class="bs-form-control">
						<div class="row">
                            <div class="col-xs-6">
                                <input type="text" class="input-form-control" id="f_name" name="f_name"
                                    placeholder="@lang('app/all.first_name')" value="{{ $client->f_name }}" >
                                    @error("f_name")
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                            </div>
                            <div class="col-xs-6">
                                <input type="text" class="input-form-control" id="l_name" name="l_name"
                                    placeholder="@lang('app/all.last_name')" value="{{ $client->l_name }}" >
                                    @error("l_name")
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                            </div>
                        </div>
					</div>
					<div class="bs-form-control direction-ltr">
						
						<input name="country_code" type="hidden" class="input-form-control" id="country_code" value="{{ $client->country_code }}">
                        @error("country_code")
                            <span class="text-danger">{{$message}}</span>
                        @enderror

						<input name="phone" type="tel" class="input-form-control" id="phone_cc" value="{{ $client->phone }}" required>
						<div id="error-msg"></div>
						<div id="valid-msg"></div>
						@error("phone")
							<span class="text-danger">{{$message}}</span>
						@enderror

					</div>
					
					<div class="bs-form-control">

						<div class="form-group">
							<select class="form-control my_custom_select" name="country_id">
								<option selected disabled>@lang('app/all.select_country')</option>
									@foreach ($countries as $level)
										<option value="{{ $level->id }}" @if ($level->id == $client->country_id)
											selected
												@endif >{{$level->name }}
										</option>
									@endforeach
							</select>
						  	@error("country_id")
								<span class="text-danger">{{$message}}</span>
							@enderror
						</div>


                        {{--  <div class="hidden">
                            @foreach ($countries as $level)
                            <input type="radio" name="country_id" id="{{$level->id}}" value="{{ $level->id }}"
                                title="{{ $level->name }}" @if ($level->id == $client->country_id)
									checked
								@endif >{{$level->name }}
                            @endforeach
                        </div>
                        <div class="dropdown dropdown-select">
                            <button class="btn btn-default dropdown-toggle" type="button" id="input-country"
                                data-toggle="dropdown" aria-expanded="true">Country <img
                                    src="{{ asset('assets/front/images/icons/dropdown-1.svg') }}" />
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="input-country">
                                @foreach ($countries as $level)
                                    <li role="presentation" @if ($level->id == $client->country_id)
																class="active"
															@endif >
										<label role="menuitem" tabindex="-1" for="{{$level->id}}">{{$level->name }}</label>
									</li>
                                @endforeach
                            </ul>
                        </div>  --}}
                    </div>
					
					<div class="bs-form-control">
						<input type="email" class="input-form-control" name="email" placeholder="@lang('app/all.email')" value="{{$client->email}}" >
						@error("email")
							<span class="text-danger">{{$message}}</span>
						@enderror
					</div>
					
					<div class="foot-btns">
						<input class="btn btn-primary" type="submit" value="@lang('app/all.save')">
						<a href="{{ route('client.password.edit') }}" class="btn btn-yellow">@lang('app/all.change_password')</a>

						<div class="bs-form-text text-center">
							<a data-toggle="modal" data-target="#acceptBid" href="#" >@lang('app/all.delete_account')</a>
						</div>

						<div class="modal fade notifications-pop" id="acceptBid" tabindex="-1" role="dialog" aria-labelledby="acceptBidLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-body">
										<div class="image">
											<img src="{{ asset('assets/front/images/icons/delete-2.svg')}}" />
										</div>
										<p>@lang('app/all.are_you_sure_about_deleting_your_account?')</p>
										<div class="modal-btns" style="display: inline-flex;">
											
												<a href="{{ route('client.delete_account') }}" class="btn btn-accept">@lang('app/all.yes')</a>
											<div style="text-align: left">
												<button type="button" class="btn btn-close" data-dismiss="modal">@lang('app/all.no'), @lang('app/all.thanks')</button>
											</div>

										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End Content Page -->
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{asset('assets/front/js/intlTelInput.js')}}"></script>
<script>
  function togglePass() {
    var pass = document.getElementById("id_password");
    var element = document.getElementById("pass_eye");
    element.classList.toggle("active");
    if (pass.type === "password") {
      pass.type = "text";
    } else {
      pass.type = "password";
    }
  }
</script>
<script>
  $(document).ready(function () {
    $(".ok").click(function(){
      $("#successfullyBid").fadeOut(200);
  })
	  
	  var _token = "{{ csrf_token() }}";
    var telInput = $("#phone_cc"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");
        $('#phone_cc').val("{{$client->country_code}}{{$client->phone}}");
        $('#country_code').val("{{$client->country_code}}");

    // initialise plugin
    telInput.intlTelInput({
        hiddenInput: "full_phone",
        initialCountry: "auto",
        geoIpLookup: function (callback) {
            $.get('https://ipinfo.io?token=5e396a67095eee', function () {
            }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        preferredCountries: ["sa", "ae", "kw", "bh", "om", "qa", "ye", "iq", "eg", "sd", "ma", "jo", "ps", "lb", "sy", "us", "tr"],
        utilsScript: "{{asset('assets/front/js/utils.js')}}"
    });
        $('#phone_cc').keydown(function () {
            //alert('ssssss')
            var countryCode = $('.selected-flag').attr('title');
            let code = countryCode.split(': ')
            $('#country_code').val(code[1])
        });

        $('.intl-tel-input').click(function () {
            var countryCode = $('.selected-flag').attr('title');
            let code = countryCode.split(': ')
           // {{--  //alert(code[1])  --}}
            $('#country_code').val(code[1])
            var countryCode = countryCode.replace(/[^0-9]/g, '')
        });
	  

    var reset = function () {
        telInput.removeClass("error");
        errorMsg.addClass("hide");
        validMsg.addClass("hide");
    };

    // on blur: validate
    telInput.blur(function () {
        reset();
        if ($.trim(telInput.val())) {
            if (telInput.intlTelInput("isValidNumber")) {
                validMsg.removeClass("hide");
            } else {
                alert('@lang('app/all.Incorrect_phone_number_format')');
                telInput.val('');
            }
        }
    });
    });
</script>

<script>
    $(document).ready(function () {

		var menu = document.getElementById("main_menu");
		var btnico = document.getElementById("nav-trigger");
	$('#nav-trigger').on('click', function() {
		
		menu.classList.toggle("active");
		btnico.classList.toggle("cansel");
		
	});
    $("#close-menu ").on('click', function() {
		
		menu.classList.toggle("active");
		btnico.classList.toggle("cansel");

    });
    $(".ico_serch ").on('click', function() {
		$("#search-pop").toggleClass('active');

    });
    $("#close-search ").on('click', function() {
		$("#search-pop").toggleClass('active');

    });
        
        
    });
</script>

<script>
	function togglePass() {
		var pass = document.getElementById("id_password");
		if (pass.type === "password") {
			pass.type = "text";
		} else {
			pass.type = "password";
		}
	}
	function toggleNPass() {
		var pass = document.getElementById("id_Npassword");
		if (pass.type === "password") {
			pass.type = "text";
		} else {
			pass.type = "password";
		}
	}
</script>

<script>
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}    
</script>





@endsection

@section('scripts')
	<script src="{{asset('assets/front/profile/main.js')}}" type="text/javascript"></script>
@endsection