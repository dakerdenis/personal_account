@php
    /** @var \App\Models\Product $product */
@endphp
<div class="theme-card">
    <h5 class="title-border">{{ $block->title }}</h5>
    <div class="offer-slider slide-1">
        @foreach($products->chunk(3) as $chunk)
            <div>
                @foreach($chunk as $product)
                    <div class="media">
                        <a href="{{ $product->link }}"><img class="img-fluid blur-up lazyload"
                                        src="{{ $product->getFirstMediaUrl('gallery') }}" alt="{{ $product->title }}"></a>
                        <div class="media-body align-self-center">
                            <a href="{{ $product->link }}" title="Lelli Kelly Girls Pink Faux Leather Boots">
                                <h6>{{ $product->title }}</h6>
                            </a>
                            @if($product->activeDeal->first())
                                <h4>{{ $product->activeDeal->first()->formatted_price }} ₼</h4>
                                <del> {{ $product->formatted_price }} ₼</del>
                            @else
                                <h4>{{ $product->formatted_price }} ₼</h4>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
