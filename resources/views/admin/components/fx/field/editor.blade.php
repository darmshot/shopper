@props([
    'name',
    'value' => null,
    'id' => uniqid('editor_'),
])
<div class="mb-3">
    <textarea
        data-fx-field="editor"
        name="{{ $name }}"
        id="{{ $id }}"
    {{ $attributes }}
>{!! $value !!}</textarea>
</div>

