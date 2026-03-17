@props([
    'product',
])
@if($product->image)
    <figure>
        <img
            src="{{ asset("storage/$product->image") }}"
            alt="{{ $product->name }}"
            class="aspect-3/4 object-cover"
        />
    </figure>
@else
    <x-design::fx.placeholder/>
@endif

