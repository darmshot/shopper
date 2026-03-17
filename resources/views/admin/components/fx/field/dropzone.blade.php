@blaze

@props([
    'name',
    'serverFiles' => [],
    'multiple' => false,
    'dropzoneConfig' => [],
])

@php
    $defaultDropzoneConfig = [
        'url' => '#',
        'autoProcessQueue' => false,
        'addRemoveLinks' => true,
        'thumbnailMethod' => 'contain',
    ];

    $dropzoneConfig = [
        ...$defaultDropzoneConfig,
        ...$dropzoneConfig,
        'uploadMultiple' => $multiple,
    ];
@endphp


<div class="ui-field-dropzone dropzone"
     data-fx-field="dropzone"
     data-name="{{ $name }}"
     data-server-files='@json($serverFiles)'
     data-dropzone-config='@json($dropzoneConfig)'>
{{--    <div class="fallback">--}}
{{--        <input--}}
{{--            type="file"--}}
{{--            name="{{ $inputFileName }}"--}}
{{--            @if($multiple) multiple @endif--}}
{{--        />--}}
{{--    </div>--}}
</div>

