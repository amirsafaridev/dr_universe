@extends('admin.layouts.layout')

@section('title', 'لیست کاربران')

@section('content')
    <div class="container">
        <h2>لیست کاربران</h2>

        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">ایجاد کاربر جدید</a>

        @if(session('success'))
            <div class="alert alert-success" style="margin-top: 10px">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>عکس پروفایل</th>
                <th>نام</th>
                <th>نام کاربری</th>
                <th>نقش</th>
                <th>موبایل</th>
                <th>ایمیل</th>
                <th>نوع اکانت</th>
                <th>تیک آبی</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $key => $user)
                <tr>
                    <td>{{ $users->firstItem() + $key }}</td> <!-- به جای $key + 1 -->
                    <td>
                        <img style="width: 30px;height: 30px;object-fit: cover;border-radius: 50%;" src="{{ url('storage/profiles/' . $user->profile) }}" alt="Profile Image" class="rounded-circle">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role == 'admin' ? 'مدیر' : 'کاربر' }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->account_type == 'private' ? 'خصوصی' : 'عمومی' }}</td>
                    <td>
                        @if($user->blue_tick)
                            <span>دارد</span>
                        @else
                            ندارد
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">ویرایش</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- نمایش لینک‌های صفحه‌بندی -->
        <div class="d-flex justify-content-center" style="text-align: center;">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>

    </div>
@endsection
