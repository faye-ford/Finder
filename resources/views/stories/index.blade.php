@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl pb-24 pt-8">
    <section class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-rose-500">Stories</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Share your 24-hour travel moments.</h1>
                <p class="mt-2 text-slate-600">Create fast updates and let travelers see what’s hot right now.</p>
            </div>
            <form method="POST" action="{{ route('stories.store') }}" enctype="multipart/form-data" class="space-y-3 rounded-[2rem] bg-fuchsia-50 p-5">
                @csrf
                <div>
                    <label class="block text-sm text-slate-600">Caption</label>
                    <input name="caption" class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200" />
                </div>
                <div>
                    <label class="block text-sm text-slate-600">Media</label>
                    <input type="file" name="media" class="mt-2 w-full text-sm text-slate-600" />
                </div>
                <button type="submit" class="rounded-3xl bg-rose-400 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">Share story</button>
            </form>
        </div>

        @if ($stories->isEmpty())
            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-purple-200 bg-purple-50/50 p-12 text-center">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-purple-200/30 blur-3xl"></div>
                <div class="relative">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-purple-100 to-fuchsia-100">
                        <svg class="h-8 w-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-lg font-medium text-slate-700">No stories yet</p>
                    <p class="mt-1 text-slate-500">Share a 24-hour travel moment with the community.</p>
                </div>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($stories as $story)
                    <div class="overflow-hidden rounded-[2rem] border border-purple-200 bg-white shadow-xl ring-1 ring-purple-100">
                        @if (preg_match('/\.(mp4|mov|webm)$/i', $story->media_path))
                            <video src="{{ asset('storage/' . $story->media_path) }}" controls class="h-64 w-full object-cover"></video>
                        @else
                            <img src="{{ asset('storage/' . $story->media_path) }}" alt="{{ $story->caption }}" class="h-64 w-full object-cover" />
                        @endif
                        <div class="p-5">
                            <p class="text-sm uppercase tracking-[0.35em] text-slate-500">{{ $story->user->name }}</p>
                            <p class="mt-3 text-lg font-semibold text-slate-900">{{ $story->caption ?? 'Travel story' }}</p>
                            <p class="mt-2 text-sm text-slate-600">Expires {{ $story->expires_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
