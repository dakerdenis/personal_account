<div class="banner">
    <div class="mainBannerSwiper-container">
        <div class="swiper-container mainBannerSwiper">
            <div class="swiper-wrapper">
                @foreach($slides as $slide)
                    <div class="swiper-slide">
                        <picture>
                            <source srcset="{{ $slide->getFirstMediaUrl('preview', 'minWebp') }}" media="(max-width: 500px)">
                            <source srcset="{{ $slide->getFirstMediaUrl('preview', 'mdWebp') }}" media="(max-width: 767px)">
                            <source srcset="{{ $slide->getFirstMediaUrl('preview', 'lgWebp') }}" media="(max-width: 800px)">
                            <source srcset="{{ $slide->getFirstMediaUrl('preview', 'xlWebp') }}" media="(max-width: 1023px)">
                            <source srcset="{{ $slide->getFirstMediaUrl('preview', 'xxlWebp') }}" media="(max-width: 1440px)">
                            <img class="img-in-picture" src="{{ $slide->getFirstMediaUrl('preview', 'webp') }}" width="1349" height="780" alt="{{ $slide->title }}">
                        </picture>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="navigation">
            <div class="menu">

                @foreach($slides as $slide)
                    <div class="menu-item">
                        @if($slide->link)
                            <a class="title" title="{{ $slide->title }}" href="{{ LaravelLocalization::getLocalizedURL(\Illuminate\Support\Facades\App::getLocale(), $slide->link) }}">{{ $slide->title }}</a>
                        @else
                            <span class="title">{{ $slide->title }}</span>
                        @endif
                        <div class="collapsed mainBanner-collapsed">
                            <div class="row">
                                <div class="col">
                                    @if($slide->description)
                                        <p class="description">
                                            {!! nl2br($slide->description)!!}
                                        </p>
                                    @endif
                                    @if($slide->link)
                                        <a href="{{ LaravelLocalization::getLocalizedURL(\Illuminate\Support\Facades\App::getLocale(), $slide->link) }}" class="showMore">
                                            <span>{{ __('site.slide_more') }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                                <path d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z" fill="#F4F4F4"/>
                                            </svg>
                                        </a> @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                @foreach($slides as $slide)
                    <div class="pagination-item"><div class="progress"></div></div>
                @endforeach
            </div>
        </div>
    </div>
</div>
