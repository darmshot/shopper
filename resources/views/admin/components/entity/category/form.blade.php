@props([
    'action',
    'method' => 'POST',
    'entity' => new \App\Models\Category()
])
<x-admin::fx.form
    {{ $attributes }}
    :method="$method"
    :action="$action">
    <div class="container-xl">
        <livewire:entity.category.card.main-information
            class="mb-3"
            :category="$entity"
        />

        <div class="row">
            <div class="col-12 col-md-6">
                <livewire:entity.shared.card.page-parameters
                    class="mb-3"
                    id="page_parameters"
                    url-prefix="/catalog/"
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

        Livewire.on('entity.category.card.main-information.name.updated', ({name}) => {
            pageParameters.$wire.$set('name', name)
        })
    })
</script>
