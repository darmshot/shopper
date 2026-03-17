@props([
    'product' => null,
    'head' => false,
])
@php
    /** @var \App\Models\Product $product */
@endphp
@if($head)
    <th class="text-end">
        <div class="d-inline-block text-start">
            <div>
                Variant
            </div>
            <div class="text-lowercase">
                <a @click="toggleAllVariants()"
                   x-data="
                   {
                        get expanded() {
                            return this.$data.expandedVariants
                        }
                   }"
                   href="javascript:void(0)">
                    <span x-cloak x-show="expanded">Hide all variants</span>
                    <span x-cloak x-show="!expanded">Show all variants</span>
                    <x-admin::ui.icon.switch-vertical style="--tblr-icon-size:0.75rem;"/>
                </a>
            </div>
        </div>
    </th>
@else
    <td class="align-top text-secondary">
        <div class="mb-1">
            @foreach($product->variants->take(1) as $variant)
                <div class="row justify-content-end ms-auto mb-1 g-2 align-items-baseline">
                    @if($variant->name)
                        <div class="col-auto">{{ $variant->name }}</div>
                    @endif

                    <div class="col-8 col-lg-4 col-xl-3">
                        <x-admin::fx.editable.text
                            name="price"
                            title="price"
                            placeholder="Price"
                            value="{{ $variant->price }}"
                            class="form-control-sm"
                            suffix="{{ app()->getCurrency() }}"
                            :route="route('api.admin.product.variants.update_price', ['product' => $product->id, 'variant' => $variant->id])"
                            entity="Variant"
                        />
                    </div>

                    <div class="col-8 col-lg-4 col-xl-3">
                        <x-admin::fx.editable.text
                            name="stock"
                            title="Stock"
                            placeholder="∞"
                            value="{{ $variant->stock }}"
                            class="form-control-sm"
                            :route="route('api.admin.product.variants.update_stock', ['product' => $product->id, 'variant' => $variant->id])"
                            entity="Variant"
                            suffix="pcs."
                        />
                    </div>
                </div>
            @endforeach

            @if($product->variants->count() > 1)
                <div x-show="variantsExpanded" x-collapse>
                    @foreach($product->variants->skip(1) as $variant)
                        <div class="row justify-content-end ms-auto mb-1 g-2 align-items-baseline">
                            @if($variant->name)
                                <div class="col-auto">{{ $variant->name }}</div>
                            @endif

                            <div class="col-8 col-lg-4 col-xl-3">
                                <x-admin::fx.editable.text
                                    name="price"
                                    title="price"
                                    placeholder="Price"
                                    value="{{ $variant->price }}"
                                    class="form-control-sm"
                                    suffix="{{ app()->getCurrency() }}"
                                    :route="route('api.admin.product.variants.update_price', ['product' => $product->id, 'variant' => $variant->id])"
                                    entity="Variant"
                                />
                            </div>

                            <div class="col-8 col-lg-4 col-xl-3">
                                <x-admin::fx.editable.text
                                    name="stock"
                                    title="Stock"
                                    placeholder="∞"
                                    value="{{ $variant->stock }}"
                                    class="form-control-sm"
                                    :route="route('api.admin.product.variants.update_stock', ['product' => $product->id, 'variant' => $variant->id])"
                                    entity="Variant"
                                    suffix="pcs."
                                />
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end">
                    <a @click="toggle();"
                       href="javascript:void(0)"
                       class="small">
                        {{ $product->variants_count }} variants
                        <x-admin::ui.icon.switch-vertical style="--tblr-icon-size:0.75rem;"/>
                    </a>
                </div>
            @endif
        </div>
    </td>
@endif
