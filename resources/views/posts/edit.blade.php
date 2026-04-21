@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl rounded-[2rem] border border-fuchsia-200 bg-white p-8 shadow-xl ring-1 ring-fuchsia-100">
    <div class="mb-8 flex items-center justify-between gap-4">
        <div>
            <p class="text-sm uppercase tracking-[0.35em] text-fuchsia-500">Edit post</p>
            <h1 class="mt-2 text-3xl font-semibold text-slate-900">Update destination details</h1>
        </div>
        <a href="{{ route('profile.show', ['user' => auth()->id()]) }}" class="rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-slate-700 transition hover:bg-rose-100">Back to profile</a>
    </div>

    <form method="POST" action="{{ route('posts.update', ['post' => $post]) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-6 sm:grid-cols-2">
            <label class="block text-sm text-slate-700">
                <span class="font-medium">Destination name</span>
                <input type="text" name="destination" value="{{ old('destination', $post->destination) }}" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-200" />
            </label>
            <label class="block text-sm text-slate-700">
                <span class="font-medium">Location</span>
                <input type="text" name="location" value="{{ old('location', $post->location) }}" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-200" />
            </label>
        </div>

        <label class="block text-sm text-slate-700">
            <span class="font-medium">Suggested activities</span>
            <input type="text" name="activities" value="{{ old('activities', $post->activities) }}" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-200" />
        </label>

        <label class="block text-sm text-slate-700">
            <span class="font-medium">Caption</span>
            <textarea name="caption" rows="4" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-200">{{ old('caption', $post->caption) }}</textarea>
        </label>

        <div class="space-y-4 rounded-3xl bg-rose-50 p-4 ring-1 ring-rose-100">
            <p class="text-sm text-slate-700 font-medium">Current images ({{ $post->images->count() }})</p>
            <div class="grid grid-cols-3 gap-3">
                @foreach($post->images as $image)
                    <div class="relative aspect-square overflow-hidden rounded-2xl">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Post image" class="h-full w-full object-cover" />
                    </div>
                @endforeach
            </div>
        </div>

        <label class="block text-sm text-slate-700">
            <span class="font-medium">Replace images</span>
            <input type="file" name="images[]" accept="image/jpeg,image/png,image/jpg" multiple class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none file:rounded-3xl file:border-0 file:bg-fuchsia-400 file:px-4 file:py-2 file:text-white" />
            <p class="mt-2 text-xs text-slate-500">Select new images to replace all current images (JPG/PNG only)</p>
        </label>

        <button type="submit" class="rounded-3xl bg-fuchsia-400 px-6 py-3 text-sm font-semibold text-white transition hover:bg-fuchsia-500">Save changes</button>
    </form>
</div>
@endsection
