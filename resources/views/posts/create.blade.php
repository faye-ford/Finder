@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl rounded-[2rem] border border-purple-200 bg-white p-8 shadow-xl ring-1 ring-purple-100">
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <p class="text-sm uppercase tracking-[0.35em] text-purple-500">New post</p>
            <h1 class="mt-2 text-3xl font-semibold text-slate-900">Share a tourist destination</h1>
        </div>
        <a href="{{ route('home') }}" class="rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-slate-700 transition hover:bg-rose-100">Back to feed</a>
    </div>

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid gap-6 sm:grid-cols-2">
            <label class="block text-sm text-slate-700">
                <span class="font-medium">Destination name</span>
                <input type="text" name="destination" value="{{ old('destination') }}" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-200" />
            </label>
            <label class="block text-sm text-slate-700">
                <span class="font-medium">Location</span>
                <input type="text" name="location" value="{{ old('location') }}" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-200" />
            </label>
        </div>

        <label class="block text-sm text-slate-700">
            <span class="font-medium">Suggested activities</span>
            <input type="text" name="activities" value="{{ old('activities') }}" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-200" />
        </label>

        <label class="block text-sm text-slate-700">
            <span class="font-medium">Caption</span>
            <textarea name="caption" rows="4" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-200">{{ old('caption') }}</textarea>
        </label>

        <label class="block text-sm text-slate-700">
            <span class="font-medium">Upload photos</span>
            <input type="file" name="images[]" accept="image/jpeg,image/png,image/jpg" multiple required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none file:rounded-3xl file:border-0 file:bg-purple-400 file:px-4 file:py-2 file:text-white" />
            <p class="mt-2 text-xs text-slate-500">Select multiple images (JPG, PNG only)</p>
        </label>

        <button type="submit" class="rounded-3xl bg-purple-400 px-6 py-3 text-sm font-semibold text-white transition hover:bg-purple-500">Post destination</button>
    </form>
</div>
@endsection
