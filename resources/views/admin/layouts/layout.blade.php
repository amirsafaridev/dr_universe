<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

    <title>پنل مدیریت دکتر یونیورس</title>

    <!-- Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/morris/morris.css') }}">

    <!-- App css -->
    <link href="{{ asset('admin/assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/menu.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{ asset('admin/assets/js/modernizr.min.js') }}"></script>
</head>

<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="{{ url('/admin') }}" class="logo">
                <span>دکتر<span>یونیورس</span></span><i class="zmdi zmdi-layers"></i>
            </a>
        </div>


        <!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <button class="button-menu-mobile open-left">
                            <i class="zmdi zmdi-menu"></i>
                        </button>
                    </li>
                    <li>
                        <h4 class="page-title">پنل مدیریت دکتر یونیورس</h4>
                    </li>
                </ul>
{{--                <ul class="nav navbar-nav navbar-right">--}}
{{--                    <li>--}}
{{--                        <div class="notification-box">--}}
{{--                            <ul class="list-inline m-b-0">--}}
{{--                                <li>--}}
{{--                                    <a href="javascript:void(0);" class="right-bar-toggle">--}}
{{--                                        <i class="zmdi zmdi-notifications-none"></i>--}}
{{--                                    </a>--}}
{{--                                    <div class="noti-dot">--}}
{{--                                        <span class="dot"></span>--}}
{{--                                        <span class="pulse"></span>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li class="hidden-xs">--}}
{{--                        <form role="search" class="app-search">--}}
{{--                            <input type="text" placeholder="به دنبال چه می گردی ؟؟؟" class="form-control">--}}
{{--                            <a href=""><i class="fa fa-search"></i></a>--}}
{{--                        </form>--}}
{{--                    </li>--}}
{{--                </ul>--}}
            </div>
        </div>
    </div>
    <!-- Top Bar End -->

    <!-- Sidebar -->
    @include('admin.sidebar')

    <!-- Main Content -->
    <div class="content-page">
        <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-right">
        2024 © ArtaCode
    </footer>
</div>

<!-- Scripts -->
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap-rtl.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/detect.js') }}"></script>
<script src="{{ asset('admin/assets/js/fastclick.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('admin/assets/js/waves.js') }}"></script>
<script src="{{ asset('admin/assets/js/wow.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('admin/assets/pages/jquery.dashboard.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.core.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.app.js') }}"></script>

</body>
</html>
