<section class="section mini-article">
    <div class="section-bg mini-article__section-bg">
        <span class="section-bg__interactive-circle"></span>
        <span class="section-bg__interactive-circle"></span>
        <span class="section-bg__interactive-circle"></span>
    </div>
    <div class="container">
        <div class="mini-article__content">
            <div class="mini-article__text">
                <div class="section-top section-top--type-1 mini-article__section-top">
                    <h2 class="section-title section-title--type-1 mini-article__section-title">
                        <picture class="section-title__icon">
                            <img src="{{ asset('assets/img/section-title-icon-1.svg') }}" alt="{{ $block->title }}" class="section-title__icon-image">
                        </picture>
                        <span class="section-title__text">{{ $block->title }}</span>
                    </h2>
                    <div class="section-description section-description--type-1">
                        <p>{!! nl2br($block->data['heading_description']) !!}</p>
                    </div>
                </div>
                <div class="mini-article__entry">
                    <p>{!! nl2br($block->data['description']) !!}</p>
                </div>
                <div class="btn-group mini-article__btn-group">
                    <a href="{{ LaravelLocalization::getLocalizedURL(\Illuminate\Support\Facades\App::getLocale(), $block->meta['link']) }}" title="{{ $block->title }}" class="btn btn--type-1">{{ __('site.read_more') }}</a>
                </div>
            </div>
            <div class="mini-article__pics-all">
                <picture class="mini-article__pic">
                    <source srcset="{{ $block->getFirstMediaUrl('preview', 'webp') }}" type="image/webp">
                    <source srcset="{{ $block->getFirstMediaUrl('preview') }}" type="image/png">
                    <img src="{{ $block->getFirstMediaUrl('preview') }}" width="566" height="800" alt="{{ $block->title }}" class="mini-article__pic-image">
                </picture>
            </div>
        </div>
    </div>
</section>
