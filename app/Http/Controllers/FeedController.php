<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $location = $request->query('location');

        $posts = Post::with(['user', 'comments.user', 'category', 'managedLocation'])
            ->withCount(['comments', 'likes'])
            ->visible()
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('location', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%")
                    ->orWhere('activities', 'like', "%{$search}%");
            }))
            ->when($category, fn ($query) => $query->whereHas('category', fn ($query) => $query->where('slug', $category)))
            ->when($location, fn ($query) => $query->whereHas('managedLocation', fn ($query) => $query->where('slug', $location)))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('feed.home', [
            'posts' => $posts,
            'search' => $search,
            'category' => $category,
            'location' => $location,
            'categories' => Category::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
        ]);
    }

    public function latest(Request $request)
    {
        $after = $request->query('after', Carbon::now()->subMinutes(10)->toDateTimeString());
        $after = Carbon::parse($after)->toDateTimeString();

        $posts = Post::with('user')
            ->visible()
            ->where('created_at', '>', $after)
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'count' => $posts->count(),
            'after' => $posts->first()?->created_at?->toDateTimeString(),
        ]);
    }

    public function explore(Request $request)
    {
        $topic = $request->query('topic');

        $posts = Post::with(['user', 'comments.user', 'category', 'managedLocation'])
            ->withCount(['comments', 'likes'])
            ->visible()
            ->when($topic, function ($query, $topic) {
                $topic = strtolower($topic);

                if (in_array($topic, ['beach', 'mountains', 'food'])) {
                    $query->where(function ($query) use ($topic) {
                        $query->where('activities', 'like', "%{$topic}%")
                            ->orWhere('destination', 'like', "%{$topic}%")
                            ->orWhere('location', 'like', "%{$topic}%");
                    });
                }
            })
            ->inRandomOrder()
            ->paginate(8)
            ->withQueryString();

        return view('explore.index', [
            'posts' => $posts,
            'topic' => $topic,
            'categories' => Category::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
        ]);
    }
}
