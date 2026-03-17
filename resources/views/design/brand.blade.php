@extends('design.index')

@section('title', $brand->meta_title)
@section('meta_description', $brand->meta_description)

@section('header_bottom')
    <x-design::widget.breadcrumbs
        class="text-black">
        <x-design::widget.breadcrumbs.item.link
            label="Brands"
            :route="route('brands')"
        />

        <x-design::widget.breadcrumbs.item.link
            :label="$brand->name"
        />
    </x-design::widget.breadcrumbs>
@endsection

@section('body')
    <x-design::entity.brand.detail
        :brand="$brand">
        <x-design::widget.product-toolbar>
            <x-design::widget.product-toolbar.sort/>

            <x-design::widget.product-toolbar.variant-filter
                :brand-id="$brand->id"
            />
        </x-design::widget.product-toolbar>

        <x-design::widget.catalog-products
            :brand-id="$brand->id"
        />
    </x-design::entity.brand.detail>
@endsection
