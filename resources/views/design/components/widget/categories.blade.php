<div class="h2 mb-5">Catalog</div>
<ul class="menu bg-base-100 w-full">
    @php
        /** @var \App\Services\Tree\Data\Node<\App\Models\Category> $category */
    @endphp
    @foreach($categories as $category)
        <li><a href="{{ route('category.show', $category->entity->url) }}">{{ $category->entity->name }}</a></li>
    @endforeach
</ul>
