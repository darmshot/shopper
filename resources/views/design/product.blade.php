@extends('design.index')

@section('title', $product->meta_title)
@section('meta_description', $product->meta_description)

@section('body')
    <x-design::entity.product.detail
        :product="$product"
        class="mt-10">
        <x-slot:top>
            <x-design::widget.breadcrumbs
                class="text-black pt-0">
                @if($product->category_id)
                    <x-design::widget.breadcrumbs.category
                        :category-id="$product->category_id"
                        :with-last-route="true"
                    />
                @endif

                <x-design::widget.breadcrumbs.item.link
                    :label="$product->name"
                />
            </x-design::widget.breadcrumbs>
        </x-slot:top>

        <x-slot:body>
            <x-design::widget.related-products
                :product-id="$product->id"
                class="mt-10"
            />
        </x-slot:body>
    </x-design::entity.product.detail>
@endsection
