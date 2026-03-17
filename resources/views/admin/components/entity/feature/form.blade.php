@props([
    'action',
    'method' => 'POST',
    'entity' => new \App\Models\Feature(),
])
<x-admin::fx.form
    {{ $attributes }}
    :method="$method"
    :action="$action">
    <div class="container-xl">
        <livewire:entity.feature.card.main-information
            class="mb-3"
            :feature="$entity"
        />

        <div class="row">
            <div class="col-12 col-md-6">
                <livewire:entity.feature.card.use-in-categories
                    class="mb-3"
                    :feature="$entity"
                />
            </div>

            <div class="col-12 col-md-6">
                <livewire:entity.feature.card.property-settings
                    class="mb-3"
                    :feature="$entity"
                />
            </div>
        </div>
    </div>
</x-admin::fx.form>
