<header class="sticky top-4 z-20 mx-4 mb-6 mt-4 flex items-center gap-4 rounded-[20px] bg-white/70 px-5 py-3 backdrop-blur-xl sm:mx-6 dark:bg-navy-800/70">

    {{-- Below xl the sidebar is a drawer: this opens it. --}}
    <button type="button" @click="sidebarOpen = true" title="Open menu"
            class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-white dark:hover:bg-white/10 xl:hidden">
        <x-icon name="menu" class="h-5 w-5"/>
    </button>

    {{-- From xl up it is always visible, so this collapses it to an icon rail.
         The class lives on <html> so the head script can restore it before
         first paint; localStorage remembers the choice across pages. --}}
    <button type="button"
            x-data="{ collapsed: document.documentElement.classList.contains('sidebar-collapsed') }"
            @click="
                collapsed = document.documentElement.classList.toggle('sidebar-collapsed');
                localStorage.setItem('hz-sidebar', collapsed ? 'collapsed' : 'expanded');
            "
            :title="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
            :aria-label="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
            :aria-expanded="(! collapsed).toString()"
            class="hidden rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 dark:text-white dark:hover:bg-white/10 xl:block">
        <x-icon name="chevrons-left" class="h-5 w-5 transition-transform duration-300"
                x-bind:class="collapsed ? 'rotate-180' : ''"/>
    </button>

    <div class="min-w-0 flex-1">
        <nav class="flex items-center gap-1 text-xs font-medium text-navy-700 dark:text-white">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Pages</a>
            <span class="text-slate-400">/</span>
            <span>@yield('title', 'Dashboard')</span>
        </nav>
        <h1 class="truncate text-[34px] font-bold leading-tight tracking-tight text-navy-700 dark:text-white">
            @hasSection('heading')
                @yield('heading')
            @else
                @yield('title', 'Dashboard')
            @endif
        </h1>
    </div>

    <div class="flex shrink-0 items-center gap-2 rounded-full bg-white p-2 shadow-card dark:bg-navy-900 dark:shadow-none">

        {{-- Unread messages --}}
        <a href="{{ route('admin.messages.index') }}" title="Messages"
           class="relative rounded-full p-2 text-slate-400 transition hover:text-navy-700 dark:hover:text-white">
            <x-icon name="bell" class="h-5 w-5"/>
            @if ($unreadMessages > 0)
                <span class="absolute right-1 top-1 flex h-2 w-2 rounded-full bg-danger ring-2 ring-white dark:ring-navy-900"></span>
            @endif
        </a>

        {{-- Theme toggle --}}
        <button type="button" title="Toggle theme"
                x-data
                @click="
                    document.documentElement.classList.toggle('dark');
                    localStorage.setItem('hz-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                "
                class="rounded-full p-2 text-slate-400 transition hover:text-navy-700 dark:hover:text-white">
            <x-icon name="sun" class="hidden h-5 w-5 dark:block"/>
            <x-icon name="moon" class="h-5 w-5 dark:hidden"/>
        </button>

        {{-- Account --}}
        <div x-data="{ open: false }" class="relative">
            <button type="button" @click="open = !open"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white">
                {{ \Illuminate\Support\Str::of(auth()->user()->name)->explode(' ')->take(2)->map(fn ($w) => \Illuminate\Support\Str::substr($w, 0, 1))->implode('') }}
            </button>

            <div x-show="open" @click.outside="open = false" x-transition style="display: none"
                 class="absolute right-0 top-12 w-56 rounded-[20px] bg-white p-4 shadow-card dark:bg-navy-700 dark:shadow-card-dark">
                <p class="text-sm font-bold text-navy-700 dark:text-white">👋 Hey, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}</p>
                <p class="truncate text-xs text-slate-400 dark:text-navy-200">{{ auth()->user()->email }}</p>
                <div class="my-3 h-px bg-slate-200 dark:bg-white/10"></div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 text-sm font-medium text-danger hover:underline">
                        <x-icon name="logout" class="h-4 w-4"/> Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
