@extends('layouts.site')

@section('title')
@lang('app/all.create_account_n')
@endsection

@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
@endsection




<!-- Start Content Page -->
<div id="content" class="page-content sign_in-page">
    <div class="page_form">
        <div class="container">
            <h2 class="title_sec">@lang('app/all.create_account_n')</h2>
            <div class="form-sign">
                <form method="POST" action="{{ route('client.register.submit') }}">
                    @csrf

                    <div class="bs-form-control">
                        <div class="row">
                            <div class="col-xs-6">
                                <input type="text" class="input-form-control" id="f_name" name="f_name"
                                    placeholder="@lang('app/all.first_name')" required>
                                    @error("f_name")
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                            </div>
                            <div class="col-xs-6">
                                <input type="text" class="input-form-control" id="l_name" name="l_name"
                                    placeholder="@lang('app/all.last_name')" required>
                                    @error("l_name")
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bs-form-control direction-ltr">
                        <input name="country_code" type="hidden" class="input-form-control" id="country_code">
                        @error("country_code")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <input name="phone" type="tel" class="input-form-control" id="phone_cc" required>
							<div id="error-msg"></div>
							<div id="valid-msg"></div>
                            @error("phone")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>

                    <div class="bs-form-control"> <span class="text-info hide loading" style="display: none">loading...</span>
                        <select class="form-control my_custom_select" name="country_id"  >
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

                    <div class="bs-form-control">
                        <input type="email" class="input-form-control" name="email" placeholder="@lang('app/all.email')" value="" required>
                        @error("email")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="bs-form-control form-control-password">
                        <input type="password" name="password" class="input-form-control" id="id_password"
                            placeholder="@lang('app/all.password')" required>
                        <a id="pass_eye" class="pass_eye " onclick="togglePass()"><span class="span-eye"></span></a>
                        @error("password")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="bs-form-text">
                        <label for="terms_and_conditions" class="checkbox">
                            <input id="terms_and_conditions" name="accept_terms" type="checkbox" required>
                            <span class="checkbox__mark">
                                <svg width="25" height="18" viewBox="0 0 25 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.13449 12.7269L22.2809 0L25 2.64085L9.13449 18L0 9.15702L2.71912 6.51624L9.13449 12.7269Z"
                                        fill="#FFFFFF" />
                                </svg>
                            </span>
                             <a href="#" target="_blank">@lang('app/all.accept_our_terms_and_conditions')</a>
                        </label>
                        @error("accept_terms")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

        <div class="includes" style="margin: 0 auto;" >
            @include('front.includes.alerts.success')
            @include('front.includes.alerts.errors')
          </div>

                    <div class="foot-btns">
                        <input class="btn btn-primary" type="submit" value="@lang('app/all.register0')">
                        <a href="{{ route('client.login') }}" class="btn btn-yellow">@lang('app/all.login')</a>
                        <div class="bs-form-text text-center">
                            <a href="{{ route('client.home') }}">@lang('app/all.enter_as_a_visitor')</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="foot-page">
                <img src="{{asset('assets/front/images/icons/i2.svg')}}" />
            </div>
        </div>
    </div>
</div>

@section('scripts')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{asset('assets/front/js/intlTelInput.js')}}"></script>

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
	  var _token = "{{ csrf_token() }}";
    var telInput = $("#phone_cc"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");

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
            {{--  $('#phone_cc').val("");
            $('#phone_cc').val($('#phone_cc').val());  --}}
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
<!-- End Content Page -->


<script>
	const firebaseConfig = {
		apiKey: "AIzaSyA14fIRJiJTGACLYvDgHl4Gf4YJaF7Cg9w",
		authDomain: "maza-74bb3.firebaseapp.com",
		projectId: "maza-74bb3",
		storageBucket: "maza-74bb3.appspot.com",
		messagingSenderId: "373443321646",
		appId: "1:373443321646:web:32b28629bab00bdc15e4bf",
		measurementId: "G-46CG11HDL6"
	};
	firebase.initializeApp(firebaseConfig);

	window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
		'size': 'invisible',
		'callback': function (response) {
			// reCAPTCHA solved, allow signInWithPhoneNumber.
			console.log('recaptcha resolved');
		}
	});

</script>

<script type="text/javascript">


	function sendOTP() {
		var number = $("#phone_cc").val();
		console.log(number)

		// Ajax req to check if phone exists in db
		var _token = "{{ csrf_token() }}";
		$.ajax({
			url: "{{ route('check.client') }}",
			method: "POST",
			data: { country_code: $('#country_code').val(), phone: number,type:register, _token: _token},
			success: function (result) {
				console.log(result);
				if(result.status == 200) {
					$("#error").hide();

					firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {

						window.confirmationResult = confirmationResult;

						//localStorage.setItem("confirmationResult", confirmationResult);
						localStorage.setItem("verificationId", confirmationResult['verificationId']);

						coderesult = confirmationResult;
						console.log(coderesult);
						console.log(localStorage.getItem("verificationId"));
						//console.log(localStorage.getItem("confirmationResult"));

						$("#successAuth").text("Message sent");
						$("#successAuth").show();
					//	window.location.href = "/verify-phone-page/" + $('#country_code').val() + "/" + number + "/" + result.reset_password_token
					}).catch(function (error) {
						$("#error").text(error.message);
						$("#error").show();
					});

				}else if(result.status == 201) {
					$("#error").text(result.msg);
					$("#error").show();
				}
			}

		})


	}
	function verify() {
		var code = $("#verification").val();
		coderesult.confirm(code).then(function (result) {
			var user = result.user;
			console.log(user);
			$("#successOtpAuth").text("Auth is successful");
			$("#successOtpAuth").show();
		}).catch(function (error) {
			$("#error").text(error.message);
			$("#error").show();
		});
	}
</script>




@endsection
@endsection
