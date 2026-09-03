@props(['name', 'label' => null, 'hint' => null, 'required' => false])

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if ($label)
        <label for="{{ $name }}" class="hz-label">
            {{ $label }}
            @if ($required)<span class="text-brand-600">*</span>@endif
        </label>
    @endif

    {{ $slot }}

    @error($name)
        <span class="hz-error">{{ $message }}</span>
    @else
        @if ($hint)<span class="hz-hint">{{ $hint }}</span>@endif
    @enderror
</div>
