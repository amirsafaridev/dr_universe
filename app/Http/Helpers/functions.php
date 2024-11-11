<?php

use App\Models\Like;
use App\Models\LiveStream;
use App\Models\Save;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

function isAdmin(): bool
{
    $user=Auth::user();
    $role=$user->role;
    if($role== "admin"){
        return true;
    }
    return false;
}


function isUsername($string){
    $string=str_replace('@','',$string);
    $count=User::where('username',$string)->count();
    if($count > 0){
        return true;
    }
    return false;
}

function isLikedByUser($post_id): bool
{
    $user_id=Auth::id();
    $like = Like::where('user_id', $user_id)->where('likeable_id', $post_id)->count();
    if($like > 0){
        return true;
    }
    return false;
}

function isSavedByUser($post_id): bool
{
    $user_id=Auth::id();
    $save = Save::where('user_id', $user_id)->where('savable_id', $post_id)->count();
    if($save > 0){
        return true;
    }
    return false;
}

function managePostDescHashtagsAndMentions($string){
    $input = $string;
    ////////////////////mentions/////////////
    preg_match_all('/@(.+?)\b/', $input, $output_array);
    foreach ($output_array[0] as $key=>$value) {

            $new_text= '<a href="'.route("profile_page",["username"=>$output_array[1][$key]]).'" class="arta_mentions">'.$value.'</a>';
            $string = str_replace($value,$new_text,$string);
    }

    ////////////hashtag////////////
    preg_match_all('/#(.+?)\b/u', $string, $output_array,PREG_SET_ORDER, 0);
    foreach ($output_array as $output) {

        $new_text= '<a href="'.route("hashtag_page",["hashtag"=>$output[1]]).'" class="arta_hashtags">'.$output[0].'</a>';
        $string = str_replace($output[0],$new_text,$string);
    }
    return nl2br($string);
}

function arvanCloudGetSpecifiedStream($streamId)
{
    $apiUrl = "https://napi.arvancloud.ir/live/2.0/streams/{$streamId}";
    $apiKey = 'ddc55834-4472-548a-b6e5-bf7bad56640e';

    // راه‌اندازی cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true); // تغییر به GET
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Apikey ' . $apiKey,
        'Content-Type: application/json',
        'Accept: application/json',
    ]);

    // ارسال درخواست و دریافت پاسخ
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);


    // بررسی کد وضعیت پاسخ
    if ($httpcode !== 200) {
        return '';
    }

    // پردازش داده‌های پاسخ
    $responseData = json_decode($response, true);

    if (!isset($responseData['data'])) {
        return '';
    }

   return $responseData['data'];
}

function arvanCloudDeleteSpecifiedStreamdelete($streamId)
{
    $apiUrl = "https://napi.arvancloud.ir/live/2.0/streams/$streamId";
    $apiKey = 'ddc55834-4472-548a-b6e5-bf7bad56640e';

    // راه‌اندازی cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // تغییر به DELETE
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Apikey ' . $apiKey,
        'Content-Type: application/json',
        'Accept: application/json',
    ]);

    // ارسال درخواست و دریافت پاسخ
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    // بررسی کد وضعیت پاسخ
    if ($httpcode !== 200) {
        return '';
    }

    return $response;
}
