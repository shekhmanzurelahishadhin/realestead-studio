@props(['name', 'value' => null, 'type' => 'text'])

<input type="{{ $type }}"
       name="{{ $name }}"
       id="{{ $name }}"
       value="{{ old($name, $value) }}"
       {{ $attributes->class(['hz-input', 'hz-input-error' => $errors->has($name)]) }}>
