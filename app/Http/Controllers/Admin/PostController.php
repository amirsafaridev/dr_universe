<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * نمایش لیستی از پست‌ها.
     */
    public function index()
    {
        // استفاده از paginate به جای get
        $posts = Post::with(['user', 'comments', 'likes'])
            ->withCount(['comments', 'likes'])
            ->paginate(20); // 10 پست در هر صفحه

        return view('admin.posts.index', compact('posts')); // نمایش لیست پست‌ها در ویو
    }


    /**
     * نمایش فرم برای ایجاد پست جدید.
     */
    public function create()
    {
        $users = User::all(); // دریافت تمامی کاربران برای اختصاص پست به کاربر
        return view('admin.posts.create', compact('users')); // نمایش فرم ایجاد پست
    }

    /**
     * ذخیره پست جدید.
     */
    public function store(Request $request)
    {
        // اعتبارسنجی داده‌های فرم
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'desc' => 'nullable|string',
            'media' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,avi,mov|max:20480', // حداکثر حجم 20MB
            'media_type' => 'required|in:image,video',
        ]);

        // بارگذاری فایل رسانه‌ای
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('media', 'public');
        }

        // ایجاد پست جدید
        Post::create([
            'user_id' => $request->user_id,
            'desc' => $request->desc,
            'media' => $mediaPath,
            'media_type' => $request->media_type,
            'views' => 0,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'پست جدید با موفقیت ایجاد شد.');
    }

    /**
     * نمایش اطلاعات یک پست خاص.
     */
    public function show(string $id)
    {
        $post = Post::with('user')->findOrFail($id); // یافتن پست بر اساس id
        return view('admin.posts.show', compact('post')); // نمایش اطلاعات پست
    }

    /**
     * نمایش فرم ویرایش پست.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id); // یافتن پست بر اساس id
        $users = User::all(); // دریافت لیست کاربران برای ویرایش پست
        return view('admin.posts.edit', compact('post', 'users')); // نمایش فرم ویرایش پست
    }

    /**
     * بروزرسانی اطلاعات پست.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id); // یافتن پست بر اساس id

        // اعتبارسنجی داده‌های فرم
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'desc' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpeg,jpg,png,gif,mp4,avi,mov|max:20480',
            'media_type' => 'required|in:image,video',
        ]);

        // بررسی آپلود فایل جدید و حذف فایل قدیمی
        if ($request->hasFile('media')) {
            // حذف فایل قدیمی
            if ($post->media) {
                Storage::disk('public')->delete($post->media);
            }
            // آپلود فایل جدید
            $mediaPath = $request->file('media')->store('media', 'public');
        } else {
            $mediaPath = $post->media; // در صورت عدم آپلود فایل جدید، همان فایل قبلی باقی بماند
        }

        // بروزرسانی اطلاعات پست
        $post->update([
            'user_id' => $request->user_id,
            'desc' => $request->desc,
            'media' => $mediaPath,
            'media_type' => $request->media_type,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'پست با موفقیت بروزرسانی شد.');
    }

    /**
     * حذف یک پست.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id); // یافتن پست بر اساس id

        // حذف فایل رسانه‌ای از سرور
        if ($post->media) {
            Storage::disk('public')->delete($post->media);
        }

        $post->delete(); // حذف پست

        return redirect()->route('admin.posts.index')->with('success', 'پست با موفقیت حذف شد.');
    }
}
