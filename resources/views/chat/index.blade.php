@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl space-y-8 pb-24 pt-8">
    <section class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
        <div class="mb-6">
            <p class="text-sm uppercase tracking-[0.35em] text-rose-500">Messages</p>
            <h1 class="mt-3 text-3xl font-semibold text-slate-900">Chat with other travelers</h1>
            <p class="mt-2 text-slate-600">Ask about entrance fees, tips, and travel planning in real time.</p>
        </div>

        @if ($contacts->isEmpty())
            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-purple-200 bg-purple-50/50 p-12 text-center">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-purple-200/30 blur-3xl"></div>
                <div class="relative">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-purple-100 to-fuchsia-100">
                        <svg class="h-8 w-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <p class="text-lg font-medium text-slate-700">No conversations yet</p>
                    <p class="mt-1 text-slate-500">Start chatting with other travelers to ask about destinations.</p>
                </div>
            </div>
        @else
            <div class="grid gap-3">
                @foreach ($contacts as $contact)
                    <a href="{{ route('chat.show', ['user' => $contact->id]) }}" class="block rounded-3xl border border-purple-200 bg-purple-50 px-5 py-4 text-sm text-slate-900 transition hover:bg-purple-100">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold">{{ $contact->name }}</p>
                                <p class="text-slate-600">{{ $contact->email }}</p>
                            </div>
                            <span class="rounded-full bg-fuchsia-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-fuchsia-700">Chat</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
