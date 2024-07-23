@extends('front.auth.layout')
@section('page_title','ورود')
@section('content')
    <div class="login-page">
        <div class="logo">
            <img src="{{asset('/img/logo.png')}}" width="150" alt="logo">
        </div>
        <form class="login-form" method="post" action="{{route('send_login_code')}}">
            @csrf
            <div class="phone-nr last-input">
                <label for="phone">شماره همراه</label>
                <input type="tel" id="mobile" name="mobile" value="{{old('mobile')}}">
            </div>
            @if($errors->has('mobile'))
                <div class="alert alert-danger" style="font-size: 14px;">
                    {{ $errors->first('mobile') }}
                </div>
            @endif
            <div style="align-items: center;flex-direction: row;align-content: space-around;justify-content: space-between;">
            <button class="submit" type="submit" style="margin: unset;">ارسال کد</button>
            <a href="{{route('register_page')}}" style="color: black;">ساخت حساب کاربری</a>
            </div>
        </form>

    </div>
@endsection
