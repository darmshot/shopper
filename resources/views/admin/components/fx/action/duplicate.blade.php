@props([
    'route',
    'entity',
])

<a {{ $attributes }}
   href="javascript:void(0)"
   x-data="actionDuplicate({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })"
   x-on:click="action()"
   class="btn btn-action"
   title="Duplicate"
   style="--tblr-btn-line-height:0.5rem;"
>
    <x-admin::ui.icon.copy/>
</a>
