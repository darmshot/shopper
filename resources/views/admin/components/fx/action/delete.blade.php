@props([
    'route',
    'entity',
])

<a {{ $attributes }}
   href="javascript:void(0)"
   x-data="actionDelete({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })"
   x-on:click="confirmDelete()"
   class="btn btn-action"
   title="Delete"
   style="--tblr-btn-line-height:0.5rem;">
    <x-admin::ui.icon.trash/>
</a>
