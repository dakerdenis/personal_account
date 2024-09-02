<x-app-layout>
    <section class="login-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::get('success'))
                        <div class="alert alert-success">
                            {{ \Illuminate\Support\Facades\Session::get('success') }}
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <h3>{{ __('site.login_page_title') }}</h3>
                    <div class="theme-card">
                        <form method="post" action="{{route('login')}}" class="theme-form form-register-custom">
                            @csrf
                            <div class="form-group">
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
                            <button class="btn btn-solid">{{ __('site.login') }}</button>
                            <p class="mt-3">{{ __('site.forgot_your_password') }} <a href="{{ route('password.request') }}"> {{ __("site.reset_password") }} </a></p>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 right-login">
                    <h3>{{ __('site.new_customer') }}</h3>
                    <div class="theme-card authentication-right">
                        <h6 class="title-font">{{ __('site.create_account') }}</h6>
                        <p>{!! __('site.create_account_text') !!}</p><a href="{{ route('register') }}"
                                                                        class="btn btn-solid">{{ __('site.create_account') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
