@props([
    'route',
    'featured',
    'entity',
])

<a {{ $attributes }}
   href="javascript:void(0)"
   x-data="actionFeatured({
        route: '{{ $route }}',
        entity: '{{ $entity }}',
    })"
   data-featured="{{ $featured ? 'true' : 'false' }}"
   x-on:click="action()"
   class="btn btn-action"
   title="Feature"
   style="--tblr-btn-line-height:0.5rem;">

    @if($featured)
        <x-admin::ui.icon.star-filled/>
    @else
        <x-admin::ui.icon.star/>
    @endif
</a>

