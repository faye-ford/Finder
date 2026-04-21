<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Report;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'destination' => ['required', 'string', 'max:120'],
            'location' => ['required', 'string', 'max:120'],
            'activities' => ['required', 'string', 'max:255'],
            'caption' => ['required', 'string', 'max:600'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:10240'],
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'destination' => $data['destination'],
            'location' => $data['location'],
            'activities' => $data['activities'],
            'caption' => $data['caption'],
            'image_path' => null,
            'media' => [],
            'is_approved' => Setting::getValue('approval_required', 'false') === 'true' ? false : true,
            'likes_count' => 0,
            'share_count' => 0,
        ]);

        // Save images to post_images table
        foreach ($request->file('images') as $index => $file) {
            $imagePath = Storage::disk('public')->putFile('posts', $file);
            PostImage::create([
                'post_id' => $post->id,
                'image_path' => $imagePath,
                'order' => $index,
            ]);
        }

        // Set primary image
        $firstImage = $post->images()->first();
        if ($firstImage) {
            $post->update(['image_path' => $firstImage->image_path]);
        }

        return Redirect::route('home')->with('status', 'Your destination has been shared successfully.');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id() && ! Auth::user()->is_admin) {
            abort(403);
        }

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id() && ! Auth::user()->is_admin) {
            abort(403);
        }

        $data = $request->validate([
            'destination' => ['required', 'string', 'max:120'],
            'location' => ['required', 'string', 'max:120'],
            'activities' => ['required', 'string', 'max:255'],
            'caption' => ['required', 'string', 'max:600'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:10240'],
        ]);

        $post->update([
            'destination' => $data['destination'],
            'location' => $data['location'],
            'activities' => $data['activities'],
            'caption' => $data['caption'],
        ]);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            $post->images()->delete();

            // Save new images
            foreach ($request->file('images') as $index => $file) {
                $imagePath = Storage::disk('public')->putFile('posts', $file);
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $imagePath,
                    'order' => $index,
                ]);
            }

            // Update primary image
            $firstImage = $post->images()->first();
            if ($firstImage) {
                $post->update(['image_path' => $firstImage->image_path]);
            }
        }

        return Redirect::route('profile.show', ['user' => Auth::user()->id])->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id() && ! Auth::user()->is_admin) {
            abort(403);
        }

        // Delete all images
        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $post->images()->delete();

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return Redirect::back()->with('status', 'Post removed from the feed.');
    }

    public function like(Post $post)
    {
        $userId = Auth::id();
        $existing = $post->likes()->where('user_id', $userId)->first();

        if ($existing) {
            $existing->delete();
            $post->decrement('likes_count');
        } else {
            Like::create(['user_id' => $userId, 'post_id' => $post->id]);
            $post->increment('likes_count');

            if ($post->user_id !== $userId) {
                Notification::create([
                    'user_id' => $post->user_id,
                    'message' => Auth::user()->name . ' liked your destination.',
                ]);
            }
        }

        return Redirect::back();
    }

    public function share(Post $post)
    {
        $post->increment('share_count');

        if ($post->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'message' => Auth::user()->name . ' shared your destination.',
            ]);
        }

        return Redirect::back()->with('status', 'Destination shared with your community.');
    }

    public function bookmark(Post $post)
    {
        $existing = $post->bookmarks()->where('user_id', Auth::id())->first();

        if ($existing) {
            $existing->delete();
            return Redirect::back()->with('status', 'Destination removed from your Travel List.');
        }

        $post->bookmarks()->create(['user_id' => Auth::id()]);

        return Redirect::back()->with('status', 'Destination saved to your Travel List.');
    }

    public function review(Request $request, Post $post)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'body' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ], [
            'rating' => $data['rating'],
            'body' => $data['body'] ?? '',
        ]);

        if ($post->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'message' => Auth::user()->name . ' rated your destination.',
            ]);
        }

        return Redirect::back()->with('status', 'Review saved.');
    }

    public function comment(Request $request, Post $post)
    {
        $data = $request->validate([
            'comment' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) > 1000) {
                        $fail('The ' . $attribute . ' may not be greater than 1000 words.');
                    }
                },
            ],
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'body' => $data['comment'],
        ]);

        if ($post->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'message' => Auth::user()->name . ' left a comment on your destination.',
            ]);
        }

        return Redirect::back()->with('status', 'Comment added.');
    }

    public function report(Request $request, Post $post)
    {
        $data = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        Report::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'reason' => $data['reason'] ?? 'Inappropriate content',
            'status' => 'pending',
        ]);

        return Redirect::back()->with('status', 'This post has been reported to the admin team.');
    }
}
