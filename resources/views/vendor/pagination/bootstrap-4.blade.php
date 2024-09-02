@if ($paginator->hasPages())




    <div class="custom-pagination">
        @if ($paginator->onFirstPage())
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path
                                d="M11.8477 2.51854L10.6677 1.33854L4.00099 8.00521L10.6677 14.6719L11.8477 13.4919L6.36099 8.00521L11.8477 2.51854Z"
                                fill="#BE111D" />
                        </svg>
                    </a>
        @endif

        <div class="pages">

            @if($paginator->currentPage() > 3)
                <a href="{{ $paginator->url(1) }}" class="page">1</a>
            @endif
            @if($paginator->currentPage() > 4)
                                <span class="dots">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </span>
            @endif
            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                            <a href="javascript:void(0);" class="page active">{{ $i }}</a>
                    @else
                            <a href="{{ $paginator->url($i) }}" class="page">{{ $i }}</a>
                    @endif
                @endif
            @endforeach
            @if($paginator->currentPage() < $paginator->lastPage() - 3)
                    <span class="dots">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </span>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page">{{ $paginator->lastPage() }}</a>
            @endif


        </div>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path
                                d="M4.15235 13.4815L5.33235 14.6615L11.999 7.99479L5.33234 1.32812L4.15234 2.50813L9.63901 7.99479L4.15235 13.4815Z"
                                fill="#BE111D" />
                        </svg>
                    </a>
            @endif
    </div>
@endif

