<div {{ $attributes->class('card') }}>
    <div class="card-body my-3">
        <x-admin::fx.field.text
            name="name"
            :required="true"
            placeholder="Name"
            wire:model.live.blur="name"
        />
    </div>
</div>
