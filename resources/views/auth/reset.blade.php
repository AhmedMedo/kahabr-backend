@extends('auth')

@section('content')

<div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title">Reset your password</div>

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="token" value="{{ $token }}">
						<input type="hidden" name="email" value="{{ $email }}">

						{{--<div class="form-group">--}}
							{{--<div class="col-md-12">--}}
								{{--<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">--}}
							{{--</div>--}}
						{{--</div>--}}

						<div class="form-group">
							<div class="col-md-12">
								<input type="password" class="form-control" name="password" placeholder="Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="password" class="form-control" name="password_confirmation" placeholder="confirm password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Reset Password
								</button>
							</div>
						</div>
					</form>
                </div>
                <div class="login-footer">
                    <div class="text-center">
                        &copy; 2016 Khabar
                    </div>
                   
              </div>
      </div>

		
@endsection
