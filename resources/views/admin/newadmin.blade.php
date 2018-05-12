@extends('app')
@section('title')
Dashboard |new admin
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

@if(Session::has('message'))

                    <div class="alert alert-success alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>{!! session('message') !!}</strong>
                        </div>
                    </div>

                @endif





	                                  {!!Form::open(array('url'=>'/admin/newadmin','enctype'=>'multipart/form-data','files'=>'true','class' => 'form-horizontal'))!!}

     					<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">New Admin</h3>
                                    
                                </div>
                                <div class="panel-body">

                                <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Name</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control myinput" name="name" id="name" required>
                                            </div>

                                        </div>
                                    <span class="help-block msg"></span>
                                    </div>
  								 <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Email</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="email" class="form-control" name="email" required>
                                            </div>                                            
                                        </div>
                                    </div>

                                <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Password</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                <input type="password" class="form-control" name="password" required>
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Role</label>
                                        <div class="col-md-4">
                                            <label class="check"><input type="radio" class="iradio" name="role" value="admin" checked/>admin</label>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="check"><input type="radio" class="iradio" value="superadmin" name="role"/>superadmin</label>
                                        </div>
                                    </div>
                                   
								

                                 



                                </div>      
                                <div class="panel-footer">
                                    <button class="btn btn-default" id="clear_btn">clear</button>
                                    <button class="btn btn-primary pull-right save" >Add</button>
                                </div>                            
                            </div>

                             {!!Form::close()!!}
@stop
@push('scripts')
<script type="text/javascript">


//$('#name').parents('.form-group').first().addClass('has-error has-feedback');


</script>




@endpush