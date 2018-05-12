@extends('app')
@section('title')
Dashboard | edit admin
@stop
@section('content')
    @if (count($errors) > 0)
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {!!Form::open(array('url'=>'/admin/adminmembers/update/'.$user->id,'enctype'=>'multipart/form-data','files'=>'true','class' => 'form-horizontal'))!!}

     					<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Update Member</h3>
                                    
                                </div>
                                <div class="panel-body">

                                <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Name</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                            </div>                                            
                                        </div>
                                    </div>
  								 <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Email</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="email" class="form-control" name="email" value="{{$user->email}}">
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Password</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                <input type="password" class="form-control" name="password">
                                            </div>                                            
                                        </div>
                                    </div>

                                       <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">upgrade Role</label>
                                        <div class="col-md-6 col-xs-12">
                                            @if($user->role == 'member')
                                                <div class="col-md-4">
                                                    <label class="check"><input type="radio" class="iradio" value="admin" name="role" /> admin</label>
                                                </div>

                                            <div class="col-md-4">
                                                <label class="check"><input type="radio" class="iradio" value="superadmin" name="role"/>superadmin</label>
                                            </div>

                                                @elseif($user->role == 'admin')
                                                    <div class="col-md-4">
                                                        <label class="check"><input type="radio" class="iradio" value="memNber" name="role" />member</label>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="check"><input type="radio" class="iradio" value="superadmin" name="role"/>superadmin</label>
                                                    </div>
                                                @endif

                                        </div>
                                    </div>



                                   
								

                                 



                                </div>      
                                <div class="panel-footer">
                                    <button class="btn btn-default " id="clear_btn">clear</button>
                                    <button class="btn btn-primary pull-right" type="sumbit">update</button>
                                </div>                            
                            </div>

                             {!!Form::close()!!}
@stop
