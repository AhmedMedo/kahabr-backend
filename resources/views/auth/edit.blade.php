
<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>Khabr- Edit profile</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-default.css')}}"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        
        <div class="login-container">
        	@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Edit your profile</strong></div>
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/edit') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-md-12">
							<input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" placeholder="Name">
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-md-12">
							<input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" placeholder="Email">
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
                            <button  type="button" class="btn btn btn-primary btn-block" onclick="history.back()">Back</button>
                        </div>

                        <div class="col-md-6">
                            <button  type="submit" class="btn btn-info btn-block">Edit</button>
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
            
        </div>
        
    </body>
</html>








@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
		@endif



