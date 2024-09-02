<x-app-layout :class="'main-text-page main-search-result-page'">
    <div class="text-content search-result-section">
        <section>
            <div class="main-container">
                <h2>{{ __('site.other_search') }}</h2>
                <div class="vacancies-grid">
                    @foreach($other as $item)
                        @include('site.partials.other')
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
