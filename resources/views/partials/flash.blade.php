@if (session('status') || session('error') || $errors->any())
    <div class="mb-6 max-w-4xl rounded-3xl border border-rose-200 bg-rose-50 p-5 text-sm shadow-lg">
        @if (session('status'))
            <div class="mb-3 rounded-2xl bg-emerald-100 px-4 py-3 text-emerald-700 ring-1 ring-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-3 rounded-2xl bg-rose-100 px-4 py-3 text-rose-700 ring-1 ring-rose-200">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="space-y-2 text-slate-700">
                @foreach ($errors->all() as $error)
                    <p class="rounded-2xl bg-white px-4 py-3 ring-1 ring-rose-200">{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
@endif
