@blaze

@props([
    'action',
    'method',
])
<form
    method="POST"
    action="{{ $action }}"
    class="needs-validation"
    enctype="multipart/form-data"
    autocomplete="off"
    novalidate
    {{ $attributes }}>
    @csrf
    @method($method)
    {{ $slot }}
</form>
