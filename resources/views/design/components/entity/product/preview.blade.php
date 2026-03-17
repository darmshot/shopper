<a href="{{ route('product.show', $product->url) }}" class="card">
    <x-design::entity.product.image.preview
        :product="$product"
    />
    <div class="card-body px-0">
        <div class="font-medium">{{ $product->name }}</div>
        <div>
            <x-design::entity.product.price
                :product="$product"
            />
        </div>
    </div>
</a>
