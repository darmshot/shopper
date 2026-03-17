<div x-data="variantFilter({variant: '{{ $variantInput }}'})"
    class="toolbar-section">
    @foreach($variants as $variant)
        <button class="btn font-normal border-none {{ $active($variant)  ? 'btn-primary' : ''  }}"
               type="button"
               value="{{ $variant }}"
                @click="handle"
        >{{ $variant }}</button>
    @endforeach
    <template x-if="variant">
        <input
            type="hidden"
            name="variant"
            :value="variant"
        />
    </template>
</div>

@pushonce('scripts')
    @vite('resources/js/design/components/widget/product-toolbar/variant-filter.ts')
@endpushonce
