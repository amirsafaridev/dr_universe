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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<script src="{{asset('/js/cropper.min.js')}}"></script>
<script src="{{asset('/js/interact.min.js')}}"></script>
<script>
    //////////////// site loading //////////////////


    $(window).on('pageshow', function() {

        $(".loader-parent").fadeOut("slow");
        var images = document.querySelectorAll('[data-src]');
        images.forEach(function(img) {
            img.setAttribute('src', img.getAttribute('data-src'));
        });
    });

    // $(window).on('pageshow', function() {
    //     // لود کردن تصاویر با استفاده از data-src
    //     var images = document.querySelectorAll('[data-src]');
    //     images.forEach(function(img) {
    //         img.setAttribute('src', img.getAttribute('data-src'));
    //     });
    //
    //     // بررسی وجود هر پست در URL
    //     if (window.location.hash) {
    //         var targetPost = $(window.location.hash);
    //
    //         if (targetPost.length) {
    //             // نمایش preloader
    //             $(".loader-parent").show();
    //
    //             // متغیر برای ذخیره timeout
    //             var scrollTimeout;
    //
    //             // تابع برای مخفی کردن preloader پس از اتمام اسکرول و رسیدن به پست
    //             function checkScrollAndHideLoader() {
    //                 var targetOffset = targetPost.offset().top;
    //                 var scrollPos = $(window).scrollTop();
    //                 var windowHeight = $(window).height();
    //
    //                 // بررسی اینکه آیا به پست مورد نظر رسیده‌ایم یا نه
    //                 if (scrollPos + windowHeight >= targetOffset) {
    //                     $(".loader-parent").fadeOut("slow");
    //                 }
    //             }
    //
    //             // رویداد اسکرول
    //             $(window).on('scroll', function() {
    //                 // پاک کردن timeout قبلی
    //                 clearTimeout(scrollTimeout);
    //
    //                 // تنظیم timeout جدید که پس از 200ms عدم اسکرول فراخوانی می‌شود
    //                 scrollTimeout = setTimeout(checkScrollAndHideLoader, 200);
    //             });
    //
    //             // بررسی اولیه بدون اسکرول دستی
    //             checkScrollAndHideLoader();
    //         }
    //     } else {
    //         // اگر hash وجود نداشته باشد، preloader را مخفی کن
    //         $(".loader-parent").fadeOut("slow");
    //     }
    // });


</script>
</body>
</html>
