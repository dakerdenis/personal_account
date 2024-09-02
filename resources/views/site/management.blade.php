@php
    \Illuminate\Support\Facades\View::share('topDescription', $category->description);
@endphp
<x-app-layout class="main-text-page main-management-page">

    <div class="text-content">
        <div class="main-container">

            <div class="wysiwyg">
                {!! html_entity_decode($category->description) !!}
            </div>

            <div class="management-grid animate__animated animate__fadeIn">
                @foreach($managers as $manager)
                    <span class="lazy-block management-block animate-on-scroll animate__animated" data-animation="fadeIn">
                        <span class="image-container">
                            <img @if($loop->iteration > 4) class="image lazy"  @endif width="370" height="500" src="{{ $manager->getFirstMediaUrl('preview', 'thumb') }}"
                                 data-src="{{ $manager->getFirstMediaUrl('preview', 'webp') }}" alt="{{ $manager->title }} - {{ $manager->position }}" @if($loop->iteration > 4) loading="lazy"@endif>
                            <!-- <span class="over">
                                <span>Daha ətraflı</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="58" height="16" viewBox="0 0 58 16" fill="none">
                                    <path
                                        d="M57.7071 8.70711C58.0976 8.31659 58.0976 7.68342 57.7071 7.2929L51.3431 0.928937C50.9526 0.538412 50.3195 0.538412 49.9289 0.928937C49.5384 1.31946 49.5384 1.95263 49.9289 2.34315L55.5858 8L49.9289 13.6569C49.5384 14.0474 49.5384 14.6805 49.9289 15.0711C50.3195 15.4616 50.9526 15.4616 51.3431 15.0711L57.7071 8.70711ZM-8.74228e-08 9L57 9L57 7L8.74228e-08 7L-8.74228e-08 9Z"
                                        fill="white" />
                                </svg>
                            </span> -->
                        </span>
                        <span class="info-container">
                            <span class="name-position">
                                <span class="name">{{ $manager->title }}</span>
                                <span class="position">{!! nl2br($manager->position) !!}</span>
                            </span>
                            <span class="contacts">
                                <span class="contact"><span>{{ __('site.manager_email') }}:</span> <a href="mailto:{{ $manager->email }}">{{ $manager->email }}</a></span>
                                <span class="contact"><span>{{ __('site.manager_phone') }}:</span> <a href="tel:{{ filter_var($manager->phone, FILTER_SANITIZE_NUMBER_INT) }}">{{ $manager->phone }}</a></span>
                            </span>
                        </span>
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
