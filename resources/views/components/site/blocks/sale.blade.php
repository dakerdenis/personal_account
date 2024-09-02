<section class="section products-section">
    <div class="section-bg products-section__section-bg">
        <span class="section-bg__interactive-circle"></span>
        <span class="section-bg__interactive-circle"></span>
        <span class="section-bg__interactive-circle"></span>
    </div>
    <div class="container">
        <div class="products-section__content">
            <div class="section-top section-top--type-1 products-section__section-top">
                <h2 class="section-title section-title--type-1 products-section__section-title">
                    <picture class="section-title__icon">
                        <img src="{{ asset('assets/img/section-title-icon-1.svg') }}" alt="{{ $block->title }}" class="section-title__icon-image">
                    </picture>
                    <span class="section-title__text">{{ $block->title }}</span>
                </h2>
                <div class="section-description section-description--type-1">
                    <p>{!! nl2br($block->data['description']) !!}</p>
                </div>
            </div>

            <div class="products">
                @foreach($categories as $category)
                    <div class="products__row">
                        <div class="products__type">
                            <div class="products__type-content">
                                <div class="products__type-text">
                                    <span class="products__type-title">{{ $category->title }}</span>
                                </div>
                                <div class="btn-group products__type-actions">
                                    <a href="{{ route('category', $category) }}" title="{{ $category->title }}" class="btn btn--type-2">{{ __('site.category_btn') }}</a>
                                </div>
                            </div>
                        </div>
                        @foreach($category->products()->where('active', 1)->inRandomOrder()->limit(2)->get() as $product)
                            <a href="{{ route('product', ['category' => $category->slug, 'product' => $product->slug]) }}" class="products__item" title="{{ $product->title }}">
                                <div class="products__item-content">
                                    <div class="products__item-visual">
                                        <picture class="products__item-pic">
                                            <source srcset="{{ $product->getFirstMediaUrl('preview', 'thumbWebp') }}" type="image/webp">
                                            <source srcset="{{ $product->getFirstMediaUrl('preview', 'thumb') }}" type="image/jpeg">
                                            <img src="{{ $product->getFirstMediaUrl('preview', 'thumb') }}" width="385" height="385" alt="{{ $product->title }}" class="products__item-image">
                                        </picture>
                                        @if($product->type_b_active)
                                        <ul class="products__item-categories-list">
                                            <li class="products__item-category products__item-category--active">A</li>
                                            <li class="products__item-category">B</li>
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="products__item-info">
                                        <span class="products__item-title">{{ $product->title }}</span>
                                        <div class="products__item-description">
                                            <p>{{ $product->sub_title }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
