<div {{ $attributes->class('card') }}>
    <div class="card-header">Product Images</div>
    <div class="card-body" wire:ignore>
        <x-admin::fx.field.dropzone
            name="images"
            :server-files="$images"
            :dropzone-config="$dropzoneConfig"
            multiple
        />
    </div>
</div>
