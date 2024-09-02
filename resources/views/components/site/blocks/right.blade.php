<section class="annual-stats-section">
    <div class="main-container">
        <div class="on-picture-content">
            @php
                $string = $block->title;
                $updatedString = preg_replace('/@@(.*?)@@/', '<span class="bold">$1</span>', $string);
            @endphp
            <div class="icon">
                <img src="{{ asset('assets/images/akar-icons_statistic-up_gray.svg') }}" width="43" height="43" alt="{{ strip_tags($updatedString) }}" loading="lazy">
            </div>
            <h2>{!! $updatedString !!}</h2>
        </div>
    </div>
    <picture class="p-abs-inset-0">
        <source srcset="{{ $block->getFirstMediaUrl('preview', 'thumbIndicators') }}" media="(max-width: 500px)">
        <img class="img-in-picture" src="{{ $block->getFirstMediaUrl('preview', 'webp') }}" width="1044" height="480" alt="{{ strip_tags($updatedString) }}" loading="lazy">
    </picture>
    <div class="floating">
        <div class="float-stat">
            <p class="title">{{ $block->data['first_title'] ?? '' }}</p>
            <p class="numbers">{{ $block->data['first_value'] ?? '' }}</p>
        </div>
        @if($block->data['second_title'])
            <div class="float-stat">
                <p class="title">{{ $block->data['second_title'] ?? '' }}</p>
                <p class="numbers">{{ $block->data['second_value'] ?? '' }}</p>
            </div>
        @endif
    </div>
</section>

<section class="annual-stats-section floating-section">
    <div class="floating">
        <div class="float-stat">
            <p class="title">{{ $block->data['first_title'] ?? '' }}</p>
            <p class="numbers">{{ $block->data['first_value'] ?? '' }}</p>
        </div>
        @if($block->data['second_title'])
        <div class="float-stat">
            <p class="title">{{ $block->data['second_title'] ?? '' }}</p>
            <p class="numbers">{{ $block->data['second_value'] ?? '' }}</p>
        </div>
        @endif
    </div>
</section>
