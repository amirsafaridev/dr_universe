<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $query = Comment::with('user');

        // بررسی وضعیت فیلتر
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            $query = $query->where('status', $status);
        }

        // استفاده از paginate به جای get
        $comments = $query->paginate(20); // 10 کامنت در هر صفحه

        return view('admin.comments.index', compact('comments'));
    }


    /**
     * Approve the specified comment.
     */
    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 1; // 1 = تایید شده
        $comment->save();

        return redirect()->back()->with('success', 'کامنت تایید شد.');
    }

    /**
     * Reject the specified comment.
     */
    public function reject($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = 2; // 2 = رد شده
        $comment->save();

        return redirect()->back()->with('success', 'کامنت رد شد.');
    }
}
