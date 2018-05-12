@extends('app')
@section('title')
Dashboard | admin members
@stop
@section('content')



	@if(Session::has('deletemessage'))
		<div class="col-md-12">
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>{!! session('deletemessage') !!}</strong>
			</div>
		</div>

	@endif
@if(Session::has('message'))
	<div class="col-md-12">
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{!! session('message') !!}</strong>
		</div>
	</div>

                @endif
   <div class="row">
				<div class="col-md-12">
 						<div class="panel panel-success panel-hidden-control">
	                                <div class="panel-heading">                                
	                                    <h3 class="panel-title">Members</h3>
	                                    <ul class="panel-controls">
	                                      <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>

	                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
	                                    </ul>                                
	                                </div>
	                                <div class="panel-body">
	                               			 <table class="table  datatable">
											        <thead>
											            <tr>
											            	<th>ID</th>
											                <th>Name</th>
											                <th>Email</th>
											                <th>Role</th>
											                <th>Actions</th>
											            </tr>
											        </thead>
											        <tbody>
											        	@foreach($users as $user)
											        	<tr>
											        		<td>{{$user->id}}</td>
											        		<td>{{$user->name}}</td>
											        		<td>{{$user->email}}</td>
											        		<td>{{$user->role}}</td>
											        		<td>


											   				 <a href="{{route('updatemember',$user->id)}}" class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></a>
                                                        	<a  href="{{route('deletemember',$user->id)}}" class="btn btn-danger btn-rounded btn-sm">	<span class="fa fa-times"></span></a>




											        		</td>




											        	
															
											        	</tr>
											        


											        	@endforeach
											        </tbody>
											      
											    </table>
								</div>
				</div>

		</div>
</div>

@stop

