@extends('layouts.site')

@section('title')
@lang('app/all.edit_password')
@endsection

@section('content')


		<!-- Start Content Page -->
		<div id="content" class="page-content sign_in-page">
			<div class="page_form">
				<div class="container">

					<div class="includes" style="margin: 0 auto;" >
						@include('front.includes.alerts.success')
						@include('front.includes.alerts.errors')
					</div>
					
					@include('front.includes.items.success_model')

					<h2 class="title_sec">@lang('app/all.new_password')</h2>
					<div class="form-sign">
						<form action="{{ route('client.password.update') }}" method="POST">
							@csrf

							<div class="bs-form-control form-control-password">
								<input type="password" name="old_password" class="input-form-control" id="id_password" placeholder="@lang('app/all.password-h')" >
								<a id="pass_eye" class="pass_eye " onclick="togglePass()"><span class="span-eye"></span></a>
								@error("old_password")
									<span class="text-danger">{{$message}}</span>
								@enderror
							</div>

							<div class="bs-form-control form-control-password">
								<input type="password" name="password" class="input-form-control" id="id_password" placeholder="@lang('app/all.new_password')" >
								<a id="pass_eye" class="pass_eye " onclick="togglePass()"><span class="span-eye"></span></a>
								@error("password")
									<span class="text-danger">{{$message}}</span>
								@enderror
							</div>

							<div class="bs-form-control form-control-password">
								<input type="password" name="password_confirmation" class="input-form-control" id="id_Npassword" placeholder="@lang('app/all.confirm_new_password')" >
								<a id="npass_eye" class="pass_eye " onclick="toggleNPass()"><span class="span-eye"></span></a>
								@error("password_confirmation")
									<span class="text-danger">{{$message}}</span>
								@enderror
							</div>

							<div class="foot-btns">
								<input class="btn btn-primary" type="submit" value="@lang('app/all.confirm')">
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
  <script>

	$(document).ready(function () {

		$(".ok").click(function(){
			$("#successfullyBid").fadeOut(200);
		})

    });

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

@section('scripts')
@endsection