@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl space-y-8 pb-24 pt-8">
    <!-- Header -->
    <div class="rounded-3xl border-2 border-fuchsia-500/30 bg-gradient-to-r from-fuchsia-600 via-violet-600 to-fuchsia-600 p-8 shadow-2xl shadow-fuchsia-500/20">
        <div class="flex items-center justify-between">
            <div>
                <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-1">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-white"></span>
                    <span class="text-sm font-medium text-white">ANNOUNCEMENTS</span>
                </div>
                <h1 class="text-3xl font-bold text-white">Announcements</h1>
                <p class="mt-2 text-fuchsia-100">Manage platform announcements and updates</p>
            </div>
            <div class="hidden text-right lg:block">
                <p class="text-sm text-fuchsia-200">Total announcements</p>
                <p class="text-lg font-semibold text-white">{{ $announcements->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Search and Create -->
    <section class="rounded-[2rem] border border-fuchsia-200 bg-white p-6 shadow-xl ring-1 ring-fuchsia-100">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Manage announcements</p>
                <h1 class="mt-2 text-2xl font-semibold text-slate-900">Create, view, and manage platform updates</h1>
            </div>
            <form method="GET" class="flex gap-3">
                <input type="search" name="search" value="{{ $search }}" placeholder="Search announcements..." class="w-full rounded-3xl border border-fuchsia-200 bg-fuchsia-50 px-4 py-3 text-slate-700 outline-none" />
                <button class="rounded-3xl bg-fuchsia-400 px-4 py-3 text-white transition hover:bg-fuchsia-500">Find</button>
            </form>
        </div>
    </section>

    <!-- Create New Announcement -->
    <section class="rounded-[2rem] border border-fuchsia-200 bg-white p-6 shadow-xl ring-1 ring-fuchsia-100">
        <h2 class="text-xl font-semibold text-slate-900">Create New Announcement</h2>
        <form method="POST" action="{{ route('admin.announcements.store') }}" data-ajax class="mt-4 space-y-4">
            @csrf
            <label class="block text-sm text-slate-700">
                <span class="font-medium">Title</span>
                <input type="text" name="title" required class="mt-2 w-full rounded-3xl border border-fuchsia-200 bg-white px-4 py-3 focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-200" />
            </label>
            <label class="block text-sm text-slate-700">
                <span class="font-medium">Message</span>
                <textarea name="body" rows="3" required class="mt-2 w-full rounded-3xl border border-fuchsia-200 bg-white px-4 py-3 focus:border-fuchsia-400 focus:ring-2 focus:ring-fuchsia-200"></textarea>
            </label>
            <label class="inline-flex items-center gap-3 text-sm text-slate-700">
                <input type="checkbox" name="active" value="1" class="h-4 w-4 rounded" checked>
                Publish immediately
            </label>
            <button type="submit" class="rounded-3xl bg-fuchsia-400 px-4 py-3 text-sm font-semibold text-white transition hover:bg-fuchsia-500">Publish Announcement</button>
        </form>
    </section>

    <!-- Announcements List -->
    <section class="rounded-[2rem] border border-fuchsia-200 bg-white p-6 shadow-xl ring-1 ring-fuchsia-100">
        <h2 class="text-xl font-semibold text-slate-900">All Announcements</h2>
        <div class="mt-4 space-y-4">
            @forelse ($announcements as $announcement)
                <div id="announcement-{{ $announcement->id }}" class="rounded-3xl border border-fuchsia-200 bg-fuchsia-50 p-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $announcement->title }}</h3>
                                @if($announcement->active)
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Active</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Inactive</span>
                                @endif
                            </div>
                            <p class="mt-2 text-slate-700">{{ $announcement->body }}</p>
                            <p class="mt-3 text-sm text-slate-500">Created {{ $announcement->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('admin.announcements.destroy', ['announcement' => $announcement]) }}" data-ajax>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-3xl bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-200">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-500">No announcements yet. Create your first one above!</p>
            @endforelse
        </div>
        
        @if($announcements->hasPages())
        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
        @endif
    </section>

    <!-- Back to Dashboard -->
    <div class="flex justify-center">
        <a href="{{ route('admin.index') }}" class="rounded-3xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
            ← Back to Admin Dashboard
        </a>
    </div>
</div>
@endsection