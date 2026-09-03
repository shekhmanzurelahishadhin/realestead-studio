@props(['action', 'confirm' => 'Delete this record permanently? This cannot be undone.'])

<form method="POST" action="{{ $action }}" onsubmit="return confirm(@js($confirm))" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" title="Delete"
            {{ $attributes->merge(['class' => 'rounded-lg p-2 text-slate-400 transition hover:bg-danger/10 hover:text-danger']) }}>
        <x-icon name="trash" class="h-4 w-4"/>
    </button>
</form>
