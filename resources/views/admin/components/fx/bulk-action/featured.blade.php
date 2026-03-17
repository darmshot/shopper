@props([
    'route',
    'entity',
])

<div {{ $attributes }}
     x-data="bulkActionFeatured({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })"
    class="dropdown">
    <a href="javascript:void(0)"
       title="Feature"
       class="btn btn-action dropdown-toggle"
       style="--tblr-btn-line-height:0.5rem;"
       data-bs-toggle="dropdown">
        <x-admin::ui.icon.star/>
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="javascript:void(0)" x-on:click="featured()">Mark as feature</a>
        <a class="dropdown-item" href="javascript:void(0)" x-on:click="unfeature()" >Unmark as feature</a>
    </div>
</div>

@pushonce('scripts')
    @vite('resources/js/admin/components/fx/bulk-action/featured.ts')
@endpushonce
