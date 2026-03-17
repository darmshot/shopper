<div {{ $attributes }}
     x-data="brandCardBrands()">
    <x-admin::ui.layout.card-list
        title="Brands">
        <x-slot:bulk-actions>
            <input class="form-check-input align-middle m-1"
                   type="checkbox"
                   x-model="checkedAll"
                   x-on:click="toggleCheckedAll()"
                   aria-label="Select all Brands">

            <x-admin::fx.bulk-action.delete
                entity="Brands"
                :route="route('api.admin.brand.bulk_delete')"
                @success="$wire.$refresh"
            />
        </x-slot:bulk-actions>

        <x-slot:header-right>
            <x-admin::fx.search
                model="search"
            />
        </x-slot:header-right>

        <x-slot:body>
            @foreach($this->brands as $brand)
                <div x-data="{
                        id: '{{ $brand->id }}',
                        init() {
                            this.$data.initStateBrand(this.id)
                        }
                    }">
                    <x-admin::ui.layout.card-list.item>
                        <x-slot:body>
                            <div class="d-flex gap-2">
                                <div>
                                    <input
                                        class="form-check-input m-0 align-middle table-selectable-check"
                                        type="checkbox"
                                        x-model="checked"
                                        value="{{ $brand->id }}"
                                        aria-label="Checked">
                                </div>

                                <div>
                                    <a class="text-dark"
                                       href="{{ route('admin.brand.edit', $brand->id) }}">
                                        {{ $brand->name }}
                                    </a>
                                </div>
                            </div>
                        </x-slot:body>

                        <x-slot:actions>
                            <x-admin::fx.action.view
                                :route="route('brand.show', $brand->url)"
                            />

                            <x-admin::fx.action.delete
                                :route="route('api.admin.brand.destroy', $brand->id)"
                                :entity="$brand->name"
                                @success="$wire.$refresh"
                            />
                        </x-slot:actions>
                    </x-admin::ui.layout.card-list.item>
                </div>
            @endforeach
        </x-slot:body>

        <x-slot:footer>
            {{ $this->brands->links('admin.common.pagination.livewire.default') }}
        </x-slot:footer>
    </x-admin::ui.layout.card-list>
</div>


@pushonce('scripts')
    @vite('resources/js/admin/components/widget/brands.ts')
    @vite('resources/js/admin/components/fx/action/delete.ts')
@endpushonce
