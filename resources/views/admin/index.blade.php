<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
{{--    <meta name="viewport" content="width=device-width, initial-scale=1"/>--}}

    <meta name="viewport" content="width=1280">
    <title>@yield('title', config('app.name') . ' - Admin panel')</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.ts'])
    @livewireStyles
    @stack('styles')
</head>

<body style="min-width: 1280px">
@include('admin.common.header')

<div class="page">
<x-admin::fx.menu />

    <div class="page-wrapper">
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <h2 class="page-title">@yield('page_title')</h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col d-print-none">
                        @yield('header_action')
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body">
            @yield('body')
        </div>
    </div>
</div>

<x-admin::fx.toast/>
<x-admin::fx.modal-dialog/>

@livewireScripts
@stack('scripts')
</body>
</html>
