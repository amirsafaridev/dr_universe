<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advert;
use Illuminate\Support\Facades\Storage;


class AdvertController extends Controller
{
    // نمایش لیست تبلیغات
    public function index()
    {
        $adverts = Advert::with('user')->paginate(20);// گرفتن تبلیغات به همراه اطلاعات کاربر
        return view('admin.adverts.index', compact('adverts'));
    }

    // نمایش فرم ایجاد تبلیغ جدید
    public function create()
    {
        return view('admin.adverts.create');
    }

    // ذخیره تبلیغ جدید
    // ذخیره تبلیغ جدید
    public function store(Request $request)
    {
        // اعتبارسنجی ورودی‌ها
        $validated = $request->validate([
            'media' => 'required|file|mimes:jpeg,png,jpg,webp,gif,svg|max:51200', // تمامی فرمت‌های تصاویر مجاز
            'post_num' => 'required|integer', // شماره پست باید یک عدد صحیح باشد
        ]);

        // ذخیره فایل در storage
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $filePath = $file->store('adverts', 'public');
        }   

        // ایجاد رکورد جدید در جدول تبلیغات
        Advert::create([
            'user_id' => auth()->id(), // آی‌دی کاربر جاری
            'media_path' => $filePath,
            'media_type' => 'image', // نوع رسانه به صورت ثابت تنظیم شده
            'post_num' => $request->post_num, // ذخیره شماره پست
        ]);

        return redirect()->route('admin.adverts.index')->with('success', 'تبلیغ جدید با موفقیت ایجاد شد.');
    }



    // حذف تبلیغ
    public function destroy($id)
    {
        $advert = Advert::findOrFail($id);

        $advert->delete();

        return redirect()->route('admin.adverts.index')->with('success', 'تبلیغ با موفقیت حذف شد.');
    }
}


