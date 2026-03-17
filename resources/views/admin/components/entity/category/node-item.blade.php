@props([
    'node'
])
@php
    /** @var \App\Services\Tree\Data\Node<\App\Models\Category> $node */
@endphp
<x-admin::ui.layout.card-list.item>
    <x-slot:body>
        <div class="d-flex gap-2">
            <div
                style="margin-left: {{$node->level * 2.5}}rem"></div>
            <div>
                <input
                    class="form-check-input m-0 align-middle table-selectable-check"
                    type="checkbox"
                    x-model="checked"
                    value="{{ $node->entity->id }}"
                    aria-label="Checked">
            </div>
            <div>
                <a class="text-dark"
                   href="{{ route('admin.category.edit', $node->entity->id) }}">
                    {{ $node->entity->name }}
                    <span class="badge badge-accent">{{ $node->productsTotal }}</span>
                </a>
            </div>
        </div>
    </x-slot:body>

    <x-slot:actions>
        <x-admin::fx.action.view
            :route="route('category.show', $node->entity->url)"
        />

        <x-admin::fx.action.active
            :active="$node->entity->active"
            :route="route('api.admin.category.update', $node->entity->id)"
            :entity="$node->entity->name"
            @success="$wire.$refresh"
        />

        <x-admin::fx.action.delete
            :route="route('api.admin.category.destroy', $node->entity->id)"
            :entity="$node->entity->name"
            @success="$wire.$refresh"
        />
    </x-slot:actions>
</x-admin::ui.layout.card-list.item>
