@props([
    'action',
    'method' => 'POST',
    'entity' => new \App\Models\Brand(),
])

<x-admin::fx.form
    {{ $attributes }}
    :method="$method"
    :action="$action">
    <div class="container-xl">
        <livewire:entity.brand.card.main-information
            class="mb-3"
            :brand="$entity"
        />

        <div class="row">
            <div class="col-12 col-md-6">
                <livewire:entity.shared.card.page-parameters
                    class="mb-3"
                    id="page_parameters"
                    url-prefix="/brands/"
                    :entity="$entity"
                />
            </div>

            <div class="col-12 col-md-6">
                <livewire:entity.shared.card.image
                    class="mb-3"
                    :entity="$entity"
                />
            </div>

            <div class="col-12">
                <livewire:entity.shared.card.description
                    class="mb-3"
                    :entity="$entity"
                />
            </div>
        </div>
    </div>
</x-admin::fx.form>

<script>
    document.addEventListener('livewire:initialized', () => {
        const pageParameters = document.getElementById('page_parameters')

        Livewire.on('admin.brand.card.main-information.name.updated', ({name}) => {
            pageParameters.$wire.$set('name', name)
        })
    })
</script>
