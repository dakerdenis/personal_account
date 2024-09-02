<section class="gray-section transparent form-section">
    <div class="main-container">
        <h2 class="centralized animate-on-scroll animate__animated" data-animation="fadeIn">{{ __('site.product_form_title') }}</h2>

        <div class="form-container">
            <div id="sendCV_form_result" class="form-submit-result">
                {{ __('site.product_form_success') }}
            </div>
            <form action="{{ route('submit-product-form', [$model]) }}" id="contact-form">
                <div class="form-group">
                    <label for="fullName">{{ __('site.fullName') }}</label>
                    <input id="fullName" name="fullName" class="required" type="text">
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
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
                    <label for="description">{{ __('site.message') }}</label>
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

                    <button class="submit" id="button-send" type="submit">{{ __('site.product_send') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>

<x-slot name="scripts" >
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
            document.querySelector('#sendCV_form_result').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
            form.reset();
            grecaptcha.reset();
        });
    </script>
</x-slot>
