@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item active" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <a href="#" class="page-link">
                    <span aria-hidden="true">Prev</span>
                </a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Prev</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active page-item" aria-current="page">
                            <a href="#" class="page-link">
                                <span>{{ $page }}</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</a>
            </li>
        @else
            <li class="active page-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                <a href="#" class="page-link">
                    <span aria-hidden="true">Next</span>
                </a>
            </li>
        @endif
    </ul>
@endif
