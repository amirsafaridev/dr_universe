@extends('front.site.layout')

@section('page_title', 'رویداد ها')

@section('content')
    <style>
        .notifications-container {
            margin: 20px;
            text-align: left;
            padding-bottom: 1px;
        }

        .notification-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }
        .notification-box:last-child {
            margin-bottom: 100px;
        }

        .notification-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .notification-info {
            display: flex;
            flex-direction: column;
        }

        .notification-body {
            font-size: 14px;
        }

        .notification-body p {
            margin: 5px 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f8f9fa;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .header .icons {
            display: flex;
            align-items: center;
        }

        .header .icons a {
            margin-left: 20px;
            color: #333;
            text-decoration: none;
            font-size: 20px;
        }

        .header .icons a:hover {
            color: #007bff;
        }

        .header .icons a .fa {
            font-size: 24px;
        }
    </style>
{{--    <h1>Notifications</h1>--}}
    @if($currentUser->account_type === 'private')
        <div class="header" >
            <h4 style="margin: 0 !important;">
                درخواست ها
            </h4>
            <div class="icons">
                    <a href="{{ route('follow.requests') }}" class="settings-btn" style="margin: 0 !important;">
                        <img src="{{ asset('img/iconoir_user-love.svg') }}" style="    width: 30px;
    height: 30px;">
                    </a>
            </div>
        </div>
    @endif

    @if($notifications->isEmpty())
        <p>هیچ اعلانی یافت نشد.</p>
    @else
        <div class="notifications-container">
            @foreach($notifications as $notification)

                <?php
                    $owner = ($notification->owner)

                    ?>
                    <div class="notification-box">
                        <div class="notification-header">
                            <img src="{{ url('storage/profiles/' . ($owner->profile ?? 'default.jpg')) }}" alt="Profile Picture" class="profile-pic">
                            <div class="notification-info">
                                <strong>{!! $owner->username_with_blue_tick !!}</strong> <!-- نمایش نام کاربری لایک‌کننده -->
                            </div>
                        </div>
                        <div class="notification-body" style="text-align: right">
{{--                            <p><strong>اقدام:</strong> {{ $notification->action }}</p>--}}
                            <p>{{ $notification->desc }}</p>
{{--                            <p><strong>تاریخ:</strong> {{ \Morilog\Jalali\Jalalian::forge($notification->created_at)->format('Y/m/d H:i') }}</p>--}}
                            <p>{{ \Morilog\Jalali\Jalalian::forge($notification->created_at->addHours(3)->addMinutes(30))->format('Y/m/d-H:i') }}</p>

                        </div>
                    </div>

            @endforeach
        </div>
    @endif
@endsection
