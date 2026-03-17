@extends('design.index')

@section('title', $category->meta_title)
@section('meta_description', $category->meta_description)

@section('header_bottom')
    <x-design::widget.breadcrumbs
     class="text-black mt-5">
        <x-design::widget.breadcrumbs.category
            :category-id="$category->id"
        />
    </x-design::widget.breadcrumbs>
@endsection

@section('body')
    <x-design::entity.category.detail
        :category="$category">
        <x-slot:header-right>
            <x-design::widget.category-top-menu
                :category-id="$category->id"
            />
        </x-slot:header-right>

        <x-slot:title-navbar>
            <x-design::fx.btn.product-toolbar-filter/>
        </x-slot:title-navbar>

        <x-design::widget.product-toolbar
            @product-toolbar.window="openModal()">
            <x-design::widget.product-toolbar.sort/>

            <x-design::widget.product-toolbar.feature-filter
                :category-id="$category->id"
            />

            <x-design::widget.product-toolbar.variant-filter
                :category-id="$category->id"
            />

            <x-design::widget.product-toolbar.brand-filter
                :category-id="$category->id"
            />
        </x-design::widget.product-toolbar>

        <x-design::widget.catalog-products
            :category-id="$category->id"
        />
    </x-design::entity.category.detail>
@endsection
