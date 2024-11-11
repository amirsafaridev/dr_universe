<?php

use App\Models\Notif;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

function send_like_notif($post_id, $user_id)
{
    $post = Post::find($post_id);
    if ($post != "") {
        if (!like_notif_exists($post_id, $user_id)) {
            create_notif($post, $user_id, 'like');
        }
    }
}

function like_notif_exists($post_id, $user_id)
{
    $notif = Notif::where('action', 'like')->where('notifiable_id', $post_id)->where('user_id', $user_id)->count();
    if ($notif > 0) {
        return true;
    }
    return false;
}



function send_comment_notif($post_id, $user_id, $comment_text)
{
    $post = Post::find($post_id);
    if ($post != "") {
        create_notif($post, $user_id, "post_mention");
        comment_mention_notification($post_id, $user_id, $comment_text);
    }
}

function create_notif($post, $user_id, $action, $desc = '')
{
    $owner_id = $post->user->id;
    $notif = new Notif();
    $notif->user_id = $user_id;
    $notif->owner_id = $owner_id;
    $notif->action = $action;
    $notif->desc = $desc;
    $post->notifs()->save($notif);
}


function create_notif_mention($post, $user_id, $owner_id, $action, $desc = '')
{
    $notif = new Notif();
    $notif->user_id = $user_id;
    $notif->owner_id = $owner_id;
    $notif->action = $action;
    $notif->desc = $desc;
    $post->notifs()->save($notif);
}

function comment_mention_notification($post_id, $user_id, $comment_text)
{
    $post = Post::find($post_id);
    if ($post) {
        $regex = '~(@\w+)~';
        if (preg_match_all($regex, $comment_text, $matches, PREG_PATTERN_ORDER)) {
            foreach ($matches[1] as $word) {
                $u_name = str_replace('@', '', $word);
                $user=checkExistsUserByUsername($u_name);
                if ($user != false) {
                    create_notif_mention($post, $user_id,$user->id ,'comment_mention', $comment_text);
                }
            }
        }
    }
}

function post_mention_notification($post_id, $user_id, $caption)
{
    $post = Post::find($post_id);
    if ($post) {
        $regex = '~(@\w+)~';
        if (preg_match_all($regex, $caption, $matches, PREG_PATTERN_ORDER)) {
            foreach ($matches[1] as $word) {
                $u_name = str_replace('@', '', $word);
                $user=checkExistsUserByUsername($u_name);
                if ($user != false) {
                    create_notif_mention($post, $user_id,$user->id ,'post_mention', $caption);
                }
            }
        }
    }
}



function checkExistsUserByUsername($username)
{
    $user = User::where('username', $username)->first();
    if ($user != "") {
        return $user;
    } else {
        return false;
    }
}
