@props([
    'model' => null,
    'placeholder' => 'Search...'
])
<div {{ $attributes->class('input-group input-group-flat w-auto') }}>
                      <span class="input-group-text">
                        <x-admin::ui.icon.search/>
                      </span>
    <input
        type="text"
        placeholder="{{ $placeholder }}"
        class="form-control"
        @if($model) wire:model.live.debounce.150ms="{{$model}}" @endif
        autocomplete="off">
</div>
