<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\LiveStream;
use App\Models\Post;
use App\Models\LiveComment;
use Illuminate\Support\Facades\Log;


class LiveStreamController extends Controller
{
    public function getStreamDetails(Request $request): \Illuminate\Http\JsonResponse
    {
        $apiUrl = 'https://napi.arvancloud.ir/live/2.0/streams';
        $apiKey = 'ddc55834-4472-548a-b6e5-bf7bad56640e';

        $uniqueSlug = Str::slug('livestream' . Str::random(8));


        $data = [
            'title' => 'apitestapi',
            'slug' => $uniqueSlug,
            'mode' => 'push',
            'output_mode' => 'auto',
            'fps' => 30,

            "archive_enabled" => true,
            "archive_mode" => "auto",
            "channel_id" => "3dc687ce-43a4-4b1f-a1ce-f713541bab46",

            'type' => 'normal',
            'convert_info' => [
                [
                    'resolution' => [
                        'label' => '1080p',
                        'value' => 1080
                    ],
                    'resolution_width' => 1920,
                    'resolution_height' => 1080,
                    'video_bitrate' => '2000',
                    'audio_bitrate' => '320'
                ]
            ]
        ];



        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Apikey ' . $apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);


        if (!in_array($httpcode, [200, 201])) {
            return response()->json([
                'message' => 'Failed to fetch stream details',
                'status' => $httpcode,
                'response' => $response,
                'curl_error' => $curlError
            ], $httpcode);
        }

//        dd($response);

        $responseData = json_decode($response, true);

//        dd($responseData);


        if (!isset($responseData['data']) || !is_array($responseData['data'])) {
            return response()->json([
                'message' => 'Invalid response format',
                'response' => $responseData
            ], 500);
        }


        $streamDetails = $responseData['data'];


        // بررسی وجود کلیدها در داده‌ها
        $streamUrl = $streamDetails['input_url'] ?? 'N/A';
        $streamKey = $streamDetails['id'] ?? 'N/A';
        $status = $streamDetails['status'] ?? 'N/A';
        $liveUrl = $streamDetails['player_url'] ?? 'N/A';


//        dd($streamDetails);


        $userId = Auth::id();

//        dd($userId);
        try {
            // ذخیره اطلاعات پخش زنده در پایگاه داده
            $liveStream = LiveStream::create([
                'user_id' => $userId,
                'stream_url' => $streamUrl,
                'stream_key' => $streamKey,
                'status' => $status,
                'live_url' => $liveUrl,
            ]);


            $streamInfo = [
                'stream_url' => $liveStream->stream_url,
                'stream_key' => $liveStream->stream_key,
            ];

            return response()->json($streamInfo);


        } catch (\Exception $e) {
            return response()->json(['message' => 'Error saving data', 'error' => $e->getMessage()], 500);
        }
    }

    public function startRecording(Request $request)
    {
        // دریافت آخرین پخش زنده
        $lastStream = LiveStream::latest()->first();
        $streamId = $lastStream->stream_key;

//        $streamId = "860ba52e-7d7d-4b76-9409-a7f6122231e6";
        // ساخت URL برای درخواست
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
            return response()->json([
                'message' => 'Failed to fetch stream details',
                'status' => $httpcode,
                'response' => $response,
                'curl_error' => $curlError
            ], $httpcode);
        }

        // پردازش داده‌های پاسخ
        $responseData = json_decode($response, true);

        if (!isset($responseData['data'])) {
            return response()->json([
                'message' => 'Invalid response format',
                'response' => $responseData
            ], 500);
        }

        $streamDetails = $responseData['data'];
//        $status = $streamDetails['status'] ?? 'N/A';
        $liveUrl = $streamDetails['player_url'] ?? 'N/A';

        // به‌روزرسانی پایگاه داده با وضعیت و لینک جدید
        LiveStream::where('stream_key', $streamId)->update([
            'status' => "live",
            'live_url' => $liveUrl,
        ]);

        return response()->json(['message' => 'Recording started successfully']);
    }

    public function stopRecording(Request $request)
    {

        $lastStream = LiveStream::latest()->first();
        $streamId = $lastStream->stream_key;


        LiveStream::where('stream_key', $streamId)->update([
            'status' => "finished",
        ]);

        arvanCloudDeleteSpecifiedStreamdelete($streamId);

        return response()->json(['message' => 'Recording stopped successfully']);
    }

    public function saveArchive(Request $request)
    {

//        Log::error('test');
//
//        die('tesst');
        // آدرس API برای دریافت ویدیوهای کانال
        $apiUrl = 'https://napi.arvancloud.ir/vod/2.0/channels/3dc687ce-43a4-4b1f-a1ce-f713541bab46/videos';
        $apiKey = 'ddc55834-4472-548a-b6e5-bf7bad56640e'; // API key شما

        // راه‌اندازی cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true); // درخواست GET
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Apikey ' . $apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        // دریافت پاسخ API
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // بررسی کد وضعیت پاسخ
        if ($httpcode !== 200) {
            Log::error('Failed to fetch video details', [
                'status' => $httpcode,
                'response' => $response,
                'curl_error' => $curlError
            ]);
            return response()->json([
                'message' => 'Failed to fetch video details',
                'status' => $httpcode
            ], $httpcode);
        }

        // تبدیل پاسخ JSON به آرایه
        $responseData = json_decode($response, true);

        // بررسی داده‌ها
        if (!isset($responseData['data']) || !is_array($responseData['data']) || empty($responseData['data'])) {
            Log::error('Invalid response format', [
                'response' => $responseData
            ]);
            return response()->json([
                'message' => 'Invalid response format'
            ], 500);
        }

        // دریافت شناسه کاربر
        $userId = Auth::id();

        try {
            // برای هر ویدیو در لیست
            foreach ($responseData['data'] as $video) {
                $videoUrl = $video['video_url'] ?? null; // لینک پخش ویدیو
                if (!$videoUrl) {
                    continue; // اگر ویدیویی لینک نداشت، از آن بگذریم
                }

                // بررسی وجود ویدیو در جدول پست‌ها بر اساس media (لینک ویدیو)
                $existingPost = Post::where('media', $videoUrl)->first();

                // اگر پست موجود نبود، ایجاد پست جدید
                if (!$existingPost) {
                    $post = new Post();
                    $post->user_id = $userId;
                    $post->desc = 'این یک پست از آرشیو لایو است'; // توضیحات پست
                    $post->media = $videoUrl; // لینک ویدیو
                    $post->media_type = 'link'; // نوع رسانه
                    $post->save();
                }
            }

            return response()->json(['message' => 'آرشیو ویدیوها بررسی و ذخیره شد.']);
        } catch (\Exception $e) {
            Log::error('Error saving video archive', [
                'error' => $e->getMessage()
            ]);
            return response()->json(['message' => 'خطا در ذخیره آرشیو به عنوان پست'], 500);
        }
    }

    public function showStream()
    {

        $id = $_GET['id'];

        $live = LiveStream::findOrFail($id);

        $url = $live->checkStreamUrl();

        $decodedUrl = urldecode($url);

//        die($decodedUrl);

        // برای مثال، در اینجا می‌توانید بررسی کنید که آیا این استریم در دیتابیس وجود دارد
        $liveStream = LiveStream::where('live_url', $decodedUrl)->firstOrFail();

//        die($liveStream);

        $liveStream->increment('views');


        return view('front.site.live_stream', compact('decodedUrl','liveStream'));
    }

    public function storeComment(Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required|string',
            'live_stream_id' => 'required|exists:live_streams,id',
        ]);

        LiveComment::create([
            'user_id' => auth()->id(),
            'live_stream_id' => $validatedData['live_stream_id'],
            'comment' => $validatedData['comment'],
        ]);

        return response()->json(['status' => 'success']);
    }

    // متد برای دریافت کامنت‌ها
    public function getComments($liveStreamId)
    {
        // دریافت کامنت‌های مرتبط با لایو استریم مشخص شده
        $comments = LiveComment::where('live_stream_id', $liveStreamId)
            ->with('user') // دریافت اطلاعات کاربر
            ->latest() // کامنت‌های جدیدتر ابتدا نمایش داده شوند
            ->limit(10) // فقط ۱۰ کامنت آخر دریافت شوند
            ->get();

        return response()->json([
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'user' => [
                        'username_with_blue_tick' => $comment->user->username_with_blue_tick, // تیک آبی در اینجا اضافه می‌شود
                        'profile' => $comment->user->profile,
                    ],
                ];
            }),
        ]);
    }

    public function getViews($liveStreamId)
    {

        $liveStream = LiveStream::findOrFail($liveStreamId);
        return response()->json(['views' => $liveStream->views]);
    }

    public function decreaseViews($liveStreamId)
    {
        $liveStream = LiveStream::find($liveStreamId);
        if ($liveStream) {
            $liveStream->decrement('views'); // کاهش تعداد بازدیدها
        }

        return response()->json(['message' => 'View decreased']);
    }

    public function getIdByStreamKey($stream_key) {
        $liveStream = LiveStream::where('stream_key', $stream_key)->first();
        if ($liveStream) {
            return response()->json(['id' => $liveStream->id]);
        }
        return response()->json(['error' => 'Live stream not found'], 404);
    }


    public function toggleComments(Request $request, $id)
    {
        $liveStream = LiveStream::findOrFail($id);
        $liveStream->comments_status = $request->input('status');
        $liveStream->save();

        return response()->json(['status' => 'success']);
    }


    public function getCommentsStatus($id)
    {
        $liveStream = LiveStream::findOrFail($id);

        return response()->json(['status' => $liveStream->comments_status]);
    }

}
