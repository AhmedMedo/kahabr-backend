@extends('app')

@section('content')

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

				@if(Session::has('message'))
				<div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  {!! session('message') !!}
					</div>

				@endif

					<div class="panel panel-default tabs">
	                                <ul class="nav nav-tabs nav-justified">
	                                    <li class="active"><a href="#tab1" data-toggle="tab">input form</a></li>
	                                    <li><a href="#tab2" data-toggle="tab">Excel Sheet</a></li>
	                                </ul>
	                                <div class="panel-body tab-content">
	                                    <div class="tab-pane active" id="tab1">

													<div class="form-group">
														<label class="col-md-4 control-label">title</label>
														<div class="col-md-6">
															<input type="text" class="form-control" name="title">
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">subtitle</label>
														<div class="col-md-6">
															<input type="text" class="form-control" name="subtitle">
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">country</label>
														<div class="col-md-6">
															{!! Form::select('country',$countries,null,array('class'=>'form-control')) !!}
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">language</label>
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

																<input type="text" class="form-control" id="newtype" name="newtype" disabled>

															
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label">Topics</label>
														<div class="col-md-6">
															<select class="form-control" name="topic" id="topic">
															   @foreach ($topics as $topic)
							    										<option>{{$topic}}</option>
																	@endforeach

															  </select>
															  		<div class="checkbox">
																	  <label><input type="checkbox" id="enable-topic"> click to add new topic</label>
																	</div>

																<input type="text" class="form-control" id="newtopic" name="newtopic" disabled>

															
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label">feed link</label>
														<div class="col-md-6">
															<input type="text" class="form-control" name="link">

															
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">Feed source</label>
														<div class="col-md-6">
															<select class="form-control" name="protocol">
															    <option value="rss">rss</option>
															    <option value="tw">twitter</option>
															  </select>
															
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-4 control-label">status</label>
														<div class="col-md-6">
															<select class="form-control" name="status">
															    <option value="1">published</option>
															    <option value="0">draft</option>
															  </select>
															
														</div>
													</div>
														<div class="form-group">
																<label class="col-md-4 control-label">Icon</label>

							                                            <div class="col-md-8">
							                                                <input type="file"  id="icon" name="icon"/>
							                                            </div>                                            
							                           </div>

	                                        
	                                    </div>
	                                    <div class="tab-pane" id="tab2">
	                                         <div class="form-group">

			                                   <div class="col-md-12">
			                                         <span class="btn btn-default btn-file btn-success">
														   <i class="glyphicon glyphicon-upload"></i>
																 Import Excel file <input type="file" name="excel">
														</span>
			                                   </div>                                            
	                        	 		 </div>
	                                    </div>
	                               
	                            </div> 
@endsection
