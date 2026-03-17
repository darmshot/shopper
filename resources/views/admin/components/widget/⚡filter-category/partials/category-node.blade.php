@php
    /** @var \App\Services\Tree\Data\Node<\App\Models\Category> $node */
@endphp
<li class="py-1">
    <div class="d-flex align-items-center gap-1">
        @if($node->children->isNotEmpty())
            <span class="cursor-pointer"
                  wire:click="$toggle('expanded.{{ $node->entity->id }}')">
                {{ $expanded[$node->entity->id] ?? false ? '▾' : '▸' }}
            </span>
        @else
            <span style="width: 1rem;"></span>
        @endif

        <button type="button"
                wire:click="$set('categoryId', '{{ $node->entity->id }}')"
                class="btn btn-sm btn-link {{ $categoryId === $node->entity->id ? 'active' : '' }}">
            {{ $node->entity->name }}
        </button>
    </div>

    @if(($expanded[$node->entity->id] ?? false) && $node->children->isNotEmpty())
        <ul class="list-unstyled ms-4">
            @foreach($node->children as $child)
                @include('admin.components.widget.⚡filter-category.partials.category-node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
