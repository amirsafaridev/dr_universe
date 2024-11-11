<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function send_comment(Request $request)
    {
        $post_id = $request->input('post_id');
        $user_id = Auth::id();
        $post = Post::find($post_id);

        if ($post) {
            $comment_text = $request->input('comment');

            // ذخیره کامنت
            $comment = new Comment();
            $comment->text = $comment_text;
            $comment->user_id = $user_id;
            $post->comments()->save($comment);

            // ثبت نوتیفیکیشن برای نویسنده پست
            Notif::create([
                'user_id' => $post->user_id, // کاربر صاحب پست
                'owner_id' => $user_id, // کاربر کامنت‌گذار
                'action' => 'کامنت',
                'desc' => 'کاربر ' . auth()->user()->username . ' روی پست شما کامنت گذاشت: ' . $comment_text,
                'notifiable_type' => Comment::class,
                'notifiable_id' => $comment->id, // شناسه کامنت
            ]);

            return response()->json([
                "result" => true
            ]);
        }
    }



//    public function get_comments(Request $request)
//    {
//        $post_id=$request->input('post_id');
//        $post=Post::where('id',$post_id)->first();
//        if($post){
//            return json_encode([
//                "result"=>$post->comments->load('user')
//            ]);
//        }
//    }
    public function get_comments(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::where('id', $post_id)->first();

        if ($post) {

            $approved_comments = $post->comments()->where('status', 1)->with('user')->get();

            return response()->json([
                "result" => $approved_comments
            ]);
        }

        return response()->json([
            "result" => false,
            "message" => "پست یافت نشد."
        ]);
    }


}
