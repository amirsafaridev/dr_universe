@extends('front.site.layout')
@section('page_title','پخش زنده')

@section('content')
<style>
    footer
    {
        display: none;
    }
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
    }
    #preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    #controls {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 1;
    }
    .control-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        background-color: rgba(255, 255, 255, 0.7);
        border: none;
        cursor: pointer;
        opacity: 0.8;
    }
    .control-btn:hover {
        opacity: 1;
    }
    .control-btn.recording {
        background-color: red;
    }
    .control-btn.stopped {
        background-color: green;
    }
    #loadingMessage {
        justify-content: center;
        align-items: center;
        display: flex;
        font-size: 18px;
        color: white;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 10px;
        border-radius: 5px;
    }
    #cameraSwitchBtn {
        display: flex;
        background-color: red;
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
        z-index: 99999;
    }
    .view-counter {
        top: 10px;
        right: 10px;
    }
    .timer-counter {
        top: 10px;
        left: 10px;
        display: none;
    }
    #viewLive
    {
        display: none;
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


    input[type=checkbox] {
        height: 0;
        width: 0;
        visibility: hidden;
    }

    label {
        margin: 10px;
        cursor: pointer;
        text-indent: -9999px;
        width: 60px; /* تغییر اندازه */
        height: 30px; /* تغییر اندازه */
        background: grey;
        display: block;
        border-radius: 30px; /* تغییر شعاع */
        position: absolute; /* تغییر موقعیت */
        bottom: 0;
        right: 0;
    }

    label:after {
        content: '';
        position: absolute;
        top: 3px; /* تغییر موقعیت */
        left: 3px; /* تغییر موقعیت */
        width: 24px; /* تغییر اندازه */
        height: 24px; /* تغییر اندازه */
        background: #fff;
        border-radius: 50%; /* تغییر شعاع */
        transition: 0.3s;
    }

    input:checked + label {
        background: #bada55;
    }

    input:checked + label:after {
        left: calc(100% - 3px);
        transform: translateX(-100%);
    }

    label:active:after {
        width: 30px; /* تغییر اندازه */
        height: 30px; /* تغییر اندازه */
    }



</style>
<body>
<div class="view-counter" id="viewLive">

</div>

<!-- Timer with icon -->
<div class="timer-counter">
    <i class="fas fa-clock"></i>
    <span style="margin-top: 3px; margin-right: 10px;" id="timerDisplay">00:00:00</span>
</div>
<video id="preview" autoplay muted></video>
<div id="controls">
    <div id="loadingMessage">در حال راه‌ اندازی</div>
    <button id="cameraSwitchBtn" class="control-btn">
        <i class="fas fa-camera"></i>
    </button>
    <button id="recordBtn" class="control-btn stopped" style="display: none;">
        <i class="fas fa-record-vinyl"></i>
    </button>
</div>
<div class="comment-list" id="commentList" style="display: none">
    <!-- کامنت‌ها در اینجا نمایش داده می‌شوند -->
</div>

<input type="checkbox" id="toggleCommentsSwitch" checked  />
<label id="artabtn" for="toggleCommentsSwitch">Toggle Comments</label>





<script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const recordBtn = document.getElementById('recordBtn');
        const cameraSwitchBtn = document.getElementById('cameraSwitchBtn');
        const loadingMessage = document.getElementById('loadingMessage');
        const preview = document.getElementById('preview');
        const toggleCommentsSwitch = document.getElementById('toggleCommentsSwitch');
        const commentsContainer = document.getElementById('commentList'); // فرض بر این است که یک div برای نمایش کامنت‌ها دارید


        let recorder;
        let isRecording = false;
        let ws;
        let stream_key;
        let mediaStream;
        let currentCamera = 0; // 0 for front, 1 for back

        let elapsedTime = 0; // اضافه کردن این خط
        let timerInterval;
        let liveStreamId;


        async function initialize() {
            try {
                // دریافت stream_url و stream_key از سرور
                const response = await axios.get('/live-stream');
                const { stream_url, stream_key: receivedStreamKey } = response.data;
                stream_key = receivedStreamKey;

                await getLiveStreamId();

                // بازکردن WebSocket
                openWebSocket(stream_url);

                recordBtn.addEventListener('click', () => {
                    console.log('دکمه ضبط کلیک شد');
                    toggleRecording();
                });

                cameraSwitchBtn.addEventListener('click', () => {
                    console.log('دکمه تغییر دوربین کلیک شد');
                    switchCamera();
                });

            } catch (error) {
                console.error('خطا در هنگام مقداردهی اولیه:', error);
            }
        }

        async function getLiveStreamId() {
            try {
                const response = await axios.get(`/live/id/${stream_key}`);
                liveStreamId = response.data.id; // فرض بر این است که سرور id را با کلید id در جواب ارسال می‌کند
                console.log('Live Stream ID:', liveStreamId);
                // در اینجا می‌توانید با liveStreamId هر کاری که می‌خواهید انجام دهید
            } catch (error) {
                console.error('خطا در دریافت ID پخش زنده:', error);
            }
        }


        async function getViews() {
            try {
                // فرض بر این است که liveStreamId را از جایی دارید
                const response = await axios.get(`/live/views/${liveStreamId}`);
                const views = response.data.views;
                const viewLive = document.getElementById('viewLive');
                viewLive.innerHTML = `<i class="fas fa-eye" style="margin-left: 5px"></i>${views}<span style="margin-right: 3px"> بازدید</span>`;
            } catch (error) {
                console.error('خطا در دریافت تعداد ویوها:', error);
            }
        }

        const displayedComments = new Set(); // مجموعه‌ای برای ذخیره کامنت‌های نمایش داده شده


        async function getComments() {
            try {
                const response = await axios.get(`/live-comments/${liveStreamId}`); // فرض بر این است که این مسیر کامنت‌ها را برمی‌گرداند
                const comments = response.data.comments;

                const commentsStatusResponse = await axios.get(`/live-streams/${liveStreamId}/comments-status`); // مسیر جدید برای دریافت وضعیت کامنت‌ها
                const commentsStatus = commentsStatusResponse.data.status; // فرض بر این است که وضعیت در فیلد 'status' قرار دارد


                if (commentsStatus !== 1) {
                    commentsContainer.style.display = 'none'; // مخفی کردن کامنت‌ها اگر وضعیت غیرفعال باشد

                } else {
                    commentsContainer.style.display = 'flex'; // نمایش کامنت‌ها اگر وضعیت فعال باشد
                }


                // استفاده از یک متغیر برای ساخت HTML
                let commentsHtml = '';

                comments.forEach(comment => {
                    // چک کردن اینکه آیا کامنت قبلا نمایش داده شده یا نه
                    if (!displayedComments.has(comment.id)) {
                        displayedComments.add(comment.id); // اضافه کردن کامنت به مجموعه

                        // ساخت HTML برای کامنت جدید
                        commentsHtml += `
                <div class="comment-item">
                    <img src="{{ url('storage/profiles/') }}/${comment.user.profile}" alt="user-image" style="width: 40px; object-fit: cover; height: 40px; border-radius: 50%;">
                    <span style="margin: 10px 5px !important;">${comment.user.username_with_blue_tick}</span>
                    <p style="margin-left: 3.5rem;">${comment.comment}</p>
                </div>
                `;
                    }
                });

                // اضافه کردن کامنت‌های جدید به بالای لیست
                commentsContainer.insertAdjacentHTML('afterbegin', commentsHtml); // کامنت‌ها در بالای لیست نمایش داده شوند
            } catch (error) {
                console.error('خطا در دریافت کامنت‌ها:', error);
            }
        }



        toggleCommentsSwitch.addEventListener('change', async () => {
            console.log(toggleCommentsSwitch.checked);
            try {
                // تغییر وضعیت کامنت‌ها بر اساس وضعیت چک باکس
                const commentsStatus = toggleCommentsSwitch.checked ? 1 : 0; // 1 برای فعال و 0 برای غیرفعال

                // ارسال درخواست به سرور برای بروزرسانی وضعیت کامنت‌ها
                await axios.post(`/live-streams/${liveStreamId}/toggle-comments`, {
                    status: commentsStatus // ارسال وضعیت جدید
                });

            } catch (error) {
                console.error('خطا در تغییر وضعیت کامنت‌ها:', error);
            }
        });






        function openWebSocket(stream_url) {
            ws = new WebSocket('https://druniverselive.liara.run/');

            ws.onopen = () => {
                console.log('اتصال WebSocket برقرار شد');
                ws.send(JSON.stringify({ stream_url }));

                loadingMessage.style.display = 'none';
                recordBtn.style.display = 'flex';
                cameraSwitchBtn.style.display = 'flex'; // نمایش دکمه تغییر دوربین
            };

            ws.onerror = (error) => {
                console.error('خطای WebSocket:', error);
            };

            ws.onclose = () => {
                console.log('اتصال WebSocket بسته شد');
                ws = null;
            };

            ws.onmessage = (event) => {
                console.log('پیام سرور:', event.data);
            };
        }

        function sendBlob(blob) {
            if (!ws || ws.readyState !== WebSocket.OPEN) {
                console.log('WebSocket بسته است، بازگشایی مجدد...');
                setTimeout(() => sendBlob(blob), 1000);
            } else if (ws.readyState === WebSocket.OPEN) {
                console.log('در حال ارسال blob...');
                ws.send(blob);
            } else {
                console.error('اتصال WebSocket باز نیست');
            }
        }

        async function startRecording() {
            if (isRecording) return;

            isRecording = true;
            recordBtn.classList.remove('stopped');
            recordBtn.classList.add('recording');
            recordBtn.innerHTML = '<i class="fas fa-stop"></i>';
            timerDisplay.parentElement.style.display = 'flex'; // نمایش تایمر

            document.getElementById('viewLive').style.display = 'block';
            // document.getElementById('artabtn').style.display = 'block'; // نمایش چک باکس

            startTimer(); // شروع تایمر
            getViews(); // دریافت تعداد ویوها بلافاصله بعد از شروع ضبط
            getComments();
            setInterval(getComments, 15000);
            setInterval(getViews, 15000); // به‌روزرسانی هر 15 ثانیه


            try {
                mediaStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: currentCamera ? 'environment' : 'user' }, audio: true });
                preview.srcObject = mediaStream;

                recorder = new RecordRTC(mediaStream, {
                    type: 'video',
                    mimeType: 'video/webm;codecs=vp9',
                    timeSlice: 1000,
                    ondataavailable: (blob) => {
                        sendBlob(blob);
                    }
                });

                recorder.startRecording();
                console.log('ضبط شروع شد');

                async function callStartRecording() {
                    try {
                        const response = await axios.get('/live-stream/start-recording');
                        console.log('ضبط شروع شد:', response.data.message);
                    } catch (error) {
                        console.error('خطا در شروع ضبط:', error.response ? error.response.data : error.message);
                    }
                }

                callStartRecording();

                // مخفی کردن دکمه تغییر دوربین پس از شروع ضبط
                cameraSwitchBtn.style.display = 'none';

            } catch (error) {
                console.error('خطا در دسترسی به دستگاه‌های مدیا یا شروع ضبط.', error);
            }
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                elapsedTime++;
                const hours = String(Math.floor(elapsedTime / 3600)).padStart(2, '0');
                const minutes = String(Math.floor((elapsedTime % 3600) / 60)).padStart(2, '0');
                const seconds = String(elapsedTime % 60).padStart(2, '0');
                timerDisplay.textContent = `${hours}:${minutes}:${seconds}`;
            }, 1000);
        }

        function stopRecording() {
            if (!isRecording) return;

            isRecording = false;
            recordBtn.classList.remove('recording');
            recordBtn.classList.add('stopped');
            recordBtn.innerHTML = '<i class="fas fa-record-vinyl"></i>';

            clearInterval(timerInterval); // متوقف کردن تایمر

            recorder.stopRecording(async () => {
                const blob = recorder.getBlob();
                console.log('ضبط متوقف شد. ارسال blob نهایی.');
                sendBlob(blob);
                recorder.destroy();
                recorder = null;

                try {
                    const response = await axios.get('/live-stream/stop-recording');
                    console.log('ضبط متوقف شد:', response.data.message);
                    window.location.href = '/home';
                } catch (error) {
                    console.error('خطا در توقف ضبط:', error.response ? error.response.data : error.message);
                }
            });
        }

        function toggleRecording() {
            if (isRecording) {
                stopRecording();
            } else {
                startRecording();
            }
        }

        async function switchCamera() {
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
            }

            currentCamera = currentCamera === 0 ? 1 : 0; // Toggle between 0 and 1

            try {
                mediaStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: currentCamera ? 'environment' : 'user' }, audio: true });
                preview.srcObject = mediaStream;

                if (isRecording) {
                    recorder.stream = mediaStream; // Update the stream for the recorder
                }
            } catch (error) {
                console.error('خطا در تغییر دوربین:', error);
            }
        }

        window.addEventListener('beforeunload', async (event) => {
            try {
                await axios.get('/live-stream/stop-recording');
            } catch (error) {
                console.error('خطا در توقف ضبط:', error.response ? error.response.data : error.message);
            }
        });

        initialize();
    });
</script>

</body>
@endsection
