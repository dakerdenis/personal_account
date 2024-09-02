<x-app-layout>
    <div class="section consultation-request-section">
        <div class="container">
            <div class="consultation-request-section__content">
                <div class="ww consultation-request-description">
                    {!! html_entity_decode($category->description) !!}
                </div>
                <form action="{{ route('sendConsultation') }}" id="contact-form" method="post" class="custom-form consultation-request-form">
                    <div class="custom-form__content">
                        <div class="custom-form__group">
                            <div class="custom-input-wrapper custom-form__group-item">
                                <input name="organization" type="text" class="required custom-input custom-input--type-1" placeholder="{{ __('site.organization_placeholder') }}">
                                <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                            </div>
                            <div class="custom-input-wrapper custom-form__group-item">
                                <input name="contact" type="text" class="required custom-input custom-input--type-1" placeholder="{{ __('site.contact_placeholder') }}">
                                <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                            </div>
                            <div class="custom-input-wrapper custom-form__group-item">
                                <input type="text" name="email" class="custom-input custom-input--type-1 required" placeholder="{{ __('site.email_placeholder') }}">
                                <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                            </div>
                            <div class="custom-input-wrapper custom-form__group-item">
                                <input type="text" name="phone" class="required custom-input custom-input--type-1" placeholder="{{ __('site.phone_placeholder') }}">
                                <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                            </div>
                            <div class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                <input name="region" type="text" class="required custom-input custom-input--type-1" placeholder="{{ __('site.region_placeholder') }}">
                                <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                            </div>
                            <div class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                <input name="plant_name" type="text" class="required custom-input custom-input--type-1" placeholder="{{ __('site.plant_name_placeholder') }}">
                                <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                            </div>
                            <div class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                <textarea name="description" class="required custom-input custom-input--type-1" placeholder="{{ __('site.description_placeholder') }}"></textarea>
                            </div>
                            <div class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                <label for="images" class="custom-input custom-input--type-1">
                                    <span class="custom-input__file-title">{{ __('site.upload_photo_placeholder') }}</span>
                                    <input type="file" class="custom-input__file" id="images" accept="image/*" name="image">
                                    <span class="custom-input__icons">
                        <img src="{{ asset('assets/img/file-upload-icon-03.svg') }}" alt="JPG">
                        <img src="{{ asset('assets/img/file-upload-icon-02.svg') }}" alt="JPEG">
                        <img src="{{ asset('assets/img/file-upload-icon-01.svg') }}" alt="PNG">
                      </span>
                                </label>
                                <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                                <span id="wrong_extension" class="custom-input-wrapper__error" style="display: none">{{ __('site.only_images') }}</span>
                            </div>
                            <div style="display: flex; justify-content: center" class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                <div class="g-recaptcha" data-sitekey="6LdMfi4oAAAAAAVdEwbWcUN7pWhbeNupntg5Tedl"></div>
                                <span id="wrong_captcha" class="custom-input-wrapper__error" style="display: none">{{ __('site.captcha_error') }}</span>
                            </div>
                        </div>
                        <div class="btn-group custom-form__actions consultation-request-form__actions">
                            <button id="button-send" title="Submit" class="btn btn--type-3">{{ __('site.submit') }}</button>
                        </div>
                        <div class="btn-group custom-form__actions contacts-form__actions">
                            <p style="display: none; color: green"
                               id="success-message">{{ __('site.success_sent') }}</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="https://www.google.com/recaptcha/api.js?hl={{ \Illuminate\Support\Facades\App::getLocale() }}"
                async defer>
        </script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#contact-form').on('submit', function (event) {
                event.preventDefault();
                var v = grecaptcha.getResponse();
                if (v.length == 0) {
                    $('#wrong_captcha').show();
                    return false;
                } else {
                    $('#wrong_captcha').hide();
                }
                let success = true;
                let inputs = $(this).find('.required');
                inputs.each(function () {
                    if ($(this).val() === '') {
                        $(this).addClass('invalid');
                        $(this).next().show();
                        success = false;
                    } else {
                        $(this).removeClass('invalid');
                        $(this).next().hide();
                    }
                });
                let fileInput = $(this).find('#images');
                let filePath = fileInput.val();
                let fileName = filePath.split('\\').pop(); // Extract the file name from the path
                let fileExtension = fileName.split('.').pop().toLowerCase(); // Extract the file extension

                if (fileInput.val() === '') {
                    fileInput.parent().addClass('invalid');
                    fileInput.parent().next().show();
                    success = false;
                } else {
                    fileInput.parent().removeClass('invalid');
                    fileInput.parent().next().hide();
                }

                if (fileExtension === 'jpg' || fileExtension === 'webp' || fileExtension === 'png' || fileExtension === 'jpeg') {
                    $('#wrong_extension').hide();
                } else {
                    $('#wrong_extension').show();
                    success = false;
                }

                if (!success) {
                    return;
                }
                let form = document.querySelector('#contact-form');
                let formData = new FormData(form);
                $('#button-send').attr('disabled', true);
                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(function (d) {
                    $('#button-send').attr('disabled', false);
                });

                $('#success-message').slideDown();
                form.reset();
                grecaptcha.reset();
            });
        </script>
    </x-slot>
</x-app-layout>
