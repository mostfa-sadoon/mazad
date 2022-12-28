@extends('layouts.site')

@section('title')
@lang('app/all.Getting_Your_Code')
@endsection

@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
@endsection




<!-- Start Content Page -->
<div id="content" class="page-content sign_in-page">
	<div class="page_form">
		<div class="container">

			<div class="includes" style="margin: 0 auto;" >
				@include('front.includes.alerts.success')
				@include('front.includes.alerts.errors')
			  </div>

			<h2 class="title_sec">@lang('app/all.Enter_Your_OTP')</h2>
			<div class="form-sign">

				<form  class="digit-group otp_form" data-group-name="digits" data-autosubmit="false" autocomplete="off">

					<div class="bs-form-control direction-ltr">

						<input type="text" class="input-form-control" id="digit-1" name="digit-1" data-next="digit-2" />
						<input type="text" class="input-form-control" id="digit-2" name="digit-2" data-next="digit-3"
							data-previous="digit-1" />
						<input type="text" class="input-form-control" id="digit-3" name="digit-3" data-next="digit-4"
							data-previous="digit-2" />
						<input type="text" class="input-form-control" id="digit-4" name="digit-4" data-next="digit-5"
							data-previous="digit-3" />
						<input type="text" class="input-form-control" id="digit-5" name="digit-5" data-next="digit-6"
							data-previous="digit-4" />
						<input type="text" class="input-form-control" id="digit-6" name="digit-6"
							data-previous="digit-5" />

					</div>

					<br>
					<br>
					<div class="foot-btns">
						<a href="#" id="verifPhoneNum" onclick="onSignInSubmit(event);" class="form-control btn btn-primary">@lang('app/all.confirm')</a>
						{{--  <input class="btn btn-primary" type="submit" value="CONFIRM">  --}}
						<div class="bs-form-text text-center">
							<a href="#">@lang('app/all.Resend_Code')</a>
							<div class="otp_timer"><span id="timer"></span></div>
						</div>
					</div>
                    <div id="recaptcha-container"></div>

				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		let timerOn = true;

		function timer(remaining) {
			var m = Math.floor(remaining / 60);
			var s = remaining % 60;

			m = m < 10 ? '0' + m : m;
			s = s < 10 ? '0' + s : s;
			document.getElementById('timer').innerHTML = m + ':' + s;
			remaining -= 1;

			if (remaining >= 0 && timerOn) {
				setTimeout(function () {
					timer(remaining);
				}, 1000);
				return;
			}

			if (!timerOn) {
				// Do validate stuff here
				return;
			}

			// Do timeout stuff here
			alert('@lang('app/all.Timeout_for_otp')');
		}

		timer(120);

		$('.digit-group').find('input').each(function () {
			$(this).attr('maxlength', 1);
			$(this).on('keyup', function (e) {
				var parent = $($(this).parent());

				if (e.keyCode === 8 || e.keyCode === 37) {
					var prev = parent.find('input#' + $(this).data('previous'));

					if (prev.length) {
						$(prev).select();
					}
				} else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
					var next = parent.find('input#' + $(this).data('next'));

					if (next.length) {
						$(next).select();
					} else {
						if (parent.data('autosubmit')) {
							parent.submit();
						}
					}
				}
			});
		});
	});

</script>

<!-- End Content Page -->


@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
{{--
<script src="{{ asset('assets/firebase.js') }}"></script> --}}

<script>
$(document).ready(function () {
    const firebaseConfig = {
        apiKey: "AIzaSyA14fIRJiJTGACLYvDgHl4Gf4YJaF7Cg9w",
        authDomain: "maza-74bb3.firebaseapp.com",
        projectId: "maza-74bb3",
        storageBucket: "maza-74bb3.appspot.com",
        messagingSenderId: "373443321646",
        appId: "1:373443321646:web:32b28629bab00bdc15e4bf",
        measurementId: "G-46CG11HDL6"
    };
   // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
	window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
			'size': 'invisible',
			'callback': function (response) {
				// reCAPTCHA solved, allow signInWithPhoneNumber.
				console.log('recaptcha resolved');
			}
		});
        // send sms
        sendCode();
    });
</script>
<script>
    var verifycode="{{ $verifycode }}";
    var number="{{ $phone }}";
    var country_code="{{ $country_code }}";
    var session_phone=country_code+number;
    // this function send sms to phone
    function sendCode() {
		//alert('@lang('app/all.Getting_Your_Code')');
		var phoneNo = session_phone;
		console.log(phoneNo);
		// getCode(phoneNo);
		var appVerifier = window.recaptchaVerifier;
		firebase.auth().signInWithPhoneNumber(phoneNo, appVerifier)
			.then(function (confirmationResult) {
				window.confirmationResult = confirmationResult['verificationId'];
				localStorage.setItem("confirmationResult", confirmationResult['verificationId']);
				coderesult = confirmationResult;
				console.log(coderesult);
				// console.log(coderesult['verificationId']);
				// Add Client ___________________________________________________________________________________________________________

			}).catch(function (error) {
				console.log(error.message);
			});
	}

	function onSignInSubmit(e) {
		//$('#verifPhoneNum').on('click', function (e) {
			e.preventDefault();
			//console.log(e.target);
			let code = '';
			for (let i = 0; i < $(".bs-form-control input").length; i++) {
				code += $(".bs-form-control input")[i].value
			}
			console.log('session_phone : ' + session_phone);
			console.log('code : ' + code);
			$('#verifPhoneNum').attr('disabled', 'disabled');
			$('#verifPhoneNum').text('Processing..');
			// return firebase.auth.PhoneAuthProvider.credential(window.confirmationResult,
			// code);
			console.log(localStorage.getItem("verificationId"));

			if (code == '' || code == undefined || code == null) {
				$('#verifPhoneNum').text('@lang('app/all.must_enter_the_code')');
				$('#verifPhoneNum').removeAttr('disabled');
			}
			var credential = firebase.auth.PhoneAuthProvider.credential(localStorage.getItem("confirmationResult") , code);
			firebase.auth().signInWithCredential(credential).then((data) => {
				//console.log('@lang('app/all.phone_number_has_been_confirmed')');
                window.location.href = "/verify-phone/" + "{{$country_code}}" + "/" + session_phone + "/" + "{{$verifycode}}"

			}).catch((err) => {
				console.log(err.message);	// Token Expired
				$('#verifPhoneNum').text('@lang('app/all.enter_a_valid_code_and_confirm')');
				setTimeout(() => {
					$('#verifPhoneNum').text('@lang('app/all.Try_again')');
					$('#verifPhoneNum').removeAttr('disabled');
				}, 5000);
			})
		//});

		$('#getcode').on('click', function () {
			alert('Getting Your Code...');
			// var phoneNo = $('#number').val();
			var phoneNo = '+201091032662';
			console.log(phoneNo);
			// getCode(phoneNo);
			var appVerifier = window.recaptchaVerifier;
			firebase.auth().signInWithPhoneNumber(phoneNo, appVerifier)
				.then(function (confirmationResult) {
					window.confirmationResult = confirmationResult;
					localStorage.setItem("confirmationResult", confirmationResult['verificationId']);
					coderesult = confirmationResult;
					console.log(coderesult);
					console.log(coderesult['verificationId']);
				}).catch(function (error) {
					console.log(error.message);
				});
		});
	}
</script>
@endsection
