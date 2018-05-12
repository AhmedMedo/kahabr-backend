<table class="table">
        <thead>
            <tr>
            	<th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Date</th>
                <th>News Link</th>
                @if(Auth::user()->SuperAdmin() || Auth::user()->isAdmin())
                <th>Actions</th>
                @endif
             
              
            </tr>
        </thead>
        <tbody>
        	@foreach($all_news as $news)
        	<tr>
        		<td>{{$news->id}}</td>
        		<td><h3>{{$news->title}}</h3></td>
                <td>
                    <div id="news_image">
                        @if(is_null($news->imglink) or empty($news->imglink))

                            <img src="{{asset('images/khabar.png')}}" height="80px" width="80px">
                        @else

                            <img src="{{$news->imglink}}" height="80px" width="80px">
                        @endif
                    </div>
                </td>
        		
                <td>{{$news->date}}</td>
                <td><a href="{{$news->link}}" class="btn btn-success btn-lg">link</a></td>
                @if(Auth::user()->SuperAdmin() || Auth::user()->isAdmin())
                <td>
                    
                    {!! Form::open(['method'=>'DELETE','route'=>['admin.news.destroy',$news->id]]) !!}
                   <button type="submit" class="btn btn-danger btn-rounded btn-sm"><span class="fa fa-times"></span></button>
                {!! Form::close() !!}
                    </td>	
                @endif	
				
        	</tr>
        


        	@endforeach
        </tbody>
      
    </table>
{!!$all_news->render()!!}
