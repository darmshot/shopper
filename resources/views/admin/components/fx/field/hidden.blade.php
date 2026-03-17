@blaze

@props([
    'name',
])

<input
    name="{{ $name }}"
    type="hidden"
    {{ $attributes }}
/>

