<section class="section partners-section partners-section--bg-color-dark-1">
    <div class="container">
        <div class="partners-section__content">
            <div class="section-top section-top--type-1 section-top--centered partners-section__section-top">
                <h2 class="section-title section-title--type-1 section-title--centered text-color-white partners-section__section-title">
                    <picture class="section-title__icon">
                        <img src="{{ asset('assets/img/section-title-icon-1.svg') }}" alt="{{ $block->title }}" class="section-title__icon-image">
                    </picture>
                    <span class="section-title__text">{{ $block->title }}</span>
                </h2>
                <div class="section-description section-description--type-1 section-description--centered text-color-white">
                    <p>{!! nl2br($block->data['description']) !!}</p>
                </div>
            </div>
            <div class="partners">
                @foreach($partners as $partner)
                    <@if($partner->link)a target="_blank" href="{{ $partner->link }}" title="{{ $partner->title }}" @else()span @endif class="partners__item">
                        <picture class="partner__item-pic">
                            <source srcset="{{ $partner->getFirstMediaUrl('preview', 'webp') }}" type="image/webp">
                            <source srcset="{{ $partner->getFirstMediaUrl('preview') }}" type="image/jpeg">
                            <img src="{{ $partner->getFirstMediaUrl('preview') }}" width="520" height="302" alt="{{ $partner->title }}" class="partner__item-image">
                        </picture>
                    @if($partner->link) </a> @else </span> @endif
                @endforeach
            </div>
            <div class="btn-group btn-group--centered partners-section__btn-group">
                <a href="{{ route('category', $partnerCategory) }}" title="{{ __('site.all_partners') }}" class="btn btn--type-1">{{ __('site.all_partners') }}</a>
            </div>
        </div>
    </div>
</section>
