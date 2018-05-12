@extends('home')
@section('title')
Khabar
@stop
@section('content')
<div id="content">
                       <div class="panel panel-default">
                                <div class="panel-body posts">
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div class="post-item" style="direction:rtl;">
                                                <div class="post-title" >
                                                    <a href="{{$news->link}}">{{$news->title}}</a>
                                                </div>
                                                <div class="post-date"><span class="fa fa-calendar"></span>{{$news->date}} 
                                                <div class="post-text">
                                                    @if(!isset($news->imglink) || empty($news->imglink))
                                                    <img src="{{asset('images/khabar.png')}}" class="img-responsive img-text"/>
                                                    @else
                                                    <img src="{{$news->imglink}}" class="img-responsive img-text"/>


                                                    @endif

                                                    <p>{{$news->description}}</p>                                            
                                                </div>
                                                
                                            </div>                                            
                                            
                                        </div>
                                        
                                    </div>                                                                                                                          
                                    
                                </div>
                            </div>
            </div>
    </div>
@stop

