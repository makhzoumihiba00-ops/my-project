<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ToursHub Admin' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#29372d; --muted:#6d776c; --paper:#faf8f3; --sand:#f0e9dd; --line:#e4e2d8; --terra:#a84e31; --green:#2e4033; }
        body { font-family:'DM Sans',sans-serif; background:var(--paper); color:var(--ink); }
        .serif { font-family:'DM Serif Display',Georgia,serif; }
        .shadow-soft { box-shadow:0 14px 40px rgba(40,55,38,.07); }
        .nav-active { background:#eaf0e6; color:var(--green); }
        .status { display:inline-flex; align-items:center; border-radius:999px; padding:.3rem .65rem; font-size:.72rem; font-weight:600; text-transform:capitalize; }
        .status-pending { background:#fff0c9; color:#7b5c13; }.status-confirmed { background:#d8eee5; color:#23664d; }.status-completed { background:#dcebd5; color:#3d6a35; }.status-cancelled { background:#f8dfd9; color:#99412f; }
    </style>
</head>
<body class="min-h-screen">
<div class="min-h-screen lg:flex">
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 flex w-72 -translate-x-full flex-col border-r border-white/60 bg-[#eaf2ed] p-6 transition-transform lg:static lg:translate-x-0">
        <a href="{{ route('admin.dashboard') }}" class="mb-12 flex items-center gap-3">
            <span class="grid h-11 w-11 place-items-center rounded-full bg-[#d7e7dc] text-2xl">☼</span>
            <span><strong class="serif block text-xl">ToursHub</strong><small class="text-xs uppercase tracking-[.2em] text-[#718174]">Morocco owner</small></span>
        </a>
        <nav class="space-y-2 text-sm font-semibold">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'nav-active' : 'text-[#637064] hover:bg-white/60' }} flex items-center gap-3 rounded-xl px-4 py-3">⌂ <span>Dashboard</span></a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'nav-active' : 'text-[#637064] hover:bg-white/60' }} flex items-center gap-3 rounded-xl px-4 py-3">▤ <span>Orders</span></a>
            <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'nav-active' : 'text-[#637064] hover:bg-white/60' }} flex items-center gap-3 rounded-xl px-4 py-3">◇ <span>Packages</span></a>
        </nav>
        <div class="mt-auto border-t border-[#cad8cc] pt-5">
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-semibold text-[#637064] hover:bg-red-50 hover:text-red-700">↪ <span>Logout</span></button></form>
        </div>
    </aside>
    <div class="min-w-0 flex-1">
        <header class="flex items-center justify-between border-b border-[#e8e5dc] bg-white/70 px-5 py-4 backdrop-blur lg:px-10">
            <button id="admin-menu" class="rounded-lg border border-[#dddcd3] px-3 py-2 lg:hidden" aria-label="Open menu">☰</button>
            <div class="hidden text-sm text-[#748073] sm:block">Marrakech & Agafay · Owner workspace</div>
            <div class="flex items-center gap-3"><span class="grid h-9 w-9 place-items-center rounded-full bg-[#e4eadf] text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span class="text-sm font-semibold">{{ auth()->user()->name }}</span></div>
        </header>
        <main class="px-5 py-7 lg:px-10 lg:py-10">
            @if (session('status'))<div class="mb-6 rounded-xl border border-[#cfe4d5] bg-[#edf8ef] px-4 py-3 text-sm text-[#286141]">{{ session('status') }}</div>@endif
            @if (session('error'))<div class="mb-6 rounded-xl border border-[#f1cfc5] bg-[#fff2ef] px-4 py-3 text-sm text-[#99412f]">{{ session('error') }}</div>@endif
            {{ $slot }}
        </main>
    </div>
</div>
<script>
    document.getElementById('admin-menu')?.addEventListener('click', () => document.getElementById('admin-sidebar').classList.toggle('-translate-x-full'));
</script>
</body>
</html>
