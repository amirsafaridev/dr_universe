@extends('front.site.layout')
@section('page_title', 'خانه')

@section('content')
    <div class="container" style="    padding: 0;
    display: flex;
    flex-direction: column;
    height: 100%;">
        <div id="chat-box" class="chat-box" style="    padding: 10px;
    overflow-y: scroll;
    flex-grow: 1;
    height: 100%;">
            @foreach ($messages as $message)
                @php
                    $isSender = $message->user_id === auth()->id();
                @endphp

                <div style="display: flex; justify-content: {{ $isSender ? 'flex-start' : 'flex-end' }}; margin-bottom: 10px;">
                    @if ($isSender)
                        <!-- نمایش عکس پروفایل فرستنده (کاربر فعلی) -->
                        <img src="{{ url('storage/profiles/' . auth()->user()->profile) }}" alt="Profile Picture" style="object-fit: cover; width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                    @endif

                    <div style="max-width: 70%; margin-left: 10px; margin-right: 10px; background-color: {{ $isSender ? '#FFF' : '#DCF8C6' }}; padding: 10px; border-radius: 10px;">
                        {{-- نمایش پیام به صورت HTML --}}
                        {!! $message->message !!}
                    </div>

                    @if (!$isSender)
                        <img src="{{ url('storage/profiles/' . $message->sender->profile) }}" alt="Profile Picture" style="object-fit: cover; width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;">
                    @endif
                </div>
            @endforeach
        </div>

        <!-- فرم ارسال پیام در انتهای چت باکس -->
        <form action="{{ route('conversations.store') }}" method="POST" class="mt-3" style="padding-bottom: 80px; display: flex; align-items: center;">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->id : $conversation->userOne->id }}">

            <!-- تنظیم فرم برای قرارگیری در کنار هم -->
            <style>
                .form-control-test:focus,.form-control-test:focus-visible
                {
                    border: none !important;
                    box-shadow: none !important;
                }
            </style>
            <div class="form-group" style="flex-grow: 1; margin: 0;">
                <textarea name="message" class="form-control form-control-test" rows="2" required placeholder="پیام..." style="    border: none;
    border-radius: 0 20px 20px 0;margin:0;resize: none; width: 100%;"></textarea>
            </div>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


            <button type="submit" class="btn btn-primary" style="    padding: 20px;
    border-radius: 20px 0 0 20px;; height: auto;">        <i class="fas fa-paper-plane"></i> <!-- آیکون ارسال -->
            </button>
        </form>

    </div>

    <script>
        setInterval(function (){
            var videos = document.querySelectorAll('video');
            videos.forEach(function(video) {
                video.pause();
                video.currentTime = 0; // می‌توانید این خط را اضافه کنید تا ویدیو به ابتدای آن بازگردد
            });
        },1000);

        function scrollToBottom() {
            var chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight; // اسکرول چت‌باکس به پایین

            window.scrollTo(0, document.body.scrollHeight); // اسکرول صفحه به پایین
        }

        // وقتی صفحه بارگذاری شد، به انتهای چت اسکرول کن
        window.onload = scrollToBottom;
    </script>

@endsection
