<x-app-layout>
    <section class="pwd-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto">
                    @if(!\Illuminate\Support\Facades\Session::get('success'))
                        <h2>{{ __('site.forgot_your_password') }}</h2>
                        <p>{{ __('site.forgot_your_password_text') }}</p>
                        <form method="POST" action="{{ route('password.email') }}" class="theme-form">
                            @csrf
                            <div class="form-row row">
                                <div class="col-md-12">
                                    <input type="email" name="email" value="{{ old('email') }}" autofocus class="form-control @error('email') is-invalid @enderror" id="email" placeholder="{{ __('site.enter_your_email') }}"
                                           required="">
                                    @error('email')
                                    <div class="invalid-feedback mb-3">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button class="btn btn-solid w-auto">{{ __('site.submit') }}</button>
                                <p class="mt-3">{{ __('site.reset_to_login_text') }} <a href="{{ route('login') }}"> {{ __("site.reset_to_login_link") }} </a></p>
                                <p class="">{{ __('site.reset_to_register_text') }} <a href="{{ route('register') }}"> {{ __("site.reset_to_register_link") }} </a></p>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-success">
                            {{ \Illuminate\Support\Facades\Session::get('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
