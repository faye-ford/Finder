<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Location;
use App\Models\Post;
use App\Models\Report;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    protected function authorizeAdmin()
    {
        if (! Auth::check() || ! Auth::user()->is_admin) {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $userSearch = $request->query('user_search');
        $postSearch = $request->query('post_search');

        $users = User::withCount(['posts', 'comments'])
            ->when($userSearch, fn ($query) => $query->where(function ($query) use ($userSearch) {
                $query->where('name', 'like', "%{$userSearch}%")
                    ->orWhere('email', 'like', "%{$userSearch}%");
            }))
            ->orderBy('created_at', 'desc')
            ->get();

        $posts = Post::with(['user', 'category', 'managedLocation'])
            ->withCount('reports')
            ->when($postSearch, fn ($query) => $query->where(function ($query) use ($postSearch) {
                $query->where('destination', 'like', "%{$postSearch}%")
                    ->orWhere('location', 'like', "%{$postSearch}%");
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $reports = Report::with(['user', 'post.user'])->where('status', 'pending')->latest()->get();
        
        // Get comments from reported posts - show comments from posts that have reports
        $reportedPostIds = Report::where('status', 'pending')->pluck('post_id')->unique();
        $comments = Comment::with(['user', 'post'])
            ->whereHas('post', fn ($query) => $query->whereIn('id', $reportedPostIds))
            ->latest()
            ->limit(10)
            ->get();
        
        // If no reported comments found, show empty
        if ($comments->isEmpty()) {
            $comments = collect([]);
        }
        
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $totalUsers = User::count();
        $totalPosts = Post::count();
        $reportedPosts = Report::where('status', 'pending')->count();
        $activeUsers = User::whereHas('posts', fn ($query) => $query->where('created_at', '>=', now()->subDays(30)))
            ->orWhereHas('comments', fn ($query) => $query->where('created_at', '>=', now()->subDays(30)))
            ->distinct()
            ->count();

        return view('admin.index', compact(
            'users',
            'posts',
            'reports',
            'comments',
            'categories',
            'locations',
            'settings',
            'totalUsers',
            'totalPosts',
            'reportedPosts',
            'activeUsers',
            'userSearch',
            'postSearch'
        ));
    }

    public function banUser(User $user)
    {
        $this->authorizeAdmin();

        if ($user->id === Auth::id()) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'You cannot ban yourself.'], 422);
            }
            return back()->with('error', 'You cannot ban yourself.');
        }

        $user->update(['banned_at' => now()]);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'User has been banned.']);
        }

        return back()->with('status', 'User has been banned.');
    }

    public function unbanUser(User $user)
    {
        $this->authorizeAdmin();

        $user->update(['banned_at' => null]);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'User has been unbanned.']);
        }

        return back()->with('status', 'User has been unbanned.');
    }

    public function destroyUser(User $user)
    {
        $this->authorizeAdmin();

        if ($user->id === Auth::id()) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'You cannot delete your own account.'], 422);
            }
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'User account deleted.', 'removed' => true, 'elementId' => 'user-' . $user->id]);
        }

        return back()->with('status', 'User account deleted.');
    }

    public function hidePost(Post $post)
    {
        $this->authorizeAdmin();

        $post->update(['is_hidden' => true]);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Post has been hidden from the public feed.']);
        }

        return back()->with('status', 'Post has been hidden from the public feed.');
    }

    public function approvePost(Post $post)
    {
        $this->authorizeAdmin();

        $post->update(['is_approved' => true]);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Post has been approved.']);
        }

        return back()->with('status', 'Post has been approved.');
    }

    public function togglePostComments(Post $post)
    {
        $this->authorizeAdmin();

        $post->update(['comments_enabled' => ! $post->comments_enabled]);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Comment status updated.']);
        }

        return back()->with('status', 'Comment status updated.');
    }

    public function resolveReport(Report $report)
    {
        $this->authorizeAdmin();

        $report->update(['status' => 'resolved']);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Report marked as resolved.', 'removed' => true, 'elementId' => 'report-' . $report->id]);
        }

        return back()->with('status', 'Report marked as resolved.');
    }

    public function deleteReportedPost(Report $report)
    {
        $this->authorizeAdmin();

        $post = $report->post;

        if ($post) {
            if (! empty($post->media) && is_array($post->media)) {
                Storage::disk('public')->delete($post->media);
            }
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $post->delete();
        }

        $report->update(['status' => 'resolved']);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Reported post deleted.', 'removed' => true, 'elementId' => 'report-' . $report->id]);
        }

        return back()->with('status', 'Reported post deleted.');
    }

    public function banReportedUser(Report $report)
    {
        $this->authorizeAdmin();

        $post = $report->post;

        if ($post && $post->user_id !== Auth::id()) {
            $post->user->update(['banned_at' => now()]);
        }

        $report->update(['status' => 'resolved']);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'User has been banned and report resolved.']);
        }

        return back()->with('status', 'User has been banned and report resolved.');
    }

    public function destroyComment(Comment $comment)
    {
        $this->authorizeAdmin();

        $comment->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Comment deleted.',
                'removed' => true,
                'elementId' => 'comment-' . $comment->id
            ]);
        }

        return back()->with('status', 'Comment deleted.');
    }

    public function storeCategory(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:categories,name'],
        ]);

        Category::create([
            'name' => $data['name'],
            'slug' => str()->slug($data['name']),
        ]);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Category added.', 'reload' => true]);
        }

        return back()->with('status', 'Category added.');
    }

    public function destroyCategory(Category $category)
    {
        $this->authorizeAdmin();

        $category->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Category removed.', 'removed' => true, 'elementId' => 'category-' . $category->id]);
        }

        return back()->with('status', 'Category removed.');
    }

    public function storeLocation(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:locations,name'],
        ]);

        Location::create([
            'name' => $data['name'],
            'slug' => str()->slug($data['name']),
        ]);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Location added.', 'reload' => true]);
        }

        return back()->with('status', 'Location added.');
    }

    public function destroyLocation(Location $location)
    {
        $this->authorizeAdmin();

        $location->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Location removed.', 'removed' => true, 'elementId' => 'location-' . $location->id]);
        }

        return back()->with('status', 'Location removed.');
    }

    public function storeAnnouncement(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'body' => ['required', 'string', 'max:1000'],
            'active' => ['sometimes', 'boolean'],
        ]);

        Announcement::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'active' => $data['active'] ?? true,
        ]);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Announcement published.', 'reload' => true]);
        }

        return back()->with('status', 'Announcement published.');
    }

    public function destroyAnnouncement(Announcement $announcement)
    {
        $this->authorizeAdmin();

        $announcement->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Announcement removed.',
                'removed' => true,
                'elementId' => 'announcement-' . $announcement->id,
                'reload' => true
            ]);
        }

        return back()->with('status', 'Announcement removed.');
    }

    public function announcementsPage(Request $request)
    {
        $this->authorizeAdmin();

        $search = $request->query('search');
        
        $announcements = Announcement::when($search, fn ($query) => $query->where(function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%");
        }))
        ->latest()
        ->paginate(20)
        ->withQueryString();

        return view('admin.announcements', compact('announcements', 'search'));
    }

    public function updateSettings(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'website_name' => ['required', 'string', 'max:120'],
            'logo_url' => ['nullable', 'url'],
            'theme_color' => ['nullable', 'string', 'max:20'],
            'approval_required' => ['nullable', 'boolean'],
            'maintenance_mode' => ['nullable', 'boolean'],
        ]);

        Setting::setValue('website_name', $data['website_name']);
        Setting::setValue('logo_url', $data['logo_url'] ?? '');
        Setting::setValue('theme_color', $data['theme_color'] ?? 'rose');
        Setting::setValue('approval_required', $data['approval_required'] ? 'true' : 'false');
        Setting::setValue('maintenance_mode', $data['maintenance_mode'] ? 'true' : 'false');

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Site settings saved.']);
        }

        return back()->with('status', 'Site settings saved.');
    }

    public function destroyPost(Post $post)
    {
        $this->authorizeAdmin();

        if (! empty($post->media) && is_array($post->media)) {
            Storage::disk('public')->delete($post->media);
        }

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Post deleted permanently.', 'removed' => true, 'elementId' => 'post-' . $post->id]);
        }

        return back()->with('status', 'Post deleted permanently.');
    }
}
