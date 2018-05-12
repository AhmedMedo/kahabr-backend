@extends('newview.main')



@section('page_title')
    <h3>Search results</h3>

@stop
@section('content')
    <div class="row">
        <div class="col-md-12 no-padding w-100">
            @foreach($news->chunk(4) as $row)
                <div class="row no-margin">
                    @foreach($row as $news_element)
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                            <div class="pbc-margin-left-zero post-bottom-content">
                                <a href="" data-toggle="modal" data-target="#modal_{{$news_element->id}}"><img class="img-responsive lazy" data-original="{{$news_element->imglink}}" src="{{asset('images/khabar.png')}}" alt="{{$news_element->title}}" /></a>
                                <a href="{{$news_element->link}}" target="_blank"><p> {{mb_substr($news_element->title,0,60,'utf-8')}} {{'..'}}</p> </a>

                                <span class="date">{{$news_element->date}}</span>

                                <!-- ___Post Meta___ -->
                                <div class="post-meta">

                                    <img src="{{asset($news_element->feed->logo)}}"  />
                                    <div class="feed_title">
                                        <span class="help-block">{{$news_element->feed->title}}</span>
                                    </div>
                                </div>
                            </div><!-- End Post Bottom Content -->
                        </div><!-- End Column -->
                        <div class="modal" id="modal_{{$news_element->id}}" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-body">

                                        <div class="post-item" style="direction:rtl;">
                                            <div class="post-title" >
                                                <a href="{{$news_element->link}}">{{$news_element->title}}</a>
                                            </div>
                                            <div class="post-date"><span class="fa fa-calendar"></span>{{$news_element->date}}
                                                <div class="post-text">
                                                    @if(!isset($news_element->imglink) || empty($news_element->imglink))
                                                        <img src="{{asset('images/khabar.png')}}" class="img-responsive img-text"/>
                                                    @else
                                                        <img src="{{$news_element->imglink}}" class="img-responsive img-text"/>


                                                    @endif

                                                    <p>{{$news_element->description}}</p>
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

                    @endforeach

                </div>
            @endforeach
                <script type="text/javascript">
                    $("img.lazy").lazyload({
                        threshold : 200

                        //effect : "fadeIn",


                    });




                </script>

        </div> <!-- End Column -->
        <!-- ___Load More Btn ___ -->

<div class="text-center">
    <?php echo $news->appends(Request::capture()->except('page'))->render(); ?>


</div>




    </div> <!-- End Row -->

@stop
@push('scripts')
<script type="text/javascript">


    $('#search_form').submit(function () {
       var form=$('#search_form');

        $.ajax({
            type: "POST",
            url:'tmore',
            data:form.serialize(),
            beforeSend: function(){
            },
            success: function(data)
            {
                $('.load-more-btn').remove();

                $('#content').append(data);

            }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        });

        return false;

    })




</script>


@stop