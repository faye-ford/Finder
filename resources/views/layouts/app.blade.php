<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        @php
            use App\Models\Announcement;
            use App\Models\Setting;
            $siteName = Setting::getValue('website_name', 'Finder');
            $themeColor = Setting::getValue('theme_color', 'rose');
            $maintenanceMode = Setting::getValue('maintenance_mode', 'false') === 'true';
            $announcements = Announcement::where('active', true)->latest()->get();
        @endphp
        <title>{{ $siteName }} | Travel CMS</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            rose: {
                                50: '#fdf2f8',
                                100: '#fce7f3',
                                200: '#fbcfe8',
                                400: '#f472b6',
                                500: '#ec4899',
                                600: '#db2777',
                                700: '#be185d',
                            },
                            purple: {
                                50: '#faf5ff',
                                100: '#f3e8ff',
                                200: '#e9d5ff',
                                400: '#a78bfa',
                                500: '#a855f7',
                                600: '#9333ea',
                                700: '#7e22ce',
                            },
                            fuchsia: {
                                50: '#fdf4ff',
                                100: '#fce7fe',
                                200: '#f8d7fe',
                                400: '#d946ef',
                                500: '#d946ef',
                                600: '#c026d3',
                                700: '#a21caf',
                            },
                        },
                        fontFamily: {
                            sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        <script>
            function loadTheme() {
                const preferDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const mode = localStorage.getItem('finder-theme') || (preferDark ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', mode === 'dark');
            }

            function toggleTheme() {
                const active = document.documentElement.classList.toggle('dark');
                localStorage.setItem('finder-theme', active ? 'dark' : 'light');
            }

            loadTheme();
        </script>
    </head>
    <body class="bg-white text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100">
        <!-- Instagram-inspired gradient background -->
        <div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-pink-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
            @auth
                @include('partials.nav')
                
                <!-- Welcome message with admin badge -->
                @if(auth()->user()->is_admin)
                <div class="mx-auto mb-4 max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="rounded-2xl border border-purple-200/50 bg-gradient-to-r from-purple-50 to-violet-50 px-6 py-3 shadow-lg shadow-purple-100/50 dark:from-purple-900/30 dark:to-violet-900/30 dark:border-purple-700/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-purple-500 to-violet-500 text-white">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-purple-900 dark:text-purple-100">Welcome back, {{ auth()->user()->name }}</p>
                                    <p class="text-xs text-purple-700 dark:text-purple-300">You have admin access to the panel</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.index') }}" class="rounded-xl bg-gradient-to-r from-purple-500 to-violet-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-purple-300/50 transition-all hover:from-purple-600 hover:to-violet-600 hover:scale-105">
                                Admin Panel
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            @endauth

            @if (! $announcements->isEmpty())
                <div class="mx-auto mb-6 max-w-7xl overflow-hidden rounded-2xl border border-pink-200/50 bg-white/80 backdrop-blur-md px-6 py-4 text-sm text-slate-700 shadow-lg shadow-pink-100/50 sm:px-8">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-pink-600">📢 Announcements</p>
                            <p class="mt-1 text-sm text-slate-500">Stay up to date with the latest platform news.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($announcements as $announcement)
                                <span class="rounded-full bg-gradient-to-r from-pink-100 to-rose-100 px-4 py-2 text-sm font-medium text-pink-700 shadow-sm">{{ $announcement->title }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if ($maintenanceMode)
                <div class="mx-auto mb-6 max-w-7xl overflow-hidden rounded-2xl border border-rose-200/50 bg-rose-50/80 backdrop-blur-md px-6 py-4 text-sm text-slate-700 shadow-lg shadow-rose-100/50 sm:px-8">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-rose-100 text-rose-600">⚠️</span>
                        <div>
                            <p class="font-semibold text-slate-900">Maintenance mode is enabled.</p>
                            <p class="mt-1 text-sm text-slate-500">The site is currently marked for maintenance by admin.</p>
                        </div>
                    </div>
                </div>
            @endif

            <main class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </body>
</html>

