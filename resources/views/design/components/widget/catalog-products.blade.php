<div {{ $attributes }}>
    @if($products->isNotEmpty())
        <div class="responsive-grid-cols-6">
            @foreach($products as $product)
                <div>
                    <x-design::entity.product.preview
                        :product="$product"
                    />
                </div>
            @endforeach
        </div>

        {{ $products->links('design.common.pagination') }}
    @else
        <div role="alert" class="alert">
            <x-design::ui.icon.info-circle
                class="stroke-info h-6 w-6 shrink-0"
            />
            <span>Products not found.</span>
        </div>
    @endif
</div>

