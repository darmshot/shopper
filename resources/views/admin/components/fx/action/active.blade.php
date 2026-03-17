@props([
    'route',
    'active',
    'entity',
])

<a {{ $attributes }}
   href="javascript:void(0)"
   x-data="actionActive({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })"
   data-active="{{ $active ? 'true' : 'false' }}"
   x-on:click="action()"
   class="btn btn-action"
   title="Active"
   style="--tblr-btn-line-height:0.5rem;">


    @if($active)
        <x-admin::ui.icon.bulb-filled/>
    @else
        <x-admin::ui.icon.bulb/>
    @endif
</a>
