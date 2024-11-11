@extends('admin.layouts.layout')

@section('title', 'ایجاد تبلیغ جدید')

@section('content')
    <div class="container">
        <h2>ایجاد تبلیغ جدید</h2>

        <!-- نمایش پیام‌های خطا -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- فرم ایجاد تبلیغ -->
        <form action="{{ route('admin.adverts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="media">انتخاب رسانه (فقط تصویر)</label>
                <input type="file" class="form-control" id="media" name="media" required>
            </div>

            <div class="form-group">
                <label for="post_num">شماره پست بعد از آن نمایش داده شود</label>
                <input type="number" class="form-control" id="post_num" name="post_num" required>
            </div>

            <input type="hidden" name="media_type" value="image"> <!-- نوع رسانه به صورت مخفی تنظیم شده -->

            <button type="submit" class="btn btn-success">ذخیره</button>
        </form>
    </div>
@endsection
