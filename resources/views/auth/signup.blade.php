@extends('Dashboard.layouts.master2')
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{URL::asset('Dashboard/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{URL::asset('Dashboard/img/media/login.png')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
										<div class="mb-5 d-flex"> <a href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('Dashboard/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Va<span>le</span>x</h1></div>
										<div class="main-signup-header">
											<h2 class="text-primary">Get Started</h2>
											<h5 class="font-weight-normal mb-4">Signup  User</h5>                                           
											<form action="{{ route('register') }}" method="POST">
												@csrf
												<div class="form-group">
													<label>Firstname & Lastname</label>
                                                    <input name="name" class="form-control" placeholder="Enter your firstname and lastname" type="text" value="{{ old('name') }}" required autofocus>
													<x-input-error :messages="$errors->get('name')" class="mt-2" />

												</div>
												<div class="form-group">
													<label>Email</label>
                                                    <input class="form-control" name="email" placeholder="Enter your email" type="email" value="{{ old('email') }}" required>
													<x-input-error :messages="$errors->get('email')" class="mt-2" />

												</div>
												<div class="form-group">
													<label>Password</label>
                                                    <input class="form-control" name="password" placeholder="Enter your password" type="password" required autocomplete="new-password">
													<x-input-error :messages="$errors->get('password')" class="mt-2" />

												</div>
                                                {{-- Added Password Confirmation Field --}}
                                                <div class="form-group">
													<label>Confirm Password</label>
                                                    <input class="form-control" name="password_confirmation" placeholder="Confirm your password" type="password" required autocomplete="new-password">
                                                    {{-- No specific error needed here usually, the 'confirmed' rule on 'password' handles it --}}
												</div>
                                                <button type="submit" class="btn btn-main-primary btn-block">Create Account</button>
												{{-- Removed empty row div --}}
											</form>
											<div class="main-signup-footer mt-5">
												<p>Already have an account? <a href="{{ route('admin.login') }}">Sign In</a></p> {{-- Assuming you have an admin login route --}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
@endsection
@section('js')
@endsection