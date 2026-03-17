@props([
    'route',
    'inFilter',
    'entity',
])

<a {{ $attributes }}
   href="javascript:void(0)"
   x-data="actionInFilter({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })"
   data-in-filter="{{ $inFilter ? 'true' : 'false' }}"
   x-on:click="action()"
   class="btn btn-action"
   title="In filter"
   style="--tblr-btn-line-height:0.5rem;">


    @if($inFilter)
        <x-admin::ui.icon.filter-filled/>
    @else
        <x-admin::ui.icon.filter/>
    @endif
</a>
