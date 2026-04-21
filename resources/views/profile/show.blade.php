@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl space-y-8 pb-24 pt-8">
    <!-- Profile Header - Instagram Style -->
    <section class="relative overflow-hidden rounded-3xl border border-pink-200/50 bg-white/80 p-8 shadow-2xl shadow-pink-100/50 backdrop-blur-xl">
        <!-- Decorative elements -->
        <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-gradient-to-br from-pink-200 to-rose-200 opacity-40 blur-3xl"></div>
        <div class="absolute -bottom-12 -left-12 h-36 w-36 rounded-full bg-gradient-to-br from-purple-200 to-fuchsia-200 opacity-40 blur-3xl"></div>
        
        <div class="relative grid gap-8 lg:grid-cols-[1fr_1.5fr] lg:items-center">
            <div class="space-y-4">
                <div class="group relative inline-flex">
                    <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-pink-500 via-rose-500 to-purple-500 opacity-75 blur transition duration-500 group-hover:opacity-100"></div>
                    <div class="relative inline-flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-pink-100 to-rose-100 text-4xl font-bold text-pink-600 shadow-inner">
                        {{ strtoupper(substr($profile->name, 0, 2)) }}
                    </div>
                </div>
                <div>
                    <p class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-pink-100 to-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-pink-600">
                        {{ $profile->is_admin ? '👑 Admin' : '✈️ Traveler' }}
                    </p>
                    <h1 class="mt-3 text-4xl font-bold text-slate-900">{{ $profile->name }}</h1>
                    <p class="mt-2 text-slate-500">{{ $profile->email }}</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-100 to-rose-100 p-5 ring-1 ring-pink-200/30 transition-all hover:shadow-lg hover:shadow-pink-200/50">
                    <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/30 blur-2xl"></div>
                    <p class="relative text-sm font-medium text-pink-600">Destinations shared</p>
                    <p class="relative mt-2 text-4xl font-bold text-slate-900">{{ $posts->count() }}</p>
                </div>
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-100 to-fuchsia-100 p-5 ring-1 ring-purple-200/30 transition-all hover:shadow-lg hover:shadow-purple-200/50">
                    <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/30 blur-2xl"></div>
                    <p class="relative text-sm font-medium text-purple-600">Notifications</p>
                    <p class="relative mt-2 text-4xl font-bold text-slate-900">{{ isset($notifications) ? $notifications->count() : 0 }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Posts Gallery - Instagram Style -->
    <section class="relative overflow-hidden rounded-3xl border border-pink-200/30 bg-white/80 p-6 shadow-xl shadow-pink-100/30 backdrop-blur-xl">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-fuchsia-100 to-pink-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-fuchsia-600">
                    📸 Profile Gallery
                </p>
                <h2 class="mt-2 text-2xl font-bold text-slate-900">Your saved destinations</h2>
            </div>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-pink-300/50 transition-all hover:from-pink-600 hover:to-rose-600 hover:shadow-pink-400/60 hover:scale-105">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add new destination
            </a>
        </div>

        @if ($posts->isEmpty())
            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-pink-200 bg-pink-50/50 p-12 text-center">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-pink-200/30 blur-3xl"></div>
                <div class="relative">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-pink-100 to-rose-100">
                        <svg class="h-8 w-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <p class="text-lg font-medium text-slate-700">No posts yet</p>
                    <p class="mt-1 text-slate-500">Share your first destination to appear here.</p>
                </div>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="group overflow-hidden rounded-2xl border border-pink-100 bg-white shadow-lg shadow-pink-100/30 transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-pink-200/50">
                        <div class="relative overflow-hidden bg-slate-100">
                            @if ($post->primary_media_type === 'video')
                                <video src="{{ $post->primary_media_url }}" controls class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105"></video>
                            @else
                                <img src="{{ $post->primary_media_url }}" alt="{{ $post->destination }}" class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                            @endif
                            <!-- Hover overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-pink-500/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                        </div>
                        <div class="p-5">
                            <p class="flex items-center gap-1 text-xs font-semibold uppercase tracking-widest text-pink-500">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                {{ $post->location }}
                            </p>
                            <h3 class="mt-2 text-lg font-bold text-slate-900">{{ $post->destination }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ Str::limit($post->caption, 100) }}</p>
                            <div class="mt-4 flex items-center gap-4 text-xs font-medium text-slate-500">
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                    {{ $post->likes_count }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    {{ $post->comments_count }}
                                </span>
                            </div>
                            <div class="mt-5 flex flex-wrap gap-2">
                                <a href="{{ route('posts.edit', ['post' => $post]) }}" class="rounded-lg bg-gradient-to-r from-purple-100 to-violet-100 px-4 py-2 text-xs font-medium text-purple-700 transition hover:from-purple-200 hover:to-violet-200">Edit</a>
                                <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-gradient-to-r from-rose-100 to-pink-100 px-4 py-2 text-xs font-semibold text-rose-700 transition hover:from-rose-200 hover:to-pink-200">Delete</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
