@php
    $activeChildren = [];
@endphp

<div {{ $attributes }}>
    @if($menu->firstLevel->isNotEmpty())
        <ul class="join flex flex-wrap">
            @foreach($menu->firstLevel as $item)
                <li class="join-item">
                    <a href="{{ $route($item->entity->url) }}"
                       class="btn btn-neutral [--btn-border:#FFFFFF] {{ $item->childIds->has($categoryId) ? 'active': '' }}">
                        {{ $item->entity->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
    @if($menu->secondLevel->isNotEmpty())
        <ul class="join flex flex-wrap -mt-px">
            @foreach($menu->secondLevel as $child)
                <li class="join-item">
                    <a href="{{ $route($child->entity->url) }}"
                       class="btn btn-neutral font-normal [--btn-border:#FFFFFF] {{ $child->entity->id === $categoryId ? 'active': '' }}">
                        {{ $child->entity->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
