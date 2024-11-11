@extends('front.site.layout')
@section('page_title','پخش زنده')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            padding: 0 !important;
            direction: rtl;
            margin: 0 !important;
            overflow: hidden;
        }
        footer {
            display: none;
        }
        .r1_iframe_embed iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
        .view-counter, .timer-counter {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        .view-counter {
            top: 10px;
            right: 10px;
        }
        .timer-counter {
            top: 10px;
            left: 10px;
        }
        .comment-list {
            direction: ltr;
            flex-direction: column-reverse;
            display: flex;
            position: absolute;
            bottom: 70px; /* فاصله برای باکس کامنت */
            width: 100%;
            max-height: 200px; /* حداکثر ارتفاع لیست کامنت‌ها */
            overflow-y: auto; /* فعال کردن اسکرول عمودی */
            color: #fff;
            padding: 10px;
            border-radius: 8px; /* برای زیبایی */
        }
        .comment-container {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 10px;
            display: flex;
            align-items: center;
            box-sizing: border-box;
        }
        .heart-icon {
            font-size: 30px;
            color: red;
            margin-left: 10px;
            cursor: pointer;
        }
        .comment-box {
            flex-grow: 1;
            display: flex;
            align-items: center;
        }
        .comment-box input[type="text"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 0 50px 50px 0;
            margin: 0;
        }
        .comment-box button {
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50px 0 0 50px;
            cursor: pointer;
        }
    </style>

    <div class="r1_iframe_embed">
        <iframe
            src="{{ $decodedUrl }}"
            style="border:0 #ffffff none;"
            name="apitestapi"
            frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            webkitallowfullscreen
            mozallowfullscreen>
        </iframe>

        <!-- Counter for views -->
        <div class="view-counter">
            <i class="fas fa-eye"></i>
            <span style="margin-top: 3px;margin-right: 5px;">
{{--                <span style="margin-right: 3px"> 0 بازدید</span>--}}
            </span>
        </div>

        <!-- Timer with icon -->
        <div class="timer-counter" style="display: none">
            <i class="fas fa-clock"></i>
            <span style="margin-top: 3px; margin-right: 10px;" id="timerDisplay">00:00:00</span>
        </div>

        <div class="comment-list" id="commentList">
            <!-- کامنت‌ها در اینجا نمایش داده می‌شوند -->
        </div>

        <div class="comment-container">
            <i id="heartIcon"  class="fa fa-heart-o heart-icon"></i>
            <div class="comment-box" style="display: none">
                <input type="text" placeholder="نظر خود را بنویسید...">
                <button type="button">ارسال</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            document.getElementById('heartIcon').addEventListener('click', function() {
                console.log("Icon clicked");  // برای اطمینان از اینکه رویداد کلیک کار می‌کند
                if (this.classList.contains('fa-heart-o')) {
                    this.classList.remove('fa-heart-o');
                    this.classList.add('fa-heart');
                }
            });




            let displayedComments = new Set(); // مجموعه‌ای برای ذخیره کامنت‌های نمایش داده شده

            $('.comment-box button').on('click', function() {
                let comment = $('.comment-box input').val();
                let liveStreamId = {{ $liveStream->id }}; // فرض کنیم آی‌دی لایو استریم در دسترس است

                if (comment !== '') {
                    $.ajax({
                        url: '{{ route('live.comments.store') }}', // این مسیر برای ذخیره کامنت‌ها استفاده می‌شود
                        method: 'POST',
                        data: {
                            comment: comment,
                            live_stream_id: liveStreamId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('.comment-box input').val(''); // بعد از ارسال، ورودی خالی شود
                            loadComments(); // پس از ارسال، کامنت‌های جدید بارگذاری شوند
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText); // نمایش خطا در کنسول
                        }
                    });
                }
            });

            function loadComments() {
                let liveStreamId = {{ $liveStream->id }}; // آی‌دی لایو استریم

                // اولین درخواست برای دریافت وضعیت کامنت‌ها
                $.ajax({
                    url: `/live-streams/${liveStreamId}/comments-status`, // فرض بر این است که این مسیر وضعیت کامنت‌ها را برمی‌گرداند
                    method: 'GET',
                    success: function(statusResponse) {
                        const commentsStatus = statusResponse.status; // فرض بر این است که وضعیت در فیلد 'status' قرار دارد

                        // بررسی وضعیت کامنت‌ها
                        if (commentsStatus === 0) {
                            $('#commentList').hide(); // مخفی کردن لیست کامنت‌ها اگر وضعیت غیرفعال باشد
                            $('.comment-box').hide(); // مخفی کردن باکس کامنت‌ها
                        } else {
                            $('#commentList').show(); // نمایش کامنت‌ها اگر وضعیت فعال باشد
                            $('.comment-box').show(); // نمایش باکس کامنت‌ها
                        }

                        // درخواست برای دریافت کامنت‌ها
                        $.ajax({
                            url: '{{ route('live.comments.index', ['live_stream_id' => $liveStream->id]) }}',
                            method: 'GET',
                            success: function(response) {
                                let commentsHtml = '';
                                response.comments.forEach(function(comment) {
                                    console.log(comment.user.profile);
                                    // چک کردن اینکه آیا کامنت قبلا نمایش داده شده یا نه
                                    if (!displayedComments.has(comment.id)) {
                                        displayedComments.add(comment.id); // اضافه کردن کامنت به مجموعه
                                        commentsHtml += `
                                <div class="comment-item">
                                    <img src="{{ url('storage/profiles/') }}/${comment.user.profile}" alt="user-image" style="width: 40px; object-fit: cover; height: 40px; border-radius: 50%;">
                                    <span style="margin: 10px 5px !important;">${comment.user.username_with_blue_tick}</span>
                                    <p style="margin-left: 3.5rem;">${comment.comment}</p>
                                </div>
                            `;
                                    }
                                });

                                $('#commentList').prepend(commentsHtml); // کامنت‌های جدید در بالای لیست نمایش داده شوند
                            }
                        });
                    },
                    error: function(error) {
                        console.error('خطا در دریافت وضعیت کامنت‌ها:', error);
                    }
                });
            }


            function loadViews() {
                let liveStreamId = {{ $liveStream->id }}; // آی‌دی لایو استریم

                $.ajax({
                    url: '{{ route('live.views', ['liveStreamId' => $liveStream->id]) }}',
                    method: 'GET',
                    success: function(response) {
                        $('.view-counter span').html(`${response.views} <span style="margin-right: 3px"> بازدید</span>`);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // نمایش خطا در کنسول
                    }
                });
            }

            // هر 30 ثانیه یکبار کامنت‌ها را بارگذاری کن
            setInterval(function() {
                loadComments();
                loadViews();
            }, 15000);

            document.addEventListener('visibilitychange', function() {
                let liveStreamId = {{ $liveStream->id }};
                $.ajax({
                    url: '{{ route('live.views.decrease', ['liveStreamId' => $liveStream->id]) }}', // مسیری که برای کاهش بازدیدها ایجاد می‌کنید
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    async: false // برای اطمینان از اینکه درخواست قبل از ترک صفحه ارسال شود
                });
            });


        });
    </script>
@endsection
