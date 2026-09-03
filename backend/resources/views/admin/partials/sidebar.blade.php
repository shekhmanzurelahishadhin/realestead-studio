@php
    $groups = [
        null => [
            ['route' => 'admin.dashboard', 'label' => 'Main Dashboard', 'icon' => 'home'],
        ],
        'Content' => [
            ['route' => 'admin.properties.index',    'label' => 'Properties',    'icon' => 'key',      'count' => \App\Models\Property::count()],
            ['route' => 'admin.projects.index',      'label' => 'Projects',      'icon' => 'building', 'count' => \App\Models\Project::count()],
            ['route' => 'admin.services.index',      'label' => 'Services',      'icon' => 'sparkles'],
            ['route' => 'admin.process-steps.index', 'label' => 'Process Steps', 'icon' => 'list'],
            ['route' => 'admin.stats.index',         'label' => 'Stats',         'icon' => 'chart'],
            ['route' => 'admin.testimonials.index',  'label' => 'Testimonials',  'icon' => 'quote'],
        ],
        'Inbox' => [
            ['route' => 'admin.messages.index', 'label' => 'Messages', 'icon' => 'chat', 'count' => \App\Models\ContactMessage::where('is_read', false)->count(), 'accent' => true],
        ],
        'Site' => [
            ['route' => 'admin.settings.edit', 'label' => 'Settings', 'icon' => 'cog'],
        ],
    ];
@endphp

<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="hz-sidebar fixed inset-y-0 left-0 z-40 flex flex-col overflow-hidden bg-white transition-transform
           duration-300 dark:bg-navy-800 xl:translate-x-0! xl:shadow-none">

    {{-- Brand: full wordmark when expanded, initial-only in the rail --}}
    <div class="relative flex items-center justify-center px-6 pb-6 pt-9">
        <a href="{{ route('admin.dashboard') }}"
           class="hz-rail-hide whitespace-nowrap text-2xl font-bold tracking-tight text-navy-700 dark:text-white">
            {{ \Illuminate\Support\Str::before($siteName, ' ') }}<span class="font-normal">{{ \Illuminate\Support\Str::contains($siteName, ' ') ? ' '.\Illuminate\Support\Str::after($siteName, ' ') : ' Studio' }}</span>
        </a>

        <a href="{{ route('admin.dashboard') }}" title="{{ $siteName }}"
           class="hz-rail-only h-10 w-10 items-center justify-center rounded-xl bg-brand-600 text-base font-bold text-white">
            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($siteName, 0, 1)) }}
        </a>

        <button type="button" @click="sidebarOpen = false"
                class="absolute right-5 top-8 rounded-lg p-1 text-slate-400 hover:text-navy-700 dark:hover:text-white xl:hidden">
            <x-icon name="x" class="h-5 w-5"/>
        </button>
    </div>

    <div class="mx-6 h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent dark:via-white/20"></div>

    {{-- Navigation --}}
    <nav class="mt-6 flex-1 overflow-y-auto px-3 pb-6">
        @foreach ($groups as $heading => $items)
            @if ($heading)
                <p class="hz-rail-hide mb-1 mt-6 px-5 text-[11px] font-bold uppercase tracking-widest text-slate-400 dark:text-navy-300">
                    {{ $heading }}
                </p>
                {{-- In the rail the heading becomes a plain divider. --}}
                <div class="hz-rail-only mx-3 my-3 h-px bg-slate-200 dark:bg-white/10"></div>
            @endif

            @foreach ($items as $item)
                @php
                    // "admin.properties.index" -> every /admin/properties/* screen stays highlighted.
                    // The dashboard is an exception: its name has no resource segment to widen.
                    $active = $item['route'] === 'admin.dashboard'
                        ? request()->routeIs('admin.dashboard')
                        : request()->routeIs(\Illuminate\Support\Str::beforeLast($item['route'], '.').'.*');
                @endphp
                {{-- title= is what makes the rail usable: hovering an icon
                     still tells you where it goes. --}}
                <a href="{{ route($item['route']) }}" title="{{ $item['label'] }}"
                   class="hz-nav-link hz-rail-center {{ $active ? 'hz-nav-link-active' : '' }}">
                    <span class="relative shrink-0">
                        <x-icon :name="$item['icon']"
                                class="h-5 w-5 {{ $active ? 'text-brand-600 dark:text-white' : '' }}"/>

                        {{-- Collapsed, a count has no room to sit beside the
                             label, so it becomes a dot on the icon. --}}
                        @if (($item['count'] ?? 0) > 0)
                            <span class="hz-rail-only absolute -right-1.5 -top-1 h-2 w-2 rounded-full
                                         {{ ($item['accent'] ?? false) ? 'bg-danger' : 'bg-slate-400 dark:bg-navy-200' }}"></span>
                        @endif
                    </span>

                    <span class="hz-rail-hide flex-1 whitespace-nowrap">{{ $item['label'] }}</span>

                    @if (($item['count'] ?? 0) > 0)
                        <span class="hz-rail-hide hz-badge {{ ($item['accent'] ?? false) ? 'bg-danger/10 text-danger' : 'bg-slate-100 text-slate-500 dark:bg-white/10 dark:text-navy-100' }}">
                            {{ $item['count'] }}
                        </span>
                    @endif

                    @if ($active)
                        <span class="absolute right-0 top-1/2 h-9 w-1 -translate-y-1/2 rounded-l-md bg-brand-600"></span>
                    @endif
                </a>
            @endforeach
        @endforeach

        {{-- Inside the scroll area, not pinned: it follows the end of the nav
             list rather than sitting against the bottom of the viewport. --}}
        <a href="{{ config('app.frontend_url') }}" target="_blank" rel="noopener" title="View the live site"
           class="hz-rail-only mx-auto mt-8 h-11 w-11 items-center justify-center rounded-xl bg-brand-600 text-white transition hover:bg-brand-700">
            <x-icon name="eye" class="h-5 w-5"/>
        </a>

        <div class="hz-rail-hide relative mx-2 mt-12 rounded-[20px] bg-gradient-to-br from-brand-400 to-brand-700 px-4 pb-5 pt-10 text-center">
            <div class="absolute -top-6 left-1/2 flex h-12 w-12 -translate-x-1/2 items-center justify-center rounded-full border-4 border-white bg-brand-600 dark:border-navy-800">
                <x-icon name="eye" class="h-5 w-5 text-white"/>
            </div>
            <p class="text-sm font-bold text-white">View the live site</p>
            <p class="mt-1 text-xs text-white/70">See how your content looks to visitors.</p>
            <a href="{{ config('app.frontend_url') }}" target="_blank" rel="noopener"
               class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-white/15 px-4 py-2 text-xs font-bold text-white transition hover:bg-white/25">
                Open frontend
            </a>
        </div>
    </nav>
</aside>
