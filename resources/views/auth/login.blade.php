
@extends('auth')
@section('content')
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Welcome</strong>, Please login</div>
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-md-12">
							<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="checkbox" name="remember"/> Remember me
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="{{ url('/password/email') }}" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>

                        <div class="col-md-6">
                            <button  type="submit" class="btn btn-info btn-block">Log In</button>
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-md-6 text-center">
                            <a href="{{ url('/auth/register') }}" class="btn btn-link btn-block">Create new account</a>
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
            
     










