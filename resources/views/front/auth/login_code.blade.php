@extends('front.auth.layout')
@section('page_title','ورود')
@section('content')

    <div class="login-page">
        <div class="logo">
            <img src="{{asset('/img/logo.png')}}" width="150" alt="logo">
        </div>
        <form class="login-form" action="{{ route('verify_login_code') }}" method="POST">
            @csrf
            <div class="code last-input">
                <label for="code"> رمز یکبار مصرف ارسال شده به: <b>{{$mobile}}</b></label>
                <input type="text" id="code" name="code" required>
                <input type="hidden" id="mobile" name="mobile" value="{{$mobile}}">
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

            <div class="resend-code">
                <a href="#" id="resendCodeLink" onclick="resendCode(event)">ارسال مجدد کد</a>
                <span id="timer">(01:00)</span>
            </div>

            <button class="submit" type="submit">ورود</button>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let countdownTime = 60; // تغییر به 1 دقیقه (60 ثانیه)
            const resendLink = document.getElementById('resendCodeLink');
            const mobileInput = document.getElementById('mobile');
            const timerSpan = document.getElementById('timer');
            let countdownInterval;

            const storedMobile = localStorage.getItem('mobile');
            if (storedMobile) {
                mobileInput.value = storedMobile;
            } else if (mobileInput.value) {
                localStorage.setItem('mobile', mobileInput.value);
            }

            function loadState() {
                const savedTime = localStorage.getItem('countdownTime');
                const lastUpdate = localStorage.getItem('lastUpdate');

                if (savedTime && lastUpdate) {
                    const elapsed = Math.floor((Date.now() - lastUpdate) / 1000);
                    countdownTime = Math.max(0, savedTime - elapsed);
                }
            }

            function saveState() {
                localStorage.setItem('countdownTime', countdownTime);
                localStorage.setItem('lastUpdate', Date.now());
            }

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

            function updateTimerDisplay() {
                const minutes = Math.floor(countdownTime / 60);
                const seconds = countdownTime % 60;
                timerSpan.textContent = `(${minutes}:${seconds < 10 ? '0' : ''}${seconds})`;
            }

            function resetResendLink() {
                resendLink.style.pointerEvents = 'auto';
                resendLink.style.color = '#007bff';
                timerSpan.style.display = 'none';
                localStorage.removeItem('countdownTime');
                localStorage.removeItem('lastUpdate');
            }

            function resendCode(event) {
                event.preventDefault();

                fetch("{{ route('resend_login_code') }}", {
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
                            startTimer();
                        } else {
                            alert(data.message);
                        }
                    }).catch(error => {
                    console.error("Error:", error);
                });
            }

            loadState();
            if (countdownTime > 0) {
                startTimer();
            } else {
                resetResendLink();
            }

            resendLink.addEventListener('click', resendCode);
        });
    </script>

@endsection
