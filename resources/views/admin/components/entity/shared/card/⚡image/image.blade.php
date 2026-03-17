<div {{ $attributes->class('card') }}>
    <div class="card-header">Image</div>
    <div class="card-body" wire:ignore>
        <x-admin::fx.field.dropzone
            name="image"
            :server-files="$images"
            :dropzone-config="$dropzoneConfig"
        />
    </div>
</div>
