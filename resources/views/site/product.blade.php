@php
    /** @var Product $product */

    use App\Models\Product;\Illuminate\Support\Facades\View::share('subTitle', $product->sub_title );

    $class = 'main-text-page main-product-page';
    if ($product->getFirstMedia('big_preview')) {
        $class .= ' w-bg-picture-header';
    }
@endphp
<x-app-layout :class="$class">

    <div class="text-content stats-section">
        <div class="main-container">
            <div class="content">
                @if($smallPreview = $product->getFirstMedia('small_preview'))
                    <div class="product-cover-banner">
                        <picture>
                            <img src="{{ $smallPreview->getUrl('webp') }}" alt="" width="1060" height="380" loading="lazy">
                        </picture>
                    </div>
                @endif

                <div class="wysiwyg animate-on-scroll animate__animated" data-animation="fadeIn">
                    {!! html_entity_decode($product->description) !!}
                </div>

                @if($product->statistics && $product->statistics->text)
                    <div class="stats-block">
                        <div class="left">
                            <img class="animate-on-scroll animate__animated" data-animation="backInLeft_300px"
                                 src="{{ asset('storage/uploaded_files/v1tU/akar-icons_statistic-up.svg') }}" width="43" height="43" alt="" loading="lazy">
                            @php
                                $statistic = $product->statistics;
                                $string = $statistic->text;
                                $updatedString = preg_replace('/@@(.*?)@@/', '<span>$1</span>', $string);
                            @endphp
                            <p class="animate-on-scroll animate__animated" data-animation="fadeIn">{!! nl2br($updatedString) !!}</p>
                        </div>
                        <div class="right">
                            <div class="stat">
                                <p class="animate-on-scroll animate__animated" data-animation="fadeIn">{{ $statistic->first_line }}</p>
                                <span class="animate-on-scroll animate__animated" data-animation="zoomIn">{{ $statistic->first_line_red }}</span>
                            </div>
                            <div class="stat">
                                <p class="animate-on-scroll animate__animated" data-animation="fadeIn">{{ $statistic->second_line }}</p>
                                <span class="animate-on-scroll animate__animated" data-animation="zoomIn">{{ $statistic->second_line_red }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($product->packages->count())
        <section class="text-content medical-packages-section">
            <div class="main-container">
                <div class="header">
                    <h2 class="mb-0">{{ $product->packages_title }}</h2>
                    @if($product->packages_description)
                        <p class="animate-on-scroll animate__animated" data-animation="fadeIn">{!! nl2br($product->packages_description) !!}</p>
                    @endif
                </div>

                <div class="packages-grid">
                    @foreach($product->packages as $package)
                        <a href="{{ $package->link }}" title="{{ $package->title }}" class="package-block">
                            <picture class="p-abs-inset-0 animate-on-scroll animate__animated" data-animation="fadeIn">
                                <img class="img-in-picture" src="{{ $package->getFirstMediaUrl('preview', 'webp') }}" title="{{ $package->title }}" width="1666" height="2499"
                                     alt="{{ $package->title }}" loading="lazy">
                            </picture>
                            <div class="layer"></div>
                            <span class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
                                <path opacity="0.2" d="M40 27.3333V2M40 2H14.6667M40 2L2 40" stroke="#242323" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                        </span>
                            <span class="above-layer animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">
                            <span class="title">{{ $package->title }}</span>
                                @if($package->sub_title)
                                    <span class="text">{{ $package->sub_title }}</span>
                                @endif
                        </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($product->productFeatures->count())
        @foreach($product->productFeatures as $productFeature)
            <section class="text-content {{ $loop->first ? 'gray-section' : 'text-color-section' }} casco-advantages">
                <div class="main-container">
                    <h2 class="centralized animate-on-scroll animate__animated" data-animation="fadeIn">{{ $productFeature->title }}</h2>
                    <div class="content">
                        <p class="animate-on-scroll animate__animated" data-animation="fadeIn">
                            {!! nl2br($productFeature->description) !!}
                        </p>

                        <div class="ul-grid">
                            @foreach($productFeature->featureLines->chunk(round($productFeature->featureLines->count() / 2)) as $chunk)
                                <ul>
                                    @foreach($chunk as $line)
                                        <li class="animate-on-scroll animate__animated" data-animation="fadeInBottomLeft">{!! $line->description !!}</li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif

    @if($product->banner?->title)
        <section class="text-content car-accident-section">
            <div class="main-container">
                <div class="car-accident-wrapper animate-on-scroll animate__animated" data-animation="fadeIn">
                    <h2>{{ $product->banner->title }}</h2>
                    <p>{!! nl2br($product->banner->text) !!}</p>
                </div>
                <div class="actions">
                    <button class="primary-outline">
                        <span>{{ $product->banner->left_button_text }}</span>
                        <svg class="right-arrow" xmlns="http://www.w3.org/2000/svg" width="35" height="12" viewBox="0 0 35 12" fill="none">
                            <path
                                d="M34.5303 6.85846C34.8232 6.56556 34.8232 6.09069 34.5303 5.7978L29.7574 1.02483C29.4645 0.731933 28.9896 0.731933 28.6967 1.02483C28.4038 1.31772 28.4038 1.79259 28.6967 2.08549L32.9393 6.32813L28.6967 10.5708C28.4038 10.8637 28.4038 11.3385 28.6967 11.6314C28.9896 11.9243 29.4645 11.9243 29.7574 11.6314L34.5303 6.85846ZM-6.55671e-08 7.07812L34 7.07813L34 5.57813L6.55671e-08 5.57812L-6.55671e-08 7.07812Z"
                                fill="#BE111D"/>
                        </svg>
                    </button>
                    @if($product->banner->right_button_text)
                        <button class="primary-outline">
                            <span>{{ $product->banner->right_button_text }}</span>
                            <svg class="right-arrow" xmlns="http://www.w3.org/2000/svg" width="35" height="12" viewBox="0 0 35 12" fill="none">
                                <path
                                    d="M34.5303 6.85846C34.8232 6.56556 34.8232 6.09069 34.5303 5.7978L29.7574 1.02483C29.4645 0.731933 28.9896 0.731933 28.6967 1.02483C28.4038 1.31772 28.4038 1.79259 28.6967 2.08549L32.9393 6.32813L28.6967 10.5708C28.4038 10.8637 28.4038 11.3385 28.6967 11.6314C28.9896 11.9243 29.4645 11.9243 29.7574 11.6314L34.5303 6.85846ZM-6.55671e-08 7.07812L34 7.07813L34 5.57813L6.55671e-08 5.57812L-6.55671e-08 7.07812Z"
                                    fill="#BE111D"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
            @if($product->getFirstMedia('banner_preview'))
                <div class="car-accident-bg-image">
                    <picture class="animate-on-scroll animate__animated" data-animation="fadeInRight_horizontallyCentered">
                        <img class="img-in-picture" src="{{ $product->getFirstMediaUrl('banner_preview', 'webp') }}" width="991" height="400" alt="{{ $product->banner->title }}"
                             loading="lazy">
                    </picture>
                </div>
            @endif
        </section>
    @endif

    @if($product->articles->count())
        <section class="text-content special-offers-section">
            <div class="main-container">
                <h2>{{ __('site.special_offers') }}</h2>

                <div class="swiper-container specialOffersSwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide animate-on-scroll animate__animated" data-animation="fadeIn">
                            <picture class="p-abs-inset-0">
                                <img class="img-in-picture" src="media/images/product1.jpg" width="1600" height="500" alt="" loading="lazy">
                            </picture>
                            <div class="layer">
                                <div class="top">
                                    <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">Lorem ipsum dolor sit amet</h3>
                                    <p class="description animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">Sed ut
                                        perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                    <a href="#" class="detailed-btn-link animate-on-scroll animate__animated animate__delay-30ms"
                                       data-animation="fadeIn">
                                        <span>Подробнее</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                            <path
                                                d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                                                fill="#F4F4F4"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide animate-on-scroll animate__animated" data-animation="fadeIn">
                            <picture class="p-abs-inset-0">
                                <img class="img-in-picture" src="media/images/product1.jpg" width="1600" height="500" alt="" loading="lazy">
                            </picture>
                            <div class="layer">
                                <div class="top">
                                    <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">Lorem ipsum dolor sit amet</h3>
                                    <p class="description animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">Sed ut
                                        perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                    <a href="#" class="detailed-btn-link animate-on-scroll animate__animated animate__delay-30ms"
                                       data-animation="fadeIn">
                                        <span>Подробнее</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                            <path
                                                d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                                                fill="#F4F4F4"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide animate-on-scroll animate__animated" data-animation="fadeIn">
                            <picture class="p-abs-inset-0">
                                <img class="img-in-picture" src="media/images/product1.jpg" width="1600" height="500" alt="" loading="lazy">
                            </picture>
                            <div class="layer">
                                <div class="top">
                                    <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">Lorem ipsum dolor sit amet</h3>
                                    <p class="description animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">Sed ut
                                        perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                    <a href="#" class="detailed-btn-link animate-on-scroll animate__animated animate__delay-30ms"
                                       data-animation="fadeIn">
                                        <span>Подробнее</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                            <path
                                                d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                                                fill="#F4F4F4"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide animate-on-scroll animate__animated" data-animation="fadeIn">
                            <picture class="p-abs-inset-0">
                                <img class="img-in-picture" src="media/images/product1.jpg" width="1600" height="500" alt="" loading="lazy">
                            </picture>
                            <div class="layer">
                                <div class="top">
                                    <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">Lorem ipsum dolor sit amet</h3>
                                    <p class="description animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">Sed ut
                                        perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                    <a href="#" class="detailed-btn-link animate-on-scroll animate__animated animate__delay-30ms"
                                       data-animation="fadeIn">
                                        <span>Подробнее</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                            <path
                                                d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                                                fill="#F4F4F4"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide animate-on-scroll animate__animated" data-animation="fadeIn">
                            <picture class="p-abs-inset-0">
                                <img class="img-in-picture" src="media/images/product1.jpg" width="1600" height="500" alt="" loading="lazy">
                            </picture>
                            <div class="layer">
                                <div class="top">
                                    <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">Lorem ipsum dolor sit amet</h3>
                                    <p class="description animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">Sed ut
                                        perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                    <a href="#" class="detailed-btn-link animate-on-scroll animate__animated animate__delay-30ms"
                                       data-animation="fadeIn">
                                        <span>Подробнее</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                            <path
                                                d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                                                fill="#F4F4F4"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide animate-on-scroll animate__animated" data-animation="fadeIn">
                            <picture class="p-abs-inset-0">
                                <img class="img-in-picture" src="media/images/product1.jpg" width="1600" height="500" alt="" loading="lazy">
                            </picture>
                            <div class="layer">
                                <div class="top">
                                    <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">Lorem ipsum dolor sit amet</h3>
                                    <p class="description animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">Sed ut
                                        perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                    <a href="#" class="detailed-btn-link animate-on-scroll animate__animated animate__delay-30ms"
                                       data-animation="fadeIn">
                                        <span>Подробнее</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                            <path
                                                d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                                                fill="#F4F4F4"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pagination-navigation">
                        <div class="swiper-button-prev" role="button" aria-label="Previous Slide">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="27" viewBox="0 0 15 27" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M4.62132 14.121L14.5 23.9997L11.6716 26.8281L1.7929 16.9494C-0.159726 14.9968 -0.159727 11.831 1.79289 9.87838L11.6716 -0.000301608L14.5 2.82813L4.62132 12.7068C4.2308 13.0973 4.2308 13.7305 4.62132 14.121Z"
                                      fill="#BE111D"/>
                            </svg>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next" role="button" aria-label="Next Slide">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="27" viewBox="0 0 15 27" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.3787 12.7071L0.5 2.82843L3.32843 0L13.2071 9.87868C15.1597 11.8313 15.1597 14.9971 13.2071 16.9497L3.32843 26.8284L0.5 24L10.3787 14.1213C10.7692 13.7308 10.7692 13.0976 10.3787 12.7071Z"
                                      fill="#BE111D"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($product->insurance_conditions_title || $product->insuranceConditions->count())
        <section class="text-content insurance-conditions-section">
            <div class="main-container">
                <h2 class="centralized">{{ $product->insurance_conditions_title }}</h2>

                <div class="conditions-grid">
                    @foreach($product->insuranceConditions as $condition)
                        <div class="condition-block">
                            <img class="icon animate-on-scroll animate__animated" data-animation="backInLeft_300px" src="{{ $condition->getFirstMediaUrl('preview') }}" width="65"
                                 height="65" alt="{{ $condition->title }}" loading="lazy">
                            <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">{{ $condition->title }}</h3>
                            <div class="wysiwyg mb-0 animate-on-scroll animate__animated" data-animation="fadeIn">
                                <ul>
                                    @foreach(explode(PHP_EOL, $condition->description) as $line)
                                        @if($line)
                                            <li>{!! $line !!}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <section class="text-content">
        <div class="main-container">
            @if($product->files->count())
                <div class="download-links">
                    <h2>{{ $product->files_title }}</h2>

                    @foreach($product->files as $file)
                        <a href="{{ $file->link }}" class="download-link animate-on-scroll animate__animated" target="_blank" data-animation="zoomIn">
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
        </div>
    </section>

    @if($product->usefulLinks->count())
        <section class="gray-section recommended-links">
            <div class="main-container">
                <h2>{{ __('site.useful_links') }}</h2>

                <div class="links">
                    @foreach($product->usefulLinks as $link)
                        <a href="{{ \Illuminate\Support\Str::startsWith($link->link, 'http') ? $link->link : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(App::getLocale(), $link->link) }}"
                           target="{{ \Illuminate\Support\Str::startsWith($link->link, 'http') ? '_blank' : '_self' }}"
                           class="animate-on-scroll animate__animated" data-animation="zoomIn">
                            <img width="160" height="160" src="{{ $link->getFirstMediaUrl('preview') }}" alt="{{ $link->title }}" loading="lazy">
                            <span>{{ $link->title }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($product->faqs->count())
        <section class="text-content faq-section">
            <div class="main-container">
                <h2 class="centralized">{{ __('site.products_faq') }}</h2>

                <div class="collapse-container">
                    @foreach($product->faqs as $faq)
                        <div class="collapse-item">
                            <button class="collapse-button">
                                <span class="question animate-on-scroll animate__animated" data-animation="fadeInDown">{{ nl2br($faq->question) }}</span>
                                <span class="toggle-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                                    <rect width="50" height="50" rx="25" fill="black" fill-opacity="0.05"/>
                                    <path d="M18 23L24.2929 29.2929C24.6834 29.6834 25.3166 29.6834 25.7071 29.2929L32 23" stroke="#242323" stroke-width="2"
                                          stroke-linecap="round"/>
                                  </svg>
                            </span>
                            </button>
                            <div class="collapse-content">
                                <div class="collapse-content-wrapper">
                                    <div class="wysiwyg mb-0">
                                        <p>{!! nl2br($faq->answer) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($product->calculator)
        {!! $product->getCalculator()->render() !!}
    @endif

    @if($product->form)
        {!! $product->getForm()->renderForm() !!}
    @endif
</x-app-layout>
