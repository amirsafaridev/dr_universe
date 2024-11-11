@extends('admin.layouts.layout')

@section('title', 'لیست تبلیغات')

@section('content')
    <div class="container">
        <h2>لیست تبلیغات</h2>

        <!-- دکمه ایجاد تبلیغ -->
        <div class="mb-3">
            <a href="{{ route('admin.adverts.create') }}" class="btn btn-success btn-sm">ایجاد تبلیغ جدید</a>
        </div>

        <!-- پیام موفقیت -->
        @if(session('success'))
            <div class="alert alert-success" style="margin-top: 10px">
                {{ session('success') }}
            </div>
        @endif

        <!-- جدول تبلیغات -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>کاربر</th>
                <th>آدرس رسانه</th>
                <th>نوع رسانه</th>
                <th>نمایش بعد از پست شماره</th> <!-- اضافه کردن ستون شماره پست -->
                <th>تاریخ ایجاد</th> <!-- اضافه کردن ستون تاریخ ایجاد -->
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($adverts as $advert)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $advert->user->username }}</td>
                    <td>
                        <!-- لینک مشاهده عکس یا ویدئو -->
                        <a target="_blank" href="{{ url('storage/' . $advert->media_path) }}">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            مشاهده
                        </a>
                    </td>
                    <td>{{ $advert->media_type == 'image' ? 'تصویر' : 'ویدیو' }}</td>
                    <td>{{ $advert->post_num }}</td> <!-- نمایش شماره پست -->
                    <td>{{ $advert->created_at->format('Y/m/d H:i') }}</td> <!-- نمایش تاریخ ایجاد -->
                    <td>
                        <!-- دکمه حذف تبلیغ -->
                        <form action="{{ route('admin.adverts.destroy', $advert->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این تبلیغ مطمئن هستید؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center" style="text-align: center;">
            {{ $adverts->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
