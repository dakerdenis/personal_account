<x-app-layout>
    <section class="register-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{ __('site.register_account') }}</h3>
                    <div class="theme-card">
                        <form action="{{ route('register') }}" method="POST" class="theme-form form-register-custom">
                            @csrf
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <label for="first_name">{{ __('site.first_name') }}</label>
                                    <input type="text" value="{{ old('first_name') }}"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name" name="first_name"
                                           placeholder="{{ __('site.first_name_placeholder') }}"
                                           required="">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name">{{ __('site.last_name') }}</label>
                                    <input type="text" value="{{ old('last_name') }}"
                                           class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                           name="last_name" placeholder="{{ __('site.last_name_placeholder') }}"
                                           required="">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">{{ __('site.phone') }}</label>
                                    <input type="text" value="{{old('phone')}}"
                                           class="form-control @error('phone') is-invalid @enderror phone" id="phone"
                                           name="phone" placeholder="{{ __('site.phone_placeholder') }}"
                                           required="">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email">{{ __('site.email') }}</label>
                                    <input type="text" value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror" id="email"
                                           name="email" placeholder="{{ __('site.email_placeholder') }}" required="">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-6">
                                    <label for="password">{{ __('site.password') }}</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror" id="password"
                                           placeholder="{{ __('site.password_placeholder') }}" required="">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation">{{ __('site.password_confirmation') }}</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation"
                                           placeholder="{{ __('site.password_confirmation_confirmation') }}"
                                           required="">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-solid w-auto">{{ __('site.create_account') }}</button>
                                </div>
                                <div class="d-flex justify-content-center mt-4 register_login_link">
                                    <p>{{ __('site.already_have_account') }} <a href="{{ route('login') }}"> {{ __("site.login") }} </a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <script src="{{asset('assets/js/inputmask.min.js')}}"></script>
        <script>
            var selector = document.querySelectorAll(".phone");
            Inputmask({
                mask: "\\+\\9\\9\\4 (99) 999 99 99",
                escapeChar: "\\",
                clearMaskOnLostFocus: false
            }).mask(selector);
        </script>
    </x-slot>
</x-app-layout>
