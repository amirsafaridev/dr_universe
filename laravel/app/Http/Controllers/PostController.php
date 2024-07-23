<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Save;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function like_dislike(Request $request)
    {
        $user_id=Auth::id();
        $post_id=$request->input('post_id');
        $post=Post::find($post_id);
        if($post) {
            $like = Like::where('user_id', $user_id)->where('likeable_id', $post_id)->first();
            if ($like != null) {
                $like->delete();
            } else {
                $like = new Like();
                $like->user_id = $user_id;
                $post->likes()->save($like);
                send_like_notif($post_id,$user_id);
            }
            return json_encode([
                "result" => true
            ]);
        }
        return json_encode([
            "result" => false
        ]);
    }


    public function save_unsave(Request $request)
    {
        $user_id=Auth::id();
        $post_id=$request->input('post_id');
        $post=Post::find($post_id);
        if($post) {
            $save = Save::where('user_id', $user_id)->where('savable_id', $post_id)->first();
            if ($save != null) {
                $save->delete();
            } else {
                $save = new Save();
                $save->user_id = $user_id;
                $post->saves()->save($save);
            }
            return json_encode([
                "result" => true
            ]);
        }
        return json_encode([
            "result" => false
        ]);
    }

    public function set_view_post(Request $request)
    {
        $post_id=$request->input('post_id');
        Post::where('id',$post_id)
            ->increment('views', 1);
    }

    public function new_post(Request $request)
    {
        // Validate the form data
        $user_id = Auth::id();
        $fileName = $request->input('media_file_name');
        $caption = $request->input('caption');
        $media_type = $request->input('media_file_type');
        if (str_starts_with($media_type, 'image')) {
            $media_type = "photo";
        } else {
            if (str_starts_with($media_type, 'application/octet-stream') || $media_type == "video/mp4") {
                $media_type = "video";
            }
        }
        $post = new Post();
        $post->user_id = $user_id;
        $post->desc = $caption;
        $post->media = $fileName;
        $post->media_type = $media_type;
        $post->save();
        if($caption != ""){
            post_mention_notification($post->id,$user_id,$caption);
        }
        return redirect()->to(route('new_post'))->with('success','فایل با موفقیت آپلود شد.');

        /*return redirect()->to(route('new_post'))->with('error','فایل آپلود نشد.');*/
    }
    public function edit_post(Request $request)
    {
        // Validate the form data
        $user_id = Auth::id();
        $file = $request->file('filename');
        $caption = $request->input('caption');
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);
        if($post== null || $post->user_id != Auth::id()){
            return redirect()->back();
        }
        $media_type = "";
        if ($file != null){
            if (str_starts_with($file->getClientMimeType(), 'image')) {
                $media_type = "photo";
            } else {
                if (str_starts_with($file->getClientMimeType(), 'application/octet-stream')) {
                    $media_type = "video";
                }
            }
            if ($media_type == "photo" || $media_type == "video") {

                $fileName = time().rand(100000,99999999) . '_' . $file->getClientOriginalName();
                $file->storeAs('public/posts/', $fileName); // Store the file in the "uploads" directory

                $post->desc = $caption;
                $post->media = $fileName;
                $post->media_type = $media_type;
                $post->save();
                if($caption != ""){
                    post_mention_notification($post->id,$user_id,$caption);
                }
                return redirect()->to(route('home_page'))->with('success','فایل با موفقیت آپلود شد.');
            }
            return redirect()->back()->with('error','فایل آپلود نشد.');
        }
        else{
            $post->desc = $caption;
            $post->save();
            return redirect()->to(route('home_page'))->with('success','فایل با موفقیت آپلود شد.');
        }





    }
    public function delete_post($id){
        $post = Post::find($id);
        if($post== null || $post->user_id != Auth::id()){
            return redirect()->back();
        }
        $post->delete();
        return redirect()->back();
    }

    public function UplodePostMediaChunk(Request $request){

        $start = $request->input('start');
        $end = $request->input('end');
        $totalSize = $request->input('totalSize');
        $chunk = $request->file('file');
        $fileName = $request->input('tmp_file_name');
        $file_type = $request->input('file_type');

        $stream = fopen(Storage::path($fileName), 'c');
        fseek($stream, $start);
        fwrite($stream, file_get_contents($chunk));
        fclose($stream);

        if ($end >= $totalSize) {
            // آخرین قطعه فایل
            Storage::move($fileName, 'public/posts/' . $fileName);
        }

        return response()->json(['message' => 'Chunk uploaded successfully' , 'status'=>220,"filename"=>$fileName]);

    }
}
