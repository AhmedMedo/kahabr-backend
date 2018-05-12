@foreach($feeds_title as $title)
<li><a href="#">{{$title->title}}</a></li>
@endforeach
<li id="more_feeds"><a href="#"><strong>more feeds</strong></a></li>