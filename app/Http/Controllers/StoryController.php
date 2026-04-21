<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with('user')->where('expires_at', '>', now())->latest()->get();

        return view('stories.index', [
            'stories' => $stories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => ['nullable', 'string', 'max:240'],
            'media' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp,mp4,mov,webm', 'max:51200'],
        ]);

        $path = Storage::disk('public')->putFile('stories', $request->file('media'));

        Story::create([
            'user_id' => Auth::id(),
            'caption' => $data['caption'] ?? '',
            'media_path' => $path,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        return redirect()->route('stories.index')->with('status', 'Story shared for the next 24 hours.');
    }
}
