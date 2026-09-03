@props(['name', 'value' => null, 'rows' => 4])

<textarea name="{{ $name }}"
          id="{{ $name }}"
          rows="{{ $rows }}"
          {{ $attributes->class(['hz-input resize-y', 'hz-input-error' => $errors->has($name)]) }}>{{ old($name, $value) }}</textarea>
