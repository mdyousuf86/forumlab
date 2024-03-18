@extends($activeTemplate . 'layouts.app')
@section('app')
@php
$policyPages = getContent('policy_pages.element', orderById: true);
$register = getContent('register.content', true);
$authPage = getContent('auth_page.content', true);
@endphp

<section class="pt-100 pb-100 account-section main-wrapper"
    style="background-image: url({{ getImage('assets/images/frontend/auth_page/' . @$authPage->data_values->image, '1920x1280') }})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="account-wrapper">
                    <a class="account-section__close" href="{{ route('home') }}"> <i class="las la-times"></i></a>
                    <div class="account-thumb text-center text-white" style="background-image: url('{{ getImage('assets/images/frontend/auth_page/' . $authPage->data_values->image, '1920x1280') }}');">
                        <h2 class="text-white">@lang('Welcome to') {{ __(@$general->site_name) }}</h2>
                        <p>{{ __(@$register->data_values->short_description) }}</p>
                        <p>@lang('Already have an account')? <a class="text--base" href="{{ route('user.login') }}">@lang('Login')</a></p>
                    </div>
                    <form class="verify-gcaptcha account-content" action="{{ route('user.register') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">@lang('Username')</label>
                                <div class="custom-icon-field">
                                    <i class="las la-user"></i>
                                    <input class="form--control checkUser" id="username" name="username" type="text"
                                        value="{{ old('username') }}" required>
                                </div>
                                <small class="text--danger usernameExist"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">@lang('Email')</label>
                                <div class="custom-icon-field">
                                    <i class="las la-envelope"></i>
                                    <input class="form--control checkUser" id="email" name="email" type="email"
                                        value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="country">@lang('Country')</label>
                                <select class="form--control select" id="country" name="country" required>
                                    @foreach ($countries as $key => $country)
                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">
                                        {{ __($country->country) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile">@lang('Mobile')</label>
                                <div class="input-group">
                                    <span class="input-group-text mobile-code bg-transparent"></span>
                                    <input class="form--control checkUser" id="mobile" name="mobile" type="number"
                                        value="{{ old('mobile') }}" required>
                                </div>
                                <small class="text--danger mobileExist"></small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">@lang('Password')</label>
                                <div class="custom-icon-field">
                                    <i class="las la-key"></i>
                                    <input class="form--control" id="password" name="password" type="password" required>
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
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password-confirm">@lang('Confirm Password')</label>
                                <div class="custom-icon-field">
                                    <i class="las la-key"></i>
                                    <input class="form--control" id="password-confirm" name="password_confirmation"
                                        type="password" required autocomplete="new-password">
                                </div>
                            </div>
                            <x-captcha />
                            @if ($general->agree)
                            <div class="form-group col-md-12">
                                <input id="agree" name="agree" type="checkbox" @checked(old('agree')) required>
                                <label for="agree">@lang('I agree with ')</label>
                                <span>
                                    @foreach ($policyPages as $policy)
                                    <a class="text--base"
                                        href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                        target="_blank">
                                        {{ __($policy->data_values->title) }}
                                        @if (!$loop->last)
                                        ,
                                        @endif
                                    </a>
                                    @endforeach
                                </span>
                            </div>
                            @endif
                            <div class="form-group">
                                <button class="btn btn--gradient w-100" id="recaptcha" type="submit"> @lang('Register')</button>
                            </div>
                        </div>
                        <p class="mb-0">@lang('Already have an account?') <a class="text--base"  href="{{ route('user.login') }}">@lang('Login')</a></p>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="existModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                            <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                                <i class="las la-times"></i>
                            </span>
                        </div>
                        <div class="modal-body">
                            <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-dark btn--sm" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                            <a class="btn btn--base btn--sm" href="{{ route('user.login') }}">@lang('Login')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection



@if ($general->secure_password)
@push('script-lib')
<script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@endif

@push('script')
<script>
    "use strict";
    (function ($) {
        @if($mobileCode)
        $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
        @endif

        $('select[name=country]').change(function () {
            $('.mobile-code').text(`+${$('select[name=country] :selected').data('mobile_code')}`);
        }).change();


        $('.checkUser').on('focusout', function (e) {
            var url = '{{ route('user.checkUser') }}';
            var value = $(this).val();
            var token = '{{ csrf_token() }}';
            if ($(this).attr('name') == 'mobile') {
                var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                var data = {
                    mobile: mobile,
                    _token: token
                }
            }
            if ($(this).attr('name') == 'email') {
                var data = {
                    email: value,
                    _token: token
                }
            }
            if ($(this).attr('name') == 'username') {
                var data = {
                    username: value,
                    _token: token
                }
            }
            $.post(url, data, function (response) {
                if (response.data != false && response.type == 'email') {
                    $('#existModalCenter').modal('show');
                } else if (response.data != false) {
                    $(`.${response.type}Exist`).text(`${response.type} already exist`);
                } else {
                    $(`.${response.type}Exist`).text('');
                }
            });
        });
    })(jQuery);
</script>
@endpush
