<x-app-layout :class="'main-text-page main-search-result-page'">
    <div class="text-content search-result-section">
        @if($products->count() || $other->count())
            @if($products->count())
                <section>
                    <div class="main-container">
                        <h2>{{ __('site.products_search') }}</h2>
                        <div class="products-container">
                            @foreach($products as $product)
                                <div class="product-block">
                                    <picture class="p-abs-inset-0">
                                        <img class="img-in-picture" src="{{ $product->getFirstMediaUrl('preview', 'webp') }}" width="1600" height="500" loading="lazy" alt="{{ $product->title }}">
                                    </picture>
                                    <div class="layer">
                                        <div class="top">
                                            <div class="path animate-on-scroll animate__animated" data-animation="fadeIn">
                                                @foreach($product->hierarchy as $category)
                                                    <span>{{ $category }}</span>
                                                @endforeach
                                            </div>
                                            <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">{{ $product->title }}</h3>
                                        </div>
                                        <div class="bottom">
                                            <a href="{{ $product->link }}" title="{{ $product->title }}" class="detailed-btn-link animate-on-scroll animate__animated animate__delay-30ms" data-animation="fadeIn">
                                                <span>{{ __('site.read_more') }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                                    <path
                                                        d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                                                        fill="#F4F4F4" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- <div class="go-to-all">
                            <a class="primary-outline" href="#">
                                <span>All sections</span>
                                <svg class="right-arrow" xmlns="http://www.w3.org/2000/svg" width="35" height="12" viewBox="0 0 35 12" fill="none">
                                    <path
                                        d="M34.5303 6.85846C34.8232 6.56556 34.8232 6.09069 34.5303 5.7978L29.7574 1.02483C29.4645 0.731933 28.9896 0.731933 28.6967 1.02483C28.4038 1.31772 28.4038 1.79259 28.6967 2.08549L32.9393 6.32813L28.6967 10.5708C28.4038 10.8637 28.4038 11.3385 28.6967 11.6314C28.9896 11.9243 29.4645 11.9243 29.7574 11.6314L34.5303 6.85846ZM-6.55671e-08 7.07812L34 7.07813L34 5.57813L6.55671e-08 5.57812L-6.55671e-08 7.07812Z"
                                        fill="#BE111D" />
                                </svg>
                            </a>
                        </div> -->
                    </div>
                </section>
            @endif

            @if($other->count())
                <section>
                    <div class="main-container">
                        <h2>{{ __('site.other_search') }}</h2>
                        <div class="vacancies-grid">
                            @foreach($other as $item)
                                @include('site.partials.other')
                            @endforeach
                        </div>
                        @if($other->count() >= 6)
                            <div class="go-to-all">
                                <a class="primary-outline" href="{{ route('search-other', ['query' => request()->get('query')]) }}">
                                    <span>{{ __('site.all_results') }}</span>
                                    <svg class="right-arrow" xmlns="http://www.w3.org/2000/svg" width="35" height="12" viewBox="0 0 35 12" fill="none">
                                        <path
                                            d="M34.5303 6.85846C34.8232 6.56556 34.8232 6.09069 34.5303 5.7978L29.7574 1.02483C29.4645 0.731933 28.9896 0.731933 28.6967 1.02483C28.4038 1.31772 28.4038 1.79259 28.6967 2.08549L32.9393 6.32813L28.6967 10.5708C28.4038 10.8637 28.4038 11.3385 28.6967 11.6314C28.9896 11.9243 29.4645 11.9243 29.7574 11.6314L34.5303 6.85846ZM-6.55671e-08 7.07812L34 7.07813L34 5.57813L6.55671e-08 5.57812L-6.55671e-08 7.07812Z"
                                            fill="#BE111D" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

        @else
            <section>
                <div class="main-container">
                    <p>{{ __('site.nothing_found_text') }}</p>
                </div>
            </section>
        @endif
    </div>
</x-app-layout>
