@props([
    'product'
])
@php
    /** @var \App\Models\Product $product */
@endphp
<div x-data>
    <div class="join">
        @foreach($product->variants as $variant)
            <label class="btn btn-outline btn-sm border-transparent  has-checked:border-b-black has-checked:bg-gray-100  join-item cursor-pointer">
                <input type="radio"
                       data-price="{{money($variant->price)}}"
                       data-old-price="{{$variant->old_price ? money($variant->old_price) : ''}}"
                       @checked($loop->first)
                       name="variant_id"
                       @click="$dispatch('variant-switched')"
                       value="{{ $variant->id }}"
                       class="hidden peer"
                />
                <span class="">
                        {{ $variant->sku }}
                </span>
            </label>
        @endforeach
    </div>
</div>
