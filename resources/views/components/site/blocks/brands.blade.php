<div class="brands-section">
    <div class="container">
        <div class="brands-section__content">
            <div class="brands">
                @foreach($brands as $brand)
                    <div class="brands__item">
                        <picture class="brands__item-icon">
                            <source srcset="{{ $brand->getFirstMediaUrl('preview', 'webp') }}" type="image/webp">
                            <source srcset="{{ $brand->getFirstMediaUrl('preview') }}" type="image/jpeg">
                            <img src="{{ $brand->getFirstMediaUrl('preview') }}" loading="lazy" alt="{{ $brand->title }}">
                        </picture>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
