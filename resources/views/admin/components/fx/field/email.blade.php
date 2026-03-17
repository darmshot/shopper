@blaze

@props([
    'name',
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'prefix' => null,
])

@php
    $hasGroup = !empty($prefix);
    $dotName = \App\Support\Form::dotName($name);
    $hasError = $errors->has($dotName);

@endphp

<div class="mb-3">
    @if($label)
        <label class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    @if($hasGroup)
        <div class="input-group">@endif
            @if($prefix)
                <span class="input-group-text" id="basic-addon1">{{$prefix}}</span>
            @endif
            <input
                name="{{ $name }}"
                type="email"
                placeholder="{{$placeholder ?? $label}}"
                @required($required)
                {{ $attributes->class(['form-control', 'is-invalid' => $hasError]) }}
            />
            @if($hasGroup)</div>
    @endif
    @error($dotName)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
