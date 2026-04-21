@extends('layouts.app')

@section('content')
<div class="relative mx-auto flex min-h-[calc(100vh-4rem)] max-w-6xl items-center justify-center py-12">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(244,114,182,0.12),_transparent_25%),radial-gradient(circle_at_bottom_right,_rgba(168,85,247,0.12),_transparent_25%)]"></div>
    <div class="relative z-10 w-full rounded-[2rem] border border-rose-200 bg-white p-6 shadow-2xl backdrop-blur-xl md:p-10">
        <div class="grid gap-8 lg:grid-cols-[1.2fr_1fr]">
            <div class="space-y-6 text-slate-800">
                <div class="rounded-3xl bg-gradient-to-br from-rose-50 to-purple-50 p-6 ring-1 ring-rose-200">
                    <p class="text-sm uppercase tracking-[0.4em] text-rose-500">Finder</p>
                    <h1 class="mt-4 text-4xl font-semibold text-slate-900">Discover travel inspiration in your feed.</h1>
                    <p class="mt-4 max-w-xl text-slate-600">Login to share your favorite tourist destinations, explore local activities, and build your own travel story.</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-white p-5 ring-1 ring-rose-100">
                        <p class="text-sm text-slate-500">Explore</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">Curated destination cards</p>
                    </div>
                    <div class="rounded-3xl bg-white p-5 ring-1 ring-purple-100">
                        <p class="text-sm text-slate-500">Community</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">Like, comment, and share posts</p>
                    </div>
                </div>
            </div>
            <div class="rounded-[2rem] bg-gradient-to-br from-rose-50 to-fuchsia-50 p-8 ring-1 ring-rose-200 shadow-xl">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.4em] text-rose-500">Welcome back</p>
                        <h2 class="text-3xl font-semibold text-slate-900">Login to Finder</h2>
                    </div>
                    <div class="inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-rose-200 text-rose-600 ring-1 ring-rose-300">
                        <span class="text-xl font-bold">F</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
                    @csrf

                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-200" />
                    </label>

                    <label class="block text-sm text-slate-700">
                        <span class="font-medium">Password</span>
                        <input type="password" name="password" required class="mt-2 w-full rounded-3xl border border-rose-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-200" />
                    </label>

                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-rose-300 bg-white text-rose-500 focus:ring-rose-400" />
                            Remember me
                        </label>
                        <a href="#" class="font-medium text-rose-500 hover:text-rose-600">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full rounded-3xl bg-rose-400 px-5 py-3 font-semibold text-white transition hover:bg-rose-500">Sign in</button>
                </form>

                <p class="mt-6 text-sm text-slate-600">New to Finder? <a href="{{ route('register') }}" class="font-semibold text-slate-900 hover:text-rose-600">Create an account</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
