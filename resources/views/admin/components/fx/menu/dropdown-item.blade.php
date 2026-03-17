@props([
    'route'
])
<a class="dropdown-item {{ str_starts_with(url()->current(), $route) ? 'active' : '' }}"
   href="{{ $route }}">
    {{ $slot }}
</a>
