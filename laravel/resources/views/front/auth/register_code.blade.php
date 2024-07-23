@extends('front.auth.layout')
@section('page_title','ثبت نام')
@section('content')
<div class="login-page">
    <div class="logo">
        <img src="{{asset('/img/logo.png')}}" width="150" alt="logo">
    </div>
    <form class="login-form">
        <div class="code last-input">
            <label for="code"> رمز یکبار مصرف ارسال شده به : <b>{{$mobile}}</b></label>
            <input type="password" id="code" name="code">
            <input type="hidden" id="mobile" name="mobile" value="{{$mobile}}">
            <input type="hidden" id="username" name="username" value="{{$username}}">
        </div>

        <div id="custom_alert" class="alert alert-danger" style="font-size: 14px;display: none;">
            {{ $errors->first('code') }}
        </div>

        <button class="submit" type="button" id="check_reg_code">ورود</button>
    </form>
</div>
@endsection
