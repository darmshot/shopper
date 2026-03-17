@props([
    'route',
    'entity',
])

<div {{ $attributes }}
    x-data="bulkActionActive({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })" class="dropdown">
    <a href="javascript:void(0)"
       title="Active"
       class="btn btn-action dropdown-toggle"
       style="--tblr-btn-line-height:0.5rem;"
       data-bs-toggle="dropdown">
        <x-admin::ui.icon.bulb/>
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="javascript:void(0)" x-on:click="activate()">Activate</a>
        <a class="dropdown-item" href="javascript:void(0)" x-on:click="deactivate()">Deactivate</a>
    </div>
</div>

@pushonce('scripts')
    @vite('resources/js/admin/components/fx/bulk-action/active.ts')
@endpushonce
