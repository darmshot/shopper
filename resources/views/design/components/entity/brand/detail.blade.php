@props([
    'brand',
])


<div class="container">
    <x-design::entity.brand.name.page-title
        :brand="$brand"
        class="mb-5"
    />

    {{ $slot }}
</div>
