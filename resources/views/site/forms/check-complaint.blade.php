<section class="gray-section transparent form-section">
    <div class="main-container">
        <h2 id="checkComplaint" class="centralized animate-on-scroll animate__animated" data-animation="fadeIn">{{ __('site.complaint_form_title_2') }}</h2>

        <div class="form-container">
            <div id="result-complaint-check" style="display: block" class="form-submit-result main-products-page">
                <div class="product-category-description">
                    <div class="wysiwyg" id="result-complaint-check-data">
                    </div>
                </div>
            </div>
            <div id="sendCV_form_result" class="form-submit-result">
                {{ __('site.product_form_success') }}
            </div>
            <form action="{{ route('check-complaint-form') }}" id="check-form">
                <div class="form-group">
                    <label for="personalIdChekc">{{ __('site.personalId') }}</label>
                    <input id="personalIdChekc" name="personalId" class="" type="text">
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    <p id="wrong_pin" style="display: none" class="error">{{ __('site.wrong_pin') }}</p>
                </div>
                <div class="form-group">
                    <label for="complaint">{{ __('site.complaintNumber') }}</label>
                    <input id="complaint" name="complaintId" class="required" type="text">
                    <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                </div>

                <div class="form-actions">
                    <div class="recaptcha">
                        <div id="secondC" class="g-recaptcha"></div>
                        <div class="form-group">
                            <span id="wrong_captcha2" class="custom-input-wrapper__error error" style="display: none; ">{{ __('site.captcha_error') }}</span>
                        </div>
                    </div>

                    <button class="submit" id="button-send" type="submit">{{ __('site.complaint_send') }}<span id="loader-spinner2" style="display: none" class="loader"></span></button>
                </div>
            </form>
        </div>
    </div>
</section>

<x-slot name="scripts">
    <script>
        function captchaCallback() {
            var captchaElements = document.querySelectorAll('.g-recaptcha');

            captchaElements.forEach(function(el) {
                var widgetId = grecaptcha.render(el, {'sitekey' : '6LeMjs0oAAAAAIRFs5EFm2j5rWvixC9mHnJqDz7s'});
                el.setAttribute('data-widget-id', widgetId);
            });
        }

        document.querySelector('#check-form').addEventListener('submit', function(event) {
            event.preventDefault();
            let loaderSpinner2 = document.querySelector('#loader-spinner2');
            var widgetId = document.getElementById('secondC').getAttribute('data-widget-id');
            var v = grecaptcha.getResponse(widgetId);
            if (v.length == 0) {
                document.querySelector('#wrong_captcha2').style.display = 'block';
                return false;
            } else {
                document.querySelector('#wrong_captcha2').style.display = 'none';
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
            let pinCodeField = document.getElementById('personalIdChekc');
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
            if (!success) {
                return;
            }
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let headers = new Headers();
            headers.append('X-CSRF-TOKEN', csrfToken);
            headers.append('X-Requested-With', 'XMLHttpRequest');
            let form = document.querySelector('#check-form');
            let formData = new FormData(form);
            document.querySelector('#button-send').setAttribute('disabled', true);
            loaderSpinner2.style.display = 'inline-block';
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: headers
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                document.querySelector('#button-send').removeAttribute('disabled');
                document.querySelector('#check-form').style.display = 'none';
                document.querySelector('#result-complaint-check').style.display = 'flex';
                document.querySelector('#result-complaint-check').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                document.querySelector('#result-complaint-check-data').innerHTML = data.data;
                form.reset();
                grecaptcha.reset();
            }).catch(function(error) {
                console.log(error);
            });
        });
    </script>
</x-slot>
