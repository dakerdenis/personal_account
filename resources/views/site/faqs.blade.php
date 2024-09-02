@php
    \Illuminate\Support\Facades\View::share('topDescription', $category->description);
@endphp
<x-app-layout class="main-text-page main-management-page">

    <div class="text-content">
        <div class="main-container">


            <section class="text-content faq-section">
                <div class="main-container">

                    <div class="collapse-container">
                        @foreach($faqs as $faq)
                            <div class="collapse-item">
                                <button class="collapse-button">
                                    <span class="question animate-on-scroll animate__animated" data-animation="fadeInDown">{{ nl2br($faq->title) }}</span>
                                    <span class="toggle-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                                    <rect width="50" height="50" rx="25" fill="black" fill-opacity="0.05"/>
                                    <path d="M18 23L24.2929 29.2929C24.6834 29.6834 25.3166 29.6834 25.7071 29.2929L32 23" stroke="#242323" stroke-width="2"
                                          stroke-linecap="round"/>
                                  </svg>
                            </span>
                                </button>
                                <div class="collapse-content">
                                    <div class="collapse-content-wrapper">
                                        <div class="wysiwyg mb-0">
                                            <p>{!! nl2br($faq->description) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
