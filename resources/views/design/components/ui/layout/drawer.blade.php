@props([
    'content',
    'sidebar'
])
<div class="drawer">
    <input id="drawer_menu" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
        {{ $content }}
    </div>
    <div class="drawer-side">
        <label for="drawer_menu" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="bg-base-100 min-h-full">
            <label for="drawer_menu"
                   class="btn btn-sm btn-circle btn-icon btn-secondary absolute right-4 top-5 size-5 z-10">
                <x-design::ui.icon.x-mark/>
            </label>
            {{ $sidebar }}
        </div>
    </div>
</div>
