@extends('layouts.site')

@section('title')
@lang('app/all.login')
@endsection

@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
@endsection


@include('front.includes.items.success_model')

<!-- Start Content Page -->
<div id="content" class="page-content sign_in-page">
  <div class="page_form">
    <div class="container">
      <h2 class="title_sec">@lang('app/all.WelcomeBack')</h2>
      <div class="form-sign">

        <form method="POST" action="{{ route('client.login.submit') }}" autocomplete="off">
            @csrf
          <div class="bs-form-control direction-ltr">
            <input name="country_code" type="hidden" class="input-form-control" id="country_code">
            <input name="phone" type="tel" class="input-form-control" id="phone_cc" >
							<div id="error-msg"></div>
							<div id="valid-msg"></div>
                @error("phone")
                    <span class="text-danger">{{$message}}</span>
                @enderror
                @error("country_code")
                    <span class="text-danger">{{$message}}</span>
                @enderror
          </div>
          <div class="bs-form-control form-control-password">
            <input type="password" name="password" class="input-form-control" id="id_password" placeholder="@lang('app/all.password')">
            <a id="pass_eye" class="pass_eye " onclick="togglePass()"><span class="span-eye"></span></a>
          </div>
          <div class="bs-form-text text-right">
            <a href="{{ route('client.otp') }}">@lang('app/all.forgot_password')</a>
          </div>

        <div class="includes" style="margin: 0 auto;" >
          @include('front.includes.alerts.success')
          @include('front.includes.alerts.errors')
        </div>

          <div class="foot-btns">

            <input class="btn btn-primary" type="submit" value="@lang('app/all.login')">
            @if(session()->has('redirect'))
            <a href="{{ route('client.phone.page') }}" class="btn btn-yellow">@lang('app/all.Confirm_phone_number')</a>
            @endif
            <a href="{{ route('client.register') }}" class="btn btn-yellow">@lang('app/all.create_account')</a>
          </div>

        </form>

      </div>
      <div class="foot-page">
        <img src="{{ asset('assets/front/images/icons/i2.svg') }}" />
      </div>
    </div>
  </div>
</div>

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


<!-- End Content Page -->


@endsection

@section('scripts')

@endsection
