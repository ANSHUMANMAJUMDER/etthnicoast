@if ($paginator->hasPages())
<div style="display:flex;justify-content:center;gap:6px;padding:32px 0 60px;">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="page-btn" style="opacity:0.35;cursor:not-allowed;">
            <i class="fas fa-chevron-left"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">
            <i class="fas fa-chevron-left"></i>
        </a>
    @endif

    {{-- Page numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="page-btn" style="opacity:0.4;">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">
            <i class="fas fa-chevron-right"></i>
        </a>
    @else
        <span class="page-btn" style="opacity:0.35;cursor:not-allowed;">
            <i class="fas fa-chevron-right"></i>
        </span>
    @endif

</div>
@endif