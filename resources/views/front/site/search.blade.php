@extends('front.site.layout')
@section('page_title','جست و جو')

@section('content')
    <div class="search-container">
        <input type="text" id="userSearch" class="form-control" placeholder="نام کاربر را جستجو کنید..." style="margin-bottom: 15px;">
    </div>

    <ul id="userList" class="list-group">
        <li class="list-group-item">نام کاربری را وارد کنید تا جستجو شود.</li>
    </ul>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userSearchInput = document.getElementById('userSearch');

            userSearchInput.addEventListener('keyup', function () {
                const query = this.value.trim();

                if (query === '') {
                    document.getElementById('userList').innerHTML = '<li class="list-group-item">نام کاربری را وارد کنید تا جستجو شود.</li>';
                    return;
                }

                fetch('/search-users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ query: query })
                })
                    .then(response => response.json())
                    .then(data => {
                        const userList = document.getElementById('userList');
                        userList.innerHTML = '';

                        if (data.users.length > 0) {
                            data.users.forEach(user => {
                                const profileImage = user.profile ? `/storage/profiles/${user.profile}` : `/images/default-avatar.png`;

                                userList.innerHTML += `
    <li class="list-group-item d-flex align-items-center" style="direction: ltr;">
        <img src="${profileImage}"
             alt="${user.username}"
             class="rounded-circle"
             style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
        <a href="{{ route('profile_page', ['username' => '']) }}/${user.username}">
            ${user.username} ${user.blue_tick}  <!-- تیک آبی بعد از نام کاربر -->
        </a>
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




