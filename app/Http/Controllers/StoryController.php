<?php

namespace App\Http\Controllers;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function getUserStories($userId)
    {
        $stories = Story::where('user_id', $userId)->get();

        return response()->json($stories);
    }

    public function incrementView($id)
    {
        $story = Story::findOrFail($id);
        $story->increment('views'); // افزایش تعداد ویوها
        return response()->json(['success' => true]);
    }


    public function index()
    {
        $stories = Story::where('expired_at', '>', now())->get()->groupBy('user_id');

        return view('stories.index', compact('stories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $filePath = $request->file('file')->store('stories', 'public');

        $fileType = explode('/', $request->file('file')->getMimeType())[0]; // تعیین نوع فایل (image یا video)

        Story::create([
            'user_id' => auth()->id(),
            'type' => $fileType,
            'file_path' => $filePath,
            'expired_at' => now()->addDay(), // استوری بعد از 24 ساعت منقضی می‌شود
        ]);

        return redirect()->back()->with('success', 'Story created successfully.');
    }

}

