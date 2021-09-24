@if ($paginator->hasPages())
    <nav class="mt-3">
        <ul class="justify-content-center pagination flex-wrap me">
        @if ($paginator->onFirstPage())
            <li class="page-item mx-1 disabled" aria-disabled="true" aria-label="« Previous">
                <span class="page-link border-0 rounded" aria-hidden="true">< Previous</span>
            </li>
        @else
            <li class="page-item mx-1" aria-disabled="true" aria-label="« Previous">
                <a class="page-link border-0 rounded text-black" href="{{ $paginator->previousPageUrl() }}" rel="next" aria-label="« Previous">< Previous</a>
            </li>
        @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="pagination"><span>{{ $element }}</span></span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item mx-1 active" aria-current="page">
                                <span class="page-link border-0 rounded">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item mx-1">
                                <a class="page-link border-0 rounded text-black" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @if ($paginator->hasMorePages())
            <li class="page-item mx-1">
                <a class="page-link border-0 rounded text-black" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next »">Next ></a>
            </li>
        @else
            <li class="page-item mx-1 disabled">
                <a class="page-link border-0 rounded" rel="next" aria-label="Next »">Next ></a>
            </li>
        @endif
    </nav>
@endif