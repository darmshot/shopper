@props([
    'brand'
])
<div {{ $attributes->class('h1') }}>
    {{ $brand->name }}
</div>
