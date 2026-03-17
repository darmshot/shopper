<div {{ $attributes->class('card') }}
     x-data="{ open: false }">
    <div class="card-body">
        <div class="mb-3" x-data="{ value: @entangle('search').live }">
            <label class="form-label">Search brand</label>

            <div class="input-group input-group-flat">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Search..."
                    autocomplete="off"
                    x-model="value"
                />

                <div class="input-group-text">
                    <a href="#"
                       class="link-secondary"
                       title="Clear search"
                       data-bs-toggle="tooltip"
                       x-show="value.length"
                       @click.prevent="value = ''">
                        <x-admin::ui.icon.x/>
                    </a>
                </div>
            </div>
        </div>

        <ul
            class="list-unstyled mb-2"
            style="{{ $showAll ? 'max-height: 500px; overflow-y: auto;' : '' }}">
            <li class="py-1 cursor-pointer">
                <button type="button"
                        wire:click="$set('brandId', null)"
                        class="btn btn-sm btn-link {{ $brandId === null ? 'active' : '' }}">All brands
                </button>
            </li>
            @foreach($this->brands as $brand)
                <li class="py-1 cursor-pointer">
                    <button type="button"
                            wire:click="$set('brandId', '{{ $brand->id }}')"
                            class="btn btn-sm btn-link {{ $brandId === $brand->id ? 'active' : '' }}">{{ $brand->name }}</button>
                </li>
            @endforeach
        </ul>

        @if(!$showAll && $this->brands->count() >= 10)
            <div class="text-end">
                <button
                    type="button"
                    class="btn btn-sm btn-link"
                    wire:click="$set('showAll', true)">
                    Show all
                </button>
            </div>
        @endif
    </div>
</div>
