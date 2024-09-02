<section class="gray-section transparent form-section">
    <div class="main-container">
        <h2 class="centralized animate-on-scroll animate__animated" data-animation="fadeIn">{{ __('site.complaint_form_title') }}</h2>

        <div class="form-container">
            <div id="result-complaint" class="form-submit-result">
                <p>{{ __('site.product_form_success') }}</p>
            </div>
            <form action="{{ route('submit-complaint-form') }}" method="POST" id="complaint-form">
                @csrf
                <div class="form-group">
                    <label for="firstName">{{ __('site.firstName') }}</label>
                    <input id="firstName" name="firstName" class="required" type="text">
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                </div>
                <div class="form-group">
                    <label for="secondName">{{ __('site.secondName') }}</label>
                    <input id="secondName" name="secondName" class="required" type="text">
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                </div>
                <div class="form-group">
                    <label for="surname">{{ __('site.surname') }}</label>
                    <input id="surname" name="surname" class="required" type="text">
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                </div>
                <div class="form-group">
                    <label for="personalId">{{ __('site.personalId') }}</label>
                    <input id="personalId" name="personalId" class="" type="text">
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    <p id="wrong_pin" style="display: none" class="error">{{ __('site.wrong_pin') }}</p>
                </div>
                <div class="form-group">
                    <label for="masked-tel-input">{{ __('site.phone_number') }}</label>
                    <div class="input-w-prefix phone-input-w-prefix">
                        <input id="masked-tel-input" name="phone" type="tel">
                        <span class="prefix">+994</span>
                    </div>
                    <p style="display: none" class="error">{{ __('site.wrong_phone') }}</p>
                </div>
                <div class="form-group">
                    <label for="email">{{ __('site.email') }}</label>
                    <input id="email" name="email" class="" type="text">
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    <p id="wrong_email" style="display: none" class="error">{{ __('site.wrong_email') }}</p>
                </div>

                <div class="form-group">
                    <label for="description">{{ __('site.message') }}</label>
                    <div class="textarea-wrapper">
                        <textarea name="message" id="description"></textarea>
                    </div>
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                </div>

                <div class="form-actions">
                    <div class="recaptcha">
                        <div id="mainC" class="g-recaptcha"></div>
                        <div class="form-group">
                            <span id="wrong_captcha" class="custom-input-wrapper__error error" style="display: none; ">{{ __('site.captcha_error') }}</span>
                        </div>
                    </div>

                    <button class="submit" id="button-send" type="submit">{{ __('site.complaint_send') }}<span id="loader-spinner" style="display: none" class="loader"></span></button>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="gray-section transparent form-section">
    <div class="main-container">
        <div class="form-container">
            <div class="wysiwyg animate-on-scroll animate__animated" data-animation="fadeIn">
                <p>{!! __('site.complaint_text') !!}</p>
            </div>
        </div>
    </div>
</section>

@push('extraScripts')
    <style>
        .loader {
            width: 18px;
            height: 18px;
            border: 3px solid #FFF;
            border-bottom-color: transparent;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
            margin-left: 15px;
            top: 2px;
            position: relative;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js?hl={{ \Illuminate\Support\Facades\App::getLocale() }}&onload=captchaCallback&render=explicit"
            async defer>
    </script>

    <script>
        document.querySelector('#complaint-form').addEventListener('submit', function(event) {
            event.preventDefault();
            let loaderSpinner = document.querySelector('#loader-spinner');
            var widgetId = document.getElementById('mainC').getAttribute('data-widget-id');
            var v = grecaptcha.getResponse(widgetId);
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
            let pinCodeField = document.getElementById('personalId');
            // let pinCodePattern = /^[a-zA-Z]{7}$/;
            let pinCodePattern = /^[a-zA-Z0-9]{7}$/;
            if(!pinCodePattern.test(pinCodeField.value)) {
                if(!scrolled) {
                    pinCodeField.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                    scrolled = true;
                }
                document.getElementById('wrong_pin').style.display = 'block';
                success = false;
            } else {
                document.getElementById('wrong_pin').style.display = 'none';
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
            headers.append('X-Requested-With', 'XMLHttpRequest');
            let form = document.querySelector('#complaint-form');
            let formData = new FormData(form);
            document.querySelector('#button-send').setAttribute('disabled', true);
            loaderSpinner.style.display = 'inline-block';
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: headers
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                if(data.status !== 'success') {
                    return;
                }
                document.querySelector('#button-send').removeAttribute('disabled');
                document.querySelector('#complaint-form').style.display = 'none';
                document.querySelector('#result-complaint').style.display = 'flex';
                document.querySelector('#result-complaint').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                loaderSpinner.style.display = 'none';
                form.reset();
            });
        });
    </script>
@endpush
