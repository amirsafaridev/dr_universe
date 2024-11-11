@extends('front.site.layout')
@section('page_title','خانه')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="container" style="padding: 0">
{{--        <h2 style="text-align: left">Your Conversations</h2>--}}



        <!-- لیست گفتگوها -->
        <ul class="list-group" style="text-align: left">
            @foreach ($conversations as $conversation)
                <li class="list-group-item">
                    @php
                        // تعیین کاربر مقابل در گفتگو
                        $user = $conversation->userOne->id === auth()->id() ? $conversation->userTwo : $conversation->userOne;
                        // بررسی وجود عکس پروفایل و ساخت مسیر صحیح
                        $profileImage = $user->profile ? url('storage/profiles/' . $user->profile) : asset('images/default-avatar.png');

                  $blueTickHtml = $user->blue_tick ? '<img style="width: 20px; height:20px;    margin: 3px;
    margin-bottom: 5px;; vertical-align: middle;" src="' . asset('img/duo-icons_approved-1.svg') . '">' : '';
                    @endphp
                    <a href="{{ route('conversations.show', $conversation->id) }}">
                        {!! $blueTickHtml !!}{{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->username : $conversation->userOne->username }}
                    </a>
                    <img src="{{ $profileImage }}" alt="User Avatar" style="object-fit: cover;width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">

                </li>
            @endforeach
        </ul>

        <!-- دکمه نمایش لیست کاربران -->
        <button style="position: fixed;
    right: 0;
    bottom: 100px;
    margin: 20px;
    width: 80px;
    height: 80px;
    border-radius: 80px;" type="button" class="btn btn-primary start-conversation-btn" data-bs-toggle="modal" data-bs-target="#userListModal">
            <i style="font-size: 20px" class="fas fa-user-plus"></i> <!-- آیکون انتخاب کاربر -->
        </button>
    </div>

    <!-- Modal لیست کاربران -->
    <div class="modal fade" id="userListModal" tabindex="-1" aria-labelledby="userListModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="userListModalLabel">یک کاربر را برای چت انتخاب کنید</h5>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
                <div class="modal-body">
                    <div class="search-container">
                        <input type="text" id="userSearch" class="form-control" placeholder="نام کاربر را جستجو کنید..." style="margin-bottom: 15px;">
                    </div>

                    <ul id="userList">
                        <!-- نتایج جستجو اینجا قرار خواهد گرفت -->
                        <li class="list-group-item">نام کاربری را وارد کنید تا جستجو شود.</li>
                    </ul>


                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('userSearch');

            searchInput.addEventListener('keyup', function () {
                const query = this.value.trim(); // حذف فاصله‌های اضافی
                console.log(query); // این خط را اضافه کنید تا مقدار وارد شده را مشاهده کنید


                // اگر فیلد جستجو خالی است، لیست را خالی کن
                if (query === '') {
                    document.getElementById('userList').innerHTML = '<li class="list-group-item">نام کاربری را وارد کنید تا جستجو شود.</li>';
                    return;
                }

                // ارسال درخواست AJAX برای جستجو
                fetch('/search-users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // توکن CSRF
                    },
                    body: JSON.stringify({
                        query: query
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        const userList = document.getElementById('userList');
                        userList.innerHTML = ''; // پاک کردن لیست قبلی

                        if (data.users.length > 0) {
                            data.users.forEach(user => {
                                const profileImage = user.profile ? `/storage/profiles/${user.profile}` : `/images/default-avatar.png`;

                                userList.innerHTML += `
    <li class="list-group-item d-flex align-items-center" style="direction: ltr; margin: 10px 0;">
        <img src="${profileImage}" alt="${user.username}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
        <a href="/conversations/user/${user.id}">${user.username}${user.blue_tick}</a>
    </li>
`;

                            });
                        } else {
                            userList.innerHTML = '<li class="list-group-item">هیچ کاربری یافت نشد</li>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

    </script>
@endsection
