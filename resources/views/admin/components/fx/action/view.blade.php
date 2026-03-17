@props([
    'route',
])

<a {{ $attributes }}
   href="{{ $route }}"
   target="_blank"
   class="btn btn-action"
   title="View"
   style="--tblr-btn-line-height:0.5rem;">
    <x-admin::ui.icon.eye/>
</a>
