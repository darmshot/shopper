@props([
    'body',
    'actions',
])
<div {{ $attributes->class('row') }}>
    <div class="col">
       {{ $body }}
    </div>
    <div class="ms-auto col">
        <div class="btn-actions justify-content-end">
           {{ $actions }}
        </div>
    </div>
</div>
