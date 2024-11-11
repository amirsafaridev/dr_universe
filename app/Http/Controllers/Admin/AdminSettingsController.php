<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // اطمینان حاصل کنید که این خط را اضافه کرده‌اید
use Illuminate\Http\Request;
use App\Models\Setting;


class AdminSettingsController extends Controller
{
    public function index()
    {
        $terms = Setting::where('key', 'terms')->first()->value ?? '';

        return view('admin.settings.index', compact('terms'));
    }


    public function store(Request $request)
    {
        // اعتبارسنجی ورودی
        $request->validate([
            'terms' => 'required|string',
        ]);

        // ذخیره متن قوانین سایت
        Setting::updateOrCreate(
            ['key' => 'terms'],
            ['value' => $request->terms]
        );


        return redirect()->back()->with('admin.settings.index')->with('success', 'قوانین سایت با موفقیت ذخیره شد.');

    }
}
