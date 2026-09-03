<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · {{ $siteName ?? config('app.name') }}</title>

    {{-- Applied before first paint so the panel never flashes the wrong theme
         or the wrong sidebar width. Alpine loads deferred, so these two cannot
         wait for it. --}}
    <script>
        try {
            const stored = localStorage.getItem('hz-theme');
            if (stored === 'dark' || (!stored && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
            if (localStorage.getItem('hz-sidebar') === 'collapsed') {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        } catch (e) {}
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

    @include('admin.partials.sidebar')

    {{-- Mobile scrim --}}
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-navy-900/40 backdrop-blur-sm xl:hidden" style="display: none"></div>

    <div class="hz-shell flex min-w-0 flex-1 flex-col">
        @include('admin.partials.topbar')

        <main class="flex-1 px-4 pb-10 sm:px-6">
            @include('admin.partials.flash')

            @yield('content')
        </main>

        <footer class="px-6 pb-8 pt-2 text-center text-xs font-medium text-slate-400 dark:text-navy-300">
            &copy; {{ date('Y') }} {{ $siteName ?? config('app.name') }} — Admin
        </footer>
    </div>
</div>
</body>
</html>
