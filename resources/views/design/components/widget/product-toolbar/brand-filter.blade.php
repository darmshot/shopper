<div class="toolbar-section z-10">
    <div x-data="brandFilter"
         class="dropdown dropdown-hover">
        <button type="button"
                class="btn font-normal border-none {{ $active ? 'btn-primary' : '' }}">
            Brand
        </button>

        <ul class="dropdown-content menu w-52 rounded-box bg-base-100 shadow-sm">
            @foreach($brands as $brand)
                <li>
                    <label class="label">
                        <input type="checkbox"
                               data-checkbox
                               @checked($checked(brandId: $brand->id))
                               class="checkbox"
                               name="brands[]"
                               value="{{ $brand->id }}"
                               @click="$dispatch('filter-updated')"
                        />
                        {{ $brand->name }}
                    </label>
                </li>
            @endforeach
            <li class="block">
                <button type="button"
                        class="btn btn-secondary btn-link font-normal"
                        @click="reset()">Reset
                </button>
            </li>
        </ul>
    </div>
</div>

@pushonce('scripts')
    @vite('resources/js/design/components/widget/product-toolbar/brand-filter.ts')
@endpushonce
