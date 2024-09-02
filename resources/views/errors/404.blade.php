<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animations.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/fav/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/fav/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/fav/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/fav/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/fav/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>
        {{ __('site.404') }}
    </title>
</head>
<!--------->
<body>
<x-site.partials.header/>
<main class="main-text-page main-404-page">
    <div class="text-content content-404">
        <div class="main-container">
            <div class="block-404">
                <div class="code animate__animated animate__bounceIn">{{ __('site.404') }}</div>
                <h3>{{ __('site.page_not_found') }}</h3>
                <p>{!! __('site.go_to_main_page') !!}</p>
                <p>{!! __("site.go_to_sitemap") !!}</p>
            </div>
        </div>
    </div>
</main>
<x-site.partials.footer/>

<script src="{{ asset('assets/js/fancybox.umd.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
    if (document.querySelector('.gallerySwiper')) {
        const swiper = new window.Swiper('.gallerySwiper', {
            speed: 400,
            spaceBetween: 100,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
                dynamicMainBullets: 1,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '">' + (index + 1) + "</span>";
                },
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
</script>
{{$scripts ?? null}}

</body>
