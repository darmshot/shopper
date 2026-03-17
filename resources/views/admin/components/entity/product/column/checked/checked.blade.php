@props([
    'product' => null,
    'head' => false,
])
@php
    /** @var \App\Models\Product $product */
@endphp
@if($head)
    <th class="w-1 text-end">
        <x-admin::fx.bulk-action.checked
            title="Select all Products"
        />
    </th>
@else
    <td class="align-top">
        <div class="d-flex gap-2">
            <div>
                <input
                    class="form-check-input m-0 align-middle table-selectable-check"
                    type="checkbox"
                    x-model="checked"
                    value="{{ $product->id }}"
                    title="Checked">
            </div>
        </div>
    </td>
@endif
