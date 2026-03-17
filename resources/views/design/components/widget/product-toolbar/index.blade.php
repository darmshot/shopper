<div {{ $attributes }}
     id="product_toolbar"
     x-data="productToolbar">

{{--    Modal debug button  --}}
    {{--    <button class="btn btn-primary md:hidden" @click="openModal()">--}}
    {{--        Filters--}}
    {{--    </button>--}}

{{--    Desktop container --}}
    <div x-ref="desktop"
         class="hidden md:block"></div>

{{--  Mobile container  --}}
    <dialog
        x-ref="modal"
        class="modal md:hidden">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-icon btn-secondary absolute right-4 top-5 size-5">
                    <x-design::ui.icon.x-mark/>
                </button>
            </form>
            <h3 class="text-lg font-bold">Filters</h3>

            <div x-ref="mobile"
                 class="pt-4"></div>
        </div>
    </dialog>

{{--    Toolbar --}}
    <div x-ref="content">
        <form x-data="productToolbarForm"
              method="GET"
              action=""
              @filter-updated.debounce.350ms="submitForm()"
              @sort-updated.debounce.350ms="submitForm()"
              @submit.prevent.debounce.350ms="submitForm()">
            <div class="toolbar">
                {{ $slot }}
            </div>
        </form>
    </div>
</div>

@pushonce('scripts')
    @vite('resources/js/design/components/widget/product-toolbar.ts')
@endpushonce


