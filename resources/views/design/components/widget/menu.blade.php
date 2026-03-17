<ul class="menu rounded-box w-80">
    <li>
        <a href="{{ route('home') }}"
           class="{{ false ? 'active' : '' }}">Home</a>
    </li>

    <li>
        <a href="{{ route('discounts') }}"
           class="">Discount</a>
    </li>

    @foreach($categories as $category)
        {!!  $renderNode($category)  !!}
    @endforeach
</ul>
