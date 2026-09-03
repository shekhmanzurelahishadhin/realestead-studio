{{-- $delete — destroy URL. Include after the main form; renders nothing on create. --}}
@if ($model->exists)
    <div class="mt-5 flex items-center justify-between gap-4 rounded-[20px] border border-danger/20 bg-danger/5 px-6 py-5">
        <div>
            <p class="text-sm font-bold text-danger">Delete this record</p>
            <p class="mt-0.5 text-xs font-medium text-danger/70">It disappears from the public site immediately.</p>
        </div>
        <form method="POST" action="{{ $delete }}"
              onsubmit="return confirm('Delete this record permanently? This cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="hz-btn-danger">
                <x-icon name="trash" class="h-4 w-4"/> Delete
            </button>
        </form>
    </div>
@endif
