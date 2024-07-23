<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function send_comment(Request $request)
    {
        $post_id=$request->input('post_id');
        $user_id=Auth::id();
        $post=Post::find($post_id);
        if($post) {
            $comment_text = $request->input('comment');
            $comment = new Comment();
            $comment->text = $comment_text;
            $comment->user_id = $user_id;
            $post->comments()->save($comment);
            send_comment_notif($post_id,$user_id,$comment_text);
            return json_encode([
                "result" => true
            ]);
        }
    }


    public function get_comments(Request $request)
    {
        $post_id=$request->input('post_id');
        $post=Post::where('id',$post_id)->first();
        if($post){
            return json_encode([
                "result"=>$post->comments->load('user')
            ]);
        }
    }
}
