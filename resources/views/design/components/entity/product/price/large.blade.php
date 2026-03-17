@props([
    'product'
])
@php
    /**  @var \App\Models\Product $product */
@endphp
<div {{ $attributes->class('text-2xl mt-2 text-right') }}
     x-data="productPrice">
    <span x-ref="price">{{ money($product->price) }}</span>

    <span x-ref="oldPrice" class="text-xl text-gray-500 line-through">@if($product->old_price){{ money($product->old_price) }}@endif</span>
</div>


@pushonce('scripts')
    @vite('resources/js/design/components/entity/product/price.ts')
@endpushonce
