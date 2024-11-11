@extends('admin.layouts.layout')

@section('title', 'لیست پست‌ها')

@section('content')
    <div class="container">
        <h2>لیست پست‌ها</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped"> <!-- کلاس table-striped اضافه شده -->
            <thead>
            <tr>
                <th>#</th>
                <th>کاربر</th>
                <th>عکس پروفایل</th> <!-- ستون عکس پروفایل -->
                <th>عکس پست</th>
                <th>توضیحات</th>
                <th>نوع رسانه</th>
                <th>مشاهده‌ها</th>
                <th>تعداد کامنت‌ها</th>
                <th>تعداد لایک‌ها</th>
                <th>تاریخ ایجاد</th> <!-- اضافه کردن ستون تاریخ ایجاد -->
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->user->username }}</td>
                    <td>
                        <img style="width: 30px;height: 30px;object-fit: cover;border-radius: 50%;" src="{{ url('storage/profiles/' . $post->user->profile) }}" alt="Profile Image" width="50" height="50" class="rounded-circle">
                    </td>
                    <td>
                        @if($post->media_type === 'link')
                            <a target="_blank" href="{{ $post->media }}"><i class="fa fa-eye" aria-hidden="true"></i> مشاهده</a>
                        @else
                            <a target="_blank" href="{{ url('storage/posts/' . $post->media) }}"><i class="fa fa-eye" aria-hidden="true"></i> مشاهده</a>
                        @endif
                    </td>


                    <td>{{ $post->desc }}</td>
                    <td>{{ $post->media_type == 'photo' ? 'تصویر' : 'ویدیو' }}</td>
                    <td>{{ $post->views }}</td>
                    <td>{{ $post->comments_count }}</td> <!-- تعداد کامنت‌ها -->
                    <td>{{ $post->likes_count }}</td>    <!-- تعداد لایک‌ها -->
                    <td>{{ $post->created_at->format('Y/m/d H:i') }}</td> <!-- نمایش تاریخ ایجاد -->
                    <td>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این پست مطمئن هستید؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center" style="text-align: center;">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
