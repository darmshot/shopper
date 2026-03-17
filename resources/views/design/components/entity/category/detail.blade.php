@props([
    'category',
    'headerRight',
    'titleNavbar',
])
<x-design::ui.layout.catalog>
    <x-slot:header-left>
        <div class="flex items-baseline w-full flex-warap gap-5">
            <div>
                <x-design::entity.category.name.page-title
                    :category="$category"
                />
            </div>
            <div class="ml-auto">
                {{ $titleNavbar }}
            </div>
        </div>
    </x-slot:header-left>

    <x-slot:header-right>
        {{ $headerRight }}
    </x-slot:header-right>

    {{ $slot }}
</x-design::ui.layout.catalog>
