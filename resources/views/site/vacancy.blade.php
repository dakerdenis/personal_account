@php use App\Models\Vacancy; @endphp
@php
    /** @var Vacancy $vacancy */
@endphp
<x-app-layout class="main-text-page main-vacancy-page">
    <section class="text-content">
        <div class="main-container">
            @if($vacancy->description)
                <section class="vacancy-section animate-on-scroll animate__animated" data-animation="fadeIn">
                    <h2>{{ __('site.vacancy_description') }}</h2>
                    <div class="wysiwyg mb-0">
                        {!! html_entity_decode($vacancy->description) !!}
                    </div>
                </section>
            @endif

            @if($vacancy->requirements)
                <section class="vacancy-section animate-on-scroll animate__animated" data-animation="fadeIn">
                    <h2>{{ __('site.vacancy_requirements') }}</h2>
                    <div class="wysiwyg mb-0">
                        {!! html_entity_decode($vacancy->requirements) !!}
                    </div>
                </section>
            @endif

            @if($vacancy->conditions)
                <section class="vacancy-section animate-on-scroll animate__animated" data-animation="fadeIn">
                    <h2>{{ __('site.vacancy_conditions') }}</h2>
                    <div class="wysiwyg mb-0">
                        {!! html_entity_decode($vacancy->conditions) !!}
                    </div>
                </section>
            @endif

            @if($vacancy->contacts)
                    <section class="vacancy-section animate-on-scroll animate__animated"  data-animation="fadeIn">
                        <h2>{{ __('site.vacancy_contacts') }}</h2>
                        <div class="wysiwyg mb-0">
                            {!! html_entity_decode($vacancy->contacts) !!}
                        </div>
                    </section>
            @endif

                @if($vacancy->files->count())
                    <div class="download-links">
                        <h2>{{ __('site.vacancy_files') }}</h2>

                        @foreach($vacancy->files as $file)
                            <a href="{{ $file->link }}" class="download-link animate-on-scroll animate__animated" target="_blank" data-animation="zoomIn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M18.0018 3.11719C18.7665 3.11719 19.3864 3.7371 19.3864 4.5018V19.159L24.5227 14.0227C25.0635 13.482 25.9401 13.482 26.4809 14.0227C27.0216 14.5635 27.0216 15.4401 26.4809 15.9809L18.9809 23.4809C18.4401 24.0216 17.5635 24.0216 17.0227 23.4809L9.52273 15.9809C8.98201 15.4401 8.98201 14.5635 9.52273 14.0227C10.0635 13.482 10.9401 13.482 11.4809 14.0227L16.6172 19.159V4.5018C16.6172 3.7371 17.2371 3.11719 18.0018 3.11719ZM4.5018 21.1172C5.26651 21.1172 5.88642 21.7371 5.88642 22.5018V28.5018C5.88642 28.9302 6.05661 29.3411 6.35955 29.6441C6.6625 29.947 7.07338 30.1172 7.5018 30.1172H28.5018C28.9302 30.1172 29.3411 29.947 29.6441 29.6441C29.947 29.3411 30.1172 28.9302 30.1172 28.5018V22.5018C30.1172 21.7371 30.7371 21.1172 31.5018 21.1172C32.2665 21.1172 32.8864 21.7371 32.8864 22.5018V28.5018C32.8864 29.6647 32.4245 30.7799 31.6022 31.6022C30.7799 32.4245 29.6647 32.8864 28.5018 32.8864H7.5018C6.33893 32.8864 5.22369 32.4245 4.40141 31.6022C3.57914 30.7799 3.11719 29.6647 3.11719 28.5018V22.5018C3.11719 21.7371 3.7371 21.1172 4.5018 21.1172Z"
                                          fill="#BE111D"/>
                                </svg>

                                <span> {{ $file->title }} </span>
                            </a>
                        @endforeach
                    </div>
                @endif
        </div>
    </section>

    <section class="gray-section form-section">
        <div class="main-container">
            <h2 class="centralized">{{ __('site.send_us_cv') }}</h2>

            <div class="form-container">
                <div id="sendCV_form_result" class="form-submit-result">
                    {{ __('site.cv_sent') }}
                </div>
                <form id="contact-form" method="post" action="{{ route('send-vacancy-form') }}">
                    <input type="hidden" name="vacancy_id" id="vacancy_id" value="{{ $vacancy->id }}">
                    <div class="form-group">
                        <label for="full_name">{{ __('site.name_lastname') }}</label>
                        <input id="full_name" name="full_name" class="required" type="text">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('site.email') }}</label>
                        <input id="email" name="email" class="" type="text">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                        <p id="wrong_email" style="display: none" class="error">{{ __('site.wrong_email') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="masked-tel-input">{{ __('site.phone') }}</label>
                        <div class="input-w-prefix phone-input-w-prefix">
                            <input id="masked-tel-input" name="phone" type="tel">
                            <span class="prefix">+994</span>
                        </div>
                        <p style="display: none" class="error">{{ __('site.wrong_phone') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('site.education') }}</label>
                        <div class="textarea-wrapper">
                            <textarea name="education" id="description"></textarea>
                        </div>
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>

                    <div class="form-group">
                        <label for="fileInputText">{{ __('site.upload_file_cv') }}</label>
                        <div class="custom-file-input-wrapper">
                            <input type="text" id="fileInputText" readonly>
                            <label for="fileInput">
                                <input name="cv" type="file" accept=".pdf,.doc,.docx" id="fileInput" onchange="updateFileInputText()">
                                <span class="addonAfter">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M4.998 9V2C4.998 1.44772 5.44572 1 5.998 1H19.0858C19.351 1 19.6054 1.10536 19.7929 1.29289L22.7071 4.20711C22.8946 4.39464 23 4.649 23 4.91421V22C23 22.5523 22.5523 23 22 23H4M18 1V5C18 5.55228 18.4477 6 19 6H23M12.2383 19V19C12.0947 19 11.966 18.9116 11.9145 18.7776L9.58974 12.7333C9.53568 12.5928 9.40062 12.5 9.25 12.5V12.5C9.09938 12.5 8.96432 12.5928 8.91026 12.7333L6.58554 18.7776C6.53401 18.9116 6.40527 19 6.26171 19V19C6.1068 19 5.97066 18.8973 5.9281 18.7484L4.08558 12.2995C4.04269 12.1494 4.1554 12 4.31151 12V12C4.42164 12 4.517 12.0765 4.54089 12.184L5.9705 18.6172C5.98774 18.6948 6.05654 18.75 6.136 18.75V18.75C6.20493 18.75 6.267 18.7083 6.29301 18.6444L8.90568 12.2315C8.96271 12.0915 9.09883 12 9.25 12V12C9.40117 12 9.53729 12.0915 9.59432 12.2315L12.207 18.6444C12.233 18.7083 12.2951 18.75 12.364 18.75V18.75C12.4435 18.75 12.5123 18.6948 12.5295 18.6172L13.9591 12.184C13.983 12.0765 14.0784 12 14.1885 12V12C14.3446 12 14.4573 12.1494 14.4144 12.2995L12.5719 18.7484C12.5293 18.8973 12.3932 19 12.2383 19Z"
                                                stroke="#BE111D" stroke-width="2"/>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M4.998 9V2C4.998 1.44772 5.44572 1 5.998 1H19.0858C19.351 1 19.6054 1.10536 19.7929 1.29289L22.7071 4.20711C22.8946 4.39464 23 4.649 23 4.91421V22C23 22.5523 22.5523 23 22 23H4M18 1V5C18 5.55228 18.4477 6 19 6H23M16.5 19V13C16.5 12.4477 16.9477 12 17.5 12H20.5M16.5 15.5H19.5M4.5 12H4C3.44772 12 3 12.4477 3 13V17.875C3 17.944 3.05596 18 3.125 18V18C3.19404 18 3.25 17.944 3.25 17.875V17C3.25 16.4477 3.69772 16 4.25 16H4.5C6.5 16 6.75 14.75 6.75 14C6.75 13.25 6.5 12 4.5 12ZM11.205 12H10.5C9.94772 12 9.5 12.4477 9.5 13V17C9.5 17.5523 9.94771 18 10.5 18H11.205C12.342 18 13.5 17.5 13.5 15C13.5 12.5 12.342 12 11.205 12Z"
                                                stroke="#BE111D" stroke-width="2"/>
                                        </svg>
                                    </span>
                            </label>
                        </div>
                        <p style="display: none" id="error-file" class="error">{{ __('site.please_fill') }}</p>
                        <p style="display: none" id="error-extension" class="error">{{ __('site.only_doc_docx_pdf') }}</p>
                    </div>

                    <div class="form-actions">
                        <div class="recaptcha">
                            <div class="g-recaptcha" data-sitekey="6LeMjs0oAAAAAIRFs5EFm2j5rWvixC9mHnJqDz7s"></div>
                            <div class="form-group">
                                <span id="wrong_captcha" class="custom-input-wrapper__error error" style="display: none; ">{{ __('site.captcha_error') }}</span>
                            </div>
                        </div>

                        <button id="button-send" class="submit" type="submit">{{ __('site.send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <x-slot name="scripts">
        <script src="https://www.google.com/recaptcha/api.js?hl={{ \Illuminate\Support\Facades\App::getLocale() }}"
                async defer>
        </script>

        <script>
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

                let fileInput = this.querySelector('#fileInput');
                let filePath = fileInput.value;
                let fileName = filePath.split('\\').pop(); // Extract the file name from the path
                let fileExtension = fileName.split('.').pop().toLowerCase(); // Extract the file extension

                if (filePath === '') {
                    fileInput.parentElement.parentElement.nextElementSibling.style.display = 'block';
                    success = false;
                } else {
                    fileInput.parentElement.parentElement.nextElementSibling.style.display = 'none';
                }

                if (fileExtension === 'doc' || fileExtension === 'docx' || fileExtension === 'pdf') {
                    document.querySelector('#error-extension').style.display = 'none';
                } else {
                    document.querySelector('#error-extension').style.display = 'block';
                    success = false;
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
