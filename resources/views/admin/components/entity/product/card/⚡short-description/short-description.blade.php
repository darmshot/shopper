<div class="card mb-3">
    <div class="card-header">Short description</div>
    <div class="card-body" wire:ignore>
        <x-admin::fx.field.editor
            name="annotation"
            :value="$annotation"
        />
    </div>
</div>
