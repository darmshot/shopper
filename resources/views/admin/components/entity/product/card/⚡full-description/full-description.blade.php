<div {{ $attributes->class('card') }}>
    <div class="card-header">Full description</div>
    <div class="card-body" wire:ignore>
        <x-admin::fx.field.editor
            name="description"
            :value="$description"
        />
    </div>
</div>
