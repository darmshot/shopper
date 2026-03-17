@props([
    'product' => null,
    'head' => false,
])
@php
    /** @var \App\Models\Product $product */
@endphp
@if($head)
    <th class="w-1"></th>
@else
    <td class="align-top">
        <div class="btn-actions justify-content-end">
            <x-admin::fx.action.view
                :route="route('product.show', $product->url)"
            />

            <x-admin::fx.action.active
                :active="$product->active"
                :route="route('api.admin.product.update', $product->id)"
                :entity="__('product.entity_name_singular')"
                @success="$wire.$refresh"
            />

            <x-admin::fx.action.duplicate
                :route="route('api.admin.product.duplicate', $product->id)"
                :entity="__('product.entity_name_singular')"
                @success="$wire.$refresh"
            />

            <x-admin::fx.action.featured
                :featured="$product->featured"
                :route="route('api.admin.product.update', $product->id)"
                :entity="__('product.entity_name_singular')"
                @success="$wire.$refresh"
            />

            <x-admin::fx.action.delete
                :route="route('api.admin.product.destroy', $product->id)"
                :entity="$product->name"
                @success="$wire.$refresh"
            />
        </div>
    </td>
@endif
