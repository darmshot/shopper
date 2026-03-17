@extends('admin.index')

@section('title', config('app.name') .' - ' . __("$entity.entity_name_singular"))

@section('header_action')
    <div class="d-flex">
        <div class="ms-auto">
            <a href="{{ route("admin.$entity.create", request()->query()) }}"
               class="btn btn-primary btn-3">
                <x-admin::ui.icon.plus/>
                Add new {{ $entity }}
            </a>
        </div>
    </div>
@endsection

@section('page_title', __("$entity.entity_name_singular"))

@section('body')
    <div class="container-xl">
        @if ($errors->any())
            <x-admin::fx.alert
                variant="danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-admin::fx.alert>
        @endif

        @session('success')
        <x-admin::fx.alert
            variant="success">
            {{ $value }}
        </x-admin::fx.alert>
        @endsession
    </div>
@endsection
