@blaze

@props([
    'name',
    'label' => null,
    'required' => false,
    'nullable' => false,
])

<div class="mb-3">
    @if($label)
        <label class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    <select
        name="{{ $name }}"
        {{ $attributes->class(['form-select', 'is-invalid' => $errors->has($name)]) }}
    >
        @if($nullable)
            <option value="">--Select {{ $label }}--</option>
        @endif
        {{ $slot }}
    </select>

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
