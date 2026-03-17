<div {{ $attributes }}
     x-data="featureCardFeatures()">
    <x-admin::ui.layout.card-list
        title="Features">
        <x-slot:bulk-actions>
            <x-admin::fx.bulk-action.checked
                title="Select all Features"
            />

            <x-admin::fx.bulk-action.in-filter
                entity="Features"
                :route="route('api.admin.feature.bulk_update')"
                @success="$wire.$refresh"
            />

            <x-admin::fx.bulk-action.delete
                entity="Features"
                :route="route('api.admin.feature.bulk_delete')"
                @success="$wire.$refresh"
            />
        </x-slot:bulk-actions>

        <x-slot:header-right>
            <x-admin::fx.search
                model="search"
                wire:model.live.debounce.150ms="search"
            />
        </x-slot:header-right>

        <x-slot:body>
            @foreach($this->features as $feature)
                <div x-data="{
                        id: '{{ $feature->id }}',
                        init() {
                            this.$data.initStateFeature(this.id)
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
                                        value="{{ $feature->id }}"
                                        aria-label="Checked">
                                </div>
                                <div>
                                    <a class="text-dark"
                                       href="{{ route('admin.feature.edit', $feature->id) }}">
                                        {{ $feature->name }}
                                    </a>
                                </div>
                            </div>
                        </x-slot:body>

                        <x-slot:actions>
                            <x-admin::fx.action.in-filter
                                :in-filter="$feature->in_filter"
                                :route="route('api.admin.feature.update', $feature->id)"
                                :entity="$feature->name"
                                @success="$wire.$refresh"
                            />

                            <x-admin::fx.action.delete
                                :route="route('api.admin.feature.destroy', $feature->id)"
                                :entity="$feature->name"
                                @success="$wire.$refresh"
                            />
                        </x-slot:actions>
                    </x-admin::ui.layout.card-list.item>
                </div>
            @endforeach
        </x-slot:body>
    </x-admin::ui.layout.card-list>
</div>


@pushonce('scripts')
    @vite('resources/js/admin/components/widget/features.ts')
    @vite('resources/js/admin/components/fx/action/in-filter.ts')
    @vite('resources/js/admin/components/fx/action/delete.ts')
@endpushonce
