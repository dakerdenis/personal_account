<div class="section vacancy-request-section">
    <div class="container">
        <div class="vacancy-request-section__content">
            <div class="vacancy-request-section__left">
                <div class="section-top section-top--type-1 vacancy-request-section__section-top">
                    <h2 class="section-title section-title--type-2 vacancy-request-section__section-title">
                        <span class="section-title__text">{{ __('site.send_cv_to_us') }}</span>
                    </h2>
                    {{--                    <div class="section-description section-description--type-2">--}}
                    {{--                        <p>{{ __('site.cv_description') }}</p>--}}
                    {{--                    </div>--}}
                </div>
                <div class="vacancy-request">
                    <form enctype="multipart/form-data" id="contact-form" class="custom-form vacancy-request-form">
                        <div class="custom-form__content">
                            <div class="custom-form__group">
                                <div
                                    class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                    <input name="full_name" type="text"
                                           class="custom-input custom-input--type-1 required"
                                           placeholder="{{ __('site.full_name') }}">
                                    <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                                </div>
                                <div
                                    class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                    <input type="text" name="email" class="custom-input custom-input--type-1 required"
                                           placeholder="{{ __('site.email') }}">
                                    <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                                </div>
                                <div
                                    class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                    <input type="text" name="phone" class="custom-input custom-input--type-1 required"
                                           placeholder="{{ __('site.phone_number') }}">
                                    <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                                </div>
                                <div
                                    class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                    <textarea name="education" class="custom-input custom-input--type-1 required"
                                              placeholder="{{ __('site.education') }}"></textarea>
                                    <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                                </div>
                                <div
                                    class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                    <textarea name="experience" class="custom-input custom-input--type-1 required"
                                              placeholder="{{ __('site.work_experience') }}"></textarea>
                                    <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                                </div>
                                <div
                                    class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                    <label for="cv-docs" class="custom-input custom-input--type-1">
                                        <span class="custom-input__file-title">{{ __('site.cv_file') }}</span>
                                        <input accept=".pdf, .doc, .docx" name="cv" type="file" class="custom-input__file" id="cv-docs">
                                        <span class="custom-input__icons">
                          <img src="{{ asset('assets/img/file-upload-icon-04.svg') }}" alt="Word">
                          <img src="{{ asset('assets/img/file-upload-icon-05.svg') }}" alt="PDF">
                        </span>
                                    </label>
                                    <span class="custom-input-wrapper__error" style="display: none">{{ __('site.input_required') }}</span>
                                    <span id="wrong_extension" class="custom-input-wrapper__error" style="display: none">{{ __('site.only_doc_docx_pdf') }}</span>
                                </div>
                                <div style="display: flex; justify-content: center" class="custom-input-wrapper custom-form__group-item custom-form__group-item--full-width">
                                    <div class="g-recaptcha" data-sitekey="6LdMfi4oAAAAAAVdEwbWcUN7pWhbeNupntg5Tedl"></div>
                                    <span id="wrong_captcha" class="custom-input-wrapper__error" style="display: none">{{ __('site.captcha_error') }}</span>
                                </div>
                            </div>
                            <div class="btn-group custom-form__actions contacts-form__actions">
                                <button id="button-send" title="{{ __('site.send') }}"
                                        class="btn btn--type-3">{{ __('site.send') }}</button>
                            </div>
                            <div class="btn-group custom-form__actions contacts-form__actions">
                                <p style="display: none; color: green"
                                   id="success-message">{{ __('site.success_sent') }}</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="vacancy-request-section__right">
                <picture class="vacancy-request__section-pic">
                    <source srcset="{{ asset('assets/img/yarpaq-at-tam.webp') }}" type="image/webp">
                    <source srcset="{{ asset('assets/img/yarpaq-at-tam.png') }}" type="image/png">
                    <img src="{{ asset('assets/img/yarpaq-at-tam.png') }}" width="593" height="840" alt="Horse"
                         class="vacancy-request__section-image">
                </picture>
            </div>
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
            let fileInput = $(this).find('#cv-docs');
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

            if (fileExtension === 'doc' || fileExtension === 'docx' || fileExtension === 'pdf') {
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
