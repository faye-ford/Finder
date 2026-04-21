<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()->withCount('comments')->latest()->get();
        $savedPosts = $user->savedPosts()->withCount('likes')->latest()->get();
        $notifications = $user->notifications()->latest()->get();

        return view('profile.show', [
            'profile' => $user,
            'posts' => $posts,
            'savedPosts' => $savedPosts,
            'notifications' => $notifications,
        ]);
    }

    public function follow(User $user)
    {
        if (Auth::id() === $user->id) {
            return back();
        }

        Auth::user()->following()->syncWithoutDetaching([$user->id]);

        return back()->with('status', 'You are now following ' . $user->name . '.');
    }

    public function unfollow(User $user)
    {
        Auth::user()->following()->detach($user->id);

        return back()->with('status', 'You have unfollowed ' . $user->name . '.');
    }

    public function travelList()
    {
        $posts = Auth::user()->savedPosts()->with(['user', 'comments.user'])->withCount(['likes', 'comments'])->latest()->get();

        return view('profile.travel-list', [
            'posts' => $posts,
        ]);
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()->latest()->get();

        return view('profile.show', [
            'profile' => Auth::user(),
            'posts' => Auth::user()->posts()->latest()->get(),
            'notifications' => $notifications,
            'showNotifications' => true,
        ]);
    }

    public function markNotificationRead(Request $request, $notificationId)
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->update(['is_read' => true]);

        return back();
    }
}
