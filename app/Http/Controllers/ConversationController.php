<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ConversationController extends Controller

{
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        // جستجوی کاربران که شامل کاربر لاگین شده نباشد
        $users = User::where('username', 'like', '%' . $query . '%')
            ->where('id', '!=', auth()->id())  // حذف کاربر لاگین شده
            ->get();

        // ارسال لیست کاربران به صورت JSON
        return response()->json([
            'users' => $users->map(function ($user) {
                // اضافه کردن تیک آبی به صورت HTML
                $blueTickHtml = $user->blue_tick ? '<img style="width: 20px; height: 20px; margin: 3px; margin-bottom: 5px; vertical-align: middle;" src="' . asset('img/duo-icons_approved-1.svg') . '">' : '';
                return [
                    'id' => $user->id,                // اضافه کردن id
                    'username' => $user->username,
                    'blue_tick' => $blueTickHtml,
                    'profile' => $user->profile,
                ];
            }),
        ]);
    }


    public function index()
    {
        $user = auth()->user();
        $conversations = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->get();

        // دریافت لیست کاربران به جز کاربر لاگین شده
        $users = User::where('id', '!=', $user->id)->get();
        // $users = $user->followedUsers()->get();

        return view('conversations.index', compact('conversations', 'users'));
    }

    public function show($id)
    {
        $user = auth()->user();

        // پیدا کردن مکالمه
        $conversation = Conversation::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('user_one_id', $user->id)
                    ->orWhere('user_two_id', $user->id);
            })
            ->firstOrFail();

        // دریافت پیام‌های مکالمه
        $messages = $conversation->messages()->orderBy('created_at')->get();

        return view('conversations.show', compact('conversation', 'messages'));
    }

    public function showOrCreate($userId)
    {
        $user = auth()->user();

        // بررسی اینکه userId مقدار معتبری دارد
        if (empty($userId) || !is_numeric($userId)) {
            return back()->withErrors('User ID is invalid.');
        }

        // پیدا کردن یا ایجاد مکالمه
        $conversation = Conversation::where(function ($query) use ($user, $userId) {
            $query->where('user_one_id', $user->id)
                ->where('user_two_id', $userId);
        })->orWhere(function ($query) use ($user, $userId) {
            $query->where('user_one_id', $userId)
                ->where('user_two_id', $user->id);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $user->id,
                'user_two_id' => $userId,
            ]);
        }

        return redirect()->route('conversations.show', $conversation->id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $user = auth()->user();

        // پیدا کردن یا ایجاد مکالمه
        $conversation = Conversation::where(function ($query) use ($user, $validated) {
            $query->where('user_one_id', $user->id)
                ->where('user_two_id', $validated['receiver_id']);
        })->orWhere(function ($query) use ($user, $validated) {
            $query->where('user_one_id', $validated['receiver_id'])
                ->where('user_two_id', $user->id);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $user->id,
                'user_two_id' => $validated['receiver_id'],
            ]);
        }

        // ذخیره پیام جدید
        $message = $conversation->messages()->create([
            'user_id' => $user->id, // فرستنده پیام
            'message' => $validated['message'],
        ]);

        return redirect()->route('conversations.show', $conversation->id);
    }

    public function sendPostLinkToDirect(Request $request, $userId)
    {
        // اعتبارسنجی داده‌ها
        $request->validate([
            'post_link' => 'required|url',
        ]);

        try {
            // بازیابی کاربر گیرنده
            $receiver = User::findOrFail($userId);

            // جستجوی مکالمه بین کاربر فرستنده و گیرنده
            $conversation = Conversation::where(function($query) use ($userId) {
                $query->where('user_one_id', auth()->id())
                    ->where('user_two_id', $userId);
            })->orWhere(function($query) use ($userId) {
                $query->where('user_one_id', $userId)
                    ->where('user_two_id', auth()->id());
            })->first();

            // اگر مکالمه وجود نداشت، یک مکالمه جدید ایجاد کنید
            if (!$conversation) {
                $conversation = Conversation::create([
                    'user_one_id' => auth()->id(),
                    'user_two_id' => $receiver->id,
                ]);
            }

            $mediaUrl = '';

            if ($request->media_type == "photo" || $request->media_type == "video" || $request->media_type == "video/quicktime") {
                $mediaUrl = url('storage/posts/' . $request->media);
            }else
            {
                $mediaUrl = $request->media;
            }


            $postId = '#post_' . $request->id;


            // بر اساس نوع مدیا، تگ HTML مناسب را تنظیم کنید
            $mediaTag = '';
            if ($request->media_type === 'photo') {
                $mediaTag = '<a href="' . htmlspecialchars($request->post_link.$postId, ENT_QUOTES, 'UTF-8') . '"><img style="width: 150px;" src="' . htmlspecialchars($mediaUrl, ENT_QUOTES, 'UTF-8') . '" alt=""></a>';
            } elseif ($request->media_type === 'video' || $request->media_type === 'video/quicktime') {
                $mediaTag = '<a href="' . htmlspecialchars($request->post_link.$postId, ENT_QUOTES, 'UTF-8') . '"><video playsinline style="width: 150px;" preload="auto"    src="' . htmlspecialchars($mediaUrl, ENT_QUOTES, 'UTF-8') . '" type="video/mp4"></video></a>';
            } elseif ($request->media_type === 'link') {
                $mediaTag = '<a href="' . htmlspecialchars($request->post_link.$postId, ENT_QUOTES, 'UTF-8') . '"><video playsinline style="width: 150px;" preload="auto" autoplay="false" muted   src="' . htmlspecialchars($mediaUrl, ENT_QUOTES, 'UTF-8') . '" type="video/mp4"></video></a>';
            }

            // ایجاد پیام جدید شامل لینک
            $message = new Message();
            $message->conversation_id = $conversation->id;
            $message->user_id = auth()->id(); // فرستنده پیام
            $message->message = $mediaTag;
            $message->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to send post link.'], 500);
        }
    }
}

