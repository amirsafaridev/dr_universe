<?php
$liveStreams = App\Models\LiveStream::where('status', 'live')->get();

$user = auth()->user();

// دریافت کاربران فالو شده
$followedUsers = $user->followings()->pluck('followed_id');

$userIds = $followedUsers->push($user->id);

// دریافت استوری‌های مربوط به کاربران فالو شده
$stories = App\Models\Story::where('expired_at', '>', now())
    ->whereIn('user_id', $userIds) // فقط استوری‌های فالو شده‌ها را دریافت می‌کند
    ->orderBy('user_id')
    ->get()
    ->groupBy('user_id');

?>


<style>
    .home-container {
        margin-top: 0px !important;
    }

    .story-main {
        margin-bottom: 30px !important;
            overflow-x: scroll;
    }

    .story-container-main-sec1, .content {
        height: 130px;
        position: relative;
        padding: 10px !important;
        padding-bottom: 40px !important;
    }

    .story-container-main-sec2 {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: visible !important;
    }

    .mainimg img {
        padding: 0;
        width: 80px; /* عرض تصویر برابر با عرض والد */
        height: 80px; /* ارتفاع تصویر برابر با ارتفاع والد */
        border: 2px solid green; /* حاشیه قرمز */
        box-sizing: border-box; /* شامل حاشیه در ابعاد عنصر */
    }

    .story-img-main img {
        width: 80px; /* عرض تصویر برابر با عرض والد */
        height: 80px; /* ارتفاع تصویر برابر با ارتفاع والد */
        border: 2px solid red; /* حاشیه قرمز */
        box-sizing: border-box; /* شامل حاشیه در ابعاد عنصر */
        object-fit: cover;
    }

    .add-icon-main, .live-text {
        position: absolute;
        top: 5px;
        left: 5px;
        color: white;
        padding: 2px 5px;
        font-size: 12px;
        z-index: 2;
        border-radius: 3px;
    }

    .live-text
    {
        position: absolute;
        top: 5px;
        left: 5px;
        color: white;
        padding: 2px 5px;
        font-size: 12px;
        z-index: 2;
        border-radius: 3px;
    }

    .add-icon-main1 {
        position: absolute;
        top: 5px;
        left: -5px;
        color: white;
        padding: 2px 5px;
        font-size: 12px;
        z-index: 2;
        border-radius: 3px;
    }

    .add-icon-main1 img {
        width: 50px;
        height: 50px;
        background: none;
        padding: 0;
        border: none;
    }

    .title-main-img, .story-title-main {
        text-align: center;
        margin-top: 5px;
    }
    .story-title-main span
    {
        white-space: nowrap;
    }


    .live {
        background: red;
    }

    .story-link-main a {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        text-indent: -9999px;
    }

    .story-img-main {
        position: relative; /* اضافه شده برای تنظیم موقعیت .live-text */
        justify-content: center;
        display: flex;
    }

    .mainimg img
    {
        width: 80px;
        border-radius: 50%;
        opacity: 1;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        height: 80px;
    }
</style>

<div class="story-main">

            @if(isAdmin())


                <div class="story-container-main-sec1" onclick="window.location.href='/video-recorder'">
                    <div class="mainimg">
                        <img src="{{url('storage/profiles/'.$currentUser->profile)}}" alt="">
                    </div>
                    <div class="add-icon-main1">
                        <img src="{{ url('svg/Group 8.png') }}" alt="">
                    </div>
                    <div class="title-main-img">
                        <span>your live</span>
                    </div>
                </div>

            @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/@interactjs/interactjs@1.10.11/dist/interact.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>--}}

<div id="edit-popup" class="popup" style="display:none;">
    <div class="popup-content">
        <span id="close-edit-popup" class="close" style="z-index: 9999999;font-size: 40px">&times;</span>
        <div class="edit-container">
            <!-- Input برای انتخاب فایل -->
            <label for="fileInput" id="fileInputLabel"><img style="height: auto !important;" class="upload-img"  src="./svg/upload.png" alt=""></label>
            <input type="file" id="fileInput" accept="image/*, video/*">

            <!-- Container برای تصویر و ابزارها -->
            <div id="image-tools-container" style="display: none;">
                <div class="image-container">
                    <img id="preview-image" src="" alt="Preview Image" style="transition: transform 0.3s ease;">
                    <video id="preview-video" style="display: none; width: 100%;" autoplay loop></video>
                    <div class="tools">
                        <button id="rotate-image" title="Rotate">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button id="flip-horizontal" title="Flip Horizontal">
                            <i class="fas fa-arrows-alt-h"></i>
                        </button>
                        <button id="flip-vertical" title="Flip Vertical">
                            <i class="fas fa-arrows-alt-v"></i>
                        </button>
                        <button id="add-text-button" title="Add Text">
                            <i class="fas fa-font"></i>
                        </button>
                        <div class="filter-select-container">
                            <button id="filter-select-button" title="Select Filter">
                                <i class="fas fa-filter"></i>
                            </button>
                            <div id="filter-options" class="filter-options">
                                <div data-value="none" class="filter-option">None</div>
                                <div data-value="grayscale" class="filter-option">Grayscale</div>
                                <div data-value="sepia" class="filter-option">Sepia</div>
                                <div data-value="invert" class="filter-option">Invert</div>
                                <div data-value="blur" class="filter-option">Blur</div>
                                <div data-value="brightness" class="filter-option">Brightness</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- دکمه آپلود جدید در پایین پاپ آپ -->
            <div class="upload-container">
                <button id="upload-edited-image" class="upload-btn" title="Upload Edited Image">
                    <i class="fas fa-upload"></i>
                </button>
            </div>
        </div>
    </div>
</div>


    <style>
    .upload-container {
    display: none;
    max-width: 100vh;
    margin-top: 20px;
    margin-bottom: 20px;
    position: absolute;
    bottom: 0;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.upload-btn {
    width: 50px;
    height: 50px;
    justify-content: center;
    align-items: center;
    display: flex;
    border-radius: 50% !important;
    padding: 40px;
    background-color: #000;
    color: white;
    border: none;
    font-size: 1.2em;
    cursor: pointer;
}



.upload-btn i
{
font-size: 25px;
}


.upload-btn:hover {
    background-color: #45a049;
}

        .editable-text {
            position: absolute;
            color: white;
            font-size: 20px;
            font-weight: bold;
            cursor: move;
            padding: 5px;
            border: 1px dashed #ccc;
            background-color: rgba(0, 0, 0, 0.5);
            user-select: none; /* جلوگیری از انتخاب ناخواسته متن هنگام درگ کردن */
        }


        .filter-select-container {
            position: relative;
            display: inline-block;
        }

        #filter-select-button {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
        }

        .filter-options {
            display: none; /* به طور پیش‌فرض بسته است */
            padding: 20px 0;
            position: absolute;
            background: rgb(0 0 0 / 50%);
            border-radius: 20px;
            bottom: -190%;
            left: 102%;
            border: none;
            z-index: 1000;
            min-width: 150px;
        }

        .filter-option {
            padding: 10px;
            cursor: pointer;
        }

        .filter-option:hover {
            background: #f0f0f0;
        }


        .tools button {
            color: #fff;
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            margin: 0 5px;
        }

        .tools button:hover {
            color: #007bff; /* رنگ دلخواه هنگام هاور */
        }

        #fileInput {
            display: none; /* مخفی کردن ورودی فایل */
        }
        .arta-fileInput {
            cursor: pointer; /* تغییر نشانگر موس به دست برای نشان دادن اینکه لیبل قابل کلیک است */
            color: #00bfff;
            padding: 100px 200px;
            font-size: 30px;
            border: 20px solid #00bfff;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;

        }

        .image-container {
            /*width: 1080px;*/
            height: 1920px;
            max-width: 100%;
            max-height: 100vh;
            position: relative;
            overflow: hidden; /* جلوگیری از نمایش قسمت‌های اضافی تصویر */
            background-color: #fff; /* پس‌زمینه سیاه برای نمایش لبه‌های خالی */
        }

        .image-container img {
            width: 100%;
            height: 100%;
            /*object-fit: contain; !* حفظ تناسب تصویر و عدم کشیدگی *!*/
            transition: transform 0.3s ease;
            object-position: center center;
            object-fit: scale-down;
        }

        .tools {
            margin-top: 20px;
            justify-content:center;
        }

        .tools button {
            margin: 5px;
            padding: 10px;
            cursor: pointer;
        }

        /*.upload-btn {*/
        /*    margin-top: 20px;*/
        /*    padding: 30px;*/
        /*    cursor: pointer;*/
        /*    background-color: #4CAF50;*/
        /*    color: white;*/
        /*    border: none;*/
        /*    border-radius: 5px;*/
        /*}*/

        /* پاپ‌آپ */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* محتوای پاپ‌آپ */
        .popup-content {
            background: white;
            border-radius: 8px;
            padding: 0px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Container برای تصویر و ابزارها */
        .edit-container {
            /*width: 90%;*/
            /*height: 100dvh;*/
            display: flex;
            margin: auto;
            flex-direction: row; /* تغییر جهت از افقی به عمودی برای قراردادن ابزارها زیر تصویر */
            align-items: center; /* مرکز کردن تصویر و ابزارها */
        }

        /* استایل برای ابزارها */
        .image-container {
            position: relative;
            margin-bottom: 20px; /* فاصله بین تصویر و ابزارها */
        }

        .tools {
            border-radius: 20px;
            padding: 20px 0px;
            position: absolute;
            top: 16rem;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 10;
            color: #fff;
            background: rgba(0, 0, 0, 50%);
        }

        .tools button {
            margin-top: 10px;
        }




    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('fileInput');
            const previewImage = document.getElementById('preview-image');
            const previewVideo = document.getElementById('preview-video');
            const rotateButton = document.getElementById('rotate-image');
            const flipHorizontalButton = document.getElementById('flip-horizontal');
            const flipVerticalButton = document.getElementById('flip-vertical');
            const filterSelectButton = document.getElementById('filter-select-button');
            const filterOptions = document.getElementById('filter-options');
            const filterOptionElements = filterOptions.getElementsByClassName('filter-option');
            const uploadButton = document.getElementById('upload-edited-image');
            const popup = document.getElementById('edit-popup');
            const closePopup = document.getElementById('close-edit-popup');
            const storyContainer = document.getElementById('story-container-main-sec1');
            const addTextButton = document.getElementById('add-text-button');
            const imageContainer = document.querySelector('.image-container');

            let rotation = 0; // زاویه چرخش اولیه
            let scaleX = 1; // مقیاس برای چرخش افقی
            let scaleY = 1; // مقیاس برای چرخش عمودی

            // نمایش پاپ‌آپ
            storyContainer.addEventListener('click', function () {
                popup.style.display = 'block';
            });

            // بستن پاپ‌آپ و بازنشانی ورودی فایل
            closePopup.addEventListener('click', function () {
                popup.style.display = 'none';

                // بازنشانی مقدار ورودی فایل
                fileInput.value = '';

                // مخفی کردن تصویر پیش‌نمایش و ویدیو
                previewImage.src = '';
                previewImage.style.display = 'none';
                previewVideo.src = '';
                previewVideo.style.display = 'none';

                // نمایش دوباره لیبل انتخاب تصویر
                document.getElementById('fileInputLabel').style.display = 'inline-block';

                document.getElementById('upload-edited-image').style.display = 'none';
            });

            // نمایش تصویر یا ویدیو و مخفی کردن لیبل انتخاب تصویر
     fileInput.addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        const fileType = file.type;

        reader.onload = function (e) {
            if (fileType.startsWith('image/')) {
                // Display image preview
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                previewVideo.style.display = 'none';

                // Show all tools for image editing
                document.querySelectorAll('.tools button').forEach(button => {
                    button.style.display = 'inline-block';
                });
            } else if (fileType.startsWith('video/')) {
                // Display video preview
                previewVideo.src = e.target.result;
                previewVideo.style.display = 'block';
                previewImage.style.display = 'none';

                // Hide all tools except the upload button
                document.querySelectorAll('.tools button').forEach(button => {
                    if (button.id === 'upload-edited-image') {
                        button.style.display = 'inline-block';
                    } else {
                        button.style.display = 'none';
                    }
                });
            }

            document.querySelector('.upload-container').style.display = 'flex';
            document.getElementById('image-tools-container').style.display = 'flex';
            document.getElementById('fileInputLabel').style.display = 'none';
        };

        reader.readAsDataURL(file);
    }
});


            // چرخش تصویر
            rotateButton.addEventListener('click', function () {
                rotation += 180;
                previewImage.style.transform = `rotate(${rotation}deg) scaleX(${scaleX}) scaleY(${scaleY})`;
            });

            // چرخش افقی تصویر
            flipHorizontalButton.addEventListener('click', function () {
                scaleX = scaleX === 1 ? -1 : 1;
                previewImage.style.transform = `rotate(${rotation}deg) scaleX(${scaleX}) scaleY(${scaleY})`;
            });

            // چرخش عمودی تصویر
            flipVerticalButton.addEventListener('click', function () {
                scaleY = scaleY === 1 ? -1 : 1;
                previewImage.style.transform = `rotate(${rotation}deg) scaleX(${scaleX}) scaleY(${scaleY})`;
            });

            // نمایش و پنهان‌سازی منو فیلتر
            filterSelectButton.addEventListener('click', function (event) {
                event.stopPropagation(); // جلوگیری از بروز مشکل با کلیک درون دکمه
                filterOptions.style.display = filterOptions.style.display === 'none' || filterOptions.style.display === '' ? 'block' : 'none';
            });

            // انتخاب فیلتر و بستن منو
            Array.from(filterOptionElements).forEach(option => {
                option.addEventListener('click', function () {
                    const selectedFilter = this.getAttribute('data-value');
                    switch (selectedFilter) {
                        case 'grayscale':
                            previewImage.style.filter = 'grayscale(100%)';
                            break;
                        case 'sepia':
                            previewImage.style.filter = 'sepia(100%)';
                            break;
                        case 'invert':
                            previewImage.style.filter = 'invert(100%)';
                            break;
                        case 'blur':
                            previewImage.style.filter = 'blur(5px)';
                            break;
                        case 'brightness':
                            previewImage.style.filter = 'brightness(1.5)';
                            break;
                        default:
                            previewImage.style.filter = 'none';
                            break;
                    }
                    filterOptions.style.display = 'none'; // بستن منو بعد از انتخاب
                });
            });

            // بستن منو فیلتر اگر در جایی خارج از آن کلیک شد
            document.addEventListener('click', function (event) {
                if (!filterSelectButton.contains(event.target) && !filterOptions.contains(event.target)) {
                    filterOptions.style.display = 'none';
                }
            });

            // اضافه کردن متن به تصویر
            addTextButton.addEventListener('click', function () {
                const editableText = document.createElement('div');
                editableText.classList.add('editable-text');
                editableText.setAttribute('contenteditable', 'true');
                editableText.innerText = 'متن خود را اینجا وارد کنید';
                editableText.style.fontSize = '20px'; // اندازه متن در HTML
                editableText.style.fontFamily = 'Arial'; // فونت متن در HTML
                editableText.style.position = 'absolute'; // ضروری برای موقعیت‌یابی
                editableText.style.color = 'black'; // رنگ متن پیش‌فرض
                editableText.style.backgroundColor = 'rgba(255, 255, 255, 0.5)'; // پس‌زمینه شفاف برای بهتر دیده شدن
                editableText.style.padding = '5px'; // فاصله داخلی

                // ایجاد دکمه حذف
                const removeButton = document.createElement('button');
                removeButton.innerText = '×';
                removeButton.classList.add('remove-text-button');
                removeButton.style.position = 'absolute';
                removeButton.style.top = '-10px';
                removeButton.style.right = '-10px';
                removeButton.style.backgroundColor = 'red';
                removeButton.style.color = 'white';
                removeButton.style.border = 'none';
                removeButton.style.borderRadius = '50%';
                removeButton.style.width = '20px';
                removeButton.style.height = '20px';
                removeButton.style.textAlign = 'center';
                removeButton.style.cursor = 'pointer';
                removeButton.style.display = 'flex';
                removeButton.style.justifyContent= 'center';
                removeButton.style.alignItems= 'center';

                // افزودن دکمه حذف به باکس متنی
                editableText.appendChild(removeButton);

                // اضافه کردن باکس متنی به کانتینر تصویر
                imageContainer.appendChild(editableText);

                // تنظیم مکان اولیه متن در مرکز تصویر
                editableText.style.top = '50%';
                editableText.style.left = '50%';
                editableText.style.transform = 'translate(-50%, -50%)';

                // فعال‌سازی قابلیت درگ کردن برای متن
                interact(editableText).draggable({
                    onmove: function (event) {
                        const target = event.target;
                        const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                        const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                        target.style.transform = `translate(${x}px, ${y}px)`;

                        target.setAttribute('data-x', x);
                        target.setAttribute('data-y', y);
                    }
                });

                // حذف باکس متن با کلیک بر روی دکمه حذف
                removeButton.addEventListener('click', function () {
                    imageContainer.removeChild(editableText);
                });
            });

            // آپلود تصویر
            uploadButton.addEventListener('click', function () {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');

                const canvasWidth = 1080;
                const canvasHeight = 1920;

                canvas.width = canvasWidth;
                canvas.height = canvasHeight;

                context.fillStyle = 'black';
                context.fillRect(0, 0, canvas.width, canvas.height);

                if (previewImage.style.display === 'block') {
                    const img = new Image();
                    img.src = previewImage.src;

                    img.onload = function() {
                        const imgWidth = img.naturalWidth;
                        const imgHeight = img.naturalHeight;
                        const imgAspectRatio = imgWidth / imgHeight;
                        const canvasAspectRatio = canvasWidth / canvasHeight;

                        let drawWidth, drawHeight;
                        if (imgAspectRatio > canvasAspectRatio) {
                            drawWidth = canvasWidth;
                            drawHeight = canvasWidth / imgAspectRatio;
                        } else {
                            drawHeight = canvasHeight;
                            drawWidth = canvasHeight * imgAspectRatio;
                        }

                        const xOffset = (canvasWidth - drawWidth) / 2;
                        const yOffset = (canvasHeight - drawHeight) / 2;

                        context.filter = previewImage.style.filter;
                        context.translate(canvas.width / 2, canvas.height / 2);
                        context.rotate(rotation * Math.PI / 180);
                        context.scale(scaleX, scaleY);
                        context.drawImage(img, -drawWidth / 2, -drawHeight / 2, drawWidth, drawHeight);

                        context.setTransform(1, 0, 0, 1, 0, 0);

                        const editableTexts = document.querySelectorAll('.editable-text');
                        editableTexts.forEach(editableText => {
                            const rect = editableText.getBoundingClientRect();
                            const containerRect = imageContainer.getBoundingClientRect();

                            const x = (rect.left - containerRect.left) * (canvas.width / imageContainer.clientWidth);
                            const y = (rect.top - containerRect.top) * (canvas.height / imageContainer.clientHeight);

                            const computedFontSize = window.getComputedStyle(editableText).fontSize;
                            const fontSize = parseInt(computedFontSize) * (canvas.height / imageContainer.clientHeight);
                            const fontFamily = window.getComputedStyle(editableText).fontFamily;
                            const fontColor = window.getComputedStyle(editableText).color;

                            context.font = `${fontSize}px ${fontFamily}`;
                            context.fillStyle = fontColor;
                            const textWithoutRemoveIcon = editableText.innerText.replace('×', '');

                            context.fillText(textWithoutRemoveIcon, x, y + fontSize);
                        });

                        canvas.toBlob(function (blob) {
                            const formData = new FormData();
                            formData.append('file', blob, 'edited-image.png');
                            formData.append('type', 'image');

                            fetch('{{ route("stories.store") }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                }
                            }).then(response => {
                                if (response.ok) {
                                    window.location.reload();
                                } else {
                                    alert('Error uploading image.');
                                }
                            }).catch(error => {
                                console.error('Error:', error);
                                alert('Error uploading image.');
                            });
                        }, 'image/png');
                    };
                } else if (previewVideo.style.display === 'block') {
                    const videoFile = fileInput.files[0];
                    const formData = new FormData();
                    formData.append('file', videoFile, videoFile.name);
                    formData.append('type', 'video');

                    fetch('{{ route("stories.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    }).then(response => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            alert('Error uploading video.');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Error uploading video.');
                    });
                }
            });




        });
    </script>


    <div id="story-container-main-sec1" class="story-container-main-sec1">
        <div class="mainimg">
            <img src="{{ url('storage/profiles/'.$currentUser->profile) }}" alt="">
        </div>
        <div class="add-icon-main1">
            <img src="{{ url('svg/Group 8.png') }}" alt="">
        </div>
        <div class="title-main-img">
            <span>your story</span>
        </div>
    </div>

    <div class="story-container-main-sec2" dir="ltr">
        <!-- نمایش استوری‌های لایو -->

        <div id="story-popup" class="popup" style="display:none;">
            <div class="popup-content">
                <div class="header-test">
                    <a href="" id="user-profile-link" style="z-index: 999999;">
                        <img style="object-fit: cover" id="popup-user-image" src="" alt="User Image" class="user-profile">
                        <span id="popup-user-name" class="user-name" style="color:#fff;"></span>
                    </a>
                </div>
                <span id="close-popup" class="close" style="z-index: 9999999;color: #fff">&times;</span>
                <button id="prev-story" class="nav-btn">قبلی</button>
                <button id="next-story" class="nav-btn">بعدی</button>
                <div id="progress-bar" class="progress-bar">
                    <div id="progress-bar-fill" class="progress-bar-fill"></div>
                </div>


                <div id="story-views" class="story-views">
                        <i class="fa fa-eye" style="margin: 2px; margin-right: 10px"></i> <!-- آیکون چشم -->
                        <span id="view-count">0</span> <!-- تعداد ویوها -->
                    </div>

                <img id="popup-image" src="" alt="Story Image" style="object-fit: contain;height: 100dvh !important;">
                <video id="popup-video" autoplay loop style="background:black;display:none;object-fit: contain;height: 100dvh !important;">
                    <source id="popup-video-source" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>


        <style>
            .vertical-line {
                position: fixed;
                top:2px;
                width: 2px; /* عرض خط عمودی */
                height: 5px; /* ارتفاع خط عمودی */
                background-color: gray;
            }

            .story-views
            {
                color: #fff;
                display: none;
                position: absolute;
                bottom: 0;
                padding: 20px;
                left: 0;
                font-size: 20px;
            }

            .header-test
            {
                margin-top: 10px;
                left: 0;
                position: absolute;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 20px;
            }
            .header-test img
            {
                width: 30px !important;
                height: 30px !important;
                border-radius: 30px;
                margin-right: 10px;
            }
            .popup {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }

            .popup-content {
                background-color: black;
                padding: 20px;
                border-radius: 5px;
                position: relative;
                text-align: center;
            }

            .popup img, .popup video {
                width: 100%;
                /*height: 100%;*/
                max-width: 100%;
                max-height: 100vh;
            }

            .close {
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 30px;
                font-weight: bold;
                cursor: pointer;
            }

            .progress-bar {
                position: absolute;
                top: 0;
                left: 0;
                width: 99%;
                height: 5px;
                background: #cacaca !important;
                border-radius: 20px;
                margin: 2px;
            }

            .progress-bar-fill {
                height: 100%;
                width: 0;
                background-color: #fff; /* رنگ نوار پیشرفت */
                transition: wi  dth 0.1s linear;
            }

            .nav-btn {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background-color: #f1f1f1;
                border: none;
                padding: 10px;
                cursor: pointer;
                z-index: 1000;
            }

            #prev-story {
                left: 10px;
                padding: 200px 30px;
                background: none;
                color: #ff000000;
            }

            #next-story {
                right: 10px;
                padding: 200px 30px;
                background: none;
                color: #ff000000;
            }

            .story-img-main img.viewed {
                border: 2px solid gray; /* تغییر رنگ حاشیه به خاکستری */
            }

        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const currentUserId = {{ auth()->id() }}; // ID کاربر جاری (این را از Blade به JavaScript منتقل کنید)
                let userId;

                const popup = document.getElementById('story-popup');
                const popupImage = document.getElementById('popup-image');
                const popupVideo = document.getElementById('popup-video');
                const popupVideoSource = document.getElementById('popup-video-source');
                const closeBtn = document.getElementById('close-popup');
                const prevBtn = document.getElementById('prev-story');
                const nextBtn = document.getElementById('next-story');
                const progressBar = document.getElementById('progress-bar');
                const progressBarFill = document.getElementById('progress-bar-fill');

                let currentStoryIndex = 0;
                let storyTimeout;
                let progressBarInterval;
                let stories = [];
                let currentUserIndex = 0;
                const storyDuration = 30000; // مدت زمان نمایش هر استوری (۳۰ ثانیه)

                const userStoryElements = document.querySelectorAll('.story-img-main a');

                function createVerticalLines(totalStories) {
                    // حذف خطوط عمودی قبلی
                    const existingLines = document.querySelectorAll('.vertical-line');
                    existingLines.forEach(line => line.remove());

                    // تنها در صورتی که تعداد استوری‌ها بیشتر از یک باشد، خطوط عمودی ایجاد شوند
                    if (totalStories > 1) {
                        for (let i = 0; i < totalStories - 1; i++) { // تغییر این خط
                            const line = document.createElement('div');
                            line.className = 'vertical-line';
                            line.style.left = `${(i + 1) * (100 / totalStories)}%`; // تنظیم موقعیت خط
                            progressBar.appendChild(line);
                        }
                    }
                }

                // بررسی تعداد استوری‌ها برای هر کاربر و ایجاد خطوط عمودی پیش‌فرض
                if (userStoryElements.length > 0) {
                    const firstUserStories = JSON.parse(userStoryElements[0].getAttribute('data-stories'));
                    createVerticalLines(firstUserStories.length);
                }

                userStoryElements.forEach(function(anchor, index) {
                    anchor.addEventListener('click', function(event) {
                        event.preventDefault();
                        const stories = JSON.parse(anchor.getAttribute('data-stories'));
                        createVerticalLines(stories.length); // ایجاد خطوط جدید بر اساس تعداد استوری‌های هر کاربر
                    });
                });


                function resetProgressBar() {
                    clearInterval(progressBarInterval);
                    progressBarFill.style.width = '0%';
                    progressBar.style.display = 'none';
                }

                function startProgressBar() {
                    let progress = (currentStoryIndex * (100 / stories.length)); // پیشرفت شروع بر اساس اندیس فعلی استوری
                    progressBarFill.style.width = `${progress}%`;
                    progressBar.style.display = 'block';

                    const progressPerStory = 100 / stories.length; // درصد نوار پیشرفت برای هر استوری

                    progressBarInterval = setInterval(function() {
                        progress += (progressPerStory / (storyDuration / 100)); // افزایش درصد بر اساس مدت زمان استوری
                        progressBarFill.style.width = `${Math.min(progress, 100)}%`;

                        if (progress >= (currentStoryIndex + 1) * progressPerStory) {
                            clearInterval(progressBarInterval);
                            setTimeout(function() {
                                currentStoryIndex++;
                                showStory(currentStoryIndex);
                            }, 500);
                        }
                    }, 100);
                }

                function showStory(index) {
                    document.querySelectorAll('video').forEach(video => {
                        video.pause();
                    });

                    if (index >= stories.length) {
                        currentUserIndex++;
                        if (currentUserIndex < userStoryElements.length) {
                            loadNextUserStories();
                        } else {
                            resetProgressBar();
                            popup.style.display = 'none';
                        }
                        return;
                    }

                    const story = stories[index];
                    const href = story.file_path;
                    const storyId = story.id;
                    userId = story.user_id;
                    const storyViewsElement = document.getElementById('story-views');

                    const userName = userStoryElements[currentUserIndex].getAttribute('data-user-name');
                    const userImage = userStoryElements[currentUserIndex].getAttribute('data-user-image');
                    const userUsernameWithBlueTick = userStoryElements[currentUserIndex].getAttribute('data-user-username-with-blue-tick'); // تغییر این خط
                    document.getElementById('popup-user-name').innerHTML = userUsernameWithBlueTick;

                    // document.getElementById('popup-user-name').textContent = userName;
                    document.getElementById('popup-user-image').src = '/storage/profiles/' + userImage;
                    document.getElementById('user-profile-link').href = `/profile/${userName}`;
                    if (userId === currentUserId) { // فرض کنید currentUserId شناسه کاربر جاری است
                        storyViewsElement.style.display = 'flex'; // نمایش تعداد ویو
                        document.getElementById('view-count').textContent = `${story.views}`;
                    }else{
                        storyViewsElement.style.display = 'none'; // مخفی کردن تعداد ویو برای سایر کاربران

                        fetch(`/stories/${storyId}/view`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                    }



                    if (href.endsWith('.mp4')) {
                        popupImage.style.display = 'none';
                        popupVideo.style.display = 'block';
                        popupVideoSource.src = '/storage/' + href;
                        popupVideo.load();
                        popupVideo.play();

                        resetProgressBar();
                        startProgressBar();
                    } else {
                        popupVideo.style.display = 'none';
                        popupImage.style.display = 'block';
                        popupImage.src = '/storage/' + href;
                        resetProgressBar();
                        startProgressBar();
                    }

                    createVerticalLines(stories.length);
                    popup.style.display = 'flex';
                }

                function loadNextUserStories() {
                    const nextUser = userStoryElements[currentUserIndex];
                    stories = JSON.parse(nextUser.getAttribute('data-stories'));
                    currentStoryIndex = 0;
                    showStory(currentStoryIndex);
                }



                function showNextStory() {
                    clearTimeout(storyTimeout);
                    clearInterval(progressBarInterval);
                    if (currentStoryIndex < stories.length - 1) {
                        currentStoryIndex++;
                        showStory(currentStoryIndex);
                    } else {
                        currentUserIndex++;
                        if (currentUserIndex < userStoryElements.length) {
                            loadNextUserStories();
                        } else {
                            resetProgressBar();
                            popup.style.display = 'none';
                        }
                    }
                }

                function showPrevStory() {
                    clearTimeout(storyTimeout);
                    clearInterval(progressBarInterval);
                    if (currentStoryIndex > 0) {
                        currentStoryIndex--;
                        showStory(currentStoryIndex);
                    } else if (currentUserIndex > 0) {
                        currentUserIndex--;
                        loadNextUserStories();
                    } else {
                        resetProgressBar();
                        popup.style.display = 'none';
                    }
                }

                userStoryElements.forEach(function(anchor, index) {
                    anchor.addEventListener('click', function(event) {
                        event.preventDefault();
                        stories = JSON.parse(anchor.getAttribute('data-stories'));
                        currentStoryIndex = 0;
                        currentUserIndex = index;
                        showStory(currentStoryIndex);
                    });
                });

                closeBtn.addEventListener('click', function() {
                    clearTimeout(storyTimeout);
                    resetProgressBar();
                    popup.style.display = 'none';
                    popupVideo.pause();
                });

                prevBtn.addEventListener('click', function() {
                    showPrevStory();
                });

                nextBtn.addEventListener('click', function() {
                    showNextStory();
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const viewedStories = JSON.parse(localStorage.getItem('viewedStories')) || [];

                const updateStoryBorder = () => {
                    document.querySelectorAll('.story-image').forEach(img => {
                        const storyId = img.parentElement.dataset.id;
                        if (viewedStories.includes(storyId)) {
                            img.classList.add('viewed');
                        }
                    });
                };

                const markStoryAsViewed = (storyId) => {
                    if (!viewedStories.includes(storyId)) {
                        viewedStories.push(storyId);
                        localStorage.setItem('viewedStories', JSON.stringify(viewedStories));
                    }
                };

                document.querySelectorAll('.story-img-main a').forEach(link => {
                    link.addEventListener('click', (event) => {
                        const storyId = event.currentTarget.dataset.id;
                        markStoryAsViewed(storyId);
                        updateStoryBorder();
                    });
                });

                updateStoryBorder();
            });

        </script>


        <!-- نمایش استوری‌ها -->

        @foreach($liveStreams as $liveStream)
{{--                <?php $url = $liveStream->checkStreamUrl() ?>--}}

            <div class="content">
                <div class="story-img-main">
{{--                    <a href="{{ $url }}">--}}
                    <a href="{{ route('live.stream', ['id' => $liveStream->id]) }}">

                    <img src="/storage/profiles/{{ $liveStream->user->profile }}" alt="">
                    </a>
                    <div class="live-text live">LIVE</div>
                </div>
                <div class="story-title-main">
                    <span>
                        {!! $liveStream->user->username_with_blue_tick !!}
                    </span>
                </div>
            </div>
        @endforeach

        @foreach($stories as $userId => $userStories)
            <?php
                $user = \App\Models\User::find($userId);

                ?>
            <div class="content">
                <div class="story-img-main">
                    <a href="javascript:void(0);"
                       data-stories="{{ json_encode($userStories) }}"
                       data-id="{{ $userStories->first()->id }}"
                        data-user-name="{{ $user->username }}"
                       data-user-username-with-blue-tick="{{ $user->getUsernameWithBlueTickAttribute() }}"

                    data-user-image="{{ $user->profile }}">

                        <img src="/storage/profiles/{{ $userStories->first()->user->profile }}"
                             alt="Story Image"
                             class="story-image">
                    </a>
{{--                    @if($userStories->first()->type == 'video')--}}
{{--                        <div class="live-text">VIDEO</div>--}}
{{--                    @endif--}}
                </div>
                <div class="story-title-main">
                    <span>{!! $userStories->first()->user->username_with_blue_tick !!}</span>

                </div>
            </div>
        @endforeach




    </div>
    <!-- Hidden file input field -->
    <form id="uploadForm" action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{--            <input type="file" id="fileInput" name="file" accept="image/*,video/*" style="display: none;">--}}
        <input type="hidden" name="type" id="fileType">
    </form>

</div>






