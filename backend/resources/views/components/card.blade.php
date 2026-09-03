@props(['title' => null, 'subtitle' => null])

<section {{ $attributes->merge(['class' => 'hz-card']) }}>
    @if ($title || isset($actions))
        <div class="mb-5 flex items-start justify-between gap-4">
            <div>
                @if ($title)
                    <h2 class="text-lg font-bold text-navy-700 dark:text-white">{{ $title }}</h2>
                @endif
                @if ($subtitle)
                    <p class="mt-0.5 text-sm font-medium text-slate-400 dark:text-navy-200">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex shrink-0 items-center gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    {{ $slot }}
</section>
