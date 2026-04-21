@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl pb-24 pt-8">
    <section class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-rose-500">Travel Planner</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Organize your next trip.</h1>
                <p class="mt-2 text-slate-600">Build a plan, save favorite destinations, and add it to your itinerary.</p>
            </div>
            <a href="{{ route('posts.create') }}" class="rounded-3xl bg-purple-100 px-4 py-3 text-sm font-semibold text-purple-700 transition hover:bg-purple-200">Add destination</a>
        </div>

        <div class="grid gap-8 lg:grid-cols-[2fr_1fr]">
            <div class="space-y-6">
                <div class="rounded-[2rem] border border-fuchsia-200 bg-fuchsia-50 p-6 ring-1 ring-fuchsia-100">
                    <form method="POST" action="{{ route('plans.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-slate-600">Plan title</label>
                            <input name="title" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200" />
                        </div>
                        <div>
                            <label class="block text-sm text-slate-600">Description</label>
                            <textarea name="description" rows="3" class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-600">Travel date</label>
                            <input type="date" name="planned_date" class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200" />
                        </div>
                        <button type="submit" class="rounded-3xl bg-rose-400 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">Create plan</button>
                    </form>
                </div>

                @forelse ($plans as $plan)
                    <div class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-sm ring-1 ring-rose-100">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.35em] text-rose-500">{{ $plan->planned_date ? $plan->planned_date->format('F j, Y') : 'Open plan' }}</p>
                                <h2 class="mt-2 text-2xl font-semibold text-slate-900">{{ $plan->title }}</h2>
                                <p class="mt-2 text-slate-600">{{ $plan->description }}</p>
                            </div>
                            <form method="POST" action="{{ route('plans.destroy', ['plan' => $plan]) }}" class="inline-flex">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-3xl bg-rose-100 px-4 py-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-200">Remove</button>
                            </form>
                        </div>
                        <div class="mt-4 space-y-3">
                            @forelse ($plan->items as $item)
                                <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $item->post->destination }}</p>
                                            <p class="text-sm text-slate-600">{{ Str::limit($item->note, 80) }}</p>
                                        </div>
                                        <form method="POST" action="{{ route('plans.items.destroy', ['item' => $item]) }}" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-3xl bg-white px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-3xl border-2 border-dashed border-rose-200 bg-rose-50/50 p-6 text-center">
                                    <p class="text-slate-500">No destinations added to this plan yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-rose-200 bg-rose-50/50 p-12 text-center">
                        <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-rose-200/30 blur-3xl"></div>
                        <div class="relative">
                            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-rose-100 to-fuchsia-100">
                                <svg class="h-8 w-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            </div>
                            <p class="text-lg font-medium text-slate-700">No travel plans yet</p>
                            <p class="mt-1 text-slate-500">Create your first trip plan to organize your adventures.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <aside class="space-y-6 rounded-[2rem] border border-purple-200 bg-white p-6 shadow-xl ring-1 ring-purple-100">
                <h2 class="text-xl font-semibold text-slate-900">Add a destination to a plan</h2>
                <form method="POST" action="{{ route('plans.items.store', ['plan' => $plans->first()?->id ?? 0]) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm text-slate-600">Choose a post</label>
                        <select name="post_id" class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200">
                            @foreach ($posts as $post)
                                <option value="{{ $post->id }}">{{ $post->destination }} — {{ $post->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-600">Note</label>
                        <input name="note" class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200" />
                    </div>
                    <button type="submit" class="rounded-3xl bg-fuchsia-400 px-5 py-3 text-sm font-semibold text-white transition hover:bg-fuchsia-500">Add to plan</button>
                </form>
            </aside>
        </div>
    </section>
</div>
@endsection
