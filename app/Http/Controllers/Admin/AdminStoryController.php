<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story; // فرض کنید که مدل استوری به نام Story وجود دارد
use Illuminate\Http\Request;

class AdminStoryController extends Controller
{
    // نمایش لیست استوری‌ها
    public function index()
    {
        // دریافت استوری‌ها با کاربران مرتبط و صفحه‌بندی
        $stories = Story::with('user')->paginate(20); // 10 استوری در هر صفحه

        return view('admin.stories.index', compact('stories'));
    }

    // حذف استوری (در صورت نیاز)
    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        $story->delete();

        return redirect()->route('admin.stories.index')->with('success', 'استوری با موفقیت حذف شد.');
    }
}
