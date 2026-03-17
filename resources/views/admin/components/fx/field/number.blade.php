@blaze

@props([
    'name',
    'label' => null,
    'placeholder' => null,
    'required' => false,
])
@php
    $dotName = \App\Support\Form::dotName($name);
    $hasError = $errors->has($dotName);

@endphp
<div class="mb-3">
    @if($label)
        <label class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif

    <input
        name="{{ $name }}"
        type="number"
        placeholder="{{$placeholder ?? $label}}"
        @required($required)
        {{ $attributes->class(['form-control', 'is-invalid' => $hasError]) }}
    />

    @error($dotName)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
