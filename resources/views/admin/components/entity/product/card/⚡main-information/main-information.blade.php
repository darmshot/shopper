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

                    <x-admin::fx.field.checkbox
                        name="featured"
                        label="Featured"
                        wire:model="featured"
                    />
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <x-admin::fx.field.select
                        name="brand_id"
                        label="Brand"
                        wire:model="brandId"
                        :nullable="true">
                        @foreach($this->brandOptions as $brand)
                            <x-admin::fx.field.select.option
                                wire:key="{{ $brand->id }}"
                                value="{{ $brand->id }}">
                                {{ $brand->name }}
                            </x-admin::fx.field.select.option>
                        @endforeach
                    </x-admin::fx.field.select>
                </div>

                <div class="col-md-6">
                    <label class="form-label required">Category</label>

                    @foreach($categories as $categoryId)
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <x-admin::fx.field.select
                                    name="categories[]"
                                    :required="true"
                                    :nullable="false"
                                    wire:model.live.blur="categories.{{ $loop->index }}"
                                    :nullable="true">
                                    @foreach($this->categoryOptions as $category)
                                        <x-admin::fx.field.select.option
                                            wire:key="{{ $category->entity->id }}"
                                            value="{{ $category->entity->id }}">
                                            {{str_repeat('—',$category->level)}} {{ $category->entity->name }}
                                        </x-admin::fx.field.select.option>
                                    @endforeach
                                </x-admin::fx.field.select>
                            </div>

                            <div class="col-md-4">
                                @if($loop->index === 0)
                                    <button type="button"
                                            wire:click="addCategory"
                                            class="btn btn-ghost-success">
                                        <x-admin::ui.icon.plus/>
                                        Addition category
                                    </button>
                                @else
                                    <button type="button"
                                            wire:click="removeCategory({{ $loop->index }})"
                                            class="btn btn-ghost-danger">
                                        <x-admin::ui.icon.x/>
                                        Remove
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
