@php
    /**
    * @param \App\Services\Tree\Data\TreeCollection<\App\Models\Category> $categories
    *
    * @return Generator
     */
        $category_options = function(\App\Services\Tree\Data\TreeCollection $categories) use (&$category_options, $categoryId, $parentId) {
            foreach ($categories as $category) {
                $prefix = str_repeat('— ', $category->level);

                if ($categoryId === $category->entity->id) {
                    continue;
                }

                $selected = '';

                if ($parentId === $category->entity->id) {
                    $selected = 'selected';
                }

                yield <<<HTML
                    <option $selected value="{$category->entity->id}">$prefix {$category->entity->name}</option>
                    HTML;

                if (!empty($category->children)) {
                    yield from $category_options($category->children, $categoryId);
                }
            }
        }
@endphp
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

                <div class="col-md-6">
                    <x-admin::fx.field.checkbox
                        name="active"
                        label="Active"
                        wire:model="active"
                    />
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <x-admin::fx.field.select
                        name="parent_id"
                        label="Parent"
                        wire:model="parentId"
                        :nullable="true">
                        @foreach($category_options(categories: $this->tree) as $option)
                            {!! $option !!}
                        @endforeach
                    </x-admin::fx.field.select>
                </div>
            </div>
        </div>
    </div>
</div>
