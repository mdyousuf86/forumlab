@extends($activeTemplate . 'layouts.app')
@section('app')
@php
$authPage = getContent('auth_page.content', true);
@endphp
<div class="main-wrapper account-section pt-100 pb-100"
    style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="account-wrapper">
                    <div class="account-thumb bg_img h-100 d-flex flex-wrap align-items-center justify-content-center" style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
                        <h3 class="text-white">{{ __($pageTitle) }}</h3>
                        <p class="text-white">@lang('Your account is verified successfully. Now you can change your  password. Please enter a strong password and don\'t share it with anyone.')</p>
                    </div>
                    <div class="account-content">
                        <form method="POST" action="{{ route('user.password.update') }}">
                            @csrf
                            <input name="email" type="hidden" value="{{ $email }}">
                            <input name="token" type="hidden" value="{{ $token }}">
                            <div class="form-group">
                                <label class="form-label">@lang('Password')</label>
                                <input class="form--control" name="password" type="password" required>
                                @if ($general->secure_password)
                                <div class="input-popup">
                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                    <p class="error number">@lang('1 number minimum')</p>
                                    <p class="error special">@lang('1 special character minimum')</p>
                                    <p class="error minimum">@lang('6 character password')</p>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Confirm Password')</label>
                                <input class="form--control" name="password_confirmation" type="password" required>
                            </div>
                            <button class="btn btn--gradient w-100" type="submit"> @lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection


    @if ($general->secure_password)
    @push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
    @endif
