@extends('admin.common.entity', ['entity' => 'brand'])

@section('body')
    @parent

    @if(request()->routeIs('admin.brand.create'))
        <x-admin::entity.brand.form
            method="POST"
            id="form"
            :action="route('admin.brand.store')"
        />
    @else
        <x-admin::entity.brand.form
            method="PUT"
            id="form"
            :entity="$brand"
            :action="route('admin.brand.update', $brand->id)"
        />
    @endif
@endsection
