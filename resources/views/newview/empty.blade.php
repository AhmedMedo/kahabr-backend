@extends('newview.main')




@section('content')

    <div class="col-md-12">
        <div class="error">
            <div class="error-content text-center">
                <p class="oh-no">No result found</p>
                <h2>Result 0 </h2>
                <p class="text">The only choice you now is to</p>
                <a class="button" href="{{url('/')}}">RETURN TO home</a>
            </div>
        </div>
    </div>

@stop
