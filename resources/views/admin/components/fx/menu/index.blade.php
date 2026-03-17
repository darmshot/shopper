<div class="navbar navbar-expand-md d-print-none mb-3">
    <div class="container-xl">
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar-menu"
            aria-controls="navbar-menu"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="navbar-nav">
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle"
                   href="javascript:void(0)"
                   data-bs-toggle="dropdown"
                   data-bs-auto-close="outside"
                   role="button"
                   aria-expanded="false">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><x-admin::ui.icon.package/></span>
                    <span class="nav-link-title"> Catalog </span>
                </a>
                <div class="dropdown-menu">
                    <div class="dropdown-menu-columns">
                        <div class="dropdown-menu-column">
                            <x-admin::fx.menu.dropdown-item :route="route('admin.product.index')">Products</x-admin::fx.menu.dropdown-item>
                            <x-admin::fx.menu.dropdown-item :route="route('admin.category.index')">Categories</x-admin::fx.menu.dropdown-item>
                            <x-admin::fx.menu.dropdown-item :route="route('admin.brand.index')">Brands</x-admin::fx.menu.dropdown-item>
                            <x-admin::fx.menu.dropdown-item :route="route('admin.feature.index')">Features</x-admin::fx.menu.dropdown-item>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
