@php
    /** @var \App\Services\Tree\Data\Node<\App\Models\Category> $category */
@endphp
@foreach($categories as $category)
    @if($loop->last && $withLastRoute === false)
        <x-design::widget.breadcrumbs.item.link
            :label="$category->entity->name"
        />
    @else
        <x-design::widget.breadcrumbs.item.link
            :label="$category->entity->name"
            :route="route('category.show', $category->entity->url)"
        />
    @endif
@endforeach
