<div>
    @foreach($product->variants as $variant)
        <span class="badge {{ $variant->out_of_stock ? 'badge-neutral' : 'badge-secondary' }}">
                        {{ $variant->name ?? $variant->sku }}
                </span>
    @endforeach
</div>
