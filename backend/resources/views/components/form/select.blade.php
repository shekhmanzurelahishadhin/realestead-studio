@props(['name', 'value' => null, 'options' => [], 'placeholder' => null])

<select name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->class(['hz-input appearance-none bg-white dark:bg-navy-800', 'hz-input-error' => $errors->has($name)]) }}>
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    @foreach ($options as $key => $label)
        <option value="{{ $key }}" @selected((string) old($name, $value) === (string) $key)>{{ $label }}</option>
    @endforeach
</select>
