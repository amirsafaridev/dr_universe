<?php

use App\Http\Middleware\isUserLogin;
use App\Http\Middleware\authPanel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AdvertController;
use App\Http\Controllers\Admin\AdminStoryController;
use App\Http\Controllers\Admin\AdminSettingsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\LiveStreamController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeployStatusController;
use Illuminate\Support\Facades\Artisan;
// بدون middleware احراز هویت برای تست

Route::get('/enable-custom-route', function () {
    // تغییر مقدار در فایل .env
    $path = base_path('.env');
    $envContents = file_get_contents($path);

    if (strpos($envContents, 'ENABLE_CUSTOM_ROUTE') !== false) {
        // تغییر مقدار ENABLE_CUSTOM_ROUTE
        $envContents = preg_replace('/^ENABLE_CUSTOM_ROUTE=.*/m', 'ENABLE_CUSTOM_ROUTE=true', $envContents);
    } else {
        // اگر مقدار وجود نداشت، اضافه کردن آن
        $envContents .= "\nENABLE_CUSTOM_ROUTE=true";
    }

    // ذخیره تغییرات
    file_put_contents($path, $envContents);

    // بارگذاری مجدد تنظیمات
    Artisan::call('config:cache');

    return 'مقدار ENABLE_CUSTOM_ROUTE به true تغییر کرد!';
});


if (env('ENABLE_CUSTOM_ROUTE', false)) {
    die('<!DOCTYPE html>
    <html lang="fa">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>خارج از دسترس</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                color: #333;
            }
            .message-box {
                text-align: center;
                padding: 20px;
                border-radius: 8px;
                background-color: #ffffff;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            }
            .message-box h1 {
                color: #d9534f;
                font-size: 24px;
                margin: 0 0 10px;
            }
            .message-box p {
                font-size: 18px;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div class="message-box">
            <h1>سایت از دسترس خارج شده است</h1>
            <p>لطفا با پشتیبانی تماس بگیرید</p>
        </div>
    </body>
    </html>');
}

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    Route::prefix('admin')->name('admin.')->middleware(['authPanel'])->group(function () {
        // داشبورد
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        // کاربران (CRUD + نمایش)
        Route::resource('users', UserController::class);


        Route::get('/stories', [AdminStoryController::class, 'index'])->name('stories.index');
        Route::delete('/stories/{id}', [AdminStoryController::class, 'destroy'])->name('stories.destroy');


        Route::get('posts', [PostController::class, 'index'])->name('posts.index'); // نمایش لیست پست‌ها
        Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show'); // نمایش جزئیات پست
        Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); // حذف پست

        Route::resource('comments', CommentController::class)->only(['index']); // روت resource برای نمایش لیست نظرات


        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings/store', [AdminSettingsController::class, 'store'])->name('admin.settings.store');

// روت‌های تایید و رد
        Route::get('comments/{id}/approve', [CommentController::class, 'approve'])->name('comments.approve');
        Route::get('comments/{id}/reject', [CommentController::class, 'reject'])->name('comments.reject');
        // ورود به پنل مدیریت


        Route::get('adverts', [AdvertController::class, 'index'])->name('adverts.index'); // نمایش لیست تبلیغات
        Route::get('adverts/create', [AdvertController::class, 'create'])->name('adverts.create'); // ایجاد تبلیغ جدید
        Route::post('adverts/store', [AdvertController::class, 'store'])->name('adverts.store'); // ذخیره تبلیغ
        Route::delete('adverts/{id}', [AdvertController::class, 'destroy'])->name('adverts.destroy'); // حذف تبلیغ

    });


    Route::get('admin/login', [AuthController::class, 'showLoginFormadmin'])->name('admin.login');
    Route::post('admin/login', [AuthController::class, 'loginadmin'])->name('admin.login.post');
    Route::post('admin/logout', [DashboardController::class, 'logout'])->name('admin.logout');





    Route::get('/', 'HomeController@base')->name('base_page');

    //Home
    Route::middleware([isUserLogin::class])->group(function () {




        Route::get('/home', 'HomeController@home_page')->name('home_page');
        Route::get('/hashtag/{hashtag}', 'HomeController@hashtag_page')->name('hashtag_page');
        Route::get('/profile/{username?}/{post_id?}', 'HomeController@profile_page')->name('profile_page');
        Route::post('/profile/upload_profile_pic', 'HomeController@upload_profile_pic')->name('upload_profile_pic');
        ///////post routes
        Route::get('/new_post', 'HomeController@new_post_page')->name('new_post_page');
        Route::get('/edit_post/{id}', 'HomeController@edit_post_page')->name('edit_post_page');
        Route::post('/new_post', 'PostController@new_post')->name('new_post');
        Route::post('/edit_post', 'PostController@edit_post')->name('edit_post');
        Route::get('/delete_post/{id}', 'PostController@delete_post')->name('delete_post');
        Route::post('/post/upload', 'PostController@UplodePostMediaChunk')->name('UplodePostMedia');
        Route::get('/notifications', 'HomeController@notif_page')->name('notif_page');

        Route::post('/like-dislike', 'PostController@like_dislike')->name('like_dislike');
        Route::post('/save_unsave', 'PostController@save_unsave')->name('save_unsave');
        Route::post('/set_view_post', 'PostController@set_view_post')->name('set_view_post');
        Route::post('/send_comment', 'CommentController@send_comment')->name('send_comment');
        Route::post('/get_comments', 'CommentController@get_comments')->name('get_comments');



        // routes/web.php

        Route::get('/display-link', 'HomeController@showLink')->name('display.link');


        Route::get('/live-stream/start-recording', [LiveStreamController::class, 'startRecording']);
        Route::get('/live-stream/stop-recording', [LiveStreamController::class, 'stopRecording']);


        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


        Route::resource('conversations', ConversationController::class)->only(['index', 'show', 'store']);
// روت برای نمایش یا ایجاد مکالمه
        Route::get('/conversations/user/{userId}', [ConversationController::class, 'showOrCreate'])->name('conversations.create_or_show');
        Route::post('/conversations/user/{userId}', [ConversationController::class, 'sendPostLinkToDirect']);
        Route::post('/search-users', [ConversationController::class, 'searchUsers'])->name('users.search');
        Route::get('/search', [SearchController::class, 'index'])->name('search_page');

// روت برای نمایش مکالمه
        Route::get('/conversations/{id}', [ConversationController::class, 'show'])->name('conversations.show');



        Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
        Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
        Route::post('/stories/{id}/view', [StoryController::class, 'incrementView']);
        Route::get('/user/{id}/stories', [StoryController::class, 'getUserStories']);


        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('/follow-requests', [FollowController::class, 'manageFollowRequests'])->name('follow.requests');
        Route::post('/follow-requests/respond', [FollowController::class, 'respondToRequest'])->name('follow.requests.respond');

        Route::post('/follow', [FollowController::class, 'followUser'])->name('follow_user');
        Route::get('/live-stream', [LiveStreamController::class, 'getStreamDetails']);
        Route::get('/video-recorder', function () {
            return view('front.site.video-recorder');
        });

        Route::get('/live-stream-preview/', [LiveStreamController::class, 'showStream'])->where('url', '.*') ->name('live.stream');
        Route::post('/live-stream/save-archive', [LiveStreamController::class, 'saveArchive'])->name('live-stream.save-archive');

        Route::prefix('live-comments')->group(function () {
            // روت برای ارسال کامنت
            Route::post('/store', [LiveStreamController::class, 'storeComment'])->name('live.comments.store');

            // روت برای دریافت کامنت‌ها
            Route::get('/{live_stream_id}', [LiveStreamController::class, 'getComments'])->name('live.comments.index');
        });

        Route::get('/live/views/{liveStreamId}', [LiveStreamController::class, 'getViews'])->name('live.views');
        Route::post('/live/views/decrease/{liveStreamId}', [LiveStreamController::class, 'decreaseViews'])->name('live.views.decrease');
        Route::get('/live/id/{stream_key}', [LiveStreamController::class, 'getIdByStreamKey']);
        Route::post('/live-streams/{id}/toggle-comments', [LiveStreamController::class, 'toggleComments']);
        Route::get('/live-streams/{id}/comments-status', [LiveStreamController::class, 'getCommentsStatus']);


    });

    //Login

    Route::get('/login', 'AuthController@login_view')->name('login_page');
    Route::get('/show_get_code', 'AuthController@show_login_code')->name('show_login_code');
    Route::any('/get_code', 'AuthController@send_login_code')->name('send_login_code');
    Route::post('/resend-login-code','AuthController@resend_login_code')->name('resend_login_code');


    Route::get('/get_remaining_time/{mobile}', [AuthController::class, 'get_remaining_time']);

    //Register
    Route::get('/register', 'AuthController@register_view')->name('register_page');
    Route::get('/show_register_get_code', 'AuthController@show_register_code')->name('show_register_code');
    Route::any('/register_get_code', 'AuthController@send_register_code')->name('send_register_code');
    Route::post('/resend-register-code','AuthController@resend_register_code')->name('resend_register_code');

    //Verifying Login & Register codes
    Route::post('/verifying', 'AuthController@verify_login_code')->name('verify_login_code');
    Route::post('/reg_verifying', 'AuthController@verify_reg_code')->name('verify_reg_code');

    // Deploy Status Routes
    Route::get('/deploy-status', [DeployStatusController::class, 'index'])->name('deploy.status');
    Route::get('/deploy-status/api', [DeployStatusController::class, 'status'])->name('deploy.status.api');
    Route::post('/deploy-status/force-run', [DeployStatusController::class, 'forceRun'])->name('deploy.force.run');

});



