@extends('auth')

@section('content')

					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

			<div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                 <div class="login-title"><strong>Reset Password</strong></div>
                 <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						 <div class="form-group">
                        <div class="col-md-12">
							<input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>
                    </div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Send Password Reset Link
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

					
	
@stop
