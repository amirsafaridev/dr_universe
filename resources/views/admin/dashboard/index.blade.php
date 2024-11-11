@extends('admin.layouts.layout')

@section('title', 'داشبورد مدیریت')

@section('content')
    <div class="row">
        <!-- باکس کاربران -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card-box bg-primary text-white">
                <div class="inner">
                    <h3 style="color: #fff; font-size: 40px;">{{ $totalUsers }}</h3>
                    <p style="font-size: 20px;">تعداد کل کاربران</p>
                </div>
                <div class="icon">
                    <i class="zmdi zmdi-accounts" style="font-size: 30px;"></i>
                </div>
            </div>
        </div>

        <!-- باکس پست‌ها -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card-box bg-success text-white">
                <div class="inner">
                    <h3 style="color: #fff; font-size: 40px;">{{ $totalPosts }}</h3>
                    <p style="font-size: 20px;">تعداد کل پست‌ها</p>
                </div>
                <div class="icon">
                    <i class="zmdi zmdi-file-text" style="font-size: 30px;"></i>
                </div>
            </div>
        </div>

        <!-- باکس استوری‌ها -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card-box bg-warning text-white">
                <div class="inner">
                    <h3 style="color: #fff; font-size: 40px;">{{ $totalStories }}</h3>
                    <p style="font-size: 20px;">تعداد کل استوری‌ها</p>
                </div>
                <div class="icon">
                    <i class="zmdi zmdi-image" style="font-size: 30px;"></i>
                </div>
            </div>
        </div>

        <!-- باکس کامنت‌ها -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card-box bg-info text-white">
                <div class="inner">
                    <h3 style="color: #fff; font-size: 40px;">{{ $totalComments }}</h3>
                    <p style="font-size: 20px;">تعداد کل کامنت‌ها</p>
                </div>
                <div class="icon">
                    <i class="zmdi zmdi-comment-text" style="font-size: 30px;"></i>
                </div>
            </div>
        </div>

        <!-- باکس لایک‌ها -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card-box bg-danger text-white">
                <div class="inner">
                    <h3 style="color: #fff; font-size: 40px;">{{ $totalLikes }}</h3>
                    <p style="font-size: 20px;">تعداد کل لایک‌ها</p>
                </div>
                <div class="icon">
                    <i class="zmdi zmdi-thumb-up" style="font-size: 30px;"></i>
                </div>
            </div>
        </div>

        <!-- باکس تبلیغات -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card-box bg-purple text-white">
                <div class="inner">
                    <h3 style="color: #fff; font-size: 40px;">{{ $totalAds }}</h3>
                    <p style="font-size: 20px;">تعداد کل تبلیغات</p>
                </div>
                <div class="icon">
                    <i class="zmdi zmdi-view-list" style="font-size: 30px;"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
