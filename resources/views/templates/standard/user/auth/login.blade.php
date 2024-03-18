@extends($activeTemplate . 'layouts.app')
@section('app')
@php
$login = getContent('login.content', true);
$authPage = getContent('auth_page.content', true);
@endphp
<div class="main-wrapper account-section pt-100 pb-100"
    style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="account-wrapper">
                    <a class="account-section__close" href="{{ route('home') }}"> <i class="las la-times"></i></a>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="account-thumb bg_img h-100 d-flex flex-wrap align-items-center justify-content-center"
                                style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
                                <div class="text-center">
                                    <h2 class="text-white">@lang('Welcome to') {{ __(@$general->site_name) }}</h2>
                                    <p class="mt-2 text-white">{{ __(@$login->data_values->text) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form class="verify-gcaptcha account-content" method="POST"
                                action="{{ route('user.login') }}">
                                <div class="text-center mb-5">
                                    <h2 class="account-content__title">@lang('Get Started')</h2>
                                    <p>@lang("Haven't an account ") ? <a class="text--base" href="{{ route('user.register') }}">@lang('Create New')</a></p>
                                </div>
                                @csrf
                                <div class="form-group">
                                    <label class="mb-0" for="username">@lang('Username or Email')</label>
                                    <div class="custom-icon-field">
                                        <i class="las la-user"></i>
                                        <input class="form--control" id="username" name="username" type="text" value="{{ old('username') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="mb-0" for="password">@lang('Password')</label>
                                    <div class="custom-icon-field">
                                        <i class="las la-key"></i>
                                        <input class="form--control" id="password" name="password" type="password"  required>
                                    </div>
                                </div>
                                <x-captcha />
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check d-flex">
                                            <input class="form-check-input" id="remember" name="remember"
                                                type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label ms-1 mb-0" for="remember"> @lang('Remember Me')</label>
                                        </div>
                                        <a class="text--base" href="{{ route('user.password.request') }}"> @lang('Forgot Your Password')?</a>
                                    </div>
                                </div>
                                <button class="btn btn--gradient w-100" id="recaptcha" type="submit">@lang('Login Now')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


