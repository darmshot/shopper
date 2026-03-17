<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <title>@yield('title', config('app.name'))</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')"/>
    @endif
    @if(isset($canonical))
        <link rel="canonical" href="{{ app()->basePath() }}{{ $canonical }}"/>
    @endif
    @vite('resources/css/design.css')
    @stack('styles')
</head>

<body>
<x-design::ui.layout.drawer>
    <x-slot:content>
        @include('design.common.header')

        @yield('body')
    </x-slot:content>

    <x-slot:sidebar>
        <x-design::widget.menu/>
    </x-slot:sidebar>
</x-design::ui.layout.drawer>

@vite('resources/js/design.ts')
@stack('scripts')
</body>
</html>
