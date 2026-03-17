<div {{ $attributes->class('card') }}>
    <div class="card-header">Property settings</div>
    <div class="card-body">
        <x-admin::fx.field.checkbox
            name="in_filter"
            label="Use in filter"
            wire:model="inFilter"
        />
    </div>
</div>
