@props([
    'product',
    'variant' => 'md'
])
@php
    /**
    * @var \App\Models\Product $product
    */
@endphp

@switch($variant)
    @case('lg')
        <div class="text-2xl mt-2 text-right">
            {{ money($product->price) }}
            @if($product->old_price)
                <span class="text-xl text-gray-500 line-through">{{ money($product->old_price) }}</span>
            @endif
        </div>
    @break
    @default
        {{ money($product->price) }}
        @if($product->old_price)
            <span class="text-sm  text-gray-500 line-through">{{ money($product->old_price) }}</span>
        @endif
@endswitch
