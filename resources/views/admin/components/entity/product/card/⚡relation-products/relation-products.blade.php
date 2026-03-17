<div {{ $attributes->class('card') }}>
    <div class="card-header">Relation Products</div>
    <div class="card-body">
        <div x-sort="
        const ids = [...$el.querySelectorAll('[x-sort\\:item]')]
            .map(el => el.querySelector('input[name=\'related[]\']').value)
            $wire.call('reorderRelated', ids)
        ">
            @foreach($this->related as $id)
                @php
                    $related = $this->relatedCollection->get($id)
                @endphp
                <div x-sort:item class="row mb-1">
                    <div x-sort:handle class="col-auto cursor-move align-self-center">
                        <x-admin::ui.icon.grip-vertical/>
                    </div>

                    @if($related->image)
                        <div class="col-auto">
                            <x-admin::fx.avatar
                                :image="$related->image"
                            />
                        </div>
                    @endif

                    <div class="col align-self-center">
                        <x-admin::fx.field.hidden
                            name="related[]"
                            :value="$related->id"
                        />
                        <a href="{{ route('admin.product.edit', $related->id) }}">{{$related->name}}</a>
                    </div>

                    <div class="col-auto">
                        <button
                            type="button"
                            wire:click="removeRelated('{{ $related->id }}')"
                            class="btn btn-icon btn-ghost-danger">
                            <x-admin::ui.icon.x/>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="my-2">
            <input type="text"
                   class="form-control"
                   placeholder="Search product..."
                   wire:model.live="searchRelated">
        </div>

        {{-- Suggestions --}}
        @if(!empty($suggestRelated))
            <div class="list-group shadow-sm">
                @foreach($suggestRelated as $product)
                    <button type="button"
                            wire:click="addRelated('{{ $product['id'] }}')"
                            class="list-group-item list-group-item-action d-flex align-items-center">

                        @if(!empty($product['image']))
                            <x-admin::fx.avatar
                                :image="$product['image']"
                            />
                        @endif

                        <span>{{ $product['name'] }}</span>
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>
