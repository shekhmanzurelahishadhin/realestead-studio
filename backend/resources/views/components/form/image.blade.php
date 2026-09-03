@props(['name', 'value' => null, 'label' => 'Image', 'hint' => null, 'required' => false])

@php
    $current = old($name, $value);
    $preview = \App\Support\Media::url($current);
@endphp

<div x-data="{ preview: @js($preview) }" {{ $attributes->merge(['class' => 'w-full']) }}>
    <label class="hz-label">
        {{ $label }}
        @if ($required)<span class="text-brand-600">*</span>@endif
    </label>

    <div class="flex items-start gap-4">
        {{-- Thumbnail --}}
        <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-slate-50 dark:border-white/15 dark:bg-navy-900">
            <template x-if="preview">
                <img :src="preview" alt="" class="h-full w-full object-cover">
            </template>
            <template x-if="! preview">
                <x-icon name="photo" class="h-7 w-7 text-slate-300 dark:text-navy-300"/>
            </template>
        </div>

        <div class="min-w-0 flex-1 space-y-2">
            {{-- Upload a new file; the controller stores it and overwrites the URL below. --}}
            <input type="file"
                   name="{{ $name }}_file"
                   accept="image/*"
                   @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview"
                   class="block w-full cursor-pointer text-xs font-medium text-slate-500 file:mr-3 file:cursor-pointer
                          file:rounded-lg file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-xs
                          file:font-bold file:text-white hover:file:bg-brand-700 dark:text-navy-200">

            <input type="text"
                   name="{{ $name }}"
                   id="{{ $name }}"
                   value="{{ $current }}"
                   placeholder="…or paste an image URL"
                   @input="preview = $event.target.value"
                   @class(['hz-input py-2 text-xs', 'hz-input-error' => $errors->has($name)])>
        </div>
    </div>

    @error($name)
        <span class="hz-error">{{ $message }}</span>
    @else
        @error($name.'_file')
            <span class="hz-error">{{ $message }}</span>
        @else
            <span class="hz-hint">{{ $hint ?? 'Upload a file or paste an absolute URL. Uploads win when both are set.' }}</span>
        @enderror
    @enderror
</div>
