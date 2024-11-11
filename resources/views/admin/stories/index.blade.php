@extends('admin.layouts.layout')

@section('title', 'لیست استوری‌ها')

@section('content')
    <div class="container">
        <h2>لیست استوری‌ها</h2>

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
                <th>نوع استوری</th>
                <th>مسیر فایل</th>
                <th>زمان انقضا</th>
                <th>تعداد مشاهده‌ها</th>
                <th>تاریخ ایجاد</th> <!-- اضافه کردن ستون تاریخ ایجاد -->
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stories as $story)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $story->user->username }}</td>
                    <td>
                        <img style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;" src="{{ url('storage/profiles/' . $story->user->profile) }}" alt="Profile Image" width="50" height="50" class="rounded-circle">
                    </td>
                    <td>{{ $story->type == 'image' ? 'تصویر' : 'ویدیو' }}</td>
                    <td>
                        <a target="_blank" href="{{ url('storage/' . $story->file_path) }}"><i class="fa fa-eye" aria-hidden="true"></i> مشاهده</a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($story->expired_at)->format('Y/m/d H:i') }}</td> <!-- زمان انقضا -->
                    <td>{{ $story->views }}</td> <!-- تعداد مشاهده‌ها -->
                    <td>{{ \Carbon\Carbon::parse($story->created_at)->format('Y/m/d H:i') }}</td> <!-- نمایش تاریخ ایجاد -->

                    <td>
                      <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این استوری مطمئن هستید؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center" style="text-align: center;">
            {{ $stories->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
