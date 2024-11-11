<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\Notif;
use App\Models\User;
use App\Models\FollowRequest;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function followUser(Request $request)
    {
        try {
            $userId = Auth::id();
            $followedId = $request->input('user_id');

            $followedUser = User::findOrFail($followedId);


            $existingFollow = Follow::where('user_id', $userId)
                ->where('followed_id', $followedId)
                ->first();

            if ($followedUser->account_type === 'private') {

                $existingRequest = FollowRequest::where('user_id', $userId)
                    ->where('followed_id', $followedId)
                    ->first();

                if ($existingRequest) {
                    // پاک کردن درخواست قبلی
                    $existingRequest->delete();

                    return response()->json(['status' => 'unfollowed']);
                }

                if ($existingFollow) {
                    // لغو فالو
                    $existingFollow->delete();

                    Notif::create([
                        'user_id' => $followedId,
                        'owner_id' => $userId,
                        'action' => 'لغو دنبال',
                        'desc' => 'کاربر ' . auth()->user()->username . ' فالو شما را لغو کرد.',
                        'notifiable_type' => Follow::class,
                        'notifiable_id' => $existingFollow->id,
                    ]);

                    return response()->json(['status' => 'unfollowed']);
                } else {
                    // ثبت درخواست فالو
                    $followRequest = FollowRequest::create([
                        'user_id' => $userId,
                        'followed_id' => $followedId,
                    ]);

                    Notif::create([
                        'user_id' => $followedId,
                        'owner_id' => $userId,
                        'action' => 'درخواست فالو',
                        'desc' => 'کاربر ' . auth()->user()->username . ' درخواست دنبال کردن شما را ارسال کرد.',
                        'notifiable_type' => FollowRequest::class,
                        'notifiable_id' => $followRequest->id,
                    ]);

                    return response()->json(['status' => 'request_sent']);
                }
            }  else {
                // در صورتی که اکانت عمومی باشد، فالو مستقیم انجام شود
                $existingFollow = Follow::where('user_id', $userId)
                    ->where('followed_id', $followedId)
                    ->first();

                if ($existingFollow) {
                    // لغو فالو
                    $existingFollow->delete();

                    Notif::create([
                        'user_id' => $followedId, // کاربر فالو شده
                        'owner_id' => $userId, // کاربر فالو کننده
                        'action' => 'لغو دنبال',
                        'desc' => 'کاربر ' . auth()->user()->username . ' فالو شما را لغو کرد.',
                        'notifiable_type' => Follow::class,
                        'notifiable_id' => $existingFollow->id,
                    ]);

                    return response()->json(['status' => 'unfollowed']);
                } else {
                    // فالو مستقیم
                    $follow = Follow::create([
                        'user_id' => $userId,
                        'followed_id' => $followedId,
                    ]);

                    Notif::create([
                        'user_id' => $followedId,
                        'owner_id' => $userId,
                        'action' => 'دنبال کرد',
                        'desc' => 'کاربر ' . auth()->user()->username . ' شما را دنبال کرد.',
                        'notifiable_type' => Follow::class,
                        'notifiable_id' => $follow->id,
                    ]);

                    return response()->json(['status' => 'followed']);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Follow Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function manageFollowRequests()
    {
        $userId = Auth::id();
        $followRequests = FollowRequest::where('followed_id', $userId)->get();

        return view('front.site.requests', compact('followRequests'));
    }

    public function respondToRequest(Request $request)
    {
        $followRequest = FollowRequest::findOrFail($request->input('request_id'));

        if ($request->input('action') === 'accept') {
            // قبول کردن درخواست
            Follow::create([
                'user_id' => $followRequest->user_id,
                'followed_id' => $followRequest->followed_id,
            ]);

            // حذف درخواست پس از قبول
            $followRequest->delete();

            return redirect()->route('follow.requests')->with('status', 'درخواست دنبال کردن قبول شد.');
        } else {
            // رد کردن درخواست
            $followRequest->delete();

            return redirect()->route('follow.requests')->with('status', 'درخواست دنبال کردن رد شد.');
        }
    }

}
