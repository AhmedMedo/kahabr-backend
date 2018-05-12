@extends('app')
@section('title')
Dashboard |Edit Feed
@stop
@section('content')

                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      {!! session('message') !!}
                    </div>

                @endif

                     
   <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/feed/'.$feed->id) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{$feed->title}}</h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>

                                    </ul>
                                </div>
                                <div class="panel-body">

                                
                                            <div class="form-group">
                                            <label class="col-md-4 control-label">Title *</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control myinput" name="title" value="{{ $feed->title }}" required>
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
                                                    <select class="form-control" name="country">
                                                  
                                                      @foreach ($countries as $key => $value)
                                                            <option value="{{$key}}" <?php if($feed->country == strtolower($key)) {echo "selected";}?>>{{$value}}</option>
                                                        @endforeach


                                                    </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Language</label>
                                            <div class="col-md-6">
                                                        <select class="form-control" name="lang">
                                                  
                                                      @foreach ($languages as $key => $value)
                                                            <option  value="{{$key}}" <?php if($feed->language == strtolower($key)) {echo "selected";}?>>{{$value}}</option>
                                                        @endforeach


                                                    </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Type</label>
                                            <div class="col-md-6">
                                                    <select class="form-control" name="type" id="type">
                                                  
                                                      @foreach ($type as $item)
                                                            <option <?php if($feed->type == $item) {echo "selected";}?>>{{$item}}</option>
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
                                                    <select name="offset"  class="form-control">
                                                        <option <?php if($feed->offset == +14) {echo "selected";}?>>+14</option>
                                                        <option <?php if($feed->offset == +13) {echo "selected";}?>>+13</option>
                                                        <option <?php if($feed->offset == +12) {echo "selected";}?>>+12</option>
                                                        <option <?php if($feed->offset == +11) {echo "selected";}?>>+11</option>
                                                        <option <?php if($feed->offset == +10) {echo "selected";}?>>+10</option>
                                                        <option <?php if($feed->offset == +9) {echo "selected";}?>>+9</option>
                                                        <option <?php if($feed->offset == +8) {echo "selected";}?>>+8</option>
                                                        <option <?php if($feed->offset == +7) {echo "selected";}?>>+7</option>
                                                        <option <?php if($feed->offset == +6) {echo "selected";}?>>+6</option>
                                                        <option <?php if($feed->offset == +5) {echo "selected";}?>>+5</option>
                                                        <option <?php if($feed->offset == +4) {echo "selected";}?>>+4</option>
                                                        <option <?php if($feed->offset == +3) {echo "selected";}?>>+3</option>
                                                        <option <?php if($feed->offset == +2) {echo "selected";}?>>+2</option>
                                                        <option <?php if($feed->offset == +1) {echo "selected";}?>>+1</option>
                                                        <option <?php if($feed->offset == +0) {echo "selected";}?>>0</option>
                                                        <option <?php if($feed->offset == -1) {echo "selected";}?>>-1</option>
                                                        <option <?php if($feed->offset == -2) {echo "selected";}?>>-2</option>
                                                        <option <?php if($feed->offset == -3) {echo "selected";}?>>-3</option>
                                                        <option <?php if($feed->offset == -4) {echo "selected";}?>>-4</option>
                                                        <option <?php if($feed->offset == -5) {echo "selected";}?>>-5</option>
                                                        <option <?php if($feed->offset == -7) {echo "selected";}?>>-6</option>
                                                        <option <?php if($feed->offset == -8) {echo "selected";}?>>-8</option>
                                                        <option <?php if($feed->offset == -10) {echo "selected";}?>>-9</option>
                                                        <option <?php if($feed->offset == -11) {echo "selected";}?>>-11</option>
                                                        <option <?php if($feed->offset == -13) {echo "selected";}?>>-12</option>
                                                        <option <?php if($feed->offset == -14) {echo "selected";}?>>-14</option>
                                                    </select>
                                                </div>
                                            </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Website Link</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control link_website" data-type="website" name="website" value="{{$feed->website}}">
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
                                            <input type="text" class="form-control link_twitter" data-type="twitter" name="twitter" value="{{$feed->twitter}}">
                                            <span id="success_twitter" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
                                            <span class="help-block msg_twitter msg error_msg"></span>
                                        </div>
                                        <div  class="col-md-2">
                                            <img src="{{asset('images/status.gif')}}" id="load_twitter" style="display:none">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Rss source</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control link_rss" data-type="rss" name="rss" value="{{$feed->rss}}">
                                            <span id="success_rss" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
                                            <span class="help-block msg_rss msg error_msg"></span>
                                        </div>
                                        <div  class="col-md-2">
                                            <img src="{{asset('images/status.gif')}}" id="load_rss" style="display:none">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Facebook source</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control link_facebook" data-type="facebook" name="facebook" value="{{$feed->facebook}}">
                                            <span id="success_facebook" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
                                            <span class="help-block msg_facebook msg error_msg"></span>
                                        </div>
                                        <div  class="col-md-2">
                                            <img src="{{asset('images/status.gif')}}" id="load_facebook" style="display:none">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Youtube source</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control link_youtube" data-type="youtube" name="youtube" value="{{$feed->youtube}}">
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
                                            <input type="text" class="form-control link_instagram" data-type="instagram" name="instagram" value="{{$feed->instagram}}">
                                            <span id="success_instagram" class="glyphicon glyphicon-ok form-control-feedback" style="display: none"></span>
                                            <span class="help-block msg_instagram msg_instagram msg error_msg"></span>

                                        </div>
                                        <div  class="col-md-2">
                                            <img src="{{asset('images/status.gif')}}" id="load_instagram" style="display:none">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Status</label>
                                            <div class="col-md-6">
                                                <select class="form-control" name="status">
                                                    <option value="1" <?php if($feed->status == 'published'){echo "selected";}?>>published</option>
                                                    <option value="0" <?php if($feed->status == 'Draft'){echo "selected";}?>>draft</option>
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

                                <div class="panel-footer">
                                    <button class="btn btn-primary btn-lg pull-right save">Update</button>
                                </div>                            
                            </div>

                     

                           </form>  
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