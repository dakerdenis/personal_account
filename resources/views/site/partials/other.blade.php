<div class="vacancy-block animate-on-scroll animate__animated" data-animation="fadeIn">
    <div class="top">
        <div class="from">
            <span>{{ $item->master }}</span>
        </div>
        <div class="title">
            {{ $item->title }}
        </div>
    </div>
    <div class="bottom">
        <a href="{{ $item->link }}" class="primary-outline detailed-btn-link">
            <span>{{ __('site.more') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                <path d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z" fill="#BE111D"/>
            </svg>
        </a>
    </div>
</div>
