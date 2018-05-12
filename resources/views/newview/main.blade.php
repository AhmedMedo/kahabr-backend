<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Khabar News </title>
    <meta name="description" content="موقع خبر لعرض اخر الاخبار وتصفح الاخبار بناء على رغبة المستخدم">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{asset('home/css/highlight.css')}}">
    <!-- ===This Style sheet for Highlight === -->
    <link rel="stylesheet" href="{{asset('home/css/Pe-icon-7-stroke.css')}}">
    <!-- ===This Style sheet for Stoke Icon === -->
    <link rel="stylesheet" href="{{asset('home/css/meanmenu.css')}}">
    <!-- ===This Style sheet for Responsive Menu=== -->
    <link rel="stylesheet" href="{{asset('home/css/animate.css')}}">
    <!-- ===This Style sheet for Animations=== -->
    <link rel="stylesheet" href="{{asset('home/css/owl.carousel.css')}}">
    <!-- ===This Style sheet for Owl Carousel=== -->
    <link rel="stylesheet" href="{{asset('home/css/owl.theme.css')}}">
    <!-- ===This Style sheet for Owl Carousel=== -->
    <link rel="stylesheet" href="{{asset('home/css/font-awesome.min.css')}}">
    <!-- ===This Style sheet for Font Awesome fonts & icons=== -->
    <link rel="stylesheet" href="{{asset('home/css/bootstrap.min.css')}}">
    <!-- ===This Style sheet for Bootstrap classes=== -->
    <link rel="stylesheet" href="{{asset('home/css/style.css')}}">
    <!-- ===This Style sheet for Styling the full template=== -->
    <link rel="stylesheet" href="{{asset('home/css/responsive.css')}}">
    <!-- ===This Style sheet for making the template responsive for all devices=== -->
    <script src="{{asset('home/js/vendor/modernizr-2.6.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/jquery-1.11.3.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>


</head>
<body>


<!-- ___Start Home One Page___ -->
<div class="container-fluid home-1" id="container-full">
    <div class="row">

        <!-- ___Start Left Menu___ -->
        <div class="col-md-2 no-padding">
            <div id="left-sidebar">
                <div class="sidebar-menu">
                    <div class="logo">
                        <a href="{{url('/')}}"><img src="{{asset('home/images/khabar_2.png')}}" alt="Octagon"/></a>
                    </div>
                    <!-- End Logo -->

                    <!-- ___Start Menu Area___ -->
                    <div id="menu-area" class="menu-area toogle-sidebar-sections">
                        <div class="menu-head">
                            <a href="#0" class="accordion-toggle">Menu <span class="toggle-icon"><i
                                            class="fa fa-bars"></i></span></a>
                            <div class="accordion-content">
                                <div class="menu-body">
                                    <ul>
                                        <li class="home"><a href="{{url('/')}}">Last news</a>
                                        </li>

                                        @if(Auth::check())
                                            @if(Auth::user()->isAdmin() || Auth::user()->SuperAdmin())

                                                <li>
                                                    <a href="{{url('/admin')}}"><span class="fa fa-dashboard"></span>
                                                        <span class="xn-text">Dashboard</span></a>
                                                </li>
                                            @endif
                                        @endif

                                        <div class="search_div">
                                            <li class="home">
                                                <form method="GET" action="{{url('/result')}}" id="search">

                                                    <div class="form-group">
                                                        <input type="text" class="form-control search_form " placeholder="Search" name="keyword" />
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control form_selected" name="title">
                                                            <option value="" disabled selected>Select your feed</option>
                                                            @foreach($menu_tree as $key =>$value)
                                                                <optgroup label="{{$key}}">
                                                                    @foreach($value as $title)
                                                                        <option>{{$title->title}}</option>

                                                                    @endforeach

                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control form_selected" name="tags">
                                                            <option value="" disabled selected>Select your topic</option>
                                                            @foreach($tags as $tag)
                                                                <option>{{$tag}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control form_selected" name="country">
                                                            <option value="" disabled selected>Select your country</option>
                                                            @foreach($countries as $country)
                                                                <option>{{$country}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control form_selected" name="language">
                                                            <option value="" disabled selected>Select your language</option>
                                                            @foreach($languages as $language)
                                                                <option>{{$language}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <button type="submit" class="btn btn-info pull-right">search</button>
                                                </form>
                                            </li>

                                        </div>

                                    </ul>

                                </div><!-- End Menu Body -->
                            </div><!-- End According Content -->
                            {{--<div class="search_div">--}}

                                {{--<a href="#0" class="accordion-toggle">Search <span class="toggle-icon"><i--}}
                                                {{--class="fa fa-bars"></i></span></a>--}}
                                {{--<div class="accordion-content">--}}
                                    {{--<div class="menu-body">--}}
                                        {{--<ul>--}}
                                            {{--<li class="home">--}}
                                                {{--<form method="GET" action="{{url('/result')}}" id="search">--}}

                                                        {{--<div class="col-md-6">--}}
                                                            {{--<input type="text" class="form-control search_form " placeholder="Search" />--}}

                                                        {{--</div>--}}
                                                        {{--<button type="submit" class="btn btn-info pull-right">search</button>--}}
                                                {{--</form>--}}
                                            {{--</li>--}}
                                        {{--</ul>--}}

                                    {{--</div><!-- End Menu Body -->--}}
                                {{--</div><!-- End According Content -->--}}
                            {{--</div>--}}

                        </div><!-- End Menu Head -->
                    </div>
                    <!-- End Menu Area -->


                </div><!-- End Sidebar Menu -->
            </div><!-- End Menu Left -->
        </div><!-- End Column -->
        <!-- End Left Menu -->

        <!-- ___Start Column___ -->
        <div class="col-md-10 no-padding">

            <!-- ___Start Top Bar___ -->
            <div class="top-bar">
                <div class="top-bar-head">
                    <div class="search">
                        <i class="pe-7s-search showSingle" id="1"></i>
                        <p>what are you looking for?</p>
                    </div>
                    <div class="login-user pull-right showSingle" id="2">
                        <i class="pe-7s-user"></i>
                    </div>

                    <!-- <div class="login-mail pull-right showSingle" id="3">
                        <i class="pe-7s-mail"></i>
                    </div> -->
                </div>
                <!-- End Top Bar Head -->

                <!-- ___Start Top Bar Body___ -->
                <div class="top-bar-body">
                    <div class="search-body targetDiv" id="div1">
                        <p>What are you looking for?</p>
                        <form method="GET" action="{{url('/result')}}" id="search">

                            <div class="form-group">
                                <input type="text" class="form-control no-radius" placeholder="search keyword"
                                       name="keyword">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="title">
                                    <option value="" disabled selected>Select your feed</option>
                                    @foreach($menu_tree as $key =>$value)
                                        <optgroup label="{{$key}}">
                                            @foreach($value as $title)
                                                <option>{{$title->title}}</option>

                                            @endforeach

                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="tags">
                                    <option value="" disabled selected>Select your topic</option>
                                    @foreach($tags as $tag)
                                        <option>{{$tag}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="country">
                                    <option value="" disabled selected>Select your country</option>
                                    @foreach($countries as $country)
                                        <option>{{$country}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="language">
                                    <option value="" disabled selected>Select your language</option>
                                    @foreach($languages as $language)
                                        <option>{{$language}}</option>
                                    @endforeach
                                </select>
                            </div>




                            <div class="form-group">

                                <button type="reset" class="btn btn-info btn-lg" id="reset">

                                    reset

                                </button>
                                <button type="submit" class="btn btn-default btn-lg pull-right">
                                    <i class="fa fa-search"></i>

                                    search

                                </button>

                            </div>

                        </form>
                    </div>

                    <!-- ___Start Top Bar Login Body___ -->
                    <div class="user-body targetDiv" id="div2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="register">


                                    @if(Auth::guest())


                                        <p>Already a user</p>
                                        <button type="submit" class="btn btn-info form-control no-radius"
                                                onclick="location.href='{{url('/auth/login')}}';">LOGIN
                                        </button>

                                    @else
                                        <p>edit profile</p>
                                        <button type="submit" class="btn btn-info form-control no-radius"
                                                onclick="location.href='{{url('/auth/edit')}}';">EDIT PROFILE
                                        </button>
                                    @endif


                                </div>
                            </div><!-- End Column -->

                            <div class="dashed-divider"></div>
                            <div class="col-md-6">
                                <div class="register">
                                    @if(Auth::guest())

                                        <p>Are You New User</p>
                                        <button type="submit" class="btn btn-default form-control no-radius"
                                                onclick="location.href='{{url('/auth/register')}}';">Register Your
                                            Account
                                        </button>
                                    @else

                                        <p>logout</p>
                                        <button type="submit" class="btn btn-default form-control no-radius"
                                                onclick="location.href='{{url('/auth/logout')}}';">Logout
                                        </button>

                                    @endif
                                </div>
                            </div><!-- End Column -->
                        </div><!-- End Row -->
                    </div>
                    <!-- End Top Bar Login Body -->


                </div>
                <!-- End Top Bar -->


                <!-- ___Main Content___ -->
                <div class="main-content">
                    <!-- End Main Slider -->
                    <div class="page_title">

                        @yield('page_title')


                    </div>
                    <!-- ___Mani Post Body___ -->
                    <div class="main-post-body" id="content">
                        @yield('content')
                    </div> <!-- End Main Body Post -->
                </div> <!-- End Main Content -->


                <!-- ___Start Bottom___ -->
                <div class="bottom container-fluid">
                    <div class="row">

                        <!-- ___Contact Us___ -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="bottom-contact widget">
                                <h3>Contact</h3>
                                <div class="contact-info">
                                    <p><strong>Email :</strong> info@fekracomputers.com</p>
                                    <p><strong>Tel :</strong> +02 (0) 11 5050 5005</p>
                                </div>
                            </div>
                        </div>
                        <!-- End Column -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="bottom-contact widget about_us">
                                <h3> About us</h3>
                                <p>

                                    تعتبر شركة فكرة من إحدي شركات البرمجة التي تتمتع بالخبرة في مجال تصميم تطبيقات
                                    المحمول والمواقع الإليكترونية،لدينا فريق عمل قوي، ذو خبرة عميقة في تطوير الأدوات
                                    التكنولوجية الرئيسية المختلفة من جافا، دوت نت، بالإضافة إلي معرفتنا العميقة بالأي
                                    فون والاندرويد والبلاك بيري.فكرة تحتل مكان فريد من بين المئات من الشركات المحترفة في
                                    البرمجة وشركات تصميم المواقع الإليكترونية،
                                    فنحن لا نكتفي فقط بتقديم خدمة او منتج ولكننا نقدم افضل الوسائل والحلول المتاحة التي
                                    تتناسب مع المتطلبات المالية والوظيفية لعملائنا.إن تحليلاتنا الديمجرافية التنافسية
                                    والتي هي في عمق السوق تمكن شركتنا من إنتاج تحسينات مثلى لمحركات البحث لا يستطيع
                                    منافسينا إنتاجها بنفس المستوى.
                                    نحن نهدف باستمرار لعمل حلول مختلفة بناءًا على متطلبات عملائنا المالية واستراتيجياتهم
                                    الدقيقة تقود إلى علاقات عمل مستمرة وطويلة المدى.نتمنى مساعدتكم.


                                </p>
                            </div>
                        </div>
                        <!-- End Column -->


                    </div><!-- End Row -->
                </div>
                <!-- End Bottom -->


            </div><!-- End Column -->
        </div><!-- End Row -->


    </div><!--End row-->

</div><!-- End Container -->
<script src="{{asset('home/js/scripts.js')}}"></script>                <!-- ===This Script for Custom Script=== -->
<script src="{{asset('home/js/owl.carousel.min.js')}}"></script>            <!-- ===This Script for Owl Carousel=== -->
<script src="{{asset('home/js/bootstrap.min.js')}}"></script>            <!-- ===This Script for Bootstrap=== -->
<script src="{{asset('home/js/wow.min.js')}}"></script>                <!-- ===This Script for Wow JS=== -->
<script src="{{asset('home/js/jquery.meanmenu.min.js')}}"></script>        <!-- ===This Script for Main Menu=== -->
<script src="{{asset('home/js/jquery.jscroll.js')}}"></script>



@stack('scripts')
</body>
</html>
