<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class HomeController extends Controller
{
    public function home_page()
    {
        $posts = Post::orderBy('id', 'DESC')->with(['user'])->get();
        return view('front.site.home', compact('posts'));
    }
    public function hashtag_page($hashtag)
    {
        $posts = Post::orderBy('id', 'DESC')->where("desc",'LIKE', "%#$hashtag%")->with(['user'])->get();
        return view('front.site.home', compact('posts'));
    }
    public function notif_page()
    {
        $user = Auth::user();
        $notifs = $user->notifs_last50;
        return view('front.site.notifications', compact('notifs'));
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



    public function profile_page($username="",$post_id="")
    {
        if ($username != ""){
            $user=User::where('username',$username)->first();
        }else{
            $user_is=Auth::id();
            $user=User::where('id',$user_is)->first();
        }
        if (empty($user)){
            return redirect(route('home_page'));
        }
        $followers=count($user->followers);
        $followings=count($user->followings);
        $followers_list=[];
        $followings_list=[];
        foreach ($user->followings as $item){
            $item=User::where('id',$item->user_id)->first();
            $followings_list[] = $item;
        }
        foreach ($user->followers as $item){
            $item=User::where('id',$item->user_id)->first();
            $followers_list[] = $item;
        }
        $posts=$user->posts->reverse();
        $post_save = $user->saves()->get();

        return view('front.site.myaccount',compact('user','followers','followings','posts','followers_list','followings_list','post_save','post_id'));
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
