@extends('front.site.layout')

@section('page_title', 'تنظیمات')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .settings-container {
            text-align: right;
            direction: rtl;
            padding: 20px;
        }

        .accordion {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .accordion-header {
            padding: 15px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ddd;
            color: #000;
            border-radius: 5px;
        }

        .accordion-header:hover {
            background-color: #808080;
            color: #fff;
        }

        .accordion-header .icon {
            margin-left: 10px;
        }

        .accordion-body {
            display: none;
            padding: 15px;
            border-top: 1px solid #ddd;
        }

        .accordion.active .accordion-body {
            display: block;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>

    <div class="settings-container">

        @if(auth()->user()->isAdmin())
            <div class="accordion">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    <span><i class="fas fa-desktop icon"></i>پنل مدیریت</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="accordion-body">
                    <div class="logout-section">
                        <p>برای رفتن به داشبورد ادمین کلیک کنید</p>
                        <a class="btn btn-dark" style="display: block; margin: auto;width: fit-content;" href="{{ route('admin.dashboard') }}"> داشبورد ادمین </a>
                    </div>
                </div>
            </div>
        @endif
        <!-- آکاردیون تغییر نام کاربری -->
        <div class="accordion">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <span><i class="fas fa-user icon"></i> تغییر نام کاربری</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="accordion-body">
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="username">نام کاربری جدید :</label>
                        <input style="width: 100%" type="text" id="username" name="username" value="{{ auth()->user()->username }}" required>
                        @error('username')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">نام :</label>
                        <input style="width: 100%" type="text" id="name" name="name" value="{{ auth()->user()->name }}">
                        @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">توضیحات :</label>
                        <textarea style="width: 100%" id="description" name="description" rows="4">{{ auth()->user()->description }}</textarea>
                        @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>نوع اکانت:</label><br>
                        <div>
                            <input type="radio" id="public" name="account_type" value="public" {{ auth()->user()->account_type == 'public' ? 'checked' : '' }}>
                            <label for="public">عمومی</label>
                        </div>
                        <div>
                            <input type="radio" id="private" name="account_type" value="private" {{ auth()->user()->account_type == 'private' ? 'checked' : '' }}>
                            <label for="private">خصوصی</label>
                        </div>
                    </div>


                    <button style="display: block; margin: auto;" type="submit" class="btn btn-dark">به‌روزرسانی نام کاربری و اطلاعات</button>
                </form>
            </div>
        </div>

        <!-- آکاردیون خروج -->
        <div class="accordion">
            <div class="accordion-header" onclick="toggleAccordion(this)">
                <span><i class="fas fa-sign-out-alt icon"></i> خروج از حساب کاربری</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="accordion-body">
                <div class="logout-section">
                    <p>برای خروج از حساب کاربری خود بر روی دکمه زیر کلیک کنید.</p>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-dark" style="display: block; margin: auto;" type="submit" onclick="return confirmLogout()">خروج</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script>
        function toggleAccordion(element) {
            element.parentElement.classList.toggle('active');
        }

        function confirmLogout() {
            return confirm('آیا مطمئن هستید که می‌خواهید خارج شوید؟');
        }
    </script>
@endsection
