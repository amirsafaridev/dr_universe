@extends('admin.layouts.layout')

@section('title', 'لیست نظرات')

@section('content')
    <div class="container">
        <h2>لیست نظرات</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>کاربر</th>
                <th>عکس پروفایل</th> <!-- ستون عکس پروفایل -->
                <th>متن نظر</th>
                <th>وضعیت</th>
                <th>تاریخ ایجاد</th> <!-- اضافه کردن ستون تاریخ ایجاد -->
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($comments as $comment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $comment->user->username }}</td>
                    <td>
                        <img style="width: 30px;height: 30px;object-fit: cover;border-radius: 50%;" src="{{ url('storage/profiles/' . $comment->user->profile) }}" alt="Profile Image" width="50" height="50" class="rounded-circle">
                    </td>
                    <td>{{ $comment->text }}</td>
                    <td>
                        @if($comment->status == 0)
                            <span class="badge badge-warning">در انتظار تایید</span>
                        @elseif($comment->status == 1)
                            <span class="badge badge-success">تایید شده</span>
                        @elseif($comment->status == 2)
                            <span class="badge badge-danger">رد شده</span>
                        @endif
                    </td>
                    <td>{{ $comment->created_at->format('Y/m/d H:i') }}</td> <!-- نمایش تاریخ ایجاد -->
                    <td>
                        @if($comment->status == 0)
                            <a href="{{ route('admin.comments.approve', $comment->id) }}" class="btn btn-success btn-sm">تایید</a>
                            <a href="{{ route('admin.comments.reject', $comment->id) }}" class="btn btn-danger btn-sm">رد</a>
                        @elseif($comment->status == 1)
                            <a href="{{ route('admin.comments.reject', $comment->id) }}" class="btn btn-danger btn-sm">رد</a>
                        @elseif($comment->status == 2)
                            <a href="{{ route('admin.comments.approve', $comment->id) }}" class="btn btn-success btn-sm">تایید</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center" style="text-align: center;">
            {{ $comments->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
