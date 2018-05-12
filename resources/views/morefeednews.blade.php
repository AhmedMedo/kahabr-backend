                        @foreach(array_chunk($news->all(),4) as $row)
                          <div class="row">
                                    @foreach($row as $news)
                                       <div class="gallery-item" >
                                              <div class="feed_icon">
                                                <img src="{{asset($news->feed->img)}}">
                                              </div>
                                               <div class="news_date">
                                                <span class="label label-info label-form">{{$news->date}}</span>
                                              </div>
                                              <div class="image" href="#" data-toggle="modal" data-target="#modal_{{$news->id}}">
                                                 

                                                  <img src="{{asset('images/khabar.png')}}" class="lazy" data-original="{{$news->imglink}}"  alt="{{$news->title}}" height="119px" width="221px"> 
                                                  
                                              </div>
                                              <div class="meta">
                                                 <a href="{{$news->link}}"> <strong>{{$news->title}}</strong></a>

                                              </div>  
                                               <div class="modal" id="modal_{{$news->id}}" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
                                                                  <div class="modal-dialog">
                                                                      <div class="modal-content"> 

                                                                          <div class="modal-body">

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
                                                                          <div class="modal-footer">
                                                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </div>   

                                          </div>  
                                     
                                    @endforeach
                                    </div>
                                  @endforeach


                                     <script type="text/javascript">
                                      $(function() {
                                            $("img.lazy").lazyload({
                                                //effect : "fadeIn",
                                                threshold : 200



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

                        <button class="btn btn-info btn-block" id="news_more"   data-title="{{$title}}">Load more</button>
              </div>
</div>

@endif