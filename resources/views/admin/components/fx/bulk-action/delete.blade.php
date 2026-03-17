@props([
    'route',
    'entity',
])

<a {{ $attributes }}
   href="javascript:void(0)"
   x-data="bulkActionDelete({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })"
   x-on:click="confirmBulkDelete()"
   class="btn btn-action btn-danger"
   title="Delete"
   style="--tblr-btn-line-height:0.5rem;"
>
    <x-admin::ui.icon.trash/>
</a>

@pushonce('scripts')
    @vite('resources/js/admin/components/fx/bulk-action/delete.ts')
@endpushonce
