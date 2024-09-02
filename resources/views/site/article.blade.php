@php
    /** @var Article $article */
    use App\Models\Article;use App\View\Components\Site\PageTitleBreadcrumbs;\Illuminate\Support\Facades\View::share('date', $article->date?->format(('d.m.Y') ));
    \Illuminate\Support\Facades\View::share('end_date', $article->end_date?->format(('d.m.Y') ))
@endphp
<x-app-layout :class="'main-text-page'">

    @if($article->getFirstMedia('preview_center'))
        <div class="text-content cover-banner-section">
            <div class="main-container">
                <div class="cover-banner animate-on-scroll animate__animated" data-animation="fadeIn">
                    <picture class="p-abs-inset-0">
                        <img class="img-in-picture" src="{{ $article->getFirstMediaUrl('preview_center', 'webp') }}" width="1600" height="500" alt="{{ $article->title }}">
                    </picture>
                    <div class="layer">
                        <div class="top">
                            <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">{{ $article->title }}</h3>
                            @if($article->subtitle)
                                <p class="description animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">{{ $article->subtitle }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

            <section class="text-content">
                <div class="main-container">
                    <div class="wysiwyg animate-on-scroll animate__animated" data-animation="fadeIn">
                        {!! html_entity_decode($article->description) !!}
                    </div>

                    @if($article->files->count())
                    <div class="download-links">
                        <h2>{{ __('site.article_files') }}</h2>

                        @foreach($article->files as $file)
                            <a href="{{ $file->link }}" target="_blank" class="download-link animate-on-scroll animate__animated" data-animation="zoomIn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M18.0018 3.11719C18.7665 3.11719 19.3864 3.7371 19.3864 4.5018V19.159L24.5227 14.0227C25.0635 13.482 25.9401 13.482 26.4809 14.0227C27.0216 14.5635 27.0216 15.4401 26.4809 15.9809L18.9809 23.4809C18.4401 24.0216 17.5635 24.0216 17.0227 23.4809L9.52273 15.9809C8.98201 15.4401 8.98201 14.5635 9.52273 14.0227C10.0635 13.482 10.9401 13.482 11.4809 14.0227L16.6172 19.159V4.5018C16.6172 3.7371 17.2371 3.11719 18.0018 3.11719ZM4.5018 21.1172C5.26651 21.1172 5.88642 21.7371 5.88642 22.5018V28.5018C5.88642 28.9302 6.05661 29.3411 6.35955 29.6441C6.6625 29.947 7.07338 30.1172 7.5018 30.1172H28.5018C28.9302 30.1172 29.3411 29.947 29.6441 29.6441C29.947 29.3411 30.1172 28.9302 30.1172 28.5018V22.5018C30.1172 21.7371 30.7371 21.1172 31.5018 21.1172C32.2665 21.1172 32.8864 21.7371 32.8864 22.5018V28.5018C32.8864 29.6647 32.4245 30.7799 31.6022 31.6022C30.7799 32.4245 29.6647 32.8864 28.5018 32.8864H7.5018C6.33893 32.8864 5.22369 32.4245 4.40141 31.6022C3.57914 30.7799 3.11719 29.6647 3.11719 28.5018V22.5018C3.11719 21.7371 3.7371 21.1172 4.5018 21.1172Z"
                                          fill="#BE111D"/>
                                </svg>

                                <span> {{ $file->title }} </span>
                            </a>
                        @endforeach
                    </div>
                    @endif

                    @if($article->youtube_tag)
                        @foreach(explode(',', $article->youtube_tag) as $tag)
                            <div class="video-container animate-on-scroll animate__animated" data-animation="fadeIn">
                                <iframe src="https://www.youtube.com/embed/{{ trim($tag) }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" allowfullscreen></iframe>
                                {{--                    <iframe src="https://www.youtube.com/embed/{{ $tag }}" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;" allowfullscreen--}}
                                {{--                            srcdoc="<style>*{padding:0;margin:0;overflow:hidden}html,body{height:100%}img,span{position:absolute;width:100%;top:0;bottom:0;margin:auto}span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em black}</style>--}}
                                {{--                            <a href='https://www.youtube.com/embed/{{ $tag }}?autoplay=1'>--}}
                                {{--                                <img src='https://img.youtube.com/vi/{{ $tag }}/hqdefault.jpg' alt='Video Title'>--}}
                                {{--                                <span>▶</span>--}}
                                {{--                            </a>"--}}
                                {{--                    ></iframe>--}}
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>

    @if($article->usefulLinks->count())
            <section class="gray-section recommended-links">
                <div class="main-container">
                    <h2>{{ __('site.article_useful_links') }}</h2>

                    <div class="links">
                        @foreach($article->usefulLinks as $link)
                            <a href="{{ \Illuminate\Support\Str::startsWith($link->link, 'http') ? $link->link : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(App::getLocale(), $link->link) }}"
                               class="animate-on-scroll animate__animated"
                               target="{{ \Illuminate\Support\Str::startsWith($link->link, 'http') ? '_blank' : '_self' }}"
                               data-animation="zoomIn">
                                <img width="160" height="160" src="{{ $link->getFirstMediaUrl('preview') }}" alt="{{ $link->title }}" loading="lazy">
                                <span>{{ $link->title }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
    @endif

    @if($article->gallery_id)
            <section class="gallery-section">
                <div class="main-container">
                    <h2 class="centralized">{{ __('site.gallery') }}</h2>

                    <div class="swiper-container gallerySwiper">
                        <div class="swiper-wrapper">
                            @foreach($article->gallery->getMedia()->chunk(6) as $chunk)
                                <div class="swiper-slide @if($loop->first) animate-on-scroll animate__animated @endif" @if($loop->first) data-animation="fadeIn" @endif>
                                    @foreach($chunk as $image)
                                        <a title="{{ $image->title }}" class="gallery" href="{{ $image->getUrl('fullHD') }}" data-fancybox="gallery">
                                            <img width="1600" height="700" src="{{ $image->getUrl('thumbWebp') }}" alt="{{ $image->title }}" loading="lazy">
                                            <div class="over">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                                                    <path
                                                        d="M16.1458 11.625C14.9468 11.625 13.7969 12.1013 12.9491 12.9491C12.1013 13.7969 11.625 14.9468 11.625 16.1458V20.0208C11.625 20.5347 11.4209 21.0275 11.0575 21.3909C10.6942 21.7542 10.2014 21.9583 9.6875 21.9583C9.17364 21.9583 8.68083 21.7542 8.31748 21.3909C7.95413 21.0275 7.75 20.5347 7.75 20.0208V16.1458C7.75 13.9191 8.63456 11.7836 10.2091 10.2091C11.7836 8.63456 13.9191 7.75 16.1458 7.75H20.0208C20.5347 7.75 21.0275 7.95413 21.3909 8.31748C21.7542 8.68083 21.9583 9.17364 21.9583 9.6875C21.9583 10.2014 21.7542 10.6942 21.3909 11.0575C21.0275 11.4209 20.5347 11.625 20.0208 11.625H16.1458ZM45.8542 11.625C48.3497 11.625 50.375 13.6503 50.375 16.1458V20.0208C50.375 20.5347 50.5791 21.0275 50.9425 21.3909C51.3058 21.7542 51.7986 21.9583 52.3125 21.9583C52.8264 21.9583 53.3192 21.7542 53.6825 21.3909C54.0459 21.0275 54.25 20.5347 54.25 20.0208V16.1458C54.25 13.9191 53.3654 11.7836 51.7909 10.2091C50.2164 8.63456 48.0809 7.75 45.8542 7.75H41.9792C41.4653 7.75 40.9725 7.95413 40.6091 8.31748C40.2458 8.68083 40.0417 9.17364 40.0417 9.6875C40.0417 10.2014 40.2458 10.6942 40.6091 11.0575C40.9725 11.4209 41.4653 11.625 41.9792 11.625H45.8542ZM45.8542 50.375C47.0532 50.375 48.2031 49.8987 49.0509 49.0509C49.8987 48.2031 50.375 47.0532 50.375 45.8542V41.9792C50.375 41.4653 50.5791 40.9725 50.9425 40.6091C51.3058 40.2458 51.7986 40.0417 52.3125 40.0417C52.8264 40.0417 53.3192 40.2458 53.6825 40.6091C54.0459 40.9725 54.25 41.4653 54.25 41.9792V45.8542C54.25 48.0809 53.3654 50.2164 51.7909 51.7909C50.2164 53.3654 48.0809 54.25 45.8542 54.25H41.9792C41.4653 54.25 40.9725 54.0459 40.6091 53.6825C40.2458 53.3192 40.0417 52.8264 40.0417 52.3125C40.0417 51.7986 40.2458 51.3058 40.6091 50.9425C40.9725 50.5791 41.4653 50.375 41.9792 50.375H45.8542ZM16.1458 50.375C14.9468 50.375 13.7969 49.8987 12.9491 49.0509C12.1013 48.2031 11.625 47.0532 11.625 45.8542V41.9792C11.625 41.4653 11.4209 40.9725 11.0575 40.6091C10.6942 40.2458 10.2014 40.0417 9.6875 40.0417C9.17364 40.0417 8.68083 40.2458 8.31748 40.6091C7.95413 40.9725 7.75 41.4653 7.75 41.9792V45.8542C7.75 48.0809 8.63456 50.2164 10.2091 51.7909C11.7836 53.3654 13.9191 54.25 16.1458 54.25H20.0208C20.5347 54.25 21.0275 54.0459 21.3909 53.6825C21.7542 53.3192 21.9583 52.8264 21.9583 52.3125C21.9583 51.7986 21.7542 51.3058 21.3909 50.9425C21.0275 50.5791 20.5347 50.375 20.0208 50.375H16.1458Z"
                                                        fill="white" fill-opacity="0.8"/>
                                                </svg>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="pagination-navigation">
                            <div class="swiper-button-prev" role="button" aria-label="Previous Slide">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M11.8477 2.51854L10.6677 1.33854L4.00099 8.00521L10.6677 14.6719L11.8477 13.4919L6.36099 8.00521L11.8477 2.51854Z"
                                        fill="#BE111D"/>
                                </svg>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next" role="button" aria-label="Next Slide">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M4.15235 13.4815L5.33235 14.6615L11.999 7.99479L5.33234 1.32812L4.15234 2.50813L9.63901 7.99479L4.15235 13.4815Z"
                                        fill="#BE111D"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    @endif
</x-app-layout>
