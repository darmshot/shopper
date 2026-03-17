@extends('admin.common.entity', ['entity' => 'product'])

@section('body')
    @parent

    @if(request()->routeIs('admin.product.create'))
        <x-admin::entity.product.form
            method="POST"
            id="form"
            :action="route('admin.product.store')"
        />
    @else
        <x-admin::entity.product.form
            method="PUT"
            id="form"
            :entity="$product"
            :action="route('admin.product.update', $product->id)"
        />
    @endif
@endsection
