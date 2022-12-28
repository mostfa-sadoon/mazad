@extends('layouts.site')

@section('title')
New Password
@endsection

@section('content')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
@endsection



		<!-- Start Content Page -->
		<div id="content" class="page-content sign_in-page">
			<div class="page_form">
				<div class="container">
					<h2 class="title_sec">New Password</h2>
					<div class="form-sign">
						<form action="{{ route('client.new_password.update' , ['country_code'=> $country_code , 'phone'=> $phone , 'reset_password_token'=> $reset_password_token]) }}" method="POST">
							@csrf

							<input type="hidden" name="country_code" value="{{$country_code}}">
							<input type="hidden" name="phone" value="{{$phone}}">
							<input type="hidden" name="reset_password_token" value="{{$reset_password_token}}">

							<div class="bs-form-control form-control-password">
								<input type="password" name="password" class="input-form-control" id="id_password" placeholder="New Password" >
								<a id="pass_eye" class="pass_eye " onclick="togglePass()"><span class="span-eye"></span></a>
								@error("password")
									<span class="text-danger">{{$message}}</span>
								@enderror
							</div>

							<div class="bs-form-control form-control-password">
								<input type="password" name="password_confirmation" class="input-form-control" id="id_Npassword" placeholder="Confirm New Password" >
								<a id="npass_eye" class="pass_eye " onclick="toggleNPass()"><span class="span-eye"></span></a>
								@error("password_confirmation")
									<span class="text-danger">{{$message}}</span>
								@enderror
							</div>

							<div class="foot-btns">
								<input class="btn btn-primary" type="submit" value="DONE">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
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
		<!-- End Content Page -->
		
	

		

@endsection