<div {{ $attributes }}>
    <div class="h2 mb-4">
      On model
    </div>
    <div class="responsive-grid-cols-6">
        @foreach($products as $product)
            <div>
                <x-design::entity.product.preview
                    :product="$product"
                />
            </div>
        @endforeach
    </div>
</div>

