@extends('admin.layouts.layout')

@section('title', 'تنظیمات')

@section('content')
    <div class="container">
        <h2>تنظیمات</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('admin/settings/store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="terms">قوانین سایت:</label>
                <textarea id="terms" name="terms" rows="5" class="form-control" required>{{ old('terms', $terms) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">ذخیره</button>
        </form>
    </div>
@endsection
