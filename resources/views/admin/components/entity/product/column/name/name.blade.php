@props([
    'product' => null,
    'head' => false,
])
@php
    /** @var \App\Models\Product $product */
@endphp
@if($head)
    <th>Name</th>
@else
    <td class="align-top">
        <div class="d-flex align-items-center">
            <x-admin::fx.avatar
                :image="$product->image"
            />
            <div class="flex-fill">
                <div class="d-flex gap-1">
                    @foreach($product->categories as $category)
                        <div class="small">
                            <a href="{{ route('admin.category.edit', $category->id) }}">{{ $category->name }}</a>@if(!$loop->last),@endif
                        </div>
                    @endforeach
                </div>

                <a class="text-dark" href="{{ route('admin.product.edit', $product->id) }}">{{ $product->name }}</a>
            </div>
        </div>
    </td>
@endif
