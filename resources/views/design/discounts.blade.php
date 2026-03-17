@extends('design.index')

@section('title', 'Discount')

@section('header_bottom')
    <x-design::widget.breadcrumbs class="mt-5 text-black">
        <x-design::widget.breadcrumbs.item.link
            label="Discount"
        />
    </x-design::widget.breadcrumbs>
@endsection

@section('body')
    <x-design::ui.layout.catalog>
        <x-slot:header-left>
            <div class="flex items-baseline w-full flex-warap gap-5">
                <div>
                    <h1 class="h1">With discount</h1>
                </div>

                <div class="ml-auto">
                    <x-design::fx.btn.product-toolbar-filter/>
                </div>
            </div>
        </x-slot:header-left>

        <x-design::widget.product-toolbar
            @product-toolbar.window="openModal()">
            <x-design::widget.product-toolbar.sort/>

            <x-design::widget.product-toolbar.variant-filter/>
        </x-design::widget.product-toolbar>

        <x-design::widget.catalog-products
            discount-only
        />
    </x-design::ui.layout.catalog>
@endsection
