<div x-data="productToolbarSort({sort: '{{ $sort }}'})"
     class="join">
    <div class="toolbar-section" >
        <button class="btn font-normal border-none {{ in_array($sort, ['new_desc', 'new_asc']) ? 'btn-primary' : '' }}"
                type="button"
                @click="toggle('new')"
        >
            New @if($sort === 'new_desc')
                <span>▼</span>
            @else
                <span>▲</span>
            @endif
        </button>
    </div>

    <div class="toolbar-section">
        <button class="btn font-normal border-none {{ in_array($sort, ['price_asc', 'price_desc']) ? 'btn-primary' : '' }}"
                type="button"
                @click="toggle('price')">
            Price @if($sort === 'price_desc')
                <span>▼</span>
            @else
                <span>▲</span>
            @endif
        </button>
    </div>
    <template x-if="sort">
        <input
            type="hidden"
            name="sort"
            x-model="sort"
            value="{{ $sort }}"
        />
    </template>
</div>

@pushonce('scripts')
    @vite('resources/js/design/components/widget/product-toolbar/sort.ts')
@endpushonce
