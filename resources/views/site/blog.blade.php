@php use App\Models\Article; @endphp
@php
    /** @var Article $articles */
@endphp
<x-app-layout :class="'main-text-page main-news-page'">
    <div class="text-content">
        <div class="main-container">
            @if($category->taxonomy === \App\Models\Category::SPECIAL_OFFERS && $archiveShowed)
                <div class="go-to-all above-list">
                    <a class="primary-outline" href="{{ url()->current() }}">
                        <span>{{ __('site.special_offers_current') }}</span>
                        <svg class="right-arrow" xmlns="http://www.w3.org/2000/svg" width="35" height="12" viewBox="0 0 35 12" fill="none">
                            <path d="M34.5303 6.85846C34.8232 6.56556 34.8232 6.09069 34.5303 5.7978L29.7574 1.02483C29.4645 0.731933 28.9896 0.731933 28.6967 1.02483C28.4038 1.31772 28.4038 1.79259 28.6967 2.08549L32.9393 6.32813L28.6967 10.5708C28.4038 10.8637 28.4038 11.3385 28.6967 11.6314C28.9896 11.9243 29.4645 11.9243 29.7574 11.6314L34.5303 6.85846ZM-6.55671e-08 7.07812L34 7.07813L34 5.57813L6.55671e-08 5.57812L-6.55671e-08 7.07812Z" fill="#BE111D"></path>
                        </svg>
                    </a>
                </div>
            @endif
            <div class="news-grid">
                @foreach($articles as $article)
                    <a href="{{ $article->link }}" title="{{ $article->title }}" class="news-block animate-on-scroll animate__animated" data-animation="fadeIn">
                        <span class="image-container">
                            @if($article->getFirstMedia('preview'))
                                <img src="{{ $article->getFirstMediaUrl('preview', 'thumbWebp') }}" width="480" height="480" alt="{{ $article->title }}" class="news__item-icon-image">
                            @else
                                <img src="{{ asset('assets/images/a-group-news-icon.webp') }}" width="480" height="480" alt="{{ $article->title }}" class="news__item-icon-image">
                            @endif
                            <span class="over">
                                <span>{{ __('site.read_more') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="58" height="16" viewBox="0 0 58 16" fill="none">
                                    <path
                                        d="M57.7071 8.70711C58.0976 8.31659 58.0976 7.68342 57.7071 7.2929L51.3431 0.928937C50.9526 0.538412 50.3195 0.538412 49.9289 0.928937C49.5384 1.31946 49.5384 1.95263 49.9289 2.34315L55.5858 8L49.9289 13.6569C49.5384 14.0474 49.5384 14.6805 49.9289 15.0711C50.3195 15.4616 50.9526 15.4616 51.3431 15.0711L57.7071 8.70711ZM-8.74228e-08 9L57 9L57 7L8.74228e-08 7L-8.74228e-08 9Z"
                                        fill="white" />
                                </svg>
                            </span>
                        </span>
                        <span class="info-container">
                            <span class="date">{{ $article->date?->format('d.m.Y') }} {{ $article->end_date ? '- ' . $article->end_date->format('d.m.Y') : '' }}</span>
                            <span class="title">{{ $article->title }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
            @if($category->taxonomy === \App\Models\Category::BLOG)
                {{ $articles->links() }}
            @endif

            @if($category->taxonomy === \App\Models\Category::SPECIAL_OFFERS && $hasArchive && !$archiveShowed)
                <div class="go-to-all">
                    <a class="primary-outline" href="{{ url()->current() }}?archive=1">
                        <span>{{ __('site.special_offers_archive') }}</span>
                        <svg class="right-arrow" xmlns="http://www.w3.org/2000/svg" width="35" height="12" viewBox="0 0 35 12" fill="none">
                            <path d="M34.5303 6.85846C34.8232 6.56556 34.8232 6.09069 34.5303 5.7978L29.7574 1.02483C29.4645 0.731933 28.9896 0.731933 28.6967 1.02483C28.4038 1.31772 28.4038 1.79259 28.6967 2.08549L32.9393 6.32813L28.6967 10.5708C28.4038 10.8637 28.4038 11.3385 28.6967 11.6314C28.9896 11.9243 29.4645 11.9243 29.7574 11.6314L34.5303 6.85846ZM-6.55671e-08 7.07812L34 7.07813L34 5.57813L6.55671e-08 5.57812L-6.55671e-08 7.07812Z" fill="#BE111D"></path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
