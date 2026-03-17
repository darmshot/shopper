@props([
    'top',
    'left',
    'right'
])
<div class="container">
    <div class="grid gap-5 mb-5
                grid-cols-1
                md:grid-cols-2 md:grid-rows-[auto_1fr_1fr]">
        <div class="order-1 md:order-2">
            {{ $top }}
        </div>

        <div class="order-2 md:order-1 md:row-span-3">
            {{ $left }}
        </div>

        <div class="order-3 md:order-3 md:row-span-2">
            {{ $right }}
        </div>
    </div>
    {{ $slot }}
</div>
