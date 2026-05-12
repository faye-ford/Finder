<!-- Toggle Button -->
<button id="nav-toggle" class="fixed top-4 left-4 z-50 inline-flex h-12 w-12 items-center justify-center rounded-xl border border-pink-200/30 bg-white/90 shadow-xl shadow-pink-100/50 backdrop-blur-xl text-pink-500 transition-all hover:scale-105 hover:shadow-pink-200/50">
    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/>
    </svg>
</button>

<!-- Sidebar Overlay -->
<div id="nav-overlay" class="fixed inset-0 z-40 bg-black/50 opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Sidebar Navigation -->
<nav id="sidebar" class="fixed top-0 left-0 z-40 h-full w-64 -translate-x-full transform border-r border-pink-200/30 bg-white/95 shadow-xl shadow-pink-100/50 backdrop-blur-xl transition-transform duration-300 overflow-y-auto @auth @if(auth()->user()->is_admin) admin-sidebar @endif @endauth">
    <div class="flex h-full flex-col p-4">
        <!-- Logo/Header -->
        <div class="mb-6 flex items-center gap-3 border-b border-pink-100 pb-4 shrink-0">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-pink-500 to-rose-500 text-white shadow-lg shadow-pink-300/50">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M3 12l3.5-3.5V8h1V4h8v4h1v-.5L21 12l-9 9-9-9z"/></svg>
            </div>
            <span class="text-xl font-bold bg-gradient-to-r from-pink-500 to-rose-500 bg-clip-text text-transparent">Finder</span>
            @auth
                @if(auth()->user()->is_admin)
                <span class="ml-auto rounded-full bg-gradient-to-r from-purple-500 to-violet-500 px-3 py-1 text-xs font-bold text-white shadow-lg shadow-purple-300/50">ADMIN</span>
                @endif
            @endauth
        </div>

        <!-- Navigation Links - Scrollable -->
        <div class="flex-1 space-y-2 overflow-y-auto pb-4">
            <a href="{{ route('home') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-gradient-to-r hover:from-pink-100 hover:to-rose-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-500 shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-pink-200/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M3 12l3.5-3.5V8h1V4h8v4h1v-.5L21 12l-9 9-9-9z"/></svg>
                </span>
                <span>Home</span>
            </a>

            <a href="{{ route('explore') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-gradient-to-r hover:from-purple-100 hover:to-violet-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-purple-100 to-violet-100 text-purple-500 shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-purple-200/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </span>
                <span>Explore</span>
            </a>

            <a href="{{ route('profile.travel-list') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-gradient-to-r hover:from-fuchsia-100 hover:to-pink-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-fuchsia-100 to-pink-100 text-fuchsia-500 shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-fuchsia-200/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M6 4h12v16H6z" opacity="0.4"/><path d="M8 6v12h8V6H8zm2 3h4v2h-4V9z"/></svg>
                </span>
                <span>Travel List</span>
            </a>

            <a href="{{ route('chat.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-gradient-to-r hover:from-pink-100 hover:to-rose-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-500 shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-pink-200/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M21 15a2 2 0 0 1-2 2H8l-4 4V5a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2v10z"/></svg>
                </span>
                <span>Chat</span>
            </a>

            <a href="{{ route('stories.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-gradient-to-r hover:from-purple-100 hover:to-violet-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-purple-100 to-violet-100 text-purple-500 shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-purple-200/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M12 6a6 6 0 1 1 0 12 6 6 0 0 1 0-12zm0-4a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/></svg>
                </span>
                <span>Stories</span>
            </a>

            <a href="{{ route('plans.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-gradient-to-r hover:from-fuchsia-100 hover:to-pink-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-fuchsia-100 to-pink-100 text-fuchsia-500 shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-fuchsia-200/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M4 4h16v2H4zm0 5h12v2H4zm0 5h16v2H4zm0 5h12v2H4z"/></svg>
                </span>
                <span>Planner</span>
            </a>

            <a href="{{ route('profile.show', ['user' => auth()->id()]) }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition-all hover:bg-gradient-to-r hover:from-fuchsia-100 hover:to-pink-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-fuchsia-100 to-pink-100 text-fuchsia-500 shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-fuchsia-200/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm0 2c-4 0-6 2-6 4v1h12v-1c0-2-2-4-6-4z"/></svg>
                </span>
                <span>Profile</span>
            </a>

            <!-- Admin Section - Only visible to admins -->
            @auth
            @if(auth()->user()->is_admin)
            <div class="my-4 border-t border-pink-200/50"></div>
            <p class="mb-2 px-4 text-xs font-semibold uppercase tracking-wider text-purple-600">Admin Panel</p>
            
            <a href="{{ route('admin.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-purple-700 transition-all hover:bg-gradient-to-r hover:from-purple-100 hover:to-violet-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-violet-500 text-white shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-purple-300/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.announcements.index') }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-purple-700 transition-all hover:bg-gradient-to-r hover:from-purple-100 hover:to-violet-100">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-fuchsia-500 to-pink-500 text-white shadow-sm group-hover:scale-110 group-hover:shadow-md group-hover:shadow-fuchsia-300/50 transition-all">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/></svg>
                </span>
                <span>Announcements</span>
            </a>
            @endif
            @endauth
        </div>

        <!-- Logout - Fixed at bottom -->
        <div class="border-t border-pink-100 pt-4 shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="group flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-white transition-all bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 shadow-lg shadow-pink-300/50">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7"/><path d="M7 8v8"/></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    const toggle = document.getElementById('nav-toggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('nav-overlay');

    function openNav() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('opacity-0', 'pointer-events-none');
    }

    function closeNav() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');
    }

    toggle.addEventListener('click', openNav);
    overlay.addEventListener('click', closeNav);
</script>
