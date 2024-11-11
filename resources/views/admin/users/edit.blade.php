@extends('admin.layouts.layout')

@section('title', 'ویرایش کاربر')

@section('content')
    <div class="container">
        <h2>ویرایش کاربر: {{ $user->name }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">نام:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
            </div>

            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="form-group">
                <label for="mobile">موبایل:</label>
                <input type="text" id="mobile" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
            </div>

            <div class="form-group">
                <label for="role">نقش:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>مدیر</option>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>کاربر</option>
                </select>
            </div>

            <div class="form-group">
                <label for="account_type">نوع اکانت:</label>
                <select id="account_type" name="account_type" class="form-control">
                    <option value="public" {{ old('account_type', $user->account_type) == 'public' ? 'selected' : '' }}>عمومی</option>
                    <option value="private" {{ old('account_type', $user->account_type) == 'private' ? 'selected' : '' }}>خصوصی</option>
                </select>
            </div>

            <div class="form-group">
                <label for="blue_tick">تیک آبی:</label>
                <input type="checkbox" id="blue_tick" name="blue_tick" {{ old('blue_tick', $user->blue_tick) ? 'checked' : '' }}>
            </div>

            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
@endsection
