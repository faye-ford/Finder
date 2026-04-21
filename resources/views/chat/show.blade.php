@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl pb-24 pt-8">
    <section class="rounded-[2rem] border border-rose-200 bg-white p-6 shadow-xl ring-1 ring-rose-100">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-rose-500">Chat</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">Talking with {{ $contact->name }}</h1>
                <p class="mt-2 text-slate-600">Keep the conversation going and ask about anything travel-related.</p>
            </div>
            <a href="{{ route('chat.index') }}" class="rounded-3xl bg-purple-100 px-4 py-3 text-sm font-semibold text-purple-700 transition hover:bg-purple-200">Back to contacts</a>
        </div>

        @if ($messages->isEmpty())
            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-rose-200 bg-rose-50/50 p-12 text-center">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-rose-200/30 blur-3xl"></div>
                <div class="relative">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-rose-100 to-purple-100">
                        <svg class="h-8 w-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <p class="text-lg font-medium text-slate-700">No messages yet</p>
                    <p class="mt-1 text-slate-500">Start the conversation with {{ $contact->name }}!</p>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($messages as $message)
                    <div class="max-w-3xl {{ $message->sender_id === auth()->id() ? 'ml-auto bg-rose-50 text-slate-900' : 'bg-slate-100 text-slate-900' }} rounded-3xl p-4 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm font-semibold">{{ $message->sender->id === auth()->id() ? 'You' : $message->sender->name }}</p>
                        <p class="mt-2 text-sm leading-6">{{ $message->body }}</p>
                        <p class="mt-3 text-xs text-slate-500">{{ $message->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('chat.send', ['user' => $contact->id]) }}" class="mt-8 space-y-4">
            @csrf
            <label class="block text-sm text-slate-600">
                Message
                <textarea name="body" rows="4" class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-200"></textarea>
            </label>
            <button type="submit" class="rounded-3xl bg-rose-400 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-500">Send message</button>
        </form>
    </section>
</div>
@endsection
