@extends('layouts.app')

@section('content')
<div class="relative mx-auto flex min-h-[calc(100vh-4rem)] max-w-6xl items-center justify-center py-12">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(16,185,129,0.12),_transparent_15%),radial-gradient(circle_at_bottom_right,_rgba(168,85,247,0.12),_transparent_20%)]"></div>
    <div class="relative z-10 w-full rounded-[2rem] border border-fuchsia-200 bg-white p-6 shadow-2xl backdrop-blur-xl md:p-10">
        <div class="grid gap-8 lg:grid-cols-[1.2fr_1fr]">
            <div class="space-y-6 text-slate-800">
                <div class="rounded-3xl bg-gradient-to-br from-purple-50 to-fuchsia-50 p-6 ring-1 ring-purple-200">
                    <p class="text-sm uppercase tracking-[0.4em] text-purple-500">Finder</p>
                    <h1 class="mt-4 text-4xl font-semibold text-slate-900">Join a travel-first social space built for wanderers.</h1>
                    <p class="mt-4 max-w-xl text-slate-600">Create an account and share breathtaking destinations with other travelers. Your feed becomes a curated travel guide.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-white p-5 ring-1 ring-purple-100">
                        <p class="text-sm text-slate-500">Discover</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">Search by city or landscape</p>
                    </div>
                    <div class="rounded-3xl bg-white p-5 ring-1 ring-fuchsia-100">
                        <p class="text-sm text-slate-500">Grow</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">Build a portfolio of destinations</p>
                    </div>
                </div>
            </div>
            <div class="rounded-[2rem] bg-gradient-to-br from-purple-50 to-fuchsia-50 p-8 ring-1 ring-fuchsia-200 shadow-xl">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.4em] text-fuchsia-500">Create account</p>
                        <h2 class="text-3xl font-semibold text-slate-900">Start sharing today</h2>
                    </div>
                    <div class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-purple-200 text-purple-600 ring-1 ring-purple-300">
                        <span class="text-xl font-bold">+</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('register.submit') }}" class="space-y-5">
                    @csrf

                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Name</span>
                        <input type="text" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-purple-400 focus:ring-2 focus:ring-purple-200" />
                    </label>

                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-purple-400 focus:ring-2 focus:ring-purple-200" />
                    </label>

                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Password</span>
                        <input type="password" name="password" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-purple-400 focus:ring-2 focus:ring-purple-200" />
                    </label>

                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Confirm Password</span>
                        <input type="password" name="password_confirmation" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-purple-400 focus:ring-2 focus:ring-purple-200" />
                    </label>

                    <button type="submit" class="w-full rounded-3xl bg-purple-400 px-5 py-3 font-semibold text-white transition hover:bg-purple-500">Create account</button>
                </form>

                <p class="mt-6 text-sm text-slate-600">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-slate-900 hover:text-purple-600">Sign in</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
