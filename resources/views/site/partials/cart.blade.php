    <div><img src="{{ asset('assets/images/cart.png') }}"
              class="img-fluid blur-up lazyload" alt=""> <i
            class="ti-shopping-cart"></i></div>
    <span class="cart_qty_cls">{{ count($cartService->getItems()) }}</span>
    <ul class="show-div shopping-cart">
        @foreach($cartService->getItems() as $item)
            @php
                $productOffer = $item['productOffer'];
                $quantity = $item['quantity'];
            @endphp
            <li>
                <div class="media">
                    <a href="{{ $productOffer->product->link }}"><img alt="{{ $productOffer->product->title }}" class="me-3"
                                                                      src="{{ $productOffer->product->getFirstMediaUrl('gallery') }}"></a>
                    <div class="media-body">
                        <a href="{{ $productOffer->product->link }}">
                            <h4>{{ $productOffer->product->title }}</h4>
                        </a>
                        <h4><span>{{ __('site.size_c') }}: {{ $productOffer->size->title }}</span></h4>
                        <h4><span>{{ $quantity }} x {{$productOffer->product->actual_price }} ₼</span></h4>
                    </div>
                </div>
                <div data-link="{{ route('cart.remove', $productOffer) }}" class="close-circle remove-from-cart"><a href="javascript:void(0);"><i class="fa fa-times"
                                                                                                                                                  aria-hidden="true"></i></a></div>
            </li>
        @endforeach
        <li>
            <div class="total">
                <h5>{{ __('site.subtotal') }} : <span><span style="float: none" id="total-price">{{ number_format($cartService->getTotal(), 2) }}</span> <span style="float: none">₼</span></span></h5>
            </div>
        </li>
        <li>
            <div class="buttons"><a href="{{ route('cart.index') }}" class="view-cart">{{ __('site.view_cart') }}</a> <a href="{{ route('cart.checkout') }}" class="checkout">{{ __('site.checkout') }}</a></div>
        </li>
    </ul>
