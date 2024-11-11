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
                <ul class="alert alert-danger" style="font-size: 14px; list-style-type: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div style="display: flex;flex-direction: row; align-items: center;margin-bottom: 10px;    white-space: nowrap;">
                <input type="checkbox" id="accept-terms" name="accept_terms" required style="margin-left: 5px;">
                <label for="accept-terms" style="margin: 0;padding-top: 5px;">
                    <a href="#" id="show-terms" style=" color: blue;">شرایط و قوانین</a> را خوانده و می پذیرم
                </label>
            </div>

            <button class="submit" type="submit">ثبت نام</button>
        </form>
    </div>

    <!-- Popup for Terms -->
    <div id="terms-popup" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>شرایط و قوانین</h2>
            <p>{{ $terms }}</p>  <!-- نمایش متن قوانین -->
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
                overflow: auto;
    height: 32rem;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            text-align: left;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <script>
        // Script for modal popup
        document.getElementById('show-terms').onclick = function() {
            document.getElementById('terms-popup').style.display = "block";
        }

        document.querySelector('.close').onclick = function() {
            document.getElementById('terms-popup').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('terms-popup')) {
                document.getElementById('terms-popup').style.display = "none";
            }
        }
    </script>
@endsection
