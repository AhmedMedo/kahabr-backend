@extends('app')
@section('title')
Dashboard | Khabar
@stop
@section('content')

<div class="row">
	<div class="col-md-4">
    			 <div class="widget widget-default widget-carousel">
                                <div class="owl-carousel" id="owl-example">
                                    <div>                                    
                                        <div class="widget-title">Feeds</div>                                                                        
                                        <div class="widget-subtitle">Stored feeds</div>
                                        <div class="widget-int">{{$number_of_feeds}}</div>
                                    </div>
                                    <div>                                    
                                        <div class="widget-title">News</div>
                                        <div class="widget-subtitle">Stored news</div>
                                        <div class="widget-int">{{$number_of_news}}</div>
                                    </div>
                                  
                                </div>                            

                            </div> 
			</div>


			<div class="col-md-4">
					<div class="widget widget-default widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-user"></span>
                                </div>
                                <div class="widget-data">
                                    <div class="widget-int num-count">{{$number_of_mobile_users}}</div>
                                    <div class="widget-title">Registred users</div>
                                    <div class="widget-subtitle">On the mobile application</div>
                                </div>

              </div>  

              </div>



              <div class="col-md-4">

                <!-- START WIDGET CLOCK -->
                            <div class="widget widget-danger widget-padding-sm">
                                <div class="widget-big-int plugin-clock">00:00</div>                            
                                <div class="widget-subtitle plugin-date">Loading...</div>

                             <!--    <div class="widget-buttons widget-c3">
                                    <div class="col">
                                        <a href="#"><span class="fa fa-clock-o"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-bell"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-calendar"></span></a>
                                    </div>
                                </div>  -->                           
                            </div>                        
                            <!-- END WIDGET CLOCK -->
              </div>  



</div>
@stop

