@blaze

@props([
    'name',
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'prefix' => null,
    'suffix' => null,
])

@php
    $hasGroup = !empty($prefix) || !empty($suffix);
    $dotName = \App\Support\Form::dotName($name);
    $hasError = $errors->has($dotName);
    $isSmall = str_contains($attributes->get('class'), 'form-control-sm');
@endphp
<div class="mb-3">
    @if($label)
        <label class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    @if($hasGroup)
        <div class="input-group input-group-flat {{ $isSmall ? 'input-group-sm': '' }}">@endif
            @if($prefix)
                <span class="input-group-text {{$hasError ? 'border-danger':''}} {{!$errors->has($name) && $errors->isNotEmpty()?'border-success':''}}">{{$prefix}}</span>
            @endif
            <input
                name="{{ $name }}"
                type="text"
                placeholder="{{$placeholder ?? $label ?? $attributes->get('title')}}"
                @required($required)
                {{ $attributes->class([
                    'form-control',
                    'is-invalid' => $hasError,
                    'is-valid' => !$hasError && $errors->isNotEmpty(),
                    'ps-0' => $prefix,
                ]) }}
            />
            @if($suffix)
                <span class="input-group-text {{$hasError ? 'border-danger':''}} {{!$errors->has($name) && $errors->isNotEmpty()?'border-success':''}}">{{$suffix}}</span>
            @endif
            @if($hasGroup)</div>
    @endif

    @error($dotName)
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

</div>

