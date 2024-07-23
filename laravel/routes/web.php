<?php

use App\Http\Middleware\isUserLogin;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'], function () {

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
    });

    //Login

    Route::get('/login', 'AuthController@login_view')->name('login_page');
    Route::post('/get_code', 'AuthController@send_login_code')->name('send_login_code');

    //Register
    Route::get('/register', 'AuthController@register_view')->name('register_page');
    Route::post('/register_get_code', 'AuthController@send_register_code')->name('send_register_code');

    //Verifying Login & Register codes
    Route::post('/verifying', 'AuthController@verify_login_code')->name('verify_login_code');
    Route::post('/reg_verifying', 'AuthController@verify_reg_code')->name('verify_reg_code');
});


