<?php
/**
 * Created by PhpStorm.
 * User: Shahid Islam
 * Date: 05/07/2019
 * Time: 3:19 PM
 */
?>
@if ($paginator->hasPages())
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="disabled page-item"><a class="page-link" data-page="Previous" href="javascript:void(0)"><i class="fas fa-chevron-left"></i></a></li>
        @else
            <li class="page-item">
                <a class="page-link" data-page="Previous" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        @endif

        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><a class="page-link" href="javascript:void(0)">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" data-page="{{ $page }}" href="javascript:void(0)">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" data-page="{{ $page }}" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a  class="page-link" data-page="Next" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" data-page="Next" href="javascript:void(0)" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        @endif
    </ul>
@endif
