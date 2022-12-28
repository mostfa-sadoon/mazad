@extends('layouts.site')

@section('title')
@lang('app/all.forgot_password')
@endsection

@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
@endsection

<!-- Start Content Page -->
<div id="content" class="page-content sign_in-page">
	<div class="page_form">
		<div class="container">
            @if(!isset($register))
			  <h2 class="title_sec">@lang('app/all.forgot_password')</h2>
            @else
               <h2>@lang('app/all.phone_number')</h2>
            @endif

			<div class="form-sign">

				<div class="includes" style="margin: 0 auto;" >
					@include('front.includes.alerts.success')
					@include('front.includes.alerts.errors')
				  </div>

			<div class="alert alert-danger" id="error" style="display: none;"></div>
			<div class="alert alert-success" id="successAuth" style="display: none;"></div>

				{{-- <form action="otp.html"> --}}
					<div class="bs-form-control direction-ltr">
						<input name="country_code" type="hidden" class="input-form-control" id="country_code">
						<input name="phone" type="tel" class="input-form-control" id="phone_cc" >
						<div id="error-msg"></div>
						<div id="valid-msg"></div>
					</div>
					<div id="recaptcha-container"></div>

					<div class="foot-btns">
						<button class="btn btn-primary" onclick="sendOTP();" type="submit">@lang('app/all.send_otp')</button>
					</div>
					{{--
				</form> --}}
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
{{--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
<!-- End Content Page -->



@endsection




@section('scripts')

{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/8.0.1/firebase.js"></script> --}}
{{--
<script src="{{ asset('assets/firebase.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

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
	    var countrycode=$('#country_code').val();
        var otpnumber =countrycode+number;
        console.log(otpnumber);
		// Ajax req to check if phone exists in db
		var _token = "{{ csrf_token() }}";
		$.ajax({
			url: "{{ route('check.client') }}",
			method: "POST",
			data: { country_code: $('#country_code').val(), phone: number, _token: _token},
			success: function (result) {
				console.log(result);
				if(result.status == 200) {
					$("#error").hide();
					firebase.auth().signInWithPhoneNumber(otpnumber, window.recaptchaVerifier).then(function (confirmationResult) {
						window.confirmationResult = confirmationResult;
						localStorage.setItem("confirmationResult", confirmationResult);
						localStorage.setItem("verificationId", confirmationResult['verificationId']);
						coderesult = confirmationResult;
						console.log(coderesult);
						console.log(localStorage.getItem("verificationId"));
						//console.log(localStorage.getItem("confirmationResult"));
						$("#successAuth").text("Message sent");
						$("#successAuth").show();
						 window.location.href = "/reset-password/" + $('#country_code').val() + "/" + otpnumber + "/" + result.reset_password_token
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

<script src="{{asset('assets/front/js/intlTelInput.js')}}"></script>
<script>
  $(document).ready(function () {
    $(".ok").click(function(){
      $("#successfullyBid").fadeOut(200);
  })

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
        });

    });
</script>


@endsection
