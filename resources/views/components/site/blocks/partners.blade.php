<section class="text-content text-color-section customers-section">
    <picture class="p-abs-inset-0">
        <source srcset="{{ asset('assets/images/building_385-500.jpg') }}" media="(max-width: 500px)">
        <source srcset="{{ asset('assets/images/building_501-800.jpg') }}" media="(max-width: 800px)">
        <source srcset="{{ asset('assets/images/building_801-1439.jpg') }}" media="(max-width: 1440px)">
        <img class="img-in-picture" src="{{ asset('assets/images/building_1440-1920.jpg') }}" width="1920" height="711" alt="{{ $block->title }}" loading="lazy">
    </picture>
    <div class="main-container">
        <div class="header">
            <h2 class="mb-0">{{ $block->title }}</h2>
            <a class="detailed-btn-link gray-1" title="{{ $partnerCategory->title }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(app()->getLocale(), route('category', $partnerCategory)) }}">
                <span>{{ __('site.all_partners') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                    <path
                        d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                        fill="#F4F4F4" />
                </svg>
            </a>
        </div>

        <div class="customers-grid animate__animated animate__fadeIn">
            @foreach($partners as $partner)
                <div class="lazy-block customer-block">
                    <img class="image lazy" width="210" height="211" src="{{ $partner->getFirstMediaUrl('preview') }}" data-src="{{ $partner->getFirstMediaUrl('preview') }}" alt="{{ $partner->title }}" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>
