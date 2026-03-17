@extends('admin.index')

@section('header_action')
    <div class="d-flex">
        <div class="ps-4">
            <a
                href="{{ route("admin.$entity.index") }}"
                form="form"
                class="btn">
                <x-admin::ui.icon.chevron-left/>
                Back
            </a>
        </div>
        <div class="ms-auto">
            <button
                type="submit"
                form="form"
                class="btn btn-primary btn-3">
                <x-admin::ui.icon.plus/>
                Save
            </button>
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
