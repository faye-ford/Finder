@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl space-y-8 pb-24 pt-8">
    <!-- Admin Panel Header -->
    <div class="rounded-3xl border-2 border-purple-500/30 bg-gradient-to-r from-purple-600 via-violet-600 to-purple-600 p-8 shadow-2xl shadow-purple-500/20">
        <div class="flex items-center justify-between">
            <div>
                <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-white"></span>
                    <span class="text-sm font-medium text-white">ADMIN PANEL</span>
                </div>
                <h1 class="text-3xl font-bold text-white">Dashboard</h1>
                <p class="mt-2 text-purple-100">Manage users, posts, reports, and platform settings</p>
            </div>
            <div class="hidden text-right lg:block">
                <p class="text-sm text-purple-200">Logged in as</p>
                <p class="text-lg font-semibold text-white">{{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>

    <section class="grid gap-6 lg:grid-cols-4">
        <div class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
            <p class="text-sm uppercase tracking-[0.35em] text-rose-500">Total users</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalUsers }}</p>
        </div>
        <div class="rounded-[2rem] border border-purple-200 bg-white p-6 shadow-xl ring-1 ring-purple-100">
            <p class="text-sm uppercase tracking-[0.35em] text-purple-500">Total posts</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalPosts }}</p>
        </div>
        <div class="rounded-[2rem] border border-fuchsia-200 bg-white p-6 shadow-xl ring-1 ring-fuchsia-100">
            <p class="text-sm uppercase tracking-[0.35em] text-fuchsia-500">Reported posts</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $reportedPosts }}</p>
        </div>
        <div class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
            <p class="text-sm uppercase tracking-[0.35em] text-rose-500">Active users</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $activeUsers }}</p>
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl ring-1 ring-slate-100">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Admin command center</p>
                <h1 class="mt-2 text-3xl font-semibold text-slate-900">Moderation, reports, and content control</h1>
            </div>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                <form method="GET" class="flex gap-3">
                    <input type="search" name="user_search" value="{{ $userSearch }}" placeholder="Search users" class="w-full rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-slate-700 outline-none" />
                    <button class="rounded-3xl bg-rose-400 px-4 py-3 text-white transition hover:bg-rose-500">Find</button>
                </form>
                <form method="GET" class="flex gap-3">
                    <input type="search" name="post_search" value="{{ $postSearch }}" placeholder="Search posts" class="w-full rounded-3xl border border-purple-200 bg-purple-50 px-4 py-3 text-slate-700 outline-none" />
                    <button class="rounded-3xl bg-purple-400 px-4 py-3 text-white transition hover:bg-purple-500">Filter</button>
                </form>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.75fr_1fr]">
        <div class="space-y-6">
            <div class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
                <h2 class="text-xl font-semibold text-slate-900">User management</h2>
                <div class="mt-4 space-y-4">
                    @foreach ($users as $user)
                        <div class="flex flex-col gap-4 rounded-3xl border border-rose-200 bg-rose-50 p-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $user->name }} @if($user->is_admin)<span class="rounded-full bg-purple-100 px-2 py-1 text-xs font-semibold text-purple-700">Admin</span>@endif</p>
                                <p class="text-sm text-slate-600">{{ $user->email }} • {{ $user->posts_count }} posts • {{ $user->comments_count }} comments</p>
                                <p class="text-sm text-slate-500">{{ $user->banned_at ? 'Banned' : 'Active' }}</p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                @if ($user->id !== auth()->id())
                                    @if ($user->banned_at)
                                        <form method="POST" action="{{ route('admin.unban', ['user' => $user]) }}" data-ajax>
                                            @csrf
                                            <button type="submit" class="rounded-3xl bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-200">Unban</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.ban', ['user' => $user]) }}" data-ajax>
                                            @csrf
                                            <button type="submit" class="rounded-3xl bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-200">Ban</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.user.destroy', ['user' => $user]) }}" data-ajax>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[2rem] border border-purple-200 bg-white p-6 shadow-xl ring-1 ring-purple-100">
                <h2 class="text-xl font-semibold text-slate-900">Reported posts</h2>
                <div class="mt-4 space-y-4">
                    @forelse ($reports as $report)
                        <div class="rounded-3xl border border-purple-200 bg-purple-50 p-4">
                            <p class="font-semibold text-slate-900">{{ $report->post->destination ?? 'Unknown post' }}</p>
                            <p class="text-sm text-slate-600">Reported by {{ $report->user->name }} • {{ $report->created_at->diffForHumans() }}</p>
                            <p class="mt-3 text-slate-700">Reason: {{ $report->reason }}</p>
                            <div class="mt-4 flex flex-wrap gap-3">
                                <form method="POST" action="{{ route('admin.report.resolve', ['report' => $report]) }}" data-ajax>
                                    @csrf
                                    <button class="rounded-3xl bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-200">Resolve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.report.delete-post', ['report' => $report]) }}" data-ajax>
                                    @csrf
                                    <button class="rounded-3xl bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-200">Delete Post</button>
                                </form>
                                <form method="POST" action="{{ route('admin.report.ban-user', ['report' => $report]) }}" data-ajax>
                                    @csrf
                                    <button class="rounded-3xl bg-fuchsia-100 px-4 py-2 text-sm font-semibold text-fuchsia-700 transition hover:bg-fuchsia-200">Ban User</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No pending reports right now.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
                <h2 class="text-xl font-semibold text-slate-900">Reported comments</h2>
                <div class="mt-4 space-y-4">
                    @forelse ($comments as $comment)
                        <div id="comment-{{ $comment->id }}" class="rounded-3xl border border-rose-200 bg-rose-50 p-4">
                            <p class="font-semibold text-slate-900">{{ $comment->user->name }} on {{ $comment->post->destination }}</p>
                            <p class="mt-2 text-slate-700">{{ $comment->body }}</p>
                            <div class="mt-4 flex gap-3">
                                <form method="POST" action="{{ route('admin.comment.destroy', ['comment' => $comment]) }}" data-ajax>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-3xl bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-200">Delete comment</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No reported comments to moderate.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl ring-1 ring-slate-100">
                <h2 class="text-xl font-semibold text-slate-900">Moderation queue</h2>
                <div class="mt-4 space-y-4">
                    @foreach ($posts as $post)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $post->destination }}</p>
                                    <p class="text-sm text-slate-600">{{ $post->location }} • {{ $post->created_at->diffForHumans() }}</p>
                                    <p class="text-sm text-slate-500">Status: {{ $post->is_approved ? 'Approved' : 'Pending' }} • {{ $post->is_hidden ? 'Hidden' : 'Visible' }} • Comments {{ $post->comments_enabled ? 'On' : 'Off' }}</p>
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    @if (! $post->is_approved)
                                        <form method="POST" action="{{ route('admin.post.approve', ['post' => $post]) }}" data-ajax>
                                            @csrf
                                            <button class="rounded-3xl bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-200">Approve</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.post.hide', ['post' => $post]) }}" data-ajax>
                                        @csrf
                                        <button class="rounded-3xl bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-200">Hide</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.post.toggle-comments', ['post' => $post]) }}" data-ajax>
                                        @csrf
                                        <button class="rounded-3xl bg-purple-100 px-4 py-2 text-sm font-semibold text-purple-700 transition hover:bg-purple-200">Toggle Comments</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
                <h2 class="text-xl font-semibold text-slate-900">Categories</h2>
                <form method="POST" action="{{ route('admin.categories.store') }}" data-ajax class="mt-4 space-y-4">
                    @csrf
                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Category name</span>
                        <input type="text" name="name" class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 focus:border-rose-400 focus:ring-2 focus:ring-rose-200" />
                    </label>
                    <button class="rounded-3xl bg-rose-400 px-4 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">Add category</button>
                </form>
                <div class="mt-6 space-y-3">
                    @foreach ($categories as $category)
                        <div class="flex items-center justify-between rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3">
                            <span class="text-sm text-slate-700">{{ $category->name }}</span>
                            <form method="POST" action="{{ route('admin.categories.destroy', ['category' => $category]) }}" data-ajax>
                                @csrf
                                @method('DELETE')
                                <button class="rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[2rem] border border-purple-200 bg-white p-6 shadow-xl ring-1 ring-purple-100">
                <h2 class="text-xl font-semibold text-slate-900">Locations</h2>
                <form method="POST" action="{{ route('admin.locations.store') }}" data-ajax class="mt-4 space-y-4">
                    @csrf
                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Location name</span>
                        <input type="text" name="name" class="mt-2 w-full rounded-3xl border border-purple-200 bg-white px-4 py-3 focus:border-purple-400 focus:ring-2 focus:ring-purple-200" />
                    </label>
                    <button class="rounded-3xl bg-purple-400 px-4 py-3 text-sm font-semibold text-white transition hover:bg-purple-500">Add location</button>
                </form>
                <div class="mt-6 space-y-3">
                    @foreach ($locations as $location)
                        <div class="flex items-center justify-between rounded-3xl border border-purple-200 bg-purple-50 px-4 py-3">
                            <span class="text-sm text-slate-700">{{ $location->name }}</span>
                            <form method="POST" action="{{ route('admin.locations.destroy', ['location' => $location]) }}" data-ajax>
                                @csrf
                                @method('DELETE')
                                <button class="rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl ring-1 ring-slate-100">
                <h2 class="text-xl font-semibold text-slate-900">Site settings</h2>
                <form method="POST" action="{{ route('admin.settings.update') }}" data-ajax class="mt-4 space-y-4">
                    @csrf
                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Website name</span>
                        <input type="text" name="website_name" value="{{ $settings['website_name'] ?? 'Finder' }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 focus:border-slate-400 focus:ring-2 focus:ring-slate-200" />
                    </label>
                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Logo URL</span>
                        <input type="url" name="logo_url" value="{{ $settings['logo_url'] ?? '' }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 focus:border-slate-400 focus:ring-2 focus:ring-slate-200" />
                    </label>
                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Theme color</span>
                        <input type="text" name="theme_color" value="{{ $settings['theme_color'] ?? 'rose' }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 focus:border-slate-400 focus:ring-2 focus:ring-slate-200" />
                    </label>
                    <label class="inline-flex items-center gap-3 text-sm text-slate-700">
                        <input type="checkbox" name="approval_required" value="1" {{ ($settings['approval_required'] ?? 'false') === 'true' ? 'checked' : '' }} class="h-4 w-4 rounded" />
                        Require admin approval before posts go live
                    </label>
                    <label class="inline-flex items-center gap-3 text-sm text-slate-700">
                        <input type="checkbox" name="maintenance_mode" value="1" {{ ($settings['maintenance_mode'] ?? 'false') === 'true' ? 'checked' : '' }} class="h-4 w-4 rounded" />
                        Enable maintenance mode
                    </label>
                    <button class="rounded-3xl bg-slate-800 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-900">Save settings</button>
                </form>
            </div>
        </aside>
    </section>
</div>
@endsection
