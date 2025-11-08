@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-4">
        <ul class="inline-flex items-center space-x-1 text-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-1 rounded bg-green-200 text-white cursor-not-allowed">&laquo;</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded bg-green-600 hover:bg-green-700 text-white">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-3 py-1 rounded bg-green-200 text-white">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-1 rounded bg-green-800 text-white font-semibold">{{ $page }}</li>
                        @else
                            <li><a href="{{ $url }}" class="px-3 py-1 rounded bg-green-600 hover:bg-green-700 text-white">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded bg-green-600 hover:bg-green-700 text-white">&raquo;</a>
                </li>
            @else
                <li class="px-3 py-1 rounded bg-green-200 text-white cursor-not-allowed">&raquo;</li>
            @endif
        </ul>
    </nav>
@endif
