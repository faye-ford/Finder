@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl space-y-8 pb-24 pt-8">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl border border-pink-200/50 bg-white/80 p-8 shadow-2xl shadow-pink-100/50 backdrop-blur-xl">
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-gradient-to-br from-pink-200 to-rose-200 opacity-50 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-48 w-48 rounded-full bg-gradient-to-br from-purple-200 to-fuchsia-200 opacity-50 blur-3xl"></div>
        
        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-xl">
                <p class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-pink-100 to-rose-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-pink-600">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-pink-500"></span>
                    Explore
                </p>
                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    Discover <span class="bg-gradient-to-r from-pink-500 to-rose-500 bg-clip-text text-transparent">trending destinations</span> and fresh travel ideas.
                </h1>
                <p class="mt-3 text-slate-600">Filter by beach, mountains or food, and uncover places the community is loving right now.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('explore', ['topic' => 'beach']) }}" class="rounded-xl bg-gradient-to-r from-rose-100 to-pink-100 px-5 py-3 text-sm font-semibold text-rose-700 transition-all hover:from-rose-200 hover:to-pink-200 hover:shadow-md hover:shadow-rose-200/50">🏖️ Beach</a>
                <a href="{{ route('explore', ['topic' => 'mountains']) }}" class="rounded-xl bg-gradient-to-r from-purple-100 to-violet-100 px-5 py-3 text-sm font-semibold text-purple-700 transition-all hover:from-purple-200 hover:to-violet-200 hover:shadow-md hover:shadow-purple-200/50">🏔️ Mountains</a>
                <a href="{{ route('explore', ['topic' => 'food']) }}" class="rounded-xl bg-gradient-to-r from-fuchsia-100 to-pink-100 px-5 py-3 text-sm font-semibold text-fuchsia-700 transition-all hover:from-fuchsia-200 hover:to-pink-200 hover:shadow-md hover:shadow-fuchsia-200/50">🍜 Food</a>
            </div>
        </div>
    </section>

    <section class="grid gap-8 lg:grid-cols-[2fr_1fr]">
        <div class="space-y-8">
            @foreach ($posts as $post)
                <article class="group overflow-hidden rounded-3xl border border-pink-200/30 bg-white/90 shadow-xl shadow-pink-100/30 backdrop-blur-xl transition-all hover:shadow-2xl hover:shadow-pink-200/50">
                    <div class="relative overflow-hidden bg-slate-100">
                        @if ($post->primary_media_type === 'video')
                            <video src="{{ $post->primary_media_url }}" controls class="h-[360px] w-full object-cover transition-transform duration-500 group-hover:scale-105"></video>
                        @else
                            <img src="{{ $post->primary_media_url }}" alt="{{ $post->destination }}" class="h-[360px] w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        @endif
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent p-6 text-white">
                            <p class="flex items-center gap-2 text-sm font-medium uppercase tracking-widest text-pink-300">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                {{ $post->location }}
                            </p>
                            <h2 class="mt-2 text-2xl font-bold">{{ $post->destination }}</h2>
                        </div>
                    </div>
                    <div class="space-y-5 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600 font-bold">{{ strtoupper(substr($post->user->name, 0, 2)) }}</div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $post->user->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-slate-700 leading-relaxed">{{ $post->caption }}</p>
                        <div class="flex items-center gap-4 border-t border-pink-100 pt-4 text-sm text-slate-500">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-5 w-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                {{ $post->likes_count }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-5 w-5 text-purple-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                {{ $post->views_count }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-5 w-5 text-fuchsia-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                {{ $post->comments_count }}
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach

            @if ($posts->isEmpty())
                <div class="relative overflow-hidden rounded-3xl border border-pink-200/30 bg-white/80 p-12 text-center shadow-xl shadow-pink-100/30 backdrop-blur-xl">
                    <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-gradient-to-br from-pink-200 to-rose-200 opacity-40 blur-3xl"></div>
                    <div class="absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-gradient-to-br from-purple-200 to-fuchsia-200 opacity-40 blur-3xl"></div>
                    <div class="relative">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-purple-100 to-fuchsia-100">
                            <svg class="h-10 w-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">No destinations found</h3>
                        <p class="mt-2 text-slate-600">Try a different filter or be the first to share a destination!</p>
                        <a href="{{ route('posts.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-500 to-fuchsia-500 px-6 py-3 font-semibold text-white shadow-lg shadow-purple-300/50 transition-all hover:from-purple-600 hover:to-fuchsia-600 hover:shadow-purple-400/60">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Share a Destination
                        </a>
                    </div>
                </div>
            @endif

            {{ $posts->links() }}
        </div>

        <!-- Trending Sidebar -->
        <aside class="space-y-6 rounded-3xl border border-pink-200/30 bg-white/80 p-6 shadow-xl shadow-pink-100/30 backdrop-blur-xl">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-100 via-pink-100 to-fuchsia-100 p-5 ring-1 ring-pink-200/30">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/30 blur-2xl"></div>
                <p class="text-sm font-semibold uppercase tracking-widest text-purple-600">🔥 Hot right now</p>
                <h2 class="mt-2 text-xl font-bold text-slate-900">Trending Destinations</h2>
            </div>

            <div class="space-y-3">
                @foreach ($posts->take(5) as $index => $hot)
                    <div class="group relative overflow-hidden rounded-xl border border-pink-100 bg-gradient-to-r from-pink-50/50 to-rose-50/50 p-4 transition-all hover:shadow-md hover:shadow-pink-100/50">
                        <div class="absolute -right-4 -top-4 h-16 w-16 rounded-full bg-gradient-to-br from-pink-200 to-rose-200 opacity-50 blur-2xl"></div>
                        <div class="relative flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-rose-500 text-sm font-bold text-white shadow-lg">{{ $index + 1 }}</span>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-pink-500">{{ $hot->location }}</p>
                                <h3 class="font-semibold text-slate-900">{{ $hot->destination }}</h3>
                                <p class="text-xs text-slate-500">{{ $hot->likes_count }} likes • {{ $hot->views_count }} views</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>
    </section>
</div>
@endsection
