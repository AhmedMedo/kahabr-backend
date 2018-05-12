<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>@yield('title')</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
        
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/css/bootstrap-select.min.css">

        <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-night.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/home.css')}}"/>

		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script type="text/javascript" src="{{asset('/js/jquery-1.11.3.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/jquery/jquery.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
        <script type="text/javascript" src="{{asset('js/js.cookies.js')}}"></script>


        <!-- EOF CSS INCLUDE -->       
        <style type="text/css">
        
        </style>                             
    </head>
    <body class="page-container-boxed">
    <div class="page-container page-mode-rtl">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="{{url('/')}}">KHABAR</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                                                                                           
                   
                   			
                               
                                                                  
                                    <!-- <li><a href="#">Feed one</a></li>
                                    <li><a href="#">Feed two</a></li>
                                    <li><a href="#">Feed there</a></li> -->
                     <li>
                        <a href="{{url('/')}}"><span class="fa fa-rss"></span> <span class="xn-text">Last News</span></a>
                    </li>
                    @if(Auth::check())
                        @if(Auth::user()->isAdmin() || Auth::user()->SuperAdmin())      

                     <li>
                        <a href="{{url('/admin')}}"><span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span></a>
                    </li>
                        @endif
                    @endif
                   <!--  <li class="xn-title">News Navigation</li>
                      <li class="xn-openable">
                        <a href="#"><span class="fa fa-cogs"></span><span class="xn-text" id="feed_type">Type</span></a>
                        <ul id="type">
                        @foreach($type as $type)
                            <li><a href="#">{{$type}}</a></li>
                          @endforeach
                        </ul>
                    </li>
                      <li class="xn-openable">
                        <a href="#"><span class="fa fa-rss"></span><span class="xn-text" id="feed_title">Feeds</span></a>
                        <ul id="feeds">
                        @foreach($feeds_title as $title)
                            <li><a href="#">{{$title->title}}</a></li>
                          @endforeach
                        </ul>
                    </li>


 -->


                        @yield('feeds')                                         
                    
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content" style="height: 304px;">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                  
                    <!-- SEARCH -->
                    <li class="xn-search" id="news_search">
                        <form role="form" method="POST" id="search_form">
                            <input type="text" name="search" id="search_text"  placeholder="Search..." >
                            <input type="hidden" name="hidden_country"  id="hidden_country" value="eg">
                            <input type="hidden" name="hidden_language" id="hidden_language" value="ar">

                        </form>
                    </li>   
                    <!-- END SEARCH -->
                    <!-- Login/Sign out -->
                    @if(Auth::guest())
                     <li class="xn-icon-button pull-right">
                        <a href="{{url('auth/login')}}">Login<span class="fa fa-sign-in"></span></a>
                    </li> 
                    @endif
                    @if(Auth::check())
                        <li class="xn-icon-button pull-right">
                            <a href="#" id="orginal_country">{{Auth::user()->name}}</a>
                            <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging" >

                                <div class="panel-body list-group list-group-contacts scroll" >
                                        <a href="{{url('auth/logout')}}" class="list-group-item" >
                                            <span class="fa fa-sign-out"></span>
                                            logout

                                        </a>

                                    <a href="{{url('auth/edit')}}" class="list-group-item" >
                                        <span class="fa fa-edit"></span>
                                        edit


                                    </a>





                                </div>

                            </div>
                        </li>

                    @endif
                    <!--End login/signout -->
                     <li class="xn-icon-button pull-right" id="languages">
                        <a href="#"><strong id="lang">ar</strong></a>
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                            
                            <div class="panel-body list-group list-group-contacts scroll">
                            
                               
                                <a href="#" class="list-group-item">
                                <strong>eng</strong>
                                 
                                </a>
                            
                            </div>     
                                                       
                        </div>                        
                    </li>
                     <!-- Countries -->
                    <li class="xn-icon-button pull-right" id="countries">
                        <a href="#" id="orginal_country" data-country="{{$countries[0]}}"><img id="main_country" src="{{asset('images/countries/'.$countries[0].'.png')}}"></a>
                        <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging" >
                            
                            <div class="panel-body list-group list-group-contacts scroll" id="countries_list">
                                @foreach(array_splice($countries,1) as $country)
                                 <a href="#" class="list-group-item" data-country="{{$country}}">
                                    <img src="{{asset('images/countries/'.$country.'.png')}}">

                                </a>

                                @endforeach
                                
                              
                            
                            </div>     
                                                       
                        </div>                        
                    </li>
                  
               
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                         
                
                <div class="page-title">                    
                    <h2>@yield('page_title')</h2>
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->


                  
                <div class="page-content-wrap">


                    @if(Session::has('sessionmessage'))


                        <div class="message-box message-box-danger animated fadeIn" id="message-box-danger" style="display: block">
                            <div class="mb-container">
                                <div class="mb-middle">
                                    <div class="mb-title"><span class="fa fa-times"></span> Danger</div>
                                    <div class="mb-content">
                                        {{Session('sessionmessage')}}
                                    </div>
                                    <div class="mb-footer">
                                        <button class="btn btn-default btn-lg pull-right mb-control-close" id="close">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                <div id="loadingDiv" style="display:none">
                <img src='{{asset('images/spin.gif')}}'  align="middle" />
                </div>
			               
                                     
                       @yield('content')            
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
	    




        <!-- START PLUGINS -->

        <script type="text/javascript" src="{{asset('/js/plugins/jquery/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/bootstrap/bootstrap.min.js')}}"></script>      
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>        
        <script type="text/javascript" src="{{asset('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>
        
       
        <script type="text/javascript" src="{{URL::asset('/js/plugins.js')}}"></script>        
        <script type="text/javascript" src="{{asset('/js/actions.js')}}"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script type="text/javascript" src="{{asset('js/ajaxsearch.js')}}"></script>

<!--         <script type="text/javascript" src="{{asset('js/demo_dashboard.js')}}"></script>
 -->
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->


    <script type="text/javascript">
        $(document).ready(function () {
            $('#close').click(function () {
                $('#message-box-danger').hide();
            })
        });
    </script>



   @stack('scripts')
     
    </body>
</html>






