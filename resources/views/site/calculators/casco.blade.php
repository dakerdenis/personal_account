<section class="text-content form-section calculating-section">
    <picture class="p-abs-inset-0">
        <img class="img-in-picture" src="{{ asset('assets/images/cascocalc.webp') }}" width="1666" height="2499" alt="{{ $data['title'] }}" loading="lazy">
    </picture>
    <div class="main-container">
        <h2 id="cascoCalculate" class="centralized animate-on-scroll animate__animated" data-animation="fadeIn">{{ $data['title'] }}</h2>

        <div class="form-container">
            <div id="successCreateOrder" style="display: none"  class="form-submit-result">
                {{ __('casco.success_created_order') }}
            </div>
            <form action="{{ route('casco-calculate') }}" enctype="multipart/form-data" id="casco-form">
                <div class="form-group horizontal">
                    <label for="ts-category">{{ __('casco.car_brand') }}</label>
                    <div class="field">
                        <select class="required-casco" name="brand" id="ts-category">
                            <option value="" disabled selected>{{ __('casco.select_brand') }}</option>
                            @foreach($data['brands'] ?? [] as $brand)
                                <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                            @endforeach
                        </select>
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="ts">{{ __('casco.car_year') }}</label>
                    <div class="field">
                        <select name="productionYear" class="required-casco" id="ts">
                            <option value="" disabled selected>{{ __('casco.select_year') }}</option>
                            @foreach($data['years'] ?? [] as $brand)
                                <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                            @endforeach
                        </select>
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="ts-price">{{ __('casco.car_price') }}</label>
                    <div class="field">
                        <input name="marketPrice" class="required-casco" id="ts-price" type="text" placeholder="{{ __('casco.car_price_placeholder') }}">
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                        <p style="display: none" id="amount-error" class="error">{{ __('casco.amount_error') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal radio-inputs flexStart">
                    <label>{{ __('casco.repair_shop_type') }}</label>
                    <div class="field">
                        <div class="horizontal-radio-checkbox-inputs">
                            @foreach($data['shops'] ?? [] as $shop)
                                <label class="custom-radio-input" for="radio-yes{{ $shop['id'] }}">
                                    <input id="radio-yes{{ $shop['id'] }}" type="radio" name="repairShop" value="{{ $shop['id'] }}" {{ $loop->first ? 'checked' : '' }}>
                                    <span class="radio-checkbox-btn radio-btn"><span></span></span>
                                    {{ __('casco.' . \Illuminate\Support\Str::slug($shop['name'])) }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="franchises">{{ __('casco.franchise') }}</label>
                    <div class="field">
                        <select name="franchise" class="required-casco" id="franchises">
                            <option value="" disabled selected>{{ __('casco.select_franchise') }}</option>
                            @foreach($data['franchises'] ?? [] as $franchise)
                                @continue($franchise['name'] == '0')
                                <option value="{{ $franchise['id'] }}">{{ $franchise['name'] }}</option>
                            @endforeach
                        </select>
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
                <div class="form-group horizontal">
                    <label for="drivers">{{ __('casco.driver') }}</label>
                    <div class="field">
                        <select name="driver" class="required-casco" id="drivers">
                            <option value="" disabled selected>{{ __('casco.select_driver') }}</option>
                            @foreach($data['drivers'] ?? [] as $driver)
                                <option value="{{ $driver['id'] }}">{{ $driver['name'] }}</option>
                            @endforeach
                        </select>
                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                    </div>
                </div>
{{--                <div class="form-group horizontal">--}}
{{--                    <label for="installment">{{ __('casco.installment') }}</label>--}}
{{--                    <div class="field">--}}
{{--                        <select name="installment" class="required-casco"  id="installment">--}}
{{--                            <option value="" disabled selected>{{ __('casco.select_installment') }}</option>--}}
{{--                            @foreach($data['installments'] ?? [] as $installment)--}}
{{--                                <option value="{{ $installment['id'] }}">{{ $installment['name'] }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="form-group horizontal">--}}
{{--                    <label for="bonus">{{ __('casco.bonus') }}</label>--}}
{{--                    <div class="field">--}}
{{--                        <select name="bonus" class="required-casco" id="bonus">--}}
{{--                            <option value="" disabled selected>{{ __('casco.select_bonus') }}</option>--}}
{{--                            @foreach($data['bonuses'] ?? [] as $bonus)--}}
{{--                                <option value="{{ $bonus['id'] }}">{{ $bonus['name'] }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <p style="display: none" class="error">{{ __('site.please_fill') }}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div id="casco-price-wrapper" class="form-group horizontal">
                    <label>{{ __('casco.price') }}</label>
                    <div class="field casco-calc-price-field">
                        <div id="price-holder" class="price">0.00 AZN</div>
                        <div class="description">{{ __('casco.casco_price_description') }}</div>
                        <p style="display: none" class="error" id="price-error">{{ __('casco.please_fill') }}</p>
                    </div>
                </div>

                <div id="orderFields" style="display: none">
                    <div class="form-group horizontal">
                        <label for="calc-fullname">{{ __('casco.full_name') }}</label>
                        <div class="field">
                            <input id="calc-fullname" name="fullname" class="required-casco-send" type="text" placeholder="{{ __('casco.full_name_placeholder') }}">
                            <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label for="calc-contact">{{ __('casco.phone_number') }}</label>
                        <div class="field">
                            <input name="phoneNumber" class="required-casco-send"  id="calc-contact" type="tel" placeholder="{{ __('casco.phone_number_placeholder') }}">
                            <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label for="calc-email">{{ __('casco.email') }}</label>
                        <div class="field">
                            <input id="calc-email" class=""  name="email" type="text" placeholder="{{ __('casco.email_placeholder') }}">
                            <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                            <p id="wrong_email" style="display: none" class="error">{{ __('site.wrong_email') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label for="calc-pin">{{ __('casco.pin_code') }}</label>
                        <div class="field">
                            <input id="calc-pin" class="required-casco-send"  name="pinCode" type="text" placeholder="{{ __('casco.pin_code_placeholder') }}">
                            <p style="display: none" class="error">{{ __('site.please_fill') }}</p>
                            <p id="wrong_pin" style="display: none" class="error">{{ __('site.wrong_pin') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label>{{ __('casco.idCardFront') }}</label>
                        <div class="field casco-calc-upload-field">
                            <input type="file" id="calc-label-1-file" class="required-file" name="idCardFront" onchange="updateCascoCalcFileInputText(1)">
                            <div id="casco-calc-uploaded-file-1"  class="uploaded-file">
                                <div class="file-name" id="calc-label-1-text"></div>
                                <div class="remove" onclick="removeCascoCalcFileInput(1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.46434 2.46144C2.71919 2.20659 3.13238 2.20659 3.38722 2.46144L13.5389 12.6131C13.7938 12.868 13.7938 13.2812 13.5389 13.536C13.2841 13.7909 12.8709 13.7909 12.616 13.536L2.46434 3.38432C2.20949 3.12948 2.20949 2.71629 2.46434 2.46144Z" fill="#242323"/>
                                        <path d="M2.46535 13.5396C2.2105 13.2847 2.2105 12.8715 2.46535 12.6167L12.617 2.46499C12.8719 2.21014 13.2851 2.21014 13.5399 2.46499C13.7948 2.71984 13.7948 3.13302 13.5399 3.38787L3.38823 13.5396C3.13338 13.7944 2.72019 13.7944 2.46535 13.5396Z" fill="#242323"/>
                                    </svg>
                                </div>
                            </div>
                            <button class="primary-outline" type="button" id="calc-label-1-btn" onclick="triggerCascoCalcFileInput(1)">{{ __('casco.upload') }}</button>
                            <p style="display: none" class="error" id="calc-label-1-error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label>{{ __('casco.idCardBack') }}</label>
                        <div class="field casco-calc-upload-field">
                            <input type="file" name="idCardBack" class="required-file" id="calc-label-2-file" onchange="updateCascoCalcFileInputText(2)">
                            <div id="casco-calc-uploaded-file-2" class="uploaded-file">
                                <div class="file-name" id="calc-label-2-text"></div>
                                <div class="remove" onclick="removeCascoCalcFileInput(2)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.46434 2.46144C2.71919 2.20659 3.13238 2.20659 3.38722 2.46144L13.5389 12.6131C13.7938 12.868 13.7938 13.2812 13.5389 13.536C13.2841 13.7909 12.8709 13.7909 12.616 13.536L2.46434 3.38432C2.20949 3.12948 2.20949 2.71629 2.46434 2.46144Z" fill="#242323"/>
                                        <path d="M2.46535 13.5396C2.2105 13.2847 2.2105 12.8715 2.46535 12.6167L12.617 2.46499C12.8719 2.21014 13.2851 2.21014 13.5399 2.46499C13.7948 2.71984 13.7948 3.13302 13.5399 3.38787L3.38823 13.5396C3.13338 13.7944 2.72019 13.7944 2.46535 13.5396Z" fill="#242323"/>
                                    </svg>
                                </div>
                            </div>
                            <button class="primary-outline" type="button" id="calc-label-2-btn" onclick="triggerCascoCalcFileInput(2)">{{ __('casco.upload') }}</button>
                            <p style="display: none" class="error" id="calc-label-2-error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label>{{ __('casco.texPassportFront') }}</label>
                        <div class="field casco-calc-upload-field">
                            <input type="file" name="texPassportFront" class="required-file" id="calc-label-3-file" onchange="updateCascoCalcFileInputText(3)">
                            <div id="casco-calc-uploaded-file-3" class="uploaded-file">
                                <div class="file-name" id="calc-label-3-text"></div>
                                <div class="remove" onclick="removeCascoCalcFileInput(3)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.46434 2.46144C2.71919 2.20659 3.13238 2.20659 3.38722 2.46144L13.5389 12.6131C13.7938 12.868 13.7938 13.2812 13.5389 13.536C13.2841 13.7909 12.8709 13.7909 12.616 13.536L2.46434 3.38432C2.20949 3.12948 2.20949 2.71629 2.46434 2.46144Z" fill="#242323"/>
                                        <path d="M2.46535 13.5396C2.2105 13.2847 2.2105 12.8715 2.46535 12.6167L12.617 2.46499C12.8719 2.21014 13.2851 2.21014 13.5399 2.46499C13.7948 2.71984 13.7948 3.13302 13.5399 3.38787L3.38823 13.5396C3.13338 13.7944 2.72019 13.7944 2.46535 13.5396Z" fill="#242323"/>
                                    </svg>
                                </div>
                            </div>
                            <button class="primary-outline" type="button" id="calc-label-3-btn" onclick="triggerCascoCalcFileInput(3)">{{ __('casco.upload') }}</button>
                            <p style="display: none" class="error" id="calc-label-3-error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label>{{ __('casco.texPassportBack') }}</label>
                        <div class="field casco-calc-upload-field">
                            <input type="file" name="texPassportBack" class="required-file" id="calc-label-4-file" onchange="updateCascoCalcFileInputText(4)">
                            <div id="casco-calc-uploaded-file-4" class="uploaded-file">
                                <div class="file-name" id="calc-label-4-text"></div>
                                <div class="remove" onclick="removeCascoCalcFileInput(4)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.46434 2.46144C2.71919 2.20659 3.13238 2.20659 3.38722 2.46144L13.5389 12.6131C13.7938 12.868 13.7938 13.2812 13.5389 13.536C13.2841 13.7909 12.8709 13.7909 12.616 13.536L2.46434 3.38432C2.20949 3.12948 2.20949 2.71629 2.46434 2.46144Z" fill="#242323"/>
                                        <path d="M2.46535 13.5396C2.2105 13.2847 2.2105 12.8715 2.46535 12.6167L12.617 2.46499C12.8719 2.21014 13.2851 2.21014 13.5399 2.46499C13.7948 2.71984 13.7948 3.13302 13.5399 3.38787L3.38823 13.5396C3.13338 13.7944 2.72019 13.7944 2.46535 13.5396Z" fill="#242323"/>
                                    </svg>
                                </div>
                            </div>
                            <button class="primary-outline" type="button" id="calc-label-4-btn" onclick="triggerCascoCalcFileInput(4)">{{ __('casco.upload') }}</button>
                            <p style="display: none" class="error" id="calc-label-4-error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label>{{ __('casco.driveLicenseFront') }}</label>
                        <div class="field casco-calc-upload-field">
                            <input type="file" name="driveLicenseFront" class="required-file" id="calc-label-5-file" onchange="updateCascoCalcFileInputText(5)">
                            <div id="casco-calc-uploaded-file-5" class="uploaded-file">
                                <div class="file-name" id="calc-label-5-text"></div>
                                <div class="remove" onclick="removeCascoCalcFileInput(5)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.46434 2.46144C2.71919 2.20659 3.13238 2.20659 3.38722 2.46144L13.5389 12.6131C13.7938 12.868 13.7938 13.2812 13.5389 13.536C13.2841 13.7909 12.8709 13.7909 12.616 13.536L2.46434 3.38432C2.20949 3.12948 2.20949 2.71629 2.46434 2.46144Z" fill="#242323"/>
                                        <path d="M2.46535 13.5396C2.2105 13.2847 2.2105 12.8715 2.46535 12.6167L12.617 2.46499C12.8719 2.21014 13.2851 2.21014 13.5399 2.46499C13.7948 2.71984 13.7948 3.13302 13.5399 3.38787L3.38823 13.5396C3.13338 13.7944 2.72019 13.7944 2.46535 13.5396Z" fill="#242323"/>
                                    </svg>
                                </div>
                            </div>
                            <button class="primary-outline" type="button" id="calc-label-5-btn" onclick="triggerCascoCalcFileInput(5)">{{ __('casco.upload') }}</button>
                            <p style="display: none" class="error" id="calc-label-5-error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label>{{ __('casco.driveLicenseBack') }}</label>
                        <div class="field casco-calc-upload-field">
                            <input type="file" name="driveLicenseBack" class="required-file" id="calc-label-6-file" onchange="updateCascoCalcFileInputText(6)">
                            <div id="casco-calc-uploaded-file-6" class="uploaded-file">
                                <div class="file-name" id="calc-label-6-text"></div>
                                <div class="remove" onclick="removeCascoCalcFileInput(6)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.46434 2.46144C2.71919 2.20659 3.13238 2.20659 3.38722 2.46144L13.5389 12.6131C13.7938 12.868 13.7938 13.2812 13.5389 13.536C13.2841 13.7909 12.8709 13.7909 12.616 13.536L2.46434 3.38432C2.20949 3.12948 2.20949 2.71629 2.46434 2.46144Z" fill="#242323"/>
                                        <path d="M2.46535 13.5396C2.2105 13.2847 2.2105 12.8715 2.46535 12.6167L12.617 2.46499C12.8719 2.21014 13.2851 2.21014 13.5399 2.46499C13.7948 2.71984 13.7948 3.13302 13.5399 3.38787L3.38823 13.5396C3.13338 13.7944 2.72019 13.7944 2.46535 13.5396Z" fill="#242323"/>
                                    </svg>
                                </div>
                            </div>
                            <button class="primary-outline" type="button" id="calc-label-6-btn" onclick="triggerCascoCalcFileInput(6)">{{ __('casco.upload') }}</button>
                            <p style="display: none" class="error" id="calc-label-6-error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label>{{ __('casco.etibarnameFront') }}</label>
                        <div class="field casco-calc-upload-field">
                            <input type="file" name="etibarnameFront" class="required-file" id="calc-label-7-file" onchange="updateCascoCalcFileInputText(7)">
                            <div id="casco-calc-uploaded-file-7" class="uploaded-file">
                                <div class="file-name" id="calc-label-7-text"></div>
                                <div class="remove" onclick="removeCascoCalcFileInput(7)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.46434 2.46144C2.71919 2.20659 3.13238 2.20659 3.38722 2.46144L13.5389 12.6131C13.7938 12.868 13.7938 13.2812 13.5389 13.536C13.2841 13.7909 12.8709 13.7909 12.616 13.536L2.46434 3.38432C2.20949 3.12948 2.20949 2.71629 2.46434 2.46144Z" fill="#242323"/>
                                        <path d="M2.46535 13.5396C2.2105 13.2847 2.2105 12.8715 2.46535 12.6167L12.617 2.46499C12.8719 2.21014 13.2851 2.21014 13.5399 2.46499C13.7948 2.71984 13.7948 3.13302 13.5399 3.38787L3.38823 13.5396C3.13338 13.7944 2.72019 13.7944 2.46535 13.5396Z" fill="#242323"/>
                                    </svg>
                                </div>
                            </div>
                            <button class="primary-outline" type="button" id="calc-label-7-btn" onclick="triggerCascoCalcFileInput(7)">{{ __('casco.upload') }}</button>
                            <p style="display: none" class="error" id="calc-label-7-error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>

                    <div class="form-group horizontal">
                        <label>{{ __('casco.etibarnameBack') }}</label>
                        <div class="field casco-calc-upload-field">
                            <input type="file" name="etibarnameBack" class="required-file" id="calc-label-8-file" onchange="updateCascoCalcFileInputText(8)">
                            <div id="casco-calc-uploaded-file-8" class="uploaded-file">
                                <div class="file-name" id="calc-label-8-text"></div>
                                <div class="remove" onclick="removeCascoCalcFileInput(8)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.46434 2.46144C2.71919 2.20659 3.13238 2.20659 3.38722 2.46144L13.5389 12.6131C13.7938 12.868 13.7938 13.2812 13.5389 13.536C13.2841 13.7909 12.8709 13.7909 12.616 13.536L2.46434 3.38432C2.20949 3.12948 2.20949 2.71629 2.46434 2.46144Z" fill="#242323"/>
                                        <path d="M2.46535 13.5396C2.2105 13.2847 2.2105 12.8715 2.46535 12.6167L12.617 2.46499C12.8719 2.21014 13.2851 2.21014 13.5399 2.46499C13.7948 2.71984 13.7948 3.13302 13.5399 3.38787L3.38823 13.5396C3.13338 13.7944 2.72019 13.7944 2.46535 13.5396Z" fill="#242323"/>
                                    </svg>
                                </div>
                            </div>
                            <button class="primary-outline" type="button" id="calc-label-8-btn" onclick="triggerCascoCalcFileInput(8)">{{ __('casco.upload') }}</button>
                            <p style="display: none" class="error" id="calc-label-8-error">{{ __('site.please_fill') }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-actions calculating-form-actions">
                    <button class="submit" id="casco-calc" type="button">{{ __('casco.calculate') }}<span id="loader-spinner" style="display: none" class="loader"></span></button>
                    <button id="casco-send" class="submit gray" disabled type="button">{{ __('casco.send') }}<span id="loader-spinner-send" style="display: none" class="loader"></span></button>
                </div>
                <div class="form-actions calculating-form-actions casco-note-wrapper">
                    <p class="casco-note">{{ __('site.casco_note') }}</p>
                </div>
            </form>
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
    <script>
        document.getElementById('ts-price').addEventListener('input', function (e) {
            var nonDigit = /[^0-9]/g;
            if(nonDigit.test(e.target.value)) {
                e.target.value = e.target.value.replace(nonDigit, '');
            }

            var amountError = document.getElementById('amount-error');
            if(e.target.value > 100000) {
                amountError.style.display = 'block';
            } else {
                amountError.style.display = 'none';
            }
        });

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
                let pinCodeField = document.getElementById('calc-pin');
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
                fetch('{{ route('casco-send') }}', {
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
                    document.querySelector('#casco-calc').removeAttribute('disabled');
                    loaderSpinner.style.display = 'none';
                    if(data.error !== null) {
                        document.querySelector('#price-error').style.display = 'block';
                        document.querySelector('#price-error').innerHTML = data.error;
                        document.querySelector('#casco-send').setAttribute('disabled', true);
                        document.getElementById('price-error').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                        return;
                    }
                    document.querySelector('#price-error').style.display = 'none';
                    document.querySelector('#price-holder').innerHTML = data.price + ' AZN';
                    document.querySelector('#casco-send').removeAttribute('disabled');
                    document.querySelector('#casco-send').classList.remove('gray');
                    document.getElementById('casco-price-wrapper').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                    document.getElementById('orderFields').style.display = 'block';

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

        function cascoCalcFileUploadElements(index) {
            return {
                textInputWrapper: document.getElementById(`casco-calc-uploaded-file-${index}`),
                fileInput: document.getElementById(`calc-label-${index}-file`),
                textInput: document.getElementById(`calc-label-${index}-text`),
                customUploadBtn: document.getElementById(`calc-label-${index}-btn`),
                errorLabel: document.getElementById(`calc-label-${index}-error`)
            }
        }

        function triggerCascoCalcFileInput(index) {
            document.getElementById(`calc-label-${index}-file`).click();
        }

        function updateCascoCalcFileInputText(index) {
            const { textInputWrapper, fileInput, textInput, customUploadBtn, errorLabel } = cascoCalcFileUploadElements(index)

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (!file.type.match('image.*')) {
                    errorLabel.innerHTML = '{{ __('casco.file_must_be_an_image') }}';
                    errorLabel.style.display = 'block';
                } else if (file.size > 3 * 1024 * 1024) {
                    errorLabel.innerHTML = '{{ __('casco.max_size_error') }}';
                    errorLabel.style.display = 'block';
                } else {
                    errorLabel.innerHTML = '';
                    customUploadBtn.style.display = 'none'
                    textInput.innerHTML = file.name;
                    textInputWrapper.style.display = 'flex'
                    errorLabel.style.display = 'none';
                }
            } else {
                textInput.value = '';
            }
        }

        function removeCascoCalcFileInput(index) {
            const { textInputWrapper, fileInput, textInput, customUploadBtn } = cascoCalcFileUploadElements(index)

            fileInput.value = ''
            customUploadBtn.style.display = 'initial'
            textInput.innerHTML = null;
            textInputWrapper.style.display = 'none'
        }
    </script>
@endpush
