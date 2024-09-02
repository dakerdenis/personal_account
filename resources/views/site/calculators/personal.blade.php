<section class="text-content form-section calculating-section">
    <picture class="p-abs-inset-0">
        <img class="img-in-picture" src="{{ asset('assets/images/cascocalc.jpeg') }}" width="1666" height="2499" alt="" loading="lazy">
    </picture>
    <div class="main-container">
        <h2 class="centralized animate-on-scroll animate__animated" data-animation="fadeIn">{{ $data['title'] }}</h2>

        <div class="form-container">
            <div id="successCreateOrder" style="display: none"  class="form-submit-result">
                {{ __('ozal.success_created_order') }}
            </div>
            <form action="{{ route('personal-insurance-calculate') }}" id="casco-form">
                <div class="form-group horizontal">
                    <label for="ts-price">{{ __('ozal.fullName') }}</label>
                    <div class="field">
                        <input name="fullname" class="required-casco" id="ts-price" type="text" placeholder="{{ __('ozal.fullName_placeholder') }}">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="ts-price">{{ __('ozal.birthday') }}</label>
                    <div class="field">
                        <input name="birthDay" class="required-casco" id="ts-price" type="date">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal radio-inputs flexStart">
                    <label>{{ __('ozal.gender') }}</label>
                    <div class="field">
                        <div class="horizontal-radio-checkbox-inputs">
                                <label class="custom-radio-input" for="radio-yes1">
                                    <input id="radio-yes1" type="radio" name="sexId" value="1" checked>
                                    <span class="radio-checkbox-btn radio-btn"><span></span></span>
                                    {{ __('ozal.gender_m') }}
                                </label>
                                <label class="custom-radio-input" for="radio-yes2">
                                    <input id="radio-yes2" type="radio" name="sexId" value="2">
                                    <span class="radio-checkbox-btn radio-btn"><span></span></span>
                                    {{ __('ozal.gender_f') }}
                                </label>
                        </div>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="weight">{{ __('ozal.weight') }}</label>
                    <div class="field">
                        <input name="weight" class="required-casco" id="weight" type="text" placeholder="{{ __('ozal.weight_placeholder') }}">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="height">{{ __('ozal.height') }}</label>
                    <div class="field">
                        <input name="height" class="required-casco" id="height" type="text" placeholder="{{ __('ozal.height_placeholder') }}">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="ts-price">{{ __('ozal.phone') }}</label>
                    <div class="field">
                        <input name="phoneNumber" class="required-casco" id="ts-price" type="text" placeholder="{{ __('ozal.phone_placeholder') }}">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="pinCode">{{ __('ozal.pinCode') }}</label>
                    <div class="field">
                        <input name="pinCode" class="required-casco" id="pinCode" type="text" placeholder="{{ __('ozal.pinCode_placeholder') }}">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                        <p id="wrong_pin" style="display: none" class="error">{{ __('site.wrong_pin') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="email">{{ __('ozal.email') }}</label>
                    <div class="field">
                        <input name="email" class="" id="email" type="text" placeholder="{{ __('ozal.email_placeholder') }}">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                        <p id="wrong_email" style="display: none" class="error">{{ __('site.wrong_email') }}</p>
                    </div>
                </div>
                @php
                    $questions = ['haveExaminedInLast2Years', 'areHospitalized', 'haveTreatmentOrMedication', 'haveDiseasesOfTheEsophagusAndGastrointestinalTract', 'haveAsthmaAllergiesLungDiseases',
                    'haveDiseasesOfTheKidneysOrUrinarySystem', 'haveCongenitalAndInheritedDiseases', 'haveHeadachesDizzinessAndMigraines', 'haveBloodPressure', 'haveRheumatism',
                    'havevaricoseVeinsAndOtherVascularDiseases', 'haveRhythmConductionDisturbancesAndHeartDisease', 'haveMentalIllnessNervousDisorderEpilepsy', 'haveTraumasInjuriesDefects',
                    'haveProblemsWithLumbarRegionAndSpine', 'haveDiseasesOfTheLiverSpleenPancreas', 'haveBloodDiseases', 'haveDiabetes', 'haveOtherEndocrineDiseases',
                    'havebenignOrMalignantTumors', 'haveAnyHealthProblemsOtherThanAbove', 'haveInsuredWithAnotherInsuranceCompany'];
                @endphp
                @foreach($questions as $question)
                    <div class="form-group horizontal radio-inputs flexStart">
                        <label>{{ __('ozal.' . $question) }}</label>
                        <div class="field">
                            <div class="horizontal-radio-checkbox-inputs">
                                <label class="custom-radio-input" for="{{ $question }}1">
                                    <input id="{{ $question }}1" type="radio" name="{{ $question }}" value="1">
                                    <span class="radio-checkbox-btn radio-btn"><span></span></span>
                                    {{ __('ozal.yes') }}
                                </label>
                                <label class="custom-radio-input" for="{{ $question }}2">
                                    <input id="{{ $question }}2" type="radio" name="{{ $question }}" value="0" checked>
                                    <span class="radio-checkbox-btn radio-btn"><span></span></span>
                                    {{ __('ozal.no') }}
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div id="casco-price-wrapper" class="form-group horizontal">
                    <label>{{ __('casco.price') }}</label>
                    <div class="field casco-calc-price-field">
                        <div id="price-holder" class="price">0.00 AZN</div>
                        <div class="description">{{ __('ozal.ozal_price_description') }}</div>
                        <p style="display: none" class="error" id="price-error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-actions calculating-form-actions">
                    <button class="submit" id="casco-calc" type="button">{{ __('ozal.calculate') }}<span id="loader-spinner" style="display: none" class="loader"></span></button>
                    <button id="casco-send" class="submit gray" disabled type="button">{{ __('ozal.send') }}<span id="loader-spinner-send" style="display: none" class="loader"></span></button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('extraScripts')
    <script>
        function calculateAndSendCasco(sendCasco = false) {
            let success = true;
            let inputs = document.querySelectorAll('.required-casco');
            if (sendCasco) {
                let formInputs = document.querySelectorAll('.required-casco-send');
                inputs = [...inputs, ...formInputs];
            }
            let scrolled = false;
            let loaderSpinner = document.querySelector('#loader-spinner');
            let loaderSpinnerSend = document.querySelector('#loader-spinner-send');
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

            if (sendCasco) {
                let requiredFiles = document.querySelectorAll('.required-file');
                requiredFiles.forEach(function(file) {
                    if (file.files.length === 0) {
                        if(!scrolled) {
                            file.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                            scrolled = true;
                        }
                        file.nextElementSibling.nextElementSibling.nextElementSibling.style.display = 'block';
                        file.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML = '{{ __('site.please_fill') }}';
                        success = false;
                    } else {
                        file.nextElementSibling.nextElementSibling.nextElementSibling.style.display = 'none';
                    }
                });

                let emailField = document.getElementById('calc-email');
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

                let pinCodeField = document.getElementById('pinCode');
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
            }


            if (!success) {
                return;
            }
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let headers = new Headers();
            headers.append('X-CSRF-TOKEN', csrfToken);
            headers.append('X-Requested-With', 'XMLHttpRequest');
            let form = document.querySelector('#casco-form');
            let formData = new FormData(form);
            document.querySelector('#casco-calc').setAttribute('disabled', true);
            if(sendCasco) {
                loaderSpinnerSend.style.display = 'inline-block';
                fetch('{{ route('personal-insurance-send') }}', {
                    method: 'POST',
                    body: formData,
                    headers: headers
                }).then(function(response) {
                    return response.json();
                }).then(function(data){
                    if(data.error !== null) {
                        document.querySelector('#price-error').style.display = 'block';
                        document.querySelector('#price-error').innerHTML = data.error;
                        document.getElementById('price-error').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                        return;
                    }

                    form.style.display = 'none';
                    form.reset();
                    document.getElementById('successCreateOrder').style.display = 'block';
                    document.getElementById('successCreateOrder').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});

                });
            } else {
                loaderSpinner.style.display = 'inline-block';
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: headers
                }).then(function(response) {
                    return response.json();
                }).then(function(data){
                    console.log(data);
                    document.querySelector('#casco-calc').removeAttribute('disabled');
                    loaderSpinner.style.display = 'none';
                    if(data.error !== null) {
                        document.querySelector('#price-holder').innerHTML = '0.00 AZN';
                        document.querySelector('#price-error').style.display = 'block';
                        document.querySelector('#price-error').innerHTML = data.error;
                        document.querySelector('#casco-send').setAttribute('disabled', true);
                        document.querySelector('#casco-send').classList.add('gray');
                        document.getElementById('price-error').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                        return;
                    }
                    document.querySelector('#price-error').style.display = 'none';
                    document.querySelector('#price-holder').innerHTML = data.price + ' AZN';
                    document.querySelector('#casco-send').removeAttribute('disabled');
                    document.querySelector('#casco-send').classList.remove('gray');
                    document.getElementById('casco-price-wrapper').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});

                });
            }
        }
        document.querySelector('#casco-calc').addEventListener('click', function(event) {
            event.preventDefault();
            calculateAndSendCasco();
        });
        document.querySelector('#casco-send').addEventListener('click', function(event) {
            event.preventDefault();
            calculateAndSendCasco(true);
        });
    </script>
@endpush
