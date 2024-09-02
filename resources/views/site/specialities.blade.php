<x-app-layout :class="'main-text-page main-search-page'">
    <div class="text-content">
        <div class="main-container">
            <div class="search-page-grid">
                <div class="search-content">
                    <div class="search-input">
                        <input id="searchFilter" type="text" placeholder="{{ __('site.search') }}">
                        <img src="{{ asset('assets/images/gg_search.svg') }}" width="32" height="32" alt="{{ __('site.search') }}">
                    </div>

                    <div class="search-results">
                        @foreach($specialities['specialities'] as $speciality)
                            <a href="{{ route('speciality', ['category' => $category, 'id' => $speciality['id']]) }}" data-search="{{ __('doctors.' . \Illuminate\Support\Str::slug($speciality['name'])) }}" class="search-result doctor-specialization-search-result">
                                <img class="avatar" src="{{ asset('assets/images/healthicons_doctor-male-outline.svg') }}" width="65" height="65" alt="$speciality['name']" loading="lazy">
                                <span class="title">{{ __('doctors.' . \Illuminate\Support\Str::slug($speciality['name'])) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="aside-content">
                    @if($appBlock)
                        <div class="app-block">
                            <h3 class="animate-on-scroll animate__animated" data-animation="fadeIn">{{ $appBlock->title }}</h3>
                            <p class="animate-on-scroll animate__animated" data-animation="fadeIn">{!! html_entity_decode(nl2br($appBlock->data['description'])) !!}</p>
                            <div class="app-images animate-on-scroll animate__animated" data-animation="fadeIn">
                                <a title="{{ $appBlock->title }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(\Illuminate\Support\Facades\App::getLocale(),  $appBlock->meta['link'] ) }}" class="detailed-btn-link gray-1">
                                    <span>{{ __('site.read_more') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                        <path
                                            d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z"
                                            fill="#F4F4F4" />
                                    </svg>
                                </a>
                            </div>
                            <div class="app-screen-images animate-on-scroll animate__animated animate__delay-18ms" data-animation="fadeIn">
                                <picture>
                                    <source srcset="{{ asset('assets/images/app_screens.webp') }}" media="(max-width: 1023px)">
                                    <img class="img-in-picture" src="{{ asset('assets/images/app_twisted_screens.webp') }}" alt="{{ $appBlock->title }}" width="520" height="433" loading="lazy">
                                </picture>
                            </div>
                        </div>
                    @endif

                    @if($appLinks)
                            <div class="links-block">
                                @foreach($appLinks->repeatables()->ordered()->get() as $repeatable)
                                    <a target="{{ str_starts_with($repeatable->meta['link'] ?? '', 'http') ? '_blank' : '_self' }}"
                                       href="{{ str_starts_with($repeatable->meta['link'] ?? '', 'http') ? $repeatable->meta['link'] : LaravelLocalization::localizeUrl($repeatable->meta['link'])}}"
                                       title="{{ $repeatable->title }}"
                                       class="animate-on-scroll animate__animated" data-animation="fadeIn">
                                        <img width="84" height="84" src="{{ $repeatable->getFirstMediaUrl('preview') }}" alt="{{ $repeatable->title }}" loading="lazy">
                                        <span>{{ $repeatable->title }}</span>
                                    </a>
                                @endforeach
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            function filterElements() {
                // obtain the value of the input element
                let filterValue = document.getElementById('searchFilter').value.toLowerCase();

                // get all elements with data-search attribute
                let elements = document.querySelectorAll('[data-search]');

                // loop through each collected element
                elements.forEach(function(element) {
                    let elementSearchValue = element.getAttribute('data-search').toLowerCase();

                    // if the element's `data-search` attribute value does not contain the filterValue, hide the element
                    if (elementSearchValue.indexOf(filterValue) === -1) {
                        element.style.display = 'none';  // hide
                    } else {
                        element.style.display = '';  // show
                    }
                });
            }

            // attach the filter function to the 'keyup' event of the searchFilter input
            document
                .getElementById('searchFilter')
                .addEventListener('keyup', filterElements);
        </script>
    </x-slot>
</x-app-layout>
