<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        return view('front.site.settings'); // بازگشت به ویو تنظیمات
    }

    public function update(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . Auth::id(), // اعتبارسنجی یکتایی نام کاربری با استثنا کردن کاربر جاری
            ],
            'name' => [
                'string',
                'max:255',
            ],
            'account_type' => 'required|in:public,private',
        ]);

        // دریافت کاربر جاری و به‌روزرسانی اطلاعات
        $user = Auth::user();
        $user->username = $request->input('username');
        $user->name = $request->input('name'); // به‌روزرسانی نام
        $user->description = $request->input('description'); // به‌روزرسانی توضیحات
        $user->account_type = $request->input('account_type');
        $user->save();

        return redirect('profile');

    }

}

