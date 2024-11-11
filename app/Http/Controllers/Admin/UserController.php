<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * نمایش لیستی از کاربران.
     */
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users')); // نمایش لیست کاربران در ویو
    }

    /**
     * نمایش فرم برای ایجاد کاربر جدید.
     */
    public function create()
    {
        return view('admin.users.create'); // نمایش فرم ایجاد کاربر
    }

    /**
     * ذخیره کاربر جدید.
     */
    public function store(Request $request)
    {
        // اعتبارسنجی داده‌های فرم
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'role' => 'required',
            'account_type' => 'required',
            'mobile' => 'nullable|string|unique:users,mobile',
            'email' => 'nullable|email|unique:users,email',
            ]);

        // ایجاد کاربر جدید
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'account_type' => $request->account_type,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'profile' => 'default-avatar.png', // تصویر پیش‌فرض
            'blue_tick' => $request->has('blue_tick'), // تیک آبی
        ]);

        return redirect()->route('admin.users.index')->with('success', 'کاربر جدید با موفقیت ایجاد شد.');
    }


    /**
     * نمایش اطلاعات یک کاربر خاص.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id); // یافتن کاربر بر اساس id
        return view('admin.users.show', compact('user')); // نمایش اطلاعات کاربر
    }

    /**
     * نمایش فرم ویرایش کاربر.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id); // یافتن کاربر بر اساس id
        return view('admin.users.edit', compact('user')); // نمایش فرم ویرایش کاربر
    }

    /**
     * بروزرسانی اطلاعات کاربر.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id); // یافتن کاربر بر اساس id

        // اعتبارسنجی داده‌های فرم
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required',
            'mobile' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($user->id)],
        ]);



        // بروزرسانی اطلاعات کاربر
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'account_type' => $request->account_type,
            'blue_tick' => $request->has('blue_tick'),
        ]);

        // آپلود عکس پروفایل در صورت انتخاب
        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('profiles', 'public');
            $user->update(['profile' => $path]);
        }

        return redirect()->route('admin.users.index')->with('success', 'اطلاعات کاربر با موفقیت بروزرسانی شد.');
    }


    /**
     * حذف یک کاربر.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id); // یافتن کاربر بر اساس id
        $user->delete(); // حذف کاربر

        return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
