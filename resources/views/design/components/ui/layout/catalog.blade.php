@props([
    'headerLeft',
    'headerRight' => null,
])
<div class="container py-10">
    <div class="grid xl:grid-cols-6 gap-5 mb-5">
        <div class=" {{ $headerRight ? 'xl:col-span-1' : 'xl:col-span-6' }}">
            {{ $headerLeft }}
        </div>

        @if($headerRight)
            <div class="xl:col-span-5">
                {{ $headerRight }}
            </div>
        @endif
    </div>

    {{ $slot }}
</div>
