<div class="d-flex align-items-center">
    <div class="dt-info" role="status">Showing <span class="fw-bold">{{ $paginator->firstItem() }}</span> to <span class="fw-bold">{{ $paginator->lastItem() }}</span>
        of <span class="fw-bold">{{ $paginator->total() }}</span> entries.
    </div>

    @if($paginator->hasPages())
        <ul class="pagination m-0 ms-auto">
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    @endif
</div>
