<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Finder - Your Travel Companion</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            pink: { 50: '#fdf2f8', 100: '#fce7f3', 200: '#fbcfe8', 300: '#f9a8d4', 400: '#f472b6', 500: '#ec4899', 600: '#db2777', 700: '#be185d', 800: '#9d174d', 900: '#831843' },
                            rose: { 50: '#fff1f2', 100: '#ffe4e6', 200: '#fecdd3', 300: '#fda4af', 400: '#fb7185', 500: '#f43f5e', 600: '#e11d48', 700: '#be123c' },
                            purple: { 50: '#faf5ff', 100: '#f3e8ff', 200: '#e9d5ff', 300: '#d8b4fe', 400: '#c084fc', 500: '#a855f7', 600: '#9333ea', 700: '#7e22ce' },
                            fuchsia: { 50: '#fdf4ff', 100: '#fce7fe', 200: '#f8d7fe', 300: '#f0abfc', 400: '#e879f9', 500: '#d946ef', 600: '#c026d3', 700: '#a21caf' }
                        },
                        fontFamily: { sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui'] }
                    }
                }
            }
        </script>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Instrument Sans', sans-serif; }
            .gradient-bg { background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 25%, #fdf4ff 50%, #f3e8ff 75%, #fce7f3 100%); }
            .dark .gradient-bg { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #1a1a2e 100%); }
            .blob { position: absolute; border-radius: 50%; filter: blur(60px); opacity: 0.5; }
            .float { animation: float 6s ease-in-out infinite; }
            @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        </style>
    </head>
    <body class="gradient-bg min-h-screen flex items-center justify-center p-6">
        <!-- Decorative blobs -->
        <div class="blob bg-pink-300 w-96 h-96 -top-20 -left-20"></div>
        <div class="blob bg-purple-300 w-80 h-80 top-1/2 right-10"></div>
        <div class="blob bg-fuchsia-300 w-72 h-72 -bottom-20 left-1/3"></div>
        
        <div class="relative w-full max-w-4xl">
            <!-- Main Card -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-pink-100/50 border border-pink-200/30 overflow-hidden">
                <div class="grid lg:grid-cols-2">
                    <!-- Left Side - Branding -->
                    <div class="p-8 lg:p-12 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center shadow-lg shadow-pink-300/50">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M3 12l3.5-3.5V8h1V4h8v4h1v-.5L21 12l-9 9-9-9z"/></svg>
                            </div>
                            <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-rose-500 bg-clip-text text-transparent">Finder</span>
                        </div>
                        
                        <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 mb-4">
                            Discover Your Next<br>
                            <span class="bg-gradient-to-r from-pink-500 via-rose-500 to-purple-500 bg-clip-text text-transparent">Adventure</span>
                        </h1>
                        
                        <p class="text-slate-600 text-lg mb-8">Share travel destinations, connect with fellow travelers, and plan your perfect trip.</p>
                        
                        <div class="flex flex-wrap gap-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('home') }}" class="px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-semibold rounded-xl shadow-lg shadow-pink-300/50 hover:shadow-pink-400/60 hover:scale-105 transition-all">
                                        Go to Feed →
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-semibold rounded-xl shadow-lg shadow-pink-300/50 hover:shadow-pink-400/60 hover:scale-105 transition-all">
                                        Get Started →
                                    </a>
                                    @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-pink-600 font-semibold rounded-xl border-2 border-pink-200 hover:bg-pink-50 transition-all">
                                        Create Account
                                    </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                    
                    <!-- Right Side - Features -->
                    <div class="bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50 p-8 lg:p-12">
                        <div class="grid gap-6">
                            <div class="flex items-start gap-4 p-4 bg-white/60 rounded-2xl backdrop-blur-sm">
                                <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">Explore Destinations</h3>
                                    <p class="text-sm text-slate-600">Find amazing places shared by travelers worldwide</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-4 bg-white/60 rounded-2xl backdrop-blur-sm">
                                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">Connect & Share</h3>
                                    <p class="text-sm text-slate-600">Share your travel stories and connect with others</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-4 bg-white/60 rounded-2xl backdrop-blur-sm">
                                <div class="w-10 h-10 rounded-xl bg-fuchsia-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-fuchsia-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">Plan Your Trips</h3>
                                    <p class="text-sm text-slate-600">Create travel plans and keep track of your adventures</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating elements -->
                        <div class="mt-8 flex justify-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-pink-200 to-rose-200 float" style="animation-delay: 0s;"></div>
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-200 to-fuchsia-200 float" style="animation-delay: 1s;"></div>
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-200 to-pink-200 float" style="animation-delay: 2s;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <p class="text-center text-slate-500 text-sm mt-6">© 2026 Finder. Share the world.</p>
        </div>
    </body>
</html>