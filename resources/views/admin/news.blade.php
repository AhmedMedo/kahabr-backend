@extends('app')
@section('title')
Dashboard | Feed News
@stop
@section('content')
   <div class="row">
				<div class="col-md-12">
 						<div class="panel panel-success panel-hidden-control">
	                                <div class="panel-heading">                                
	                                    <h3 class="panel-title">News of &nbsp;&nbsp;<strong>{{$feed_title}}</strong></h3>
	                                    <ul class="panel-controls">
	                                      <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>

	                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
	                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
	                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
	                                    </ul>                                
	                                </div>
	                                <div class="panel-body">
	                                    @include('admin.newstable',['all_news' =>$all_news])
	                                </div>
							 </div>
			</div>
</div>

@stop