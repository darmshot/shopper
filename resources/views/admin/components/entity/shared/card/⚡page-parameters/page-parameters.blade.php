<div {{ $attributes->class('card') }}>
    <div class="card-header">
        Page Parameters
    </div>

    <div class="card-body">
        <div class="mb-3">
            <x-admin::fx.field.text
                name="url"
                wire:model="url"
                :prefix="$urlPrefix"
                label="Url"
                required
            />
        </div>

        <div class="mb-3">
            <x-admin::fx.field.text
                name="meta_title"
                wire:model="metaTitle"
                label="Meta title"
                required
            />
        </div>

        <div class="mb-3">
            <x-admin::fx.field.textarea
                name="meta_description"
                wire:model="metaDescription"
                rows="3"
                label="Meta description"
            />
        </div>
    </div>
</div>
