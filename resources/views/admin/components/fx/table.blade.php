@props([
    'headStack' => 'table-heads'
])
<table {{ $attributes->class('table table-vcenter table-striped table-mobile-md') }}>
    <thead>
        <tr>
            @stack($headStack)
        </tr>
    </thead>
    <tbody>
    {{ $slot }}
    </tbody>
</table>
