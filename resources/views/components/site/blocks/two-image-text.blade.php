<section class="text-content text-color-section ambulance-section">
    <div class="main-container">
        <div class="content">
            <div class="top">
                <h2>{{ $block->title }}</h2>
                @if($block->data['description'] ?? null)
                    <p>{!! nl2br($block->data['description']) !!}</p>
                @endif
            </div>
            <div class="bottom">
                <a href="{{ $block->data['link'] ?? '' }}" target="_blank" title="{{ $block->title }}" class="detailed-btn-link gray-1">
                    <span>{{ __('site.banner_more') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                        <path
                            d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                            fill="#F4F4F4" />
                    </svg>
                </a>
            </div>
            <div class="bg-images">
                <picture>
                    <img class="img-in-picture" src="{{ $block->getFirstMediaUrl('preview', 'webp') }}" alt="{{ $block->title }}" width="883" height="479" loading="lazy">
                </picture>
            </div>
        </div>
    </div>
</section>
