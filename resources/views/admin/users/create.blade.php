@extends('admin.layouts.layout')

@section('title', 'ایجاد کاربر جدید')

@section('content')
    <div class="container">
        <h2>ایجاد کاربر جدید</h2>

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

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">نام:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="mobile">موبایل:</label>
                <input type="text" id="mobile" name="mobile" class="form-control" value="{{ old('mobile') }}">
            </div>

            <div class="form-group">
                <label for="role">نقش:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="admin">مدیر</option>
                    <option value="user" selected>کاربر</option>
                </select>
            </div>

            <div class="form-group">
                <label for="account_type">نوع اکانت:</label>
                <select id="account_type" name="account_type" class="form-control" required>
                    <option value="public">عمومی</option>
                    <option value="private">خصوصی</option>
                </select>
            </div>

            <div class="form-group">
                <label for="blue_tick">تیک آبی:</label>
                <input type="checkbox" id="blue_tick" name="blue_tick" class="form-check-input" {{ old('blue_tick') ? 'checked' : '' }}>
            </div>

            <button type="submit" class="btn btn-primary">ایجاد کاربر</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
@endsection
