@props([
    'product'
])
@if($product->brand)
    <div {{ $attributes }}>
        <a class="underline" href="{{ route('brand.show', $product->brand->url) }}">{{ $product->brand->name }}</a>
    </div>
@endif
