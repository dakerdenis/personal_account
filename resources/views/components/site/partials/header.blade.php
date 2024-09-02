<header class="animate__animated animate__slideInDown">
    <div class="header-container">
        <div class="header-content">
            <a class="logo" href="{{ customIndexUrl() }}" aria-label="{{ __('site.home_page') }}" title="{{ __('site.home_page') }}">
                <img width="67" height="66" src="{{ asset('assets/images/company_logo.svg') }}" alt="{{ __('site.home_page') }}">
            </a>
            <nav>
                @foreach($menu as $item)
                    @if($loop->first)
                        <div class="nav-item nav-item-0 popover-trigger">
                            @if($item->slug === '#')
                                <span>{{ $item->title }}</span>
                                @else
                                <a target="{{ $item->target }}" href="{{ $item->generated_link }}">{{ $item->title }}</a>
                            @endif
                            @if($item->children)
                            <div class="popover nav-item-0-popover animate__animated animate__duration-20ms animate__fadeIn">
                                <div class="popover-wrapper">
                                    <div class="popover-content aboutUs">
                                        <div class="navigation-links">
                                            <div class="navigation-links-col">
                                                <div class="navigation-links-block">
                                                    @foreach($item->children as $child)
                                                        <a href="{{ $child->generated_link }}" target="{{ $child->target }}"
                                                           class="link"  title="{{$child->title . ($child->seo_keywords ? ' ' . $child->seo_keywords : '')}}">{{ $child->title }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="nav-item nav-item-{{ $loop->iteration - 1}} popover-trigger">
                            <a href="{{ $item->generated_link }}" target="{{ $item->target }}"
                               title="{{$item->title . ($item->seo_keywords ? ' ' . $item->seo_keywords : '')}}">{{ $item->title }}</a>
                            @if($item->children)
                                <div class="popover nav-item-{{ $loop->iteration-1 }}-popover animate__animated animate__duration-20ms animate__fadeIn">
                                    <div class="popover-wrapper">
                                        <div class="popover-content">
                                            <div class="navigation-links">
                                                @foreach($item->children as $child)
                                                    <div class="navigation-links-col">
                                                        <div class="navigation-links-block">
                                                            <a class="title" target="{{ $child->target }}"
                                                               href="{{ $child->generated_link }}"
                                                               title="{{$child->title . ($child->seo_keywords ? ' ' . $child->seo_keywords : '')}}">{{ $child->title }}</a>
                                                            @if($child->children)
                                                                @foreach($child->children as $innerChild)
                                                                    <a class="link" target="{{ $innerChild->target }}" title="{{$innerChild->title . ($innerChild->seo_keywords ? ' ' . $innerChild->seo_keywords : '')}}"
                                                                       href="{{ $innerChild->generated_link }}">{{ $innerChild->title }}</a>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </nav>
            <div class="middle lte-1023">
                <a href="tel:{{ $contact->short_number }}" class="tel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
                        <path
                            d="M3.39844 5.09844C3.39844 4.64757 3.57754 4.21517 3.89636 3.89636C4.21517 3.57754 4.64757 3.39844 5.09844 3.39844H8.75854C9.16094 3.39862 9.55023 3.54154 9.85715 3.80178C10.1641 4.06201 10.3687 4.42269 10.4347 4.81964L11.6927 12.3591C11.7528 12.7182 11.6961 13.0871 11.5308 13.4115C11.3656 13.7359 11.1005 13.9987 10.7747 14.1611L8.14314 15.4752C9.08682 17.8138 10.4923 19.9382 12.2755 21.7214C14.0587 23.5046 16.183 24.9101 18.5216 25.8537L19.8374 23.2221C19.9998 22.8967 20.2623 22.6318 20.5864 22.4666C20.9104 22.3014 21.2789 22.2444 21.6377 22.3041L29.1772 23.5621C29.5742 23.6281 29.9349 23.8328 30.1951 24.1397C30.4553 24.4466 30.5983 24.8359 30.5984 25.2383V28.8984C30.5984 29.3493 30.4193 29.7817 30.1005 30.1005C29.7817 30.4193 29.3493 30.5984 28.8984 30.5984H25.4984C13.2924 30.5984 3.39844 20.7044 3.39844 8.49844V5.09844Z"
                            fill="#BE111D"/>
                    </svg>
                    <span>{{ $contact->short_number }}</span>
                </a>
            </div>
            <div class="right-side">
                <a href="tel:{{ $contact->short_number }}" class="tel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
                        <path
                            d="M3.39844 5.09844C3.39844 4.64757 3.57754 4.21517 3.89636 3.89636C4.21517 3.57754 4.64757 3.39844 5.09844 3.39844H8.75854C9.16094 3.39862 9.55023 3.54154 9.85715 3.80178C10.1641 4.06201 10.3687 4.42269 10.4347 4.81964L11.6927 12.3591C11.7528 12.7182 11.6961 13.0871 11.5308 13.4115C11.3656 13.7359 11.1005 13.9987 10.7747 14.1611L8.14314 15.4752C9.08682 17.8138 10.4923 19.9382 12.2755 21.7214C14.0587 23.5046 16.183 24.9101 18.5216 25.8537L19.8374 23.2221C19.9998 22.8967 20.2623 22.6318 20.5864 22.4666C20.9104 22.3014 21.2789 22.2444 21.6377 22.3041L29.1772 23.5621C29.5742 23.6281 29.9349 23.8328 30.1951 24.1397C30.4553 24.4466 30.5983 24.8359 30.5984 25.2383V28.8984C30.5984 29.3493 30.4193 29.7817 30.1005 30.1005C29.7817 30.4193 29.3493 30.5984 28.8984 30.5984H25.4984C13.2924 30.5984 3.39844 20.7044 3.39844 8.49844V5.09844Z"
                            fill="#BE111D"/>
                    </svg>
                    <span>{{ $contact->short_number }}</span>
                </a>

                @if($buttonMenu->count())
                    <div class="actions">
                        @foreach($buttonMenu as $btnItem)
                            @if($loop->first)
                                <a href="{{ $btnItem->generated_link }}" title="{{ $btnItem->title }}" class="primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                        <path d="M4.00754 21.4141H19.9854C20.2449 21.414 20.4999 21.3466 20.7256 21.2185C20.9513 21.0904 21.1399 20.906 21.2729 20.6832C21.406 20.4604 21.4789 20.2068 21.4847 19.9474C21.4905 19.688 21.4288 19.4315 21.3058 19.203L13.3174 4.36703C12.7507 3.31516 11.2422 3.31516 10.6755 4.36703L2.68708 19.203C2.56405 19.4315 2.50241 19.688 2.50818 19.9474C2.51395 20.2068 2.58693 20.4604 2.71999 20.6832C2.85304 20.906 3.04162 21.0904 3.2673 21.2185C3.49298 21.3466 3.74804 21.414 4.00754 21.4141Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M11.7346 9.66173L12.0036 15.3805L12.2722 9.66408C12.2739 9.62753 12.2681 9.59103 12.2551 9.55681C12.2422 9.52259 12.2224 9.49136 12.197 9.46504C12.1716 9.43871 12.1411 9.41785 12.1074 9.40371C12.0737 9.38958 12.0374 9.38247 12.0008 9.38283C11.9649 9.38318 11.9294 9.39073 11.8964 9.40503C11.8634 9.41933 11.8336 9.44009 11.8088 9.46609C11.784 9.49208 11.7646 9.52279 11.7519 9.55639C11.7391 9.59 11.7332 9.62581 11.7346 9.66173Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 19.125C11.8146 19.125 11.6333 19.07 11.4792 18.967C11.325 18.864 11.2048 18.7176 11.1339 18.5463C11.0629 18.375 11.0443 18.1865 11.0805 18.0046C11.1167 17.8227 11.206 17.6557 11.3371 17.5246C11.4682 17.3935 11.6352 17.3042 11.8171 17.268C11.999 17.2318 12.1875 17.2504 12.3588 17.3214C12.5301 17.3923 12.6765 17.5125 12.7795 17.6667C12.8825 17.8208 12.9375 18.0021 12.9375 18.1875C12.9375 18.4361 12.8387 18.6746 12.6629 18.8504C12.4871 19.0262 12.2486 19.125 12 19.125Z" fill="white"/>
                                    </svg>
                                    <span>{{ $btnItem->title }}</span>
                                </a>
                                @else
                                <a href="{{ $btnItem->generated_link }}" title="{{ $btnItem->title }}" target="_blank" class="primary-outline">{{ $btnItem->title }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif

                <div class="lang-switcher popover-trigger">
                    <span>{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Facades\App::getLocale()) }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="11" viewBox="0 0 16 11" fill="none">
                        <path d="M3 4L8 9L13 4" stroke="#242323" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    <div class="popover lang-switcher-popover animate__animated animate__duration-20ms animate__fadeIn">
                        <div class="popover-wrapper">
                            <div class="popover-content">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    @if(\Illuminate\Support\Facades\App::getLocale() != $localeCode)
                                        @if(\Illuminate\Support\Facades\Route::is('index') && $localeCode == 'az')
                                            <a rel="alternate"
                                               hreflang="{{ $localeCode }}"
                                               href="{{ url('/') }}">
                                                {{ \Illuminate\Support\Str::upper($localeCode) }}
                                            </a>
                                        @else
                                            <a rel="alternate"
                                               hreflang="{{ $localeCode }}"
                                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                {{ \Illuminate\Support\Str::upper($localeCode) }}
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="menu-trigger popover-trigger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20" viewBox="0 0 24 20" fill="none">
                        <path
                            d="M0 1C0 0.447715 0.447715 0 1 0H23C23.5523 0 24 0.447715 24 1C24 1.55228 23.5523 2 23 2H1C0.447716 2 0 1.55228 0 1Z"
                            fill="#242323"/>
                        <path
                            d="M0 10C0 9.44772 0.447715 9 1 9H23C23.5523 9 24 9.44772 24 10C24 10.5523 23.5523 11 23 11H1C0.447716 11 0 10.5523 0 10Z"
                            fill="#242323"/>
                        <path
                            d="M0 19C0 18.4477 0.447715 18 1 18H23C23.5523 18 24 18.4477 24 19C24 19.5523 23.5523 20 23 20H1C0.447716 20 0 19.5523 0 19Z"
                            fill="#242323"/>
                    </svg>
                    <div class="popover menu-trigger-popover animate__animated animate__duration-20ms animate__fadeIn">
                        <div class="popover-wrapper">
                            <div class="popover-content burger-menu-content">
                                <div class="search">
                                    <input type="text" id="query" name="query" placeholder="{{ __('site.search_placeholder') }}">
                                    <div id="makeSearch" class="search-magnifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M24.5414 21.8677C26.3079 19.5902 27.1405 16.7253 26.8697 13.8557C26.5988 10.9861 25.245 8.32753 23.0835 6.42074C20.9221 4.51395 18.1154 3.50222 15.2345 3.59137C12.3535 3.68051 9.61478 4.86385 7.57536 6.90063C5.53416 8.93883 4.34696 11.6786 4.25568 14.5618C4.1644 17.4449 5.17592 20.2543 7.0841 22.4176C8.99228 24.5808 11.6535 25.935 14.5255 26.2043C17.3975 26.4735 20.264 25.6375 22.541 23.8666L22.6019 23.9304L28.6114 29.9413C28.7431 30.0729 28.8993 30.1773 29.0713 30.2486C29.2433 30.3198 29.4276 30.3565 29.6137 30.3565C29.7999 30.3565 29.9842 30.3198 30.1562 30.2486C30.3281 30.1773 30.4844 30.0729 30.616 29.9413C30.7477 29.8097 30.8521 29.6534 30.9233 29.4814C30.9945 29.3095 31.0312 29.1251 31.0312 28.939C31.0312 28.7529 30.9945 28.5685 30.9233 28.3966C30.8521 28.2246 30.7477 28.0683 30.616 27.9367L24.6051 21.9272C24.5844 21.9068 24.5632 21.887 24.5414 21.8677ZM21.6004 8.90521C22.4002 9.69214 23.0363 10.6297 23.4721 11.6637C23.9078 12.6977 24.1345 13.8077 24.139 14.9298C24.1436 16.0518 23.926 17.1637 23.4987 18.2012C23.0714 19.2387 22.4429 20.1814 21.6495 20.9748C20.8561 21.7682 19.9134 22.3967 18.8759 22.824C17.8384 23.2512 16.7265 23.4689 15.6045 23.4643C14.4824 23.4597 13.3724 23.233 12.3384 22.7973C11.3044 22.3616 10.3669 21.7255 9.57994 20.9256C8.00733 19.3272 7.13004 17.1721 7.13917 14.9298C7.1483 12.6874 8.04311 10.5395 9.62869 8.95396C11.2143 7.36838 13.3622 6.47357 15.6045 6.46444C17.8468 6.45531 20.0019 7.3326 21.6004 8.90521Z"
                                                  fill="#BE111D"/>
                                        </svg>
                                    </div>
                                </div>
                                @php
                                    $firstColumn = $sideMenu->first();
                                    $secondColumn = $sideMenu->slice(1, 2);
                                    $lastColumn = $sideMenu->slice(3);
                                @endphp
                                <div class="navigation-links">
                                    <div class="navigation-links-col before-1240">
                                        <div class="navigation-links-block">
                                            <h3>
                                                @if($firstColumn->slug !== '#')
                                                    <a title="{{$firstColumn->title . ($firstColumn->seo_keywords ? ' ' . $firstColumn->seo_keywords : '')}}"
                                                       target="{{ $firstColumn->target }}"
                                                       href="{{ $firstColumn->generated_link }}">{{ $firstColumn->title }}</a>
                                                @else
                                                    {{ $firstColumn->title }}
                                                @endif
                                            </h3>
                                            @if($firstColumn->children)
                                                @foreach($firstColumn->children as $firstColumnChild)
                                                    <a title="{{$firstColumnChild->title . ($firstColumnChild->seo_keywords ? ' ' . $firstColumnChild->seo_keywords : '')}}"
                                                       class="link"
                                                       target="{{ $firstColumnChild->target }}"
                                                       href="{{ $firstColumnChild->generated_link }}">{{ $firstColumnChild->title }}</a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="navigation-links-col before-1240">
                                        @foreach($secondColumn as $secondColumnItem)
                                            <div class="navigation-links-block">
                                                <h3>
                                                    @if($secondColumnItem->slug !== '#')
                                                        <a title="{{$secondColumnItem->title . ($secondColumnItem->seo_keywords ? ' ' . $secondColumnItem->seo_keywords : '')}}"
                                                           target="{{ $secondColumnItem->target }}"
                                                           href="{{ $secondColumnItem->generated_link }}">{{ $secondColumnItem->title }}</a>
                                                    @else
                                                        {{ $secondColumnItem->title }}
                                                   @endif
                                                </h3>
                                                @if($secondColumnItem->children)
                                                    @foreach($secondColumnItem->children as $secondColumnItemChild)
                                                        <a title="{{$secondColumnItemChild->title . ($secondColumnItemChild->seo_keywords ? ' ' . $secondColumnItemChild->seo_keywords : '')}}"
                                                           class="link-header" target="{{ $secondColumnItemChild->target }}"
                                                           href="{{ $secondColumnItemChild->generated_link }}">{{ $secondColumnItemChild->title }}</a>
                                                        @foreach($secondColumnItemChild->children as $secondColumnItemChildInner)
                                                            <a title="{{$secondColumnItemChildInner->title . ($secondColumnItemChildInner->seo_keywords ? ' ' . $secondColumnItemChildInner->seo_keywords : '')}}"
                                                               class="link" target="{{ $secondColumnItemChildInner->target }}"
                                                               href="{{ $secondColumnItemChildInner->generated_link }}">{{ $secondColumnItemChildInner->title }}</a>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    @php
                                        $totalCount = $lastColumn->count();
                                        $column1Count = floor($totalCount / 2);
                                        $column2Count = $totalCount - $column1Count;
                                        $result = [
                                            $lastColumn->take($column1Count),
                                            $lastColumn->slice($column1Count, $column2Count)
                                        ];
                                    @endphp
                                    @foreach($result as $lastColumnChunk)
                                        <div class="navigation-links-col">
                                            @foreach($lastColumnChunk as $lastColumnChunkItem)
                                                <div class="navigation-links-block">
                                                    <h3>
                                                        @if($lastColumnChunkItem->slug !== '#')
                                                            <a title="{{$lastColumnChunkItem->title . ($lastColumnChunkItem->seo_keywords ? ' ' . $lastColumnChunkItem->seo_keywords : '')}}"
                                                               target="{{ $lastColumnChunkItem->target }}"
                                                               href="{{ $lastColumnChunkItem->generated_link }}">{{ $lastColumnChunkItem->title }}</a>
                                                        @else
                                                            {{ $lastColumnChunkItem->title }}
                                                        @endif
                                                    </h3>
                                                    @if($lastColumnChunkItem->children)
                                                        @foreach($lastColumnChunkItem->children as $lastColumnChunkItemChild)
                                                            <a title="{{$lastColumnChunkItemChild->title . ($lastColumnChunkItemChild->seo_keywords ? ' ' . $lastColumnChunkItemChild->seo_keywords : '')}}"
                                                               class="link" target="{{ $lastColumnChunkItemChild->target }}"
                                                               href="{{ $lastColumnChunkItemChild->generated_link }}">{{ $lastColumnChunkItemChild->title }}</a>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@push('extraScripts')
    <script>
        let searchRoute = '{{ route('search') }}';
        document.getElementById('makeSearch').addEventListener('click', function() {
            var query = document.getElementById('query').value;
            window.open(searchRoute + '/?query=' + encodeURIComponent(query), '_self');
        });

        document.getElementById('query').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                var query = e.target.value;
                window.open(searchRoute + '/?query=' + encodeURIComponent(query), '_self');
            }
        });

    </script>
@endpush
