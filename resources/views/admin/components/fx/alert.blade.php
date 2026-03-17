@props([
    'variant' => 'success',
])
@php
    $icon = match ($variant) {
        'danger' => 'admin::ui.icon.status.danger',
        'success' => 'admin::ui.icon.status.success',
        default => null
    }
@endphp
<div {{ $attributes->class(['alert', "alert-$variant"]) }} role="alert">
    @if($icon)
        <div class="alert-icon">
            <x-dynamic-component :component="$icon"/>
        </div>
    @endif

    <div class="alert-description">
        {{ $slot }}
    </div>
</div>
