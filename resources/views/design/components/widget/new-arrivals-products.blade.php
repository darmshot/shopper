@props([
    'cols' => 6
])
<div>
    <div class="h2 mb-5">New arrivals</div>
    <div class="responsive-grid-cols-{{ $cols }}">
        @foreach($products as $product)
            <div>
                <x-design::entity.product.preview
                    :product="$product"
                />
            </div>
        @endforeach
    </div>
</div>
