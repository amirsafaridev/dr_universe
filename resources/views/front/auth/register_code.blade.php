@extends('front.auth.layout')
@section('page_title','ثبت نام')
@section('content')
<div class="login-page">
    <div class="logo">
        <img src="{{asset('/img/logo.png')}}" width="150" alt="logo">
    </div>
    <style>
        /* استایل برای input در صورتی که نامعتبر باشد */
        input:invalid {
            border-color: red;
        }

        /* استایل برای پیام خطا */
        input:invalid + .error-message {
            display: inline;
            color: red;
            margin-top: 15px;
        }

        /* استایل برای پیام خطا در صورتی که ورودی معتبر باشد */
        .error-message {
            display: none;
        }
    </style>
    <form class="login-form" action="{{ route('verify_reg_code') }}" method="POST">
        @csrf
        <div class="code last-input">
            <label for="code"> رمز یکبار مصرف ارسال شده به : <b>{{$mobile}}</b></label>
            <input type="password" id="code" name="code" pattern="\d+" required>
            <span class="error-message" id="error-message">لطفاً فقط اعداد را به انگلیسی وارد کنید.</span>

            <input type="hidden" id="mobile" name="mobile" value="{{$mobile}}">
            <input type="hidden" id="username" name="username" value="{{$username}}">
        </div>

        @if ($errors->any())
            <div id="custom_alert" class="alert alert-danger" style="font-size: 14px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <a href="#" id="resendCodeLink">ارسال مجدد کد</a>
            <span id="timer" style="display:none;">(01:00)</span>
        </div>

        <button class="submit" type="submit" id="check_reg_code">ورود</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let countdownTime = 60; // پیش‌فرض 1 دقیقه به ثانیه
        const resendLink = document.getElementById('resendCodeLink');
        const mobileInput = document.getElementById('mobile');
        const timerSpan = document.getElementById('timer');
        let countdownInterval;

        const storedMobile = localStorage.getItem('mobile');
        if (storedMobile) {
            mobileInput.value = storedMobile;
        } else if (mobileInput.value) {
            // اگر شماره موبایل در LocalStorage نبود، آن را ذخیره می‌کنیم
            localStorage.setItem('mobile', mobileInput.value);
        }

        // بازیابی تایمر و وضعیت لینک از LocalStorage
        function loadState() {
            const savedTime = localStorage.getItem('countdownTime');
            const lastUpdate = localStorage.getItem('lastUpdate');

            if (savedTime && lastUpdate) {
                const elapsed = Math.floor((Date.now() - lastUpdate) / 1000);
                countdownTime = Math.max(0, savedTime - elapsed);
            }
        }

        // ذخیره تایمر در LocalStorage
        function saveState() {
            localStorage.setItem('countdownTime', countdownTime);
            localStorage.setItem('lastUpdate', Date.now());
        }

        // شروع تایمر
        function startTimer() {
            resendLink.style.pointerEvents = 'none';
            resendLink.style.color = 'gray';
            timerSpan.style.display = 'inline';

            countdownInterval = setInterval(() => {
                countdownTime--;
                saveState();
                updateTimerDisplay();

                if (countdownTime <= 0) {
                    clearInterval(countdownInterval);
                    resetResendLink();
                }
            }, 1000);
        }

        // بروزرسانی نمایش تایمر
        function updateTimerDisplay() {
            const minutes = Math.floor(countdownTime / 60);
            const seconds = countdownTime % 60;
            timerSpan.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }

        // ریست کردن لینک ارسال مجدد کد
        function resetResendLink() {
            resendLink.style.pointerEvents = 'auto';
            resendLink.style.color = '#007bff'; // رنگ لینک آبی پیش‌فرض
            timerSpan.style.display = 'none'; // پنهان کردن تایمر
            localStorage.removeItem('countdownTime'); // حذف تایمر از LocalStorage
            localStorage.removeItem('lastUpdate'); // حذف زمان آخرین به‌روزرسانی
        }

        // تابع برای ارسال مجدد کد
        function resendCode(event) {
            event.preventDefault();

            fetch("{{ route('resend_register_code') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    mobile: document.getElementById('mobile').value
                })
            }).then(response => response.json())
                .then(data => {
                    if (data.result) {
                        countdownTime = 60; // بازنشانی تایمر به 1 دقیقه
                        saveState();
                        startTimer(); // شروع مجدد تایمر
                    } else {
                        alert(data.message); // نمایش پیام خطا
                    }
                }).catch(error => {
                console.error("Error:", error);
            });
        }

        // شروع تایمر از جایی که متوقف شده بود
        loadState();
        if (countdownTime > 0) {
            startTimer();
        } else {
            resetResendLink();
        }

        // اتصال رویداد کلیک به لینک ارسال مجدد کد
        resendLink.addEventListener('click', resendCode);
    });

</script>
@endsection
