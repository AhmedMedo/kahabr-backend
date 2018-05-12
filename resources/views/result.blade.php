@extends('home')
@section('title')
Khabar
@stop
@section('feeds')
                <li class="xn-openable">
                        <a href="#"><span class="fa fa-rss"></span><span class="xn-text" id="feed_title">Feeds</span></a>
                        <ul id="feeds">
                        @foreach($feeds_title as $title)
                            <li><a href="#">{{$title->title}}</a></li>
                          @endforeach
                        </ul>

                       
                    </li>

 
@stop
@section('page_title')
<span class="fa fa-search"></span> Search Result for <strong>{{$key}}</strong> <span class="label label-success" style="float: right;
    margin-left: 8px;">{{$count}}</span>

@stop
@section('value')
{{$key}}
@stop
@section('content')

               <div id="content">  

                        
                  <div class="gallery" id="links">
                        @foreach(array_chunk($news->all(),4) as $row)
                          <div class="row">
                                    @foreach($row as $news)
                                       <div class="gallery-item" >
                                              <div class="feed_icon">
                                                <img src="{{asset($news->feed->img)}}">
                                              </div>
                                              <div class="image" data-id="{{$news->id}}" href="{{route('newsinfo',$news->id)}}" title="Lates news">
                                                 

                                                  <img src="{{asset('images/khabar.png')}}" class="lazy" data-original="{{$news->imglink}}"  alt="{{$news->title}}" height="119px" width="221px">                                                                                                           
                                              </div>
                                              <div class="meta">
                                                 <a href="{{route('newsinfo',$news->id)}}"> <strong>{{$news->title}}</strong></a>
                                              </div>    

                                          </div>  
                                     
                                    @endforeach
                                    </div>
                                  @endforeach
                               
                        <script type="text/javascript">
                          $(function() {
                                    $("img.lazy").lazyload({
                                        
                                        threshold : 200,
                                        effect : "fadeIn",
                                        failure_limit : 10


                                    });
                                });

                                // $(window).bind("load", function() {
                                //     var timeout = setTimeout(function() {
                                //         $("img.lazy").trigger("sporty")
                                //     }, 5000);

                                // });


                      </script>
                        </div> 

                        
 @if(!count($news) < 20)                       
<div class="row" id="remove-btn">
                  <div class="col-md-4 col-md-offset-4" style="padding:20px">
                            

      <button class="btn btn-info btn-block" id="result_more">Load more</button>              </div>
</div>
@endif

  </div>



@stop
@push('scripts')


@endpush
