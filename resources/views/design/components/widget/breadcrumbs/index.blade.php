<div {{ $attributes->class(['breadcrumbs']) }}>
    <ul class="flex-wrap">
        <x-design::widget.breadcrumbs.item.link
        :route="route('home')"
        label="Main"
        />
        {{ $slot }}
    </ul>
</div>
