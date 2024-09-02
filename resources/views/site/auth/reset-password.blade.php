<x-app-layout>
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h3 class="text-center">{{ __('site.reset_password_title') }}</h3>
                    <div class="theme-card">
                        <form method="POST" action="{{ route('password.update') }}" class="theme-form form-register-custom">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <input type="hidden" name="email" value="{{ $request->email }}">
                            <div class="form-group">
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
                            <div class="form-group">
                                <label for="password_confirmation">{{ __('site.password_confirmation') }}</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror" id="password"
                                       placeholder="{{ __('site.password_confirmation_placeholder') }}" required="">
                                @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button class="btn btn-solid">{{ __('site.reset_password') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
