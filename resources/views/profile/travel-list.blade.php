@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl pb-24 pt-8">
    <section class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-rose-500">Travel List</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Your saved destinations</h1>
                <p class="mt-2 text-slate-600">Saved posts appear here so you can plan trips later.</p>
            </div>
            <a href="{{ route('posts.create') }}" class="rounded-3xl bg-purple-100 px-4 py-3 text-sm font-semibold text-purple-700 transition hover:bg-purple-200">Add destination</a>
        </div>

        @if ($posts->isEmpty())
            <div class="rounded-[2rem] border border-dashed border-rose-300 bg-rose-50 p-10 text-center text-slate-600 ring-1 ring-rose-100">
                No saved destinations yet. Bookmark a post to keep it here.
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="overflow-hidden rounded-[1.75rem] border border-rose-200 bg-white shadow-lg ring-1 ring-rose-100">
                        @if ($post->primary_media_type === 'video')
                            <video src="{{ $post->primary_media_url }}" controls class="h-56 w-full object-cover"></video>
                        @else
                            <img src="{{ $post->primary_media_url }}" alt="{{ $post->destination }}" class="h-56 w-full object-cover" />
                        @endif
                        <div class="p-5">
                            <p class="text-sm uppercase tracking-[0.35em] text-rose-500">{{ $post->location }}</p>
                            <h3 class="mt-2 text-xl font-semibold text-slate-900">{{ $post->destination }}</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ Str::limit($post->caption, 110) }}</p>
                            <div class="mt-4 flex flex-wrap gap-3 text-sm text-slate-500">
                                <span>❤️ {{ $post->likes_count }}</span>
                                <span>💬 {{ $post->comments_count }}</span>
                            </div>
                            <form method="POST" action="{{ route('posts.bookmark', ['post' => $post]) }}" class="mt-4 inline-flex">
                                @csrf
                                <button type="submit" class="rounded-3xl bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-200">Remove from Travel List</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
