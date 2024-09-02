@php
    /** @var \App\Models\Vacancy[] $vacancies */
@endphp
@php
    \Illuminate\Support\Facades\View::share('topDescription', $category->description);
@endphp
<x-app-layout class="main-text-page main-vacancies-page">
    <div class="text-content">
        <div class="main-container">
            <div class="vacancies-grid">
                @foreach($vacancies as $vacancy)
                    <div class="vacancy-block animate-on-scroll animate__animated" data-animation="fadeIn">
                        <div class="top">
                            <div class="date">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M8.66667 4.33854H17.3333V2.17188H19.5V4.33854H20.5833C21.158 4.33854 21.7091 4.56681 22.1154 4.97314C22.5217 5.37947 22.75 5.93057 22.75 6.50521V21.6719C22.75 22.2465 22.5217 22.7976 22.1154 23.2039C21.7091 23.6103 21.158 23.8385 20.5833 23.8385H5.41667C4.84203 23.8385 4.29093 23.6103 3.8846 23.2039C3.47827 22.7976 3.25 22.2465 3.25 21.6719V6.50521C3.25 5.93057 3.47827 5.37947 3.8846 4.97314C4.29093 4.56681 4.84203 4.33854 5.41667 4.33854H6.5V2.17188H8.66667V4.33854ZM5.41667 8.67188V21.6719H20.5833V8.67188H5.41667ZM7.58333 11.9219H9.75V14.0885H7.58333V11.9219ZM11.9167 11.9219H14.0833V14.0885H11.9167V11.9219ZM16.25 11.9219H18.4167V14.0885H16.25V11.9219ZM16.25 16.2552H18.4167V18.4219H16.25V16.2552ZM11.9167 16.2552H14.0833V18.4219H11.9167V16.2552ZM7.58333 16.2552H9.75V18.4219H7.58333V16.2552Z"
                                          fill="#BE111D" />
                                </svg>
                                <span>{{ $vacancy->date->format('d.m.Y') }}</span>
                            </div>
                            <div class="title">
                                {{ $vacancy->title }}
                            </div>
                            <div class="branch">{{ $vacancy->vacancyPlaceTitle->title }}</div>
                        </div>
                        <div class="bottom">
                            <a href="{{ $vacancy->generateLink($category) }}" title="{{ $vacancy->title }}" class="primary-outline detailed-btn-link">
                                <span>{{ __('site.more') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="13" viewBox="0 0 35 13" fill="none">
                                    <path d="M34.5303 7.03033C34.8232 6.73744 34.8232 6.26257 34.5303 5.96967L29.7574 1.1967C29.4645 0.903808 28.9896 0.903808 28.6967 1.1967C28.4038 1.4896 28.4038 1.96447 28.6967 2.25736L32.9393 6.5L28.6967 10.7426C28.4038 11.0355 28.4038 11.5104 28.6967 11.8033C28.9896 12.0962 29.4645 12.0962 29.7574 11.8033L34.5303 7.03033ZM-6.55671e-08 7.25L34 7.25L34 5.75L6.55671e-08 5.75L-6.55671e-08 7.25Z" fill="#BE111D"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
