@extends($activeTemplate . 'layouts.app')
@section('app')
    @php
        $login = getContent('login.content', true);
        $authPage = getContent('auth_page.content', true);
    @endphp
    <section class="account">
        <span class="account__shape"><img
                src="{{ getImage('assets/images/frontend/login/' . @$login->data_values->shape_one) }}" alt=""></span>
        <span class="account__shape two"><img
                src="{{ getImage('assets/images/frontend/login/' . @$login->data_values->shape_two) }}" alt=""></span>
        <div class="account__inner">
            <div class="account__left">
                <div class="top">
                    <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                            alt=""></a>
                    <p class="have-account d-sm-block d-none">@lang('Don’t have an account?') <a href="{{ route('user.register') }}"
                            class="have-account__link text--base">@lang('Sign Up!')</a></p>
                </div>
                <div class="account__content login">
                    <form class="verify-gcaptcha account__form" action="{{ route('user.login') }}" method="POST">
                        @csrf
                        <div class="account__form-heading text-center">
                            <h2 class="title">{{ @$login->data_values->heading }}</h2>
                            <span class="tagline">{{ @$login->data_values->subheading }}</span>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" class="form--control" name="username" id="username"
                                        placeholder="Username or Email" value="{{ old('username') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <input id="your-password" name="password" type="password"
                                            class="form-control form--control" value="Password" required>
                                        <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash"
                                            id="#your-password"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <x-captcha />
                            </div>

                            <div class="col-12">
                                <div class="form-group d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="form--switch">
                                        <input class="form-check-input" id="remember" name="remember" type="checkbox"
                                            {{ old('remember') ? 'checked' : '' }} role="switch"
                                            id="flexSwitchCheckDefault">
                                    </div>
                                    <a href="{{ route('user.password.request') }}"
                                        class="forgot-password text--danger">@lang('Recover Account')</a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn--base w-100"
                                        id="recaptcha">{{ @$login->data_values->button_text }}</button>
                                    <p class="have-account d-sm-none d-block">@lang('Don’t have an account?') <a
                                            href="{{ route('user.register') }}"
                                            class="have-account__link text--base">@lang('Sign Up!')</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account__right">
                <div class="account__thumb">
                    <img src="{{ getImage('assets/images/frontend/login/' . $login->data_values->right_side_image) }}"
                        alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
