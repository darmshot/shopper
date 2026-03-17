<div {{ $attributes->class('card') }}>
    <div class="card-body my-3">
        <div class="space-y">
            <div class="row align-items-baseline">
                <div class="col-md-6">
                    <x-admin::fx.field.text
                        name="name"
                        :required="true"
                        placeholder="Name"
                        wire:model.live.blur="name"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
