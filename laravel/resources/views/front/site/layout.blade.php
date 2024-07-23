<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @laravelPWA
    <title>@yield('page_title')</title>
    <link rel="stylesheet" href="{{asset('/css/bootstrap.rtl.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap-utilities.rtl.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">

    <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>
</head>
<body dir="rtl" >
<div class="loader-parent" style="position: fixed;width: 100vw;height: 100vh;background: #ffffff;z-index: 999;top: 0;display: flex;justify-content: center;align-content: center;flex-wrap: wrap;"><span class="loader" style="left: 0;right: 0;top: 0;bottom: 0;/* width: 300px; *//* height: 300px; */"></span></div>
@yield('content')


@include('front.site.bottom_menu')

<script src="{{asset('/js/jquery.js')}}"></script>
<script src="{{asset('/js/axios.js')}}"></script>
<script src="{{asset('/js/bootstrap.js')}}"></script>
<script src="{{asset('/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('/js/front.js')}}"></script>
<script>
    //////////////// site loading //////////////////
    $(window).on("load",function () {
        $(".loader-parent").fadeOut("slow")
        var images = document.querySelectorAll('[data-src]');
        images.forEach(function(img) {
            img.setAttribute('src', img.getAttribute('data-src'));
        });
    });
   

</script>
</body>
</html>
