@props([
    'route' => null,
    'label'
])
<li>
    @if($route)
        <a href="{{ $route }}">{{ $label }}</a>
    @else
        <span class="no-underline cursor-default">{{ $label }}</span>
    @endif
</li>
