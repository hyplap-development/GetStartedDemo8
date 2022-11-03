@extends('layouts.auth')

@section('title', 'Login')

@section('header')

@endsection

@section('content')

<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
	<div class="bg-body d-flex flex-center rounded-4 w-md-600px p-10">
		<div class="w-md-400px">
			<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="../../demo8/dist/index.html" action="#">
				<div class="text-center mb-11">
					<h1 class="text-dark fw-bolder mb-3">Sign In</h1>
					<div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
				</div>
				<!-- <div class="row g-3 mb-9">
									<div class="col-md-6">
										<a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
										<img alt="Logo" src="{{asset('assets/media/svg/brand-logos/google-icon.svg')}}" class="h-15px me-3" />Sign in with Google</a>
									</div>
								</div>
								<div class="separator separator-content my-14">
									<span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
								</div> -->
				<div class="fv-row mb-8">
					<input type="text" placeholder="Login Id" id="Login" name="login" autocomplete="off" class="form-control bg-transparent" />
				</div>
				<div class="fv-row mb-3">
					<input type="password" placeholder="Password" id="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
				</div>
				<!-- <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
					<div></div>
					<a href="#" class="link-primary">Forgot Password ?</a>
				</div> -->
				<div class="d-grid mb-10">
					<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
						<span class="indicator-label">Sign In</span>
						<span class="indicator-progress">Please wait...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
					</button>
				</div>
				<!-- <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
					<a href="#" class="link-primary">Sign up</a>
				</div> -->
			</form>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@endsection