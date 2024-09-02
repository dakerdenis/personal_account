<x-app-layout>
    <x-slot name="styles">
        <link rel="stylesheet" href="{{asset('assets/includes/page_login.css')}}">
        <link rel="stylesheet" href="{{asset('assets/includes/change_password.css')}}">
        <link rel="stylesheet" href="{{asset('assets/includes/fill_pass.css')}}">
    </x-slot>

    <div class="change__password_wrapperr">
        <div class="change__password__text">
            {{__('site.forgot_password_title')}}
        </div>
        <div class="change__password__content">
            <!---Описание элемента-->
            <div class="change__password__container">
                <div class="change__password__desc">
                    <div class="change__password_desc_text">
                        {{ __('site.reset_link_set_to_your_email') }}
                        <br> <span>
                        {{ __('site.reset_password_sent_text') }}
                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
