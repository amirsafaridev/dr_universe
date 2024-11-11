<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Story; // مدل استوری
use App\Models\Comment; // مدل کامنت
use App\Models\Like; // مدل لایک
use App\Models\Advert; // مدل تبلیغ
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * نمایش صفحه داشبورد با آمارها
     */
    public function index()
    {
        // گرفتن تعداد کل کاربران
        $totalUsers = User::count();

        // گرفتن تعداد کل پست‌ها
        $totalPosts = Post::count();

        // گرفتن تعداد کل استوری‌ها
        $totalStories = Story::count();

        // گرفتن تعداد کل کامنت‌ها
        $totalComments = Comment::count();

        // گرفتن تعداد کل لایک‌ها
        $totalLikes = Like::count();

        // گرفتن تعداد کل تبلیغات
        $totalAds = Advert::count();

        // ارسال داده‌ها به ویو
        return view('admin.dashboard.index', compact('totalUsers', 'totalPosts', 'totalStories', 'totalComments', 'totalLikes', 'totalAds'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login'); // هدایت به صفحه لاگین
    }

}
