@php
    /** @var \App\Services\Tree\Data\Node<\App\Models\Category> $category */
@endphp
<div {{ $attributes }}
     x-data="categoryCardCategories()">
    <x-admin::ui.layout.card-list
        title="Categories">
        <x-slot:bulk-actions>
            <x-admin::fx.bulk-action.checked/>

            <x-admin::fx.bulk-action.active
                entity="Categories"
                :route="route('api.admin.category.bulk_update')"
                @success="$wire.$refresh"
            />

            <x-admin::fx.bulk-action.delete
                entity="Categories"
                :route="route('api.admin.category.bulk_delete')"
                @success="$wire.$refresh"
            />
        </x-slot:bulk-actions>

        <x-slot:header-right>
            <x-admin::fx.search
                model="search"
            />
        </x-slot:header-right>

        <x-slot:body>
            @foreach($this->categories as $category)
                <div x-data="{
                        id: '{{ $category->entity->id }}',
                        init() {
                            this.$data.initStateCategory(this.id)
                        }
                    }">
                    <x-admin::entity.category.node-item
                        :node="$category"
                    />
                </div>
            @endforeach
        </x-slot:body>
    </x-admin::ui.layout.card-list>
</div>


@pushonce('scripts')
    @vite('resources/js/admin/components/widget/categories.ts')
    @vite('resources/js/admin/components/fx/action/active.ts')
    @vite('resources/js/admin/components/fx/action/delete.ts')
@endpushonce
