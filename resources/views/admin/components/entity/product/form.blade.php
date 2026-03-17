@props([
    'action',
    'method' => 'POST',
    'entity' => new \App\Models\Product(),
])
<x-admin::fx.form
    {{ $attributes }}
    :method="$method"
    :action="$action">
    <div class="container-xl">
        <livewire:entity.product.card.main-information
            class="mb-3"
            :product="$entity"
        />

        <livewire:entity.product.card.variants
            class="mb-3"
            :product="$entity"
        />

        <div class="row">
            <div class="col-12 col-md-6">
                <livewire:entity.shared.card.page-parameters
                    class="mb-3"
                    id="page_parameters"
                    :entity="$entity"
                    url-prefix="/products/"
                />
            </div>

            <div class="col-12 col-md-6">
                <livewire:entity.product.card.product-images
                    class="mb-3"
                    :product="$entity"
                />
            </div>

            <div class="col-12 col-md-6">
                <livewire:entity.product.card.product-properties
                    class="mb-3"
                    id="product_properties"
                    :product="$entity"
                />
            </div>

            <div class="col-12 col-md-6">
                <livewire:entity.product.card.relation-products
                    class="mb-3"
                    :product="$entity"
                />
            </div>

            <div class="col-12">
                <livewire:entity.product.card.short-description
                    class="mb-3"
                    :product="$entity"
                />
            </div>

            <div class="col-12">
                <livewire:entity.product.card.full-description
                    class="mb-3"
                    :product="$entity"
                />
            </div>
        </div>
    </div>
</x-admin::fx.form>

<script>
    document.addEventListener('livewire:initialized', () => {
        const pageParameters = document.getElementById('page_parameters')
        const productProperties = document.getElementById('product_properties')

        Livewire.on('entity.product.card.main-information.name.updated', ({name}) => {
            pageParameters.$wire.$set('name', name)
        })

        Livewire.on('entity.product.card.main-information.categories.0.updated', (payload) => {
            productProperties.$wire.$set('mainCategoryId', payload['categories.0'])
        })
    })
</script>
