@extends('front.auth.layout')
@section('page_title','ثبت نام')
@section('content')
    <div class="login-page">
        <div class="logo">
            <img src="./svg/Group 2.png" alt="logo">
        </div>
        <form class="login-form" method="post" action="{{route('send_register_code')}}">
            @csrf
            <div class="username last-input">
                <label for="username">نام کاربری</label>
                <input type="text" id="username" name="username" value="{{old('username')}}">
            </div>
            <div class="fullname">
                <label for="mobile">شماره همراه</label>
                <input type="text" id="mobile" name="mobile" value="{{old('mobile')}}">
            </div>
            @if ($errors->any())
                <ul class="alert alert-danger" style="font-size: 14px;list-style-type: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <button class="submit" type="submit">ثبت نام</button>
        </form>
    </div>
@endsection
