@blaze

@props([
    'name',
    'label',
])

@php
    $dotName = \App\Support\Form::dotName($name);
@endphp
<input type="hidden" name="{{ $name }}" value="0">

<label class="form-check form-check-inline">
    <input
        name="{{ $name }}"
        type="checkbox"
        value="1"
        {{ $attributes->class(['form-check-input', 'is-invalid' => $errors->has($dotName)]) }}
    />

    <span class="form-check-label">{{ $label }}</span>
</label>
