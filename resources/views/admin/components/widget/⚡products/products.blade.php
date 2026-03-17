<div {{ $attributes }}
     x-data="widgetProducts">
    <x-admin::ui.layout.card-table
        title="Products">
        <x-slot:bulk-actions>
            <x-admin::fx.bulk-action.active
                entity="Products"
                :route="route('api.admin.product.bulk_update')"
                @success="$wire.$refresh"
            />

            <x-admin::fx.bulk-action.duplicate
                entity="Products"
                :route="route('api.admin.product.bulk_duplicate')"
                @success="$wire.$refresh"
            />

            <x-admin::fx.bulk-action.featured
                entity="Products"
                :route="route('api.admin.product.bulk_update')"
                @success="$wire.$refresh"
            />

            <x-admin::fx.bulk-action.delete
                entity="Products"
                :route="route('api.admin.product.bulk_delete')"
                @success="$wire.$refresh"
            />
        </x-slot:bulk-actions>

        <x-slot:header-right>
            <x-admin::fx.field.search
                wire:model.live.debounce.150ms="search"
            />
        </x-slot:header-right>

        <x-slot:thead>
            <tr>
                <x-admin::entity.product.column.checked
                    :head="true"
                />

                <x-admin::entity.product.column.name
                    :head="true"
                />

                <x-admin::entity.product.column.variant
                    :head="true"
                />

                <x-admin::entity.product.column.action
                    :head="true"
                />
            </tr>
        </x-slot:thead>

        <x-slot:tbody>
            @foreach($this->products as $product)
                <tr wire:key="product-{{ $product->id }}"
                    x-data="
                    {
                        id: '{{ $product->id }}',
                        get variantsExpanded() {
                            return this.$data.stateProducts[this.id].variants.expanded
                        },
                        init() {
                            this.$data.initStateProduct(this.id)
                        },
                        toggle() {
                            this.$data.toggleVariantCollapse(this.id)
                        },
                    }">
                    <x-admin::entity.product.column.checked
                        :product="$product"
                    />

                    <x-admin::entity.product.column.name
                        :product="$product"
                    />

                    <x-admin::entity.product.column.variant
                        :product="$product"
                    />

                    <x-admin::entity.product.column.action
                        :product="$product"
                    />
                </tr>
            @endforeach
        </x-slot:tbody>

        <x-slot:footer>
            {{ $this->products->links('admin.common.pagination.livewire.default') }}
        </x-slot:footer>
    </x-admin::ui.layout.card-table>
</div>


@pushonce('scripts')
    @vite('resources/js/admin/components/fx/action/active.ts')
    @vite('resources/js/admin/components/fx/action/duplicate.ts')
    @vite('resources/js/admin/components/fx/action/featured.ts')
    @vite('resources/js/admin/components/fx/action/delete.ts')
    @vite('resources/js/admin/components/fx/editable/text.ts')
    @vite('resources/js/admin/components/widget/products.ts')
@endpushonce
