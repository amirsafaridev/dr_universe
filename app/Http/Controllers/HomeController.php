<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\LiveStream;
use App\Models\Notif;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use App\Models\FollowRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use App\Models\Follow;

class HomeController extends Controller
{
    public function showLink(Request $request)
    {
        $url = $request->query('url');
        return view('front.site.displayLink', compact('url'));
    }

    public function home_page(Request $request)
    {

        // کاربر لاگین شده
        $user = auth()->user();

        // دریافت آیدی‌های کاربرانی که کاربر فالو کرده است
        $followingUserIds = $user->followings()->pluck('followed_id');

        // جمع آوری آیدی کاربر خودش و کاربرانی که فالو کرده
        $userIds = $followingUserIds->push($user->id);

        // فقط پست‌های کاربر و کاربرانی که فالو کرده است را بگیرید
        $posts = Post::whereIn('user_id', $userIds)
            ->orderBy('id', 'DESC')
            ->with(['user'])
            ->paginate(2);

        $page = $_GET['page'] ?? 1;



        $post_num2 = $page * 2;

        $post_num1 = $post_num2 - 1;

        $advert1 = Advert::where('post_num', $post_num1)->first();
        $advert2 = Advert::where('post_num', $post_num2)->first();


        // ایجاد یک آرایه برای پست‌ها به همراه تبلیغ
        $combinedPosts = [];
        $combinedPosts[] = $posts[0];
        $combinedPosts[] =$advert1;
        $combinedPosts[] = $posts[1];
        $combinedPosts[] =$advert2;


        $posts = collect($combinedPosts); // تبدیل به یک کالکشن


        if ($request->ajax()) {
            $view = view('front.site.partials.posts', compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }

        $liveStreams = LiveStream::where('status', 'live')->get();


        $users = User::where('id', '!=', $user->id)->get();

        return view('front.site.home', compact('posts', 'liveStreams','users'));
    }

    public function hashtag_page($hashtag)
    {
        $posts = Post::orderBy('id', 'DESC')->where("desc",'LIKE', "%#$hashtag%")->with(['user'])->get();
        return view('front.site.home', compact('posts'));
    }

    public function notif_page()
    {
        $user_id = Auth::id();

        $notifications = Notif::where('user_id', $user_id)
            ->with('notifiable') // بارگذاری eager برای مدل مرتبط
            ->latest() // مرتب‌سازی به ترتیب جدیدترین نوتیفیکیشن‌ها
            ->limit(10) // محدود کردن به ۱۰ نوتیفیکیشن
            ->get();





        return view('front.site.notifications', compact('notifications'));
    }

    public function new_post_page()
    {
        return view('front.site.new_post');
    }

    public function edit_post_page($id)
    {
        $post = Post::find($id);
        if($post->user_id != Auth::id()){
            return redirect()->back();
        }

        return view('front.site.new_post', compact('post'));
    }

    public function profile_page($username = "", $post_id = "")
    {
        // پیدا کردن کاربر بر اساس نام کاربری یا کاربر جاری
        if ($username != "") {
            $user = User::where('username', $username)->first();
        } else {
            $user = Auth::user();
        }

        // اگر کاربر یافت نشد، به صفحه اصلی ریدایرکت کنید
        if (empty($user)) {
            return redirect(route('home_page'));
        }

        // محاسبه تعداد فالوورها و فالووینگ‌ها
        $followers = $user->followers()->count();
        $followings = $user->followings()->count();

        // دریافت لیست فالوورها و فالووینگ‌ها
        $followers_list = $user->followers;
        $followings_list = $user->followings;

        // پست‌ها و ذخیره‌ها
        $posts = $user->posts->reverse();
        $post_save = $user->saves()->get();

        // در صورت تعیین پست خاص، آن را فیلتر کنید
        if (!empty($post_id)) {
            $posts = $posts->where('id', $post_id);
        }

        // کاربران برای لیست دنبال شوندگان
        $userr = auth()->user();
        $users = User::where('id', '!=', $userr->id)->get();

        // بررسی اینکه آیا کاربر جاری کاربر مشخص شده را دنبال می‌کند یا خیر
        $isFollowing = Auth::check() ? $user->followers()->where('user_id', Auth::id())->exists() : false;

        // بررسی درخواست دنبال کردن برای اکانت‌های خصوصی
        $followRequestPending = Auth::check() && FollowRequest::where('user_id', Auth::id())->where('followed_id', $user->id)->exists();

        // بازگرداندن داده‌ها به ویو
        return view('front.site.myaccount', compact(
            'user', 'users', 'followers', 'followings', 'posts', 'followers_list', 'followings_list', 'post_save', 'post_id', 'isFollowing', 'followRequestPending'
        ));
    }

    public function upload_profile_pic(Request $request){
        $file = $request->file('profile_image');
        $user=Auth::user();
        if (str_starts_with($file->getClientMimeType(), 'image')) {
            $fileName = time().rand(100000,99999999) . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profiles/', $fileName); // Store the file in the "uploads" directory
            $user->profile = $fileName;
            $user->save();

            return response()->json(['status' => 'ok', 'msg' => '']);
        }
        return response()->json(['status' => 'failed', 'msg' => ' لطفا یک عکس اپلود کنید']);
    }

    public function base()
    {
        if(Auth::check()) {
            return redirect(route('home_page'));
        }else{
            return redirect(route('login_page'));
        }
    }
}
