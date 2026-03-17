@foreach($features as $feature)
    <div class="toolbar-section z-10">
        <div class="dropdown dropdown-hover"
             x-data="featureFilter"
             data-name="{{ $feature->name }}">
            <button type="button"
                    class="btn font-normal border-none {{ $active($feature->id) ? 'btn-primary' : '' }}">
                {{ $feature->name }}
            </button>
            <ul
                class="dropdown-content menu w-52 rounded-box bg-base-100 shadow-sm"
                id="{{"feature_filter_popover_$feature->id"}}">
                @foreach($feature->options as $option)
                    <li>
                        <label class="label">
                            <input type="checkbox"
                                   @checked($activeOption(featureId: $feature->id, value: $option->value))
                                   class="checkbox"
                                   name="features[{{ $feature->id }}][{{ $option->value }}]"
                                   value="{{ $option->value }}"
                                   data-checkbox
                                   @click="$dispatch('filter-updated')"
                            />
                            {{ $option->value }}
                        </label>
                    </li>
                @endforeach
                <li class="block">
                    <button type="button"
                            class="btn btn-secondary btn-link font-normal"
                            @click="reset()">Reset</button>
                </li>
            </ul>
        </div>
    </div>
@endforeach

@pushonce('scripts')
    @vite('resources/js/design/components/widget/product-toolbar/feature-filter.ts')
@endpushonce
