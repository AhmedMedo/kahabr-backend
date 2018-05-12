@extends('app')
@section('title')
Dashboard | Feeds
@stop
@section('content')
 @if (count($errors) > 0)
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible" role="alert">
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
				<div class="col-md-12">
					<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>{!! session('message') !!}</strong>
						</div>
					</div>

				@endif

				@if(Session::has('deletemessage'))
				<div class="col-md-12">
					<div class="alert alert-danger alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>{!! session('deletemessage') !!}</strong>
						</div>
					</div>

				@endif


@if(Auth::user()->isAdmin() || Auth::user()->SuperAdmin())
	<div class="row">
		<div class="col-md-6">
			<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#newfeed"><span class="fa fa-plus"></span>News Feed</button>
		</div>

		<div class="col-offset-2 col-md-6">
			{{--<button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#upload_file"><span class="fa fa-cloud-upload"></span>--}}
                {{--upload CSV file</button>--}}
			{{--<div class="modal fade" id="upload_file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >--}}
				{{--<div class="modal-dialog" role="document">--}}
					{{--<div class="modal-content">--}}
						{{--<div class="modal-header">--}}
							{{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
							{{--<div class="row">--}}
								{{--<div class="col-md-3">--}}
									{{--<h4 class="modal-title" id="myModalLabel">Upload CSV File</h4>--}}
								{{--</div>--}}

							{{--</div>--}}
						{{--</div>--}}

						{{--<div class="modal-body">--}}
							{{--{!!  Form::open( [ 'url' => '/admin/savefile', 'method' => 'post', 'files' => true ] ) !!}--}}

							{{--<div class="form-group" style="padding: 20px;">--}}
								{{--<label class="col-md-4 control-label">Upload file</label>--}}
								{{--<div class="col-md-8">--}}
                                    {{--<span class="btn btn-info btn-file">--}}
                                        {{--Upload CSV file <input type="file" name="file">--}}
                                    {{--</span>--}}
                                {{--</div>--}}

							{{--</div>--}}
							{{--<div class="modal-footer">--}}
								{{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
								{{--<button type="submit" class="btn btn-primary save">Upload</button>--}}
							{{--</div>--}}
						{{--{!! Form::close() !!}--}}


						{{--</div>--}}

					{{--</div>--}}
				{{--</div>--}}

			{{--</div>--}}
			{{--</div>--}}


	</div>

<div class="row">

	<div class="modal fade" id="newfeed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/newfeed') }}" enctype="multipart/form-data">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="modal-dialog" role="document">
				    <div class="modal-content" style="overflow-y: scroll; height:700px;">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <div class="row">
				        <div class="col-md-3">
				       		 <h4 class="modal-title" id="myModalLabel">Add New Feed</h4>
				        </div>
				        <div class="col-md-3">
					       
                          </div>
				      </div>
				      </div>

				      <div class="modal-body">
					       <div class="panel panel-default">

	                                <div class="panel-body tab-content">
	                                    <div class="tab-pane active" id="tab1">

													<div class="form-group ">
														<label class="col-md-4 control-label">Title *</label>
														<div class="col-md-6">
															<input type="text" class="form-control myinput" name="title" required>
                                                            <span class="help-block Titlemsg"></span>
															<span id="title_success" class="glyphicon glyphicon-ok form-control-feedback " style="display: none"></span>

														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">Subtitle</label>
														<div class="col-md-6">
															<textarea class="form-control" rows="3" name="subtitle"></textarea>

														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">Country</label>
														<div class="col-md-6">
															{!! Form::select('country',$countries,null,array('class'=>'form-control')) !!}
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">Language</label>
														<div class="col-md-6">
															{!! Form::select('lang',$languages,null,array('class'=>'form-control')) !!}
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">Type</label>
														<div class="col-md-6">
															<select class="form-control" name="type" id="type">
															  
																  @foreach ($type as $item)
							    										<option>{{$item}}</option>
																	@endforeach


																	</select>

																	<span>or add a new one</span>
																	<div class="checkbox">
																	  <label><input type="checkbox" id="enable-type"> click to add new type</label>
																	</div>

																<input type="text" class="form-control" id="newtype" name="newtype" disabled required>

															
														</div>
													</div>


											<div class="form-group">
												<label class="col-md-4 control-label">Tags</label>
												<div class="col-md-8">
													<div class="input-group">

													{!!Form::select('tag_list[]',$tag_array,null,['id'=>'tags_list','class'=>'form-control','multiple'])!!}
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label">Time offset</label>
												<div class="col-md-6">
													<select class="form-control" name="offset">
														<option>+14</option>
														<option>+13</option>
														<option>+12</option>
														<option>+11</option>
														<option>+10</option>
														<option>+9</option>
														<option>+8</option>
														<option>+7</option>
														<option>+5</option>
														<option>+4</option>
														<option>+3</option>
														<option>+2</option>
														<option>+1</option>
														<option> 0 </option>
														<option>-1</option>
														<option>-2</option>
														<option>-3</option>
														<option>-4</option>
														<option>-5</option>
														<option>-6</option>
														<option>-7</option>
														<option>-8</option>
														<option>-9</option>
														<option>-10</option>
														<option>-11</option>
														<option>-12</option>
														<option>-13</option>
														<option>-14</option>
													</select>
												</div>
											</div>
<!--

													<!--  All feed sources required-->

											<div class="form-group">
												<label class="col-md-4 control-label">Website Link</label>
												<div class="col-md-6">
													<input type="text" class="form-control link_website" data-type="website" name="website">
													<span id="success_website" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
													<span class="help-block msg_website msg error_msg"></span>
												</div>
												<div  class="col-md-2">
													<img src="{{asset('images/status.gif')}}" id="load_website" style="display:none">
												</div>
											</div>

													<div class="form-group">
														<label class="col-md-4 control-label">Twitter source</label>
														<div class="col-md-6">
															<input type="text" class="form-control link_twitter" data-type="twitter" name="twitter">
															<span id="success_twitter" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
															<span class="help-block msg_twitter msg error_msg"></span>
														</div>
														<div  class="col-md-2">
															<img src="{{asset('images/status.gif')}}" id="load_twitter" style="display:none">
														</div>
													</div>
											<div class="form-group">
												<label class="col-md-4 control-label">Facebook source</label>
												<div class="col-md-6">
													<input type="text" class="form-control link_facebook" data-type="facebook" name="facebook">
													<span id="success_facebook" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
													<span class="help-block msg_facebook msg error_msg"></span>
												</div>
												<div  class="col-md-2">
													<img src="{{asset('images/status.gif')}}" id="load_facebook" style="display:none">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label">Rss source</label>
												<div class="col-md-6">
													<input type="text" class="form-control link_rss" data-type="rss" name="rss">
													<span id="success_rss" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
													<span class="help-block msg_rss msg error_msg"></span>
												</div>
												<div  class="col-md-2">
													<img src="{{asset('images/status.gif')}}" id="load_rss" style="display:none">
												</div>
											</div>



													<div class="form-group">
														<label class="col-md-4 control-label">Youtube source</label>
														<div class="col-md-6">
															<input type="text" class="form-control link_youtube" data-type="youtube" name="youtube">
															<span id="success_youtube" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
															<span class="help-block msg_youtube msg error_msg"></span>
														</div>
														<div  class="col-md-2">
															<img src="{{asset('images/status.gif')}}" id="load_youtube" style="display:none">
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">Instagram source</label>
														<div class="col-md-6">
															<input type="text" class="form-control link_instagram" data-type="instagram" name="instagram">
															<span id="success_instagram" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
															<span class="help-block msg_instagram msg_instagram msg error_msg"></span>

														</div>
														<div  class="col-md-2">
															<img src="{{asset('images/status.gif')}}" id="load_instagram" style="display:none">
														</div>
													</div>
													<!-- End -->

													<div class="form-group">
														<label class="col-md-4 control-label">Status</label>
														<div class="col-md-6">
															<select class="form-control" name="status">
															    <option value="1">published</option>
															    <option value="0">draft</option>
															  </select>
															
														</div>
													</div>
														<div class="form-group">
																<label class="col-md-4 control-label">Logo</label>
							                                            <div class="col-md-8">
							                                                <input type="file" accept="image/*"  id="icon" data-max-size="2000000" name="logo"/>
							                                            </div>
															<div class="alert alert-danger" role="alert" id="logo_alert" style="display: none">
																Your image Exceed the max size of 2M.
															</div>
							                           </div>

							                           <div class="form-group">
																<label class="col-md-4 control-label">Header</label>
							                                            <div class="col-md-8">
							                                                <input type="file" accept="image/*"  id="header" data-max-size="2000000" name="header"/>
							                                            </div>
															<div class="alert alert-danger" role="alert" id="header_alert" style="display: none">
																Your image Exceed the max size of 2M.
															</div>
							                           </div>

	                                    </div>
	                               
	                            </div> 


						
							
				      	</div>
							<div class="modal-footer">
										<button class="btn btn-default pull-left" id="clear_btn">clear</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        <button type="submit" class="btn btn-primary save">save</button>
							</div>

				     
				</div>

			</div>
		</div>

        </form>
    </div>

</div>

@endif
</br>


    <div class="row">
				<div class="col-md-12">
 						<div class="panel panel-success panel-hidden-control">
	                                <div class="panel-heading">
	                                    <h3 class="panel-title">Feeds</h3>
	                                    <ul class="panel-controls">
	                                      <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
	                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
	                                    </ul>
	                                </div>
	                                <div class="panel-body">
                                        <table class="table table-striped table-bordered table-hover datatable responsive" id="feeds_table" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>icon</th>
                                                <th>title</th>
												<th>subtitle</th>
											    <th>feed news</th>
                                                <th>Edit</th>
					                            <th>Delete</th>
												<th>parse</th>
											</tr>
                                            </thead>

                                        </table>

                                    </div>
							 </div>
			</div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->

@stop

@push('scripts')
<script type="text/javascript">
	$('#tags_list').select2({
		tags: true,
		tokenSeparators: [',', ' '],
		width : '250px'
	});
</script>
@endpush


