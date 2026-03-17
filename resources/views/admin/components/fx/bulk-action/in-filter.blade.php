@props([
    'route',
    'entity',
])

<div {{ $attributes }}
    x-data="bulkActionInFilter({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })" class="dropdown">
    <a href="javascript:void(0)"
       title="In Filter"
       class="btn btn-action dropdown-toggle"
       style="--tblr-btn-line-height:0.5rem;"
       data-bs-toggle="dropdown">
        <x-admin::ui.icon.filter/>
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="javascript:void(0)" x-on:click="activate()">Use in filter</a>
        <a class="dropdown-item" href="javascript:void(0)" x-on:click="deactivate()">Exclude from filter</a>
    </div>
</div>

@pushonce('scripts')
    @vite('resources/js/admin/components/fx/bulk-action/in-filter.ts')
@endpushonce
