<div {{ $attributes->class('card') }}>
    <div class="card-body">
        <div class="row mb-1">
            <div class="col-auto">
                <div class="px-2"></div>
            </div>

            @if($showVariantName)
                <div class="col">
                    <label class="form-label">Name</label>
                </div>
            @endif

            <div class="col">
                <label class="form-label required">Sku</label>
            </div>

            <div class="col">
                <label class="form-label required">Price</label>
            </div>

            <div class="col">
                <label class="form-label">Old price</label>
            </div>

            <div class="col" style="max-width: 100px;">
                <label class="form-label">Stock</label>
            </div>
        </div>

        <div x-sort="
        const ids = [...$el.querySelectorAll('[wire\\:key]')]
            .map(el => el.getAttribute('wire:key'))

            $wire.call('reorderVariants', ids)
            ">
            @foreach($variants as $key => $variant)
                <div wire:key="{{ $variant['id'] }}" class="row align-items-baseline">
                    <div x-sort:handle class="col-auto cursor-move">
                        <x-admin::fx.field.hidden
                            name="sort_variants[]"
                            value="{{ $loop->index }}"
                        />
                        <x-admin::ui.icon.grip-vertical/>
                    </div>

                    @if($showVariantName)
                        <div class="col">
                            <div class="row g-1">
                                <div class="col">
                                    <x-admin::fx.field.text
                                        name="variants[{{ $loop->index }}][name]"
                                        placeholder="Name"
                                        wire:model="variants.{{ $variant['id'] }}.name"
                                    />
                                </div>

                                <div class="col-auto">
                                    <button
                                        type="button"
                                        wire:click="removeVariant('{{ $variant['id']}}')"
                                        class="btn btn-icon btn-ghost-danger">
                                        <x-admin::ui.icon.x/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col">
                        <x-admin::fx.field.text
                            placeholder="Sku"
                            name="variants[{{ $loop->index }}][sku]"
                            wire:model="variants.{{ $variant['id'] }}.sku"
                        />
                    </div>

                    <div class="col">
                        <x-admin::fx.field.number
                            required
                            step=".01"
                            min="0"
                            placeholder="Price"
                            name="variants[{{ $loop->index }}][price]"
                            wire:model="variants.{{ $variant['id'] }}.price"
                        />
                    </div>

                    <div class="col">
                        <x-admin::fx.field.number
                            step=".01"
                            min="0"
                            placeholder="Old price"
                            name="variants[{{ $loop->index }}][old_price]"
                            wire:model="variants.{{ $variant['id'] }}.old_price"
                        />
                    </div>

                    <div class="col" style="max-width: 100px">
                        <x-admin::fx.field.number
                            placeholder="Stock"
                            name="variants[{{ $loop->index }}][stock]"
                            wire:model="variants.{{ $variant['id'] }}.stock"
                        />
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" wire:click="addVariant" class="btn btn-ghost-success">
            <x-admin::ui.icon.plus/>
            Add variant
        </button>
    </div>
</div>
