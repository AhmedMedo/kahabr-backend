<?php echo
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>@yield('title')</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="expires" content="0">
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
        <!-- END META SECTION -->
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/css/bootstrap-select.min.css">

        <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-default.css')}}"/>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <script type="text/javascript" src="{{asset('/js/jquery-1.11.3.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/admin.css')}}"/>



        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="{{url('/')}}">Khabr</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>

                  
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                           <img src="{{asset('images/khabar.png')}}" height="36px" width="36px"/>
                        </a>


                       
                        <div class="profile">
                            <div class="profile-image">
                                 <img src="{{asset('images/khabar.png')}}" height="100px" width="100px">
                            </div>
                            <div class="profile-data">
                                <div class="#">{{Auth::user()->name}}</div>
                            </div>
                            
                        </div>                                                                        
                    </li>
                    <li class="xn-title">Navigation</li>
                      <li class="active">
                        <a href="{{url('/admin')}}"><span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span></a>                        
                    </li>  
                    <li>
                        <a href="{{url('/admin/feeds')}}"><span class="fa fa-globe"></span><span class="xn-text">Feeds</span></a>                        
                    </li>  
                
                    <li>
                        <a href="{{url('/')}}" target="_blank"><span class="fa fa-rss"></span> <span class="xn-text">News</span></a>                        
                    </li>  
                   

                    @if(Auth::user()->SuperAdmin())
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa fa-users"></span> <span class="xn-text">Members</span></a>
                        <ul>
                            <li><a href="{{url('/admin/newadmin')}}"><span class="fa fa-plus-circle"></span> new Member</a></li>

                        </ul>
                        <ul>
                            <li><a href="{{url('/admin/adminmembers')}}"><span class="fa fa-users"></span>Dashboard Members</a></li>

                        </ul>
                       <!--  <ul>
                            <li><a href="#"><span class="fa fa-mobile-phone"></span>Mobile Members</a></li>

                        </ul> -->

                    </li>
                      <li>
                        <a href="{{url('/auth/edit')}}"><span class="fa fa-user"></span> <span class="xn-text">profile</span></a>                        
                    </li>
                    <!--  <li class="xn-openable">
                        <a href="#"><span class="fa fa-exchange"></span> <span class="xn-text">Feeds Web service</span></a>
                        <ul>
                            <li><a href="{{url('/feedsperservice')}}"><span class="fa fa-location-arrow"></span> control web service</a></li>

                        </ul>

                    </li> -->

                    @endif

                 


                    
                    
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">


                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                   
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                  <!--   <li><a href="#">Dahsbord</a></li>                    
                    <li class="active">Dashboard</li> -->
                </ul>
                <!-- END BREADCRUMB -->                       
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                  
                    
                         @yield('content')      
                    
                  
                    
                  
                    
                  
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{url('auth/logout')}}" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
            <!-- Audio Files -->
        <audio id="audio-alert" src="{{asset('/audio/alert.mp3')}}" preload="auto"></audio>
        <audio id="audio-fail" src="{{asset('/audio/fail.mp3')}}" preload="auto"></audio>
            <!--End Audio Files -->
        <!-- END PRELOADS -->                  
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->

        <script type="text/javascript" src="{{asset('/js/plugins/jquery/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/jquery/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/bootstrap/bootstrap.min.js')}}"></script>      
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src="{{asset('/js/plugins/icheck/icheck.min.js')}}"></script>        
        <script type="text/javascript" src="{{asset('/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
<!--         <script type="text/javascript" src="{{asset('/js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>
 -->        
<!--         <script type="text/javascript" src="{{asset('/js/plugins/morris/raphael-min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/morris/morris.min.js')}}"></script>       
        <script type="text/javascript" src="{{asset('/js/plugins/rickshaw/d3.v3.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/rickshaw/rickshaw.min.js')}}"></script>
        <script type='text/javascript' src="{{asset('/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script type='text/javascript' src="{{asset('/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>                
 -->        <script type='text/javascript' src="{{asset('/js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>                
        <script type="text/javascript" src="{{asset('/js/plugins/owl/owl.carousel.min.js')}}"></script>                 
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/fileinput/fileinput.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/dropzone/dropzone.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/plugins/daterangepicker/daterangepicker.js')}}"></script>
             <script type="text/javascript" src="{{asset('/js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/blueimp/jquery.blueimp-gallery.min.js')}}"></script>

        <script type="text/javascript" src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>

           <script type="text/javascript" src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script>

<!--         <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
 -->       <script type="text/javascript" src="{{URL::asset('/js/plugins.js')}}"></script>
        <script type="text/javascript" src="{{asset('/js/actions.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script type="text/javascript" src="{{asset('/js/admin.js')}}"></script>

        <!--         <script type="text/javascript" src="{{asset('js/demo_dashboard.js')}}"></script>
 -->
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
        <script type="text/javascript">

$('#feeds_table').DataTable({
                oLanguage:{
                    sProcessing: "<img src='{{asset('images/box.gif')}}'/>",
                },
                processing: true,
                serverSide: true,
                responsive: true,
                stateSave:true,
               pagingType: "full_numbers",

                ajax: '{!! route('feeds.data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    {data:'logo',
                        render:function(data, type, row) {
                            return '<img src="'+window.location.origin+'/'+data+'" height="50px" width="50px" />';
                        }
                    },
                    {data: 'title', name: 'title' },
                    {data: 'subtitle', name: 'subtitle' },
                    {data: 'feednews', name: 'feednews', orderable: false, searchable: false},
                    {data: 'edit', name: 'edit', orderable: false, searchable: false},
                    {data: 'delete', name: 'delete', orderable: false, searchable: false},
                    {data: 'parse', name: 'parse', orderable: false, searchable: false}





                ]


            });

      


         


            //on click send ajax request to the link to run the function of the given feed


//          $("#feeds_table").on('click',"button[id^='parse_']",function(){
//             var button_id=$("button#"+$(this).attr("id"));
//            var id=$("tr").has("button#"+$(this).attr("id")).find('td:first').text();
//              $.ajax({
//
//                  type: "POST",
//                  url: '../admin/feedparse',
//                  data:{id:id},
//                  beforeSend: function(){
//                        button_id.html('loading');
//                  },
//                  success: function(data)
//                  {
//
//                      button_id.html('Parse now');
//                      alert(data+" News has been added");
//
//
//                  }, error: function(XMLHttpRequest, textStatus, errorThrown) {
//
//                  }
//
//
//
//
//              });
//
//
//
//          });

        </script>
     @stack('scripts')    
    </body>
</html>






