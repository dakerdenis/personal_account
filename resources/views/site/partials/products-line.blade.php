<section class="text-content {{ $first ? 'mt' : 'pt-0' }}">
    <div class="main-container">
        @if($inner)
            <h2>{{ $category->title }}</h2>
        @endif
        @if($category->description)
                <div class="product-category-description">
                    <div class="container-1060">
                        <div class="wysiwyg animate-on-scroll animate__animated" data-animation="fadeIn">
                            {!! html_entity_decode($category->description) !!}
                        </div>
                    </div>
                </div>
        @endif
        <div class="products-container">
            @foreach($products as $product)
                <div class="product-block {{ $products->count() > 1 ? 'w-pair' : '' }}">
                    <picture class="p-abs-inset-0">
                        <source srcset="{{ $product->getFirstMediaUrl('preview', 'thumb') }}" media="(max-width: 500px)">
                        <img class="img-in-picture" src="{{ $product->getFirstMediaUrl('preview', 'webp') }}" width="{{ $products->count() > 1 ? '785' : '1600' }}" height="500" @if(($loop->iteration > 2 && $first === true) || ($first === false)) loading="lazy" @endif alt="{{ $product->title }}">
                    </picture>
                    <div class="layer">
                        <div class="top">
                            <h3 class="title animate-on-scroll animate__animated" data-animation="fadeInLeft">{{ $product->title }}</h3>
                            <p class="description animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeInLeft">{{ $product->sub_title }}</p>
                        </div>
                        <div class="bottom">
                            <a href="{{ $product->link }}" title="{{ $product->title . ' ' . $product->seo_keywords }}" class="detailed-btn-link animate-on-scroll animate__animated animate__delay-30ms" data-animation="fadeIn">
                                <span>{{ __('site.more') }}</span>
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
    </div>
</section>
