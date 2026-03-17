<div {{ $attributes->class('card') }}
     x-data="{ open: true }">
    <div class="card-body">
        {{-- Search --}}
        <div class="mb-3" x-data="{ value: @entangle('search').live }">
            <label class="form-label">Search category</label>

            <input type="text"
                   class="form-control"
                   placeholder="Search..."
                   x-model="value" />
        </div>

        {{-- Breadcrumb --}}
        @if(count($this->breadcrumbs))
            <div class="mb-2 small text-muted">
                @foreach($this->breadcrumbs as $breadcrumb)
                    <span @if(!$loop->last) wire:click="$set('categoryId', '{{ $breadcrumb->id }}')" class="cursor-pointer text-primary" @endif>
                        {{ $breadcrumb->name }}
                    </span>
                    @if(!$loop->last) › @endif
                @endforeach
            </div>
        @endif

        {{-- Tree --}}
        <ul class="list-unstyled">
            <li class="py-1">
                <button type="button"
                        wire:click="$set('categoryId', '')"
                        class="btn btn-sm btn-link {{ $categoryId === '' ? 'active' : '' }}">
                    All categories
                </button>
            </li>

            @foreach($this->filteredTree as $node)
                @include('admin.components.widget.⚡filter-category.partials.category-node', ['node' => $node])
            @endforeach
        </ul>
    </div>
</div>
