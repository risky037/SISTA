@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-6">
        <ul class="inline-flex items-center -space-x-px">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span
                        class="px-3 py-2 ml-0 leading-tight text-gray-400 bg-gray-100 border border-gray-300 rounded-l-lg cursor-default">
                        &laquo;
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-3 py-2 ml-0 leading-tight text-green-700 bg-white border border-gray-300 rounded-l-lg hover:bg-green-100 hover:text-green-800">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Dots --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span
                                    class="px-3 py-2 leading-tight text-white bg-green-600 border border-green-600 font-semibold">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="px-3 py-2 leading-tight text-green-700 bg-white border border-gray-300 hover:bg-green-100 hover:text-green-800">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-3 py-2 leading-tight text-green-700 bg-white border border-gray-300 rounded-r-lg hover:bg-green-100 hover:text-green-800">
                        &raquo;
                    </a>
                </li>
            @else
                <li>
                    <span
                        class="px-3 py-2 leading-tight text-gray-400 bg-gray-100 border border-gray-300 rounded-r-lg cursor-default">
                        &raquo;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
