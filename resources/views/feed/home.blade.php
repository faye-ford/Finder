@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl space-y-8 pb-24 pt-8 lg:pt-4">
    <!-- Hero Section - Instagram Style -->
    <section class="relative overflow-hidden rounded-3xl border border-pink-200/50 bg-white/80 p-8 shadow-2xl shadow-pink-100/50 backdrop-blur-xl">
        <!-- Decorative gradient orbs -->
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-gradient-to-br from-pink-200 to-rose-200 opacity-50 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-48 w-48 rounded-full bg-gradient-to-br from-purple-200 to-fuchsia-200 opacity-50 blur-3xl"></div>
        
        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-xl">
                <p class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-pink-100 to-rose-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-pink-600">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-pink-500"></span>
                    Traveler Feed
                </p>
                <h1 class="mt-4 text-3xl font-bold text-slate-900">
                    Explore <span class="bg-gradient-to-r from-pink-500 to-rose-500 bg-clip-text text-transparent">new destinations</span>, stories, and hotspots.
                </h1>
                <p class="mt-3 text-slate-600">Search by location or scroll to see the latest travel posts from the Finder community.</p>
            </div>
            <form method="GET" action="{{ route('home') }}" class="flex w-full items-center gap-3 rounded-2xl border border-pink-200/50 bg-white/80 px-4 py-2 shadow-lg shadow-pink-100/30 sm:max-w-md">
                <svg class="h-5 w-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" name="search" placeholder="Search locations or activities" value="{{ $search }}" class="w-full bg-transparent text-sm text-slate-900 outline-none placeholder:text-slate-400" />
                <button type="submit" class="rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-pink-300/50 transition-all hover:from-pink-600 hover:to-rose-600 hover:shadow-pink-400/60">Search</button>
            </form>
        </div>
    </section>

    <section class="grid gap-8 lg:grid-cols-[2fr_1fr]">
        <div class="space-y-8">
            @foreach ($posts as $post)
                <article class="group overflow-hidden rounded-3xl border border-pink-200/30 bg-white/90 shadow-xl shadow-pink-100/30 backdrop-blur-xl transition-all hover:shadow-2xl hover:shadow-pink-200/50">
                    <!-- Media Section - Image Slider -->
                    <div class="relative overflow-hidden bg-slate-100">
                        @php
                            $images = $post->images;
                            $hasMultipleImages = $images && $images->count() > 1;
                        @endphp
                        
                        @if($images && $images->count() > 0)
                            <div class="image-slider relative" data-post-id="{{ $post->id }}">
                                <!-- Images Container -->
                                <div class="slider-images relative h-[420px]">
                                    @foreach($images as $index => $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="{{ $post->destination }}" 
                                             class="slider-image absolute inset-0 h-full w-full object-cover transition-opacity duration-300 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                                             data-index="{{ $index }}" />
                                    @endforeach
                                </div>
                                
                                <!-- Navigation Buttons -->
                                @if($hasMultipleImages)
                                    <button class="slider-prev absolute left-4 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-slate-700 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:scale-110" data-post-id="{{ $post->id }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <button class="slider-next absolute right-4 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-slate-700 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:scale-110" data-post-id="{{ $post->id }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </button>
                                    
                                    <!-- Dots Indicator -->
                                    <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 gap-2">
                                        @foreach($images as $index => $image)
                                            <button class="slider-dot h-2 w-2 rounded-full transition-all {{ $index === 0 ? 'bg-white scale-125' : 'bg-white/50 hover:bg-white/75' }}" data-index="{{ $index }}" data-post-id="{{ $post->id }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <img src="{{ $post->primary_media_url }}" alt="{{ $post->destination }}" class="h-[420px] w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        @endif
                        
                        <!-- Gradient overlay -->
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-transparent p-6 text-white">
                            <p class="flex items-center gap-2 text-sm font-medium uppercase tracking-widest text-pink-300">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                {{ $post->location }}
                            </p>
                            <h2 class="mt-2 text-2xl font-bold">{{ $post->destination }}</h2>
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="space-y-5 p-6">
                        <!-- User info -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600 font-bold shadow-inner">
                                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $post->user->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <button class="rounded-full p-2 text-slate-400 hover:bg-pink-50 hover:text-pink-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                            </button>
                        </div>

                        <p class="text-slate-700 leading-relaxed">{{ $post->caption }}</p>
                        <p class="text-sm text-slate-600">
                            <span class="font-semibold text-pink-600">Suggested activities:</span> {{ $post->activities }}
                        </p>

                        <!-- Action buttons - Instagram style -->
                        <div class="flex items-center gap-2 border-b border-pink-100 pb-4">
                            <button type="button" onclick="toggleLike({{ $post->id }}, '{{ route('posts.like', ['post' => $post]) }}')" class="group/btn inline-flex items-center gap-2 rounded-xl border border-pink-200 bg-pink-50/50 px-4 py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-pink-100 hover:border-pink-300">
                                <svg id="like-icon-{{ $post->id }}" class="h-5 w-5 text-pink-500 transition-transform group-hover/btn:scale-110 {{ $post->likes->contains('user_id', auth()->id()) ? 'liked' : '' }}" fill="{{ $post->likes->contains('user_id', auth()->id()) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                <span id="like-count-{{ $post->id }}" class="text-pink-600">{{ $post->likes_count }}</span>
                            </button>
                            <form method="POST" action="{{ route('posts.comment', ['post' => $post]) }}" class="inline-flex">
                                @csrf
                                <button class="group/btn inline-flex items-center gap-2 rounded-xl border border-purple-200 bg-purple-50/50 px-4 py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-purple-100 hover:border-purple-300">
                                    <svg class="h-5 w-5 text-purple-500 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    <span class="text-purple-600">{{ $post->comments_count }}</span>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('posts.share', ['post' => $post]) }}" class="inline-flex">
                                @csrf
                                <button class="group/btn inline-flex items-center gap-2 rounded-xl border border-fuchsia-200 bg-fuchsia-50/50 px-4 py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-fuchsia-100 hover:border-fuchsia-300">
                                    <svg class="h-5 w-5 text-fuchsia-500 transition-transform group-hover/btn:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    <span class="text-fuchsia-600">{{ $post->share_count }}</span>
                                </button>
                            </form>
                        </div>

                        @if ($post->user_id === auth()->id() || auth()->user()->is_admin)
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('posts.edit', ['post' => $post]) }}" class="rounded-xl bg-gradient-to-r from-purple-100 to-violet-100 px-4 py-2 text-sm font-medium text-purple-700 transition hover:from-purple-200 hover:to-violet-200">Edit</a>
                                <form method="POST" action="{{ route('posts.destroy', ['post' => $post]) }}" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-xl bg-gradient-to-r from-rose-100 to-pink-100 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:from-rose-200 hover:to-pink-200">Delete</button>
                                </form>
                            </div>
                        @endif

                        <!-- Comments Section -->
                        <div class="rounded-2xl bg-gradient-to-br from-pink-50/50 to-rose-50/50 p-4 ring-1 ring-pink-100/50">
                            <p class="font-semibold text-slate-900">Latest comments</p>
                            @if ($post->comments->isEmpty())
                                <p class="mt-2 text-sm text-slate-500">No comments yet. Be the first to share your tips.</p>
                            @else
                                @foreach ($post->comments->take(2) as $comment)
                                    <div class="mt-3 rounded-xl bg-white/80 p-3 ring-1 ring-pink-100/50">
                                        <p class="font-medium text-slate-900">{{ $comment->user->name }}</p>
                                        <p class="text-sm text-slate-700">{{ $comment->body }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @if ($post->comments_enabled)
                            <form method="POST" action="{{ route('posts.comment', ['post' => $post]) }}" class="space-y-3">
                                @csrf
                                <label class="block text-sm text-slate-600">
                                    Add a comment
                                    <input type="text" name="comment" placeholder="Share a travel tip..." class="mt-2 w-full rounded-xl border border-pink-200/50 bg-white/80 px-4 py-3 text-slate-900 outline-none transition-all focus:border-pink-400 focus:ring-4 focus:ring-pink-100/50" />
                                </label>
                                <button type="submit" class="rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-pink-300/50 transition-all hover:from-pink-600 hover:to-rose-600 hover:shadow-pink-400/60">Post</button>
                            </form>
                        @else
                            <div class="rounded-xl bg-white/80 p-4 text-sm text-slate-500 ring-1 ring-pink-100/50">
                                💬 Comments are disabled for this post.
                            </div>
                        @endif

                        <!-- Report Section -->
                        <div class="rounded-xl bg-white/60 p-4 text-sm text-slate-600 ring-1 ring-pink-100/30">
                            <p class="font-medium text-slate-700">Report post</p>
                            <form method="POST" action="{{ route('posts.report', ['post' => $post]) }}" class="mt-2 flex gap-2">
                                @csrf
                                <input type="text" name="reason" placeholder="Reason (optional)" class="flex-1 rounded-lg border border-pink-200/50 bg-white px-3 py-2 text-slate-900 outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-100/50" />
                                <button type="submit" class="rounded-lg bg-gradient-to-r from-fuchsia-500 to-pink-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-fuchsia-300/50 transition-all hover:from-fuchsia-600 hover:to-pink-600">Report</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach

            @if ($posts->isEmpty())
                <div class="relative overflow-hidden rounded-3xl border border-pink-200/30 bg-white/80 p-12 text-center shadow-xl shadow-pink-100/30 backdrop-blur-xl">
                    <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-gradient-to-br from-pink-200 to-rose-200 opacity-40 blur-3xl"></div>
                    <div class="absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-gradient-to-br from-purple-200 to-fuchsia-200 opacity-40 blur-3xl"></div>
                    <div class="relative">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-pink-100 to-rose-100">
                            <svg class="h-10 w-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l3.5-3.5V8h1V4h8v4h1v-.5L21 12l-9 9-9-9z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">No destinations yet</h3>
                        <p class="mt-2 text-slate-600">Be the first to share a travel destination with the community!</p>
                        <a href="{{ route('posts.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-3 font-semibold text-white shadow-lg shadow-pink-300/50 transition-all hover:from-pink-600 hover:to-rose-600 hover:shadow-pink-400/60">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Share a Destination
                        </a>
                    </div>
                </div>
            @endif

            {{ $posts->links() }}
        </div>

        <!-- Sidebar - Instagram Style -->
        <aside class="space-y-6 rounded-3xl border border-pink-200/30 bg-white/80 p-6 shadow-xl shadow-pink-100/30 backdrop-blur-xl">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-100 via-purple-100 to-fuchsia-100 p-5 ring-1 ring-pink-200/30">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/30 blur-2xl"></div>
                <p class="text-sm font-semibold uppercase tracking-widest text-pink-600">Discovery</p>
                <h2 class="mt-2 text-xl font-bold text-slate-900">Find by category or location</h2>
                <p class="mt-2 text-sm text-slate-600">Filter the feed by admin-managed categories and locations.</p>
            </div>

            <div class="space-y-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Categories</p>
                @foreach ($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug]) }}" class="flex items-center justify-between rounded-xl border border-pink-100 bg-gradient-to-r from-pink-50/50 to-rose-50/50 px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:from-pink-100 hover:to-rose-100 hover:shadow-md hover:shadow-pink-100/50">
                        {{ $cat->name }}
                        <svg class="h-4 w-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endforeach
                
                <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-slate-400">Locations</p>
                @foreach ($locations as $loc)
                    <a href="{{ route('home', ['location' => $loc->slug]) }}" class="flex items-center justify-between rounded-xl border border-purple-100 bg-gradient-to-r from-purple-50/50 to-violet-50/50 px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:from-purple-100 hover:to-violet-100 hover:shadow-md hover:shadow-purple-100/50">
                        {{ $loc->name }}
                        <svg class="h-4 w-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endforeach
            </div>
        </aside>
    </section>
</div>
<!-- Image Slider JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sliders
    document.querySelectorAll('.image-slider').forEach(function(slider) {
        const postId = slider.dataset.postId;
        const images = slider.querySelectorAll('.slider-image');
        const dots = slider.querySelectorAll('.slider-dot');
        const prevBtn = slider.querySelector('.slider-prev');
        const nextBtn = slider.querySelector('.slider-next');
        
        if (images.length <= 1) return;
        
        let currentIndex = 0;
        
        function showImage(index) {
            images.forEach(function(img, i) {
                img.classList.toggle('opacity-100', i === index);
                img.classList.toggle('opacity-0', i !== index);
            });
            dots.forEach(function(dot, i) {
                dot.classList.toggle('bg-white', i === index);
                dot.classList.toggle('scale-125', i === index);
                dot.classList.toggle('bg-white/50', i !== index);
            });
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(currentIndex);
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % images.length;
                showImage(currentIndex);
            });
        }
        
        dots.forEach(function(dot, index) {
            dot.addEventListener('click', function() {
                currentIndex = index;
                showImage(currentIndex);
            });
        });
    });
});
</script>@endsection
