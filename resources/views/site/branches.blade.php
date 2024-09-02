<x-app-layout class="main-text-page main-branches-page">
    <section class="text-content">
        <div class="main-container">
            <div class="wysiwyg mb-0 animate-on-scroll animate__animated" data-animation="fadeIn">
                {!! html_entity_decode($category->description) !!}
            </div>

            <div class="map-container animate-on-scroll animate__animated" data-animation="fadeIn">
                <div id="map">

                </div>
            </div>

            <div class="branch-list">
                @foreach($branches as $branch)
                    <div class="branch-block animate-on-scroll animate__animated" data-animation="fadeIn">
                        <a class="gallery" href="{{ $branch->getFirstMediaUrl('preview') }}" data-fancybox="gallery"><img width="225" height="225"
                                                                                                                 src="{{ $branch->getFirstMediaUrl('preview', 'thumbWebp') }}" alt="{{ $branch->title }}" loading="lazy">
                            <div class="over">
                                <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 62 62" fill="none">
                                    <path
                                        d="M16.1458 11.625C14.9468 11.625 13.7969 12.1013 12.9491 12.9491C12.1013 13.7969 11.625 14.9468 11.625 16.1458V20.0208C11.625 20.5347 11.4209 21.0275 11.0575 21.3909C10.6942 21.7542 10.2014 21.9583 9.6875 21.9583C9.17364 21.9583 8.68083 21.7542 8.31748 21.3909C7.95413 21.0275 7.75 20.5347 7.75 20.0208V16.1458C7.75 13.9191 8.63456 11.7836 10.2091 10.2091C11.7836 8.63456 13.9191 7.75 16.1458 7.75H20.0208C20.5347 7.75 21.0275 7.95413 21.3909 8.31748C21.7542 8.68083 21.9583 9.17364 21.9583 9.6875C21.9583 10.2014 21.7542 10.6942 21.3909 11.0575C21.0275 11.4209 20.5347 11.625 20.0208 11.625H16.1458ZM45.8542 11.625C48.3497 11.625 50.375 13.6503 50.375 16.1458V20.0208C50.375 20.5347 50.5791 21.0275 50.9425 21.3909C51.3058 21.7542 51.7986 21.9583 52.3125 21.9583C52.8264 21.9583 53.3192 21.7542 53.6825 21.3909C54.0459 21.0275 54.25 20.5347 54.25 20.0208V16.1458C54.25 13.9191 53.3654 11.7836 51.7909 10.2091C50.2164 8.63456 48.0809 7.75 45.8542 7.75H41.9792C41.4653 7.75 40.9725 7.95413 40.6091 8.31748C40.2458 8.68083 40.0417 9.17364 40.0417 9.6875C40.0417 10.2014 40.2458 10.6942 40.6091 11.0575C40.9725 11.4209 41.4653 11.625 41.9792 11.625H45.8542ZM45.8542 50.375C47.0532 50.375 48.2031 49.8987 49.0509 49.0509C49.8987 48.2031 50.375 47.0532 50.375 45.8542V41.9792C50.375 41.4653 50.5791 40.9725 50.9425 40.6091C51.3058 40.2458 51.7986 40.0417 52.3125 40.0417C52.8264 40.0417 53.3192 40.2458 53.6825 40.6091C54.0459 40.9725 54.25 41.4653 54.25 41.9792V45.8542C54.25 48.0809 53.3654 50.2164 51.7909 51.7909C50.2164 53.3654 48.0809 54.25 45.8542 54.25H41.9792C41.4653 54.25 40.9725 54.0459 40.6091 53.6825C40.2458 53.3192 40.0417 52.8264 40.0417 52.3125C40.0417 51.7986 40.2458 51.3058 40.6091 50.9425C40.9725 50.5791 41.4653 50.375 41.9792 50.375H45.8542ZM16.1458 50.375C14.9468 50.375 13.7969 49.8987 12.9491 49.0509C12.1013 48.2031 11.625 47.0532 11.625 45.8542V41.9792C11.625 41.4653 11.4209 40.9725 11.0575 40.6091C10.6942 40.2458 10.2014 40.0417 9.6875 40.0417C9.17364 40.0417 8.68083 40.2458 8.31748 40.6091C7.95413 40.9725 7.75 41.4653 7.75 41.9792V45.8542C7.75 48.0809 8.63456 50.2164 10.2091 51.7909C11.7836 53.3654 13.9191 54.25 16.1458 54.25H20.0208C20.5347 54.25 21.0275 54.0459 21.3909 53.6825C21.7542 53.3192 21.9583 52.8264 21.9583 52.3125C21.9583 51.7986 21.7542 51.3058 21.3909 50.9425C21.0275 50.5791 20.5347 50.375 20.0208 50.375H16.1458Z"
                                        fill="white" fill-opacity="0.8" />
                                </svg>
                            </div>
                        </a>
                        <div class="branch-name">
                            <h2>{{ $branch->title }}</h2>
                        </div>
                        <div class="branch-info">
                            <div class="key-value">
                                <span class="key">{{ __('site.branch_address') }}:</span>
                                <span class="value">{!! nl2br($branch->address) !!}</span>
                            </div>
                            <div class="key-value">
                                <span class="key">{{ __('site.branch_phone') }}:</span>
                                <span class="value">
                                    @foreach(explode(',', $branch->phone) as $phone)
                                        <a href="tel:{{ \Illuminate\Support\Str::startsWith($phone, '*') ? $phone : filter_var($phone, FILTER_SANITIZE_NUMBER_INT) }}">{{ $phone }}</a>{{ $loop->last ? '' : ',' }}
                                    @endforeach
                                </span>
                            </div>
                            <div class="key-value">
                                <span class="key">{{ __('site.branch_email') }}:</span>
                                <span class="value">
                                    @foreach(explode(',', $branch->email) as $email)
                                        <a href="mailto:{{ $email }}">{{ $email }}</a>{{ $loop->last ? '' : ',' }}
                                    @endforeach
                                </span>
                            </div>
                            @if($branch->work_hours)
                                <div class="key-value">
                                    <span class="key">{{ __('site.branch_hours') }}:</span>
                                    <span class="value">{!! nl2br($branch->work_hours) !!}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <script src="https://www.google.com/recaptcha/api.js?hl={{ \Illuminate\Support\Facades\App::getLocale() }}"
                async defer>
        </script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1pqUc1_FU-zOAH0eSQtTs3nnFWTVSkH0&callback=initMap&v=weekly&language={{ \Illuminate\Support\Facades\App::getLocale()  }}"
            defer
        ></script>

        <script>
            function initMap() {
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 16,
                });

                let markerPositions = [
                    @foreach($branches as $branch)
                    {
                        position: new google.maps.LatLng({lat: {{ $branch->latitude }}, lng: {{ $branch->longitude }}}),
                        title: '{{ $branch->title }}',
                        infoWindow: new google.maps.InfoWindow({
                            content: "<span>{{ $branch->title }}</span>"
                        })
                    },
                    @endforeach
                ];

                let iconPath = '{{ asset('assets/images/pin.svg') }}'
                let latlngbounds = new google.maps.LatLngBounds();

                for (let i = 0; i < markerPositions.length; i++) {
                    const marker = new google.maps.Marker({
                        position: markerPositions[i].position,
                        icon: iconPath,
                        map: map,
                        title: markerPositions[i].title,
                    });
                    latlngbounds.extend(markerPositions[i].position);

                    google.maps.event.addListener(marker, 'click', function() {
                        if(!marker.open) {
                            markerPositions[i].infoWindow.open(map, marker);
                            marker.open = true;
                        } else {
                            markerPositions[i].infoWindow.close();
                            marker.open = false;
                        }

                        google.maps.event.addListener(map, 'click', function() {
                            markerPositions[i].infoWindow.close();
                            marker.open = false;
                        });
                    });
                }
                if(markerPositions.length > 1) {
                    map.fitBounds(latlngbounds);
                } else {
                    map.setCenter(markerPositions[0].position)
                    map.setZoom(13);
                }
            }

            window.initMap = initMap;
        </script>
    </x-slot>
</x-app-layout>
