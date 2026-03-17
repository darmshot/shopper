@props([
    'image'
])
<span class="avatar avatar-2 me-2" style="background-image: url('{{ $image ? asset('storage/' . $image) : null }}')"></span>
