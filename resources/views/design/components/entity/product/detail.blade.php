@props([
    'product',
    'top' => null,
    'body' => null,
])
<div {{ $attributes }}
     x-data="productDetail"
     @variant-switched="setPriceFromVariant">
    <x-design::ui.layout.detail>
        <x-slot:top>
            {{ $top }}

            <div class="card md:bg-base-100 md:-mb-5">
                <div class="card-section max-md:px-0 max-md:py-0">
                    <x-design::entity.product.name.page-title
                        :product="$product"
                    />

                    <x-design::entity.product.brand.link
                        :product="$product"
                        class="mt-2"
                    />
                </div>

                <div class="card-section max-md:px-0 max-md:py-0 md:border-y">
                    {!! $product->annotation !!}
                </div>
            </div>
        </x-slot:top>

        <x-slot:left>
            <div class="-mx-5 md:mx-0">
                <x-design::entity.product.image.gallery
                    :product="$product"
                />
            </div>
        </x-slot:left>

        <x-slot:right>
            <div class="space-y-10">
                <div class="card md:bg-base-100">
                    <div class="card-section max-md:px-0 max-md:py-0">
                        <x-design::entity.product.variants.switch
                            :product="$product"
                        />

                        <x-design::entity.product.price.large
                            :product="$product"
                        />
                    </div>
                </div>

                <div class="card md:bg-base-100">
                    <div class="card-body max-md:px-0 max-md:py-0">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </x-slot:right>

        {{ $body }}
    </x-design::ui.layout.detail>
</div>

@pushonce('scripts')
    @vite('resources/js/design/components/entity/product/detail.ts')
@endpushonce
