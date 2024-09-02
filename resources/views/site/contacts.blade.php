 @php use App\Models\Contact;use App\View\Components\Site\PageTitleBreadcrumbs; @endphp
<x-app-layout class="main-text-page main-contact-page">
    @php
        /** @var Contact $contacts */
        app()->make(PageTitleBreadcrumbs::class)->preRender();
        \Illuminate\Support\Facades\View::share('page_title', $contacts->title);
    @endphp

    <section class="text-content">
        <div class="main-container">
            <div class="wysiwyg mb-0 animate-on-scroll animate__animated" data-animation="fadeIn">
                <h2>{{ $contacts->sub_title }}</h2>
                {!! $contacts->description !!}
            </div>

            <div class="map-container animate-on-scroll animate__animated" data-animation="fadeIn">
                <div id="map"></div>
            </div>

            <div class="branch-info">
                <div class="key-value">
                    <span class="key">{{ __('site.contacts_address') }}:</span>
                    <span class="value">{!! nl2br($contacts->address) !!}</span>
                </div>
                <div class="key-value">
                    <span class="key">{{ __('site.contacts_phone') }}:</span>
                    <span class="value">
                        @if($contacts->short_number)
                            <a href="tel:{{ $contacts->short_number }}">{{ $contacts->short_number }}</a>,
                        @endif
                        @foreach(explode(',', $contacts->phones) as $phone)
                            <a href="tel:{{ filter_var($phone, FILTER_SANITIZE_NUMBER_INT) }}">{{ $phone }}</a>{{ $loop->last ? '' : ',' }}
                        @endforeach
                    </span>
                </div>
                <div class="key-value">
                    <span class="key">{{ __('site.contacts_email') }}:</span>
                    <span class="value">
                        @foreach(explode(',', $contacts->email) as $email)
                            <a href="mailto:{{ $email }}">{{ $email }}</a>{{ $loop->last ? '' : ',' }}
                        @endforeach
                    </span>
                </div>
                <div class="key-value">
                    <span class="key">{{ __('site.contacts_work_hours') }}:</span>
                    <span class="value">{!! nl2br($contacts->working_hours) !!}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="gray-section form-section">
        <div class="main-container">
            <h2 class="centralized">{{ __('site.contact_form') }}</h2>

            <div class="form-container">
                <div id="sendCV_form_result" class="form-submit-result">
                    {{ __('site.contacts_sent') }}
                </div>
                <form action="{{ route('send-contact-form') }}" id="contact-form">
                    <div class="form-group">
                        <label for="fullname">{{ __('site.contacts_full_name') }}</label>
                        <input name="fullName" id="fullname" class="required" type="text">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="company">{{ __('site.contacts_company') }}</label>
                        <input name="company" id="company" class="" type="text">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('site.contacts_email_form') }}</label>
                        <input name="email" class="" id="email" type="text">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                        <p id="wrong_email" style="display: none" class="error">{{ __('site.wrong_email') }}</p>
                    </div>


                    <div class="form-group">
                        <label for="masked-tel-input">{{ __('site.contacts_phone_form') }}</label>
                        <div class="input-w-prefix phone-input-w-prefix">
                            <input id="masked-tel-input" name="phone" type="tel">
                            <span class="prefix">+994</span>
                        </div>
                        <p style="display: none" class="error">{{ __('site.wrong_phone') }}</p>
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label for="branch">{{ __('site.contacts_department') }}</label>--}}
{{--                        <select name="department_id" class="required" id="branch">--}}
{{--                            <option value="" disabled selected>{{ __('site.select_department') }}</option>--}}
{{--                            @foreach($departments as $department)--}}
{{--                                <option value="{{ $department->id }}">{{ $department->title }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>--}}
{{--                    </div>--}}

                    <div class="form-group">
                        <label for="description">{{ __('site.contacts_text_message') }}</label>
                        <div class="textarea-wrapper">
                            <textarea name="message" id="description"></textarea>
                        </div>
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>

                    <div class="form-actions">
                        <div class="recaptcha">
                            <div class="g-recaptcha" data-sitekey="6LeMjs0oAAAAAIRFs5EFm2j5rWvixC9mHnJqDz7s"></div>
                            <div class="form-group">
                                <span id="wrong_captcha" class="custom-input-wrapper__error error" style="display: none; ">{{ __('site.captcha_error') }}</span>
                            </div>
                        </div>

                        <button class="submit" id="button-send" type="submit">{{ __('site.contacts_send') }}</button>
                    </div>
                </form>
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
                    center: { lat: {{ $contacts->latitude }}, lng: {{ $contacts->longitude }} },
                });

                let iconPath = '{{ asset('assets/images/pin.svg') }}'

                let marker = new google.maps.Marker({
                    position: new google.maps.LatLng({{ $contacts->latitude }}, {{ $contacts->longitude }}),
                    map: map,
                    icon: iconPath
                });

            }

            window.initMap = initMap;
            
            document.querySelector('#contact-form').addEventListener('submit', function(event) {
                event.preventDefault();
                var v = grecaptcha.getResponse();
                if (v.length == 0) {
                    document.querySelector('#wrong_captcha').style.display = 'block';
                    return false;
                } else {
                    document.querySelector('#wrong_captcha').style.display = 'none';
                }
                let success = true;
                let inputs = this.querySelectorAll('.required');
                let scrolled = false;
                inputs.forEach(function(input) {
                    if (input.value === '') {
                        if(!scrolled) {
                            input.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                            scrolled = true;
                        }
                        input.nextElementSibling.style.display = 'block';
                        success = false;
                    } else {
                        input.nextElementSibling.style.display = 'none';
                    }
                });
                let textArea = document.getElementById('description');
                if(! textArea.value) {
                    if(!scrolled) {
                        textArea.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                        scrolled = true;
                    }
                    textArea.parentElement.nextElementSibling.style.display = 'block';
                    success = false;
                } else {
                    textArea.parentElement.nextElementSibling.style.display = 'none';
                }
                let emailField = document.getElementById('email');
                let emailPattern = /^[a-z0-9._%+-]{2,}@([a-z0-9.-]{2,}\.)+[a-z]{2,}$/i;
                if(!emailPattern.test(emailField.value)) {
                    if(!scrolled) {
                        emailField.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                        scrolled = true;
                    }
                    document.getElementById('wrong_email').style.display = 'block';
                    success = false;
                } else {
                    document.getElementById('wrong_email').style.display = 'none';
                }
                let phoneField = document.getElementById('masked-tel-input');
                let digits = phoneField.value.match(/\d/g); // match all digits in the string

                if (digits && digits.length >= 7 && digits.length <= 9) {
                    phoneField.parentElement.nextElementSibling.style.display = 'none';
                } else {
                    if(!scrolled) {
                        phoneField.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                        scrolled = true;
                    }
                    phoneField.parentElement.nextElementSibling.style.display = 'block';
                    success = false;
                }
                if (!success) {
                    return;
                }
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let headers = new Headers();
                headers.append('X-CSRF-TOKEN', csrfToken);
                let form = document.querySelector('#contact-form');
                let formData = new FormData(form);
                document.querySelector('#button-send').setAttribute('disabled', true);
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: headers
                }).then(function(response) {
                    document.querySelector('#button-send').removeAttribute('disabled');
                });
                document.querySelector('#contact-form').style.display = 'none';
                document.querySelector('#sendCV_form_result').style.display = 'flex';
                form.reset();
                grecaptcha.reset();
            });

        </script>
    </x-slot>

</x-app-layout>
