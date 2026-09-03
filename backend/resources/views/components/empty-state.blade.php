@props(['message' => 'Nothing here yet.', 'action' => null, 'actionLabel' => 'Add the first one'])

<div class="flex flex-col items-center justify-center gap-3 px-6 py-16 text-center">
    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-white/5 dark:text-white">
        <x-icon name="inbox" class="h-6 w-6"/>
    </span>
    <p class="text-sm font-bold text-navy-700 dark:text-white">{{ $message }}</p>
    @if ($action)
        <a href="{{ $action }}" class="hz-btn-primary mt-2">
            <x-icon name="plus" class="h-4 w-4"/> {{ $actionLabel }}
        </a>
    @endif
</div>
