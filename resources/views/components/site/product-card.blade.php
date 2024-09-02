@if($showWrapper)
    <div class="{{ $class }} {{ $canDisappear ? 'can-disappear' : '' }}">
        @endif
        <div class="product-box">
            <div class="img-wrapper">
                <div class="lable-block">
                    @if($product->is_new)
                        <span class="lable3">{{ __('site.new') }}</span>
                    @endif
                    @if($product->is_on_sale)
                            <span class="lable4">{{ __('site.on_sale') }}</span>
                    @endif
                </div>
                <div class="front">
                    <a href="{{ $product->link }}"><img src="{{ $frontImage }}"
                                                        class="img-fluid blur-up lazyload bg-img product-image-a"
                                                        alt="{{ $product->title }}"></a>
                </div>
                <div class="back">
                    <a href="{{ $product->link }}"><img src="{{ $backImage }}"
                                                        class="img-fluid blur-up lazyload bg-img product-image-a"
                                                        alt="{{ $product->title }}"></a>
                </div>
                <div class="cart-info cart-wrap">
                    <a href="javascript:void(0)" title="{{ $product->is_favorite ? 'site.remove_from_wishlist' : 'site.add_to_wishlist' }}"><i
                            class="fa {{ $product->is_favorite ? 'fa-heart text-red' : 'fa-heart-o' }} toggle-favorite-inner"
                            data-icon="{{ $product->is_favorite ? 'fa-heart text-red' : 'fa-heart-o' }}"
                            data-replace-icon="{{ $product->is_favorite ? 'fa-heart-o' : 'fa-heart text-red' }}"
                            data-text="{{ $product->is_favorite ? __('site.success_remove_from_wishlist') : __('site.success_added_to_wishlist') }}"
                            data-replace-text="{{ $product->is_favorite ? __('site.success_added_to_wishlist') : __('site.success_remove_from_wishlist') }}"
                            data-id="{{ $product->id }}" data-url="{{ route('toggle-favorite', $product) }}"
                            aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="product-detail">
                <div>
                    <a title="{{ $product->title }}" href="{{ $product->link }}">
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
        </div>
        @if($showWrapper)
    </div>
@endif
