@php
    /** @var \App\Services\Tree\Data\Node<\App\Models\Category> $category */
@endphp
<div {{ $attributes->class('card') }}>
    <div class="card-header">Use in categories</div>
    <div class="card-body">
        <x-admin::fx.field.select
            name="categories[]"
            label="Use in filter"
            wire:model="categories"
            multiple
            style="height: 400px;"
        >
            @foreach($this->categoryOptions as $category)
                <option value="{{ $category->entity->id }}">
                    {{ $category->entity->name }}
                </option>
            @endforeach
        </x-admin::fx.field.select>
    </div>
</div>
