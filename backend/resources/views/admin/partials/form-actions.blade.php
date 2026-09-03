{{--
    Save / cancel for every create-and-edit screen. Deleting lives in
    `admin.partials.delete-card`, which must be included *after* the closing
    </form> tag — a form cannot be nested inside another one.

    $cancel — index URL to return to
    $model  — the record being edited (used only to decide "Create" vs "Save")
--}}
<div class="hz-card space-y-3">
    <button type="submit" class="hz-btn-primary w-full">
        <x-icon name="check" class="h-4 w-4"/>
        {{ $model->exists ? 'Save changes' : 'Create' }}
    </button>

    <a href="{{ $cancel }}" class="hz-btn-ghost w-full">Cancel</a>
</div>
