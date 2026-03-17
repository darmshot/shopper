@extends('admin.common.entity', ['entity' => 'category'])

@section('body')
    @parent

    @if(request()->routeIs('admin.category.create'))
        <x-admin::entity.category.form
            method="POST"
            id="form"
            :action="route('admin.category.store')"
        />
    @else
        <x-admin::entity.category.form
            method="PUT"
            id="form"
            :entity="$category"
            :action="route('admin.category.update', $category->id)"
        />
    @endif
@endsection
