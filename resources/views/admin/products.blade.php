@extends('admin.common.list', ['entity' => 'product'])

@section('body')
    @parent

<div x-data="{
        products: document.getElementById('products').$wire,
        filterBrand: document.getElementById('filter_brand').$wire,
        apply(payload) {
            if (typeof payload.filter != 'undefined') {
                this.products.$set('filter', payload.filter)
            }

            if (typeof payload.brand_id != 'undefined') {
                this.products.$set('brandId', payload.brand_id)
            }

            if (typeof payload.category_id != 'undefined') {
                this.filterBrand.$set('categoryId', payload.category_id)
                this.products.$set('categoryId', payload.category_id)
            }
        },
    }"
      x-on:apply="apply($event.detail)">
    <x-admin::ui.layout.page.aside>
        <x-slot:aside>
            <livewire:widget.filter/>

            <livewire:widget.filter-category
                id="filter_category"
            />

            <livewire:widget.filter-brand
                id="filter_brand"
            />
        </x-slot:aside>

        <x-slot:body>
            <livewire:widget.products
                id="products"
            />
        </x-slot:body>
    </x-admin::ui.layout.page.aside>
</div>
@endsection
