
<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>Khabr-Register</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    
@extends('auth')
@section('content')
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Signup</strong></div>
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-md-12">
							<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name">
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-md-12">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password" placeholder="Password"/>
                        </div>
                    </div>
                      <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="{{ url('/auth/login') }}" class="btn btn-link btn-block">Already have account?</a>
                        </div>

                        <div class="col-md-6">
                            <button  type="submit" class="btn btn-info btn-block">Sign up</button>
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











