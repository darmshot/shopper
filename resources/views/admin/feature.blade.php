@extends('admin.common.entity', ['entity' => 'feature'])

@section('body')
    @parent

    @if(request()->routeIs('admin.feature.create'))
        <x-admin::entity.feature.form
            method="POST"
            id="form"
            :action="route('admin.feature.store')"
        />
    @else
        <x-admin::entity.feature.form
            method="PUT"
            id="form"
            :entity="$feature"
            :action="route('admin.feature.update', $feature->id)"
        />
    @endif
@endsection
