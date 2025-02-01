<link rel="stylesheet" href="{{ asset('css/pagination/paginate.css') }}">

@if ($paginator->hasPages())
<div class="pagination__wrap">

    <ul class="pagination__nav" role="navigation">
        {{-- 前のページリンク --}}
        @if ($paginator->onFirstPage())
        <li class="pagination__list" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <span class="pagination__item">‹</span>
        </li>
        @else
        <li class="pagination__list">
            <a class="pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">‹</a>
        </li>
        @endif

        {{-- ページ番号リンク --}}
        @foreach ($elements as $element)
        {{-- 省略記号 --}}
        @if (is_string($element))
        <li class="pagination__list" aria-disabled="true">{{ $element }}</li>
        @endif

        {{-- ページリンク --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="pagination__list active" aria-current="page">
            <span class="pagination__item">{{ $page }}</span>
        </li>
        @else
        <li class="pagination__list">
            <a class="pagination__item" href="{{ $url }}">{{ $page }}</a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- 次のページリンク --}}
        @if ($paginator->hasMorePages())
        <li class="pagination__list">
            <a class="pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">›</a>
        </li>
        @else
        <li class="pagination__list" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span class="pagination__item">›</span>
        </li>
        @endif
    </ul>

</div>
@endif