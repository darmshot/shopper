<div class="navbar mt-10">
    <div class="navbar-group">
        <div class="navbar-group-item border-l-0">
            <a href="/" class="btn btn-link btn-secondary font-semibold no-underline">{{ str(config('app.name'))->upper() }}</a>
        </div>

        <div class="navbar-group-item px-6 hidden md:flex">
            <a href="{{ route('catalog') }}"
               class="btn btn-secondary btn-link font-semibold uppercase no-underline hover:text-primary {{ $active('catalog') ? 'active' : '' }}">Catalog</a>
            <a href="{{ route('discounts') }}"
               class="btn btn-secondary btn-link uppercase no-underline hover:text-primary">Discount</a>
        </div>
    </div>

    <div class="navbar-group ms-auto">
        <div class="navbar-group-item md:hidden">
            <label for="drawer_menu" class="btn-navbar-icon drawer-button">
                <x-design::ui.icon.bars-3/>
            </label>
        </div>
    </div>
</div>
