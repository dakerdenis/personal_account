
<div class="search__wrapper @if($showFlatBanner) search__wrapper_float @endif">


    <div class="header_container_nav">
        <div class="header_nav_wrap">

            @foreach($menu as $item)
                <div class="header_nav_element  @if($item->children->count()) header_nav_element_dropdown @endif">
                    @if($item->getFirstMediaUrl('preview'))
                        <img src="{{ $item->getFirstMediaUrl('preview') }}" alt="{{ $item->title }}" srcset="">
                    @endif
                    <a title="{{ $item->title }}" href="{{ $item->slug !== '#' ? LaravelLocalization::getLocalizedURL(App::getLocale(), $item->slug) : 'javascript:void(0);'}}">{{ $item->title }}</a>
                    @if($item->children->count())
                        <div class="dropdown-content1">
                            @foreach($item->children as $child)
                                <a title="{{ $child->title }}" href="{{LaravelLocalization::getLocalizedURL(App::getLocale(), $child->slug)}}">{{ $child->title }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
    </div>

    <div class="search__image__block">
        <picture class="clinics__item-icon">
            <source srcset="{{ $settings->banner.'.webp' }}"
                    type="image/webp">
            <source srcset="{{ $settings->banner.'.jpg' }}" type="image/jpeg">
            <img class="search__background_image" src="{{ $settings->banner.'.jpg' }}" alt="{{ __('site.buy_ready_business') }}">
        </picture>
    </div>

    @if(!$showFlatBanner)
    <div class="search__promotext_block">
        <div class="search__promotext_text">
            {{ __('site.buy_ready_business') }}
        </div>
{{--        <div class="search__promotext_buttons">--}}
{{--            <a href="#" class="search__promo_button_add">{{ __('site.add_business') }}</a>--}}
{{--            <a href="#" class="search__promo_button_buy">{{ __('site.buy_business') }}</a>--}}
{{--        </div>--}}
    </div>
    @endif


    <div class="search_container">
        <div class="search_name_desc">
            {{ __('site.main_search_text') }}
        </div>
        <form class="searc_form" id="filter-form" data-map-action="{{ route('map') }}" data-action="{{ route('advert-list') }}" action="{{ $getDefaultAction }}">
            <div class="search_block_wrapper">
                <div class="search__block_container_2">
                    <!--Стандартный блок на 2 элемента--->
                    <div class="search__block_block">


                        <div class="search__how_tobuy">
                            <!--Варианты покупки полные---->
                            <div class="custom-select">
                                <select name="type_id" id="type_id_filter">
                                    <option value="">{{ __('site.select_type') }}</option>
                                    @foreach($types as $type)
                                        <option {{ $getSelectedType() === $type->id ? 'selected' : '' }} data-slug="/{{ $type->slug }}" value="{{ $type->id }}">{{ $type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--Варианты категорий полные---->
                        <div class="search__how_tobuy">
                            <div class="custom-select category-select-filter">
                                <select name="category_id" data-default="{{ __('site.select_category') }}" id="category_id_filter">
                                    <option value="">{{ __('site.select_category') }}</option>
                                    @foreach($categories as $category)
                                        <option {{ $getSelectedCategory() === $category->id ? 'selected' : '' }} data-slug="{{ $category->slug }}" value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>




                    </div>
                    <!--Стандартный блок на 1 элемент--->
                    <div class="search__block_block2">
                        <!-- ввод поиска -->
                        <div class="search_buy_input">
                            <input class="search_buy_input-input" type="text" name="search" id="" value="{{ request()->get('search') }}" placeholder="{{ __('site.search_placeholder') }}">
                        </div>

                    </div>
                </div>
                <div class="search__block_square_price">

                    <!-- Цена и наличие -->
                    <div class="search__block_block3">
                        <!--Цена-->
                        <div class="search__block__price">
                            <p class="price__name_search">{{ __('site.price') }}</p>
                            <!--минимальная цена-->
                            <div class="search__price__min">
                                <input name="price_min" value="{{ request()->get('price_min') }}" type="number" placeholder="{{ __('site.min') }}">
                                <p>₼</p>
                            </div>

                            <!--максимальная цена-->
                            <div class="search__price__max">
                                <input type="number" name="price_max" value="{{ request()->get('price_max') }}" placeholder="{{ __('site.max') }}">
                                <p>₼</p>
                            </div>
                        </div>

                        <!--- локация на карте и кнопка поиска--->
                        <div class="search__block__map_button">
                            <!---локация на карте--->
                            <div class="search__block__map">
                                <a  id="popup__search_map">
                                    <img src="{{ asset('assets/style/imgs/location.png') }}" alt="#">
                                    <p>{{ __('site.show_on_map') }}</p>
                                </a>
                            </div>
                            <!-----кнопка поиска-->
                            <div class="search__block__button">
                                <button>{{ __('site.adverts_search_apply') }}</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!--Блок с вариантами локацией и кнопкой поиска -->
                <div class="search__block__map_button1">
                    <!---доп поиск все обнулить запомнить поиск--->
                    <div class="search__block__additional">
                        <div class=" additional__show_hide">
                            <p>{{ __('site.advanced_search') }}</p> <img class="additional_show__image" src="{{ asset('assets/style/imgs/arrow-down.svg') }}" alt="">
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div id="popup_3" class="popup">
        <div class="popup__body">
            <div class="popup__content">
                <a href="#header"  class="popup__close close-popup">&#10006;</a>
                <div class="popup__wrapper_content">
                    <div class="popup__map_container">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
