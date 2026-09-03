@props(['edit' => null, 'delete' => null])

<div class="flex items-center justify-end gap-1">
    @if ($edit)
        <a href="{{ $edit }}" title="Edit"
           class="rounded-lg p-2 text-slate-400 transition hover:bg-brand-50 hover:text-brand-600 dark:hover:bg-white/10 dark:hover:text-white">
            <x-icon name="pencil" class="h-4 w-4"/>
        </a>
    @endif
    {{ $slot }}
    @if ($delete)
        <x-delete-button :action="$delete"/>
    @endif
</div>
