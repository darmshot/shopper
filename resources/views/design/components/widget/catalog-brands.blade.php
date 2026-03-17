<div>
    <ul class="columns-3 gap-16 mb-8">
        @foreach($groups as $group)
            <li class="break-inside-avoid">
                <div class="py-1 text-xl font-bold">
                    {{ $group->symbol }}
                </div>

                <ul>
                    @foreach($group->items as $brand)
                        <li>
                            <a href="{{ route('brand.show', $brand->url) }}"
                               class="block py-1">{{ $brand->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    {{ $groups->links('design.common.pagination') }}
</div>
