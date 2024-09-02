<x-app-layout>
    <div class="section certificates-section pt-0">
        <div class="container">
            <div class="certificates-section__content">
                <div class="certificates">
                    @foreach($certificates as $certificate)
                        <a href="{{ $certificate->getFirstMediaUrl('preview') }}" class="certificates__item" data-fancybox="certificates-item" data-caption="{{ $certificate->title }}">
                            <div class="certificates__item-content">
                                <picture class="certificates__item-pic">
                                    <source srcset="{{ $certificate->getFirstMediaUrl('preview') }}" type="image/webp">
                                    <source srcset="{{ $certificate->getFirstMediaUrl('preview') }}" type="image/jpeg">
                                    <img src="{{ $certificate->getFirstMediaUrl('preview') }}" width="500" height="707" alt="Certificate Name" class="certificates__item-image">
                                </picture>
                                <div class="certificates__item-text">
                                    <span class="certificates__item-title">{{ $certificate->title }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
