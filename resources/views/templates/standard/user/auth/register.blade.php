@extends($activeTemplate . 'layouts.app')
@section('app')
    @php
        $policyPages = getContent('policy_pages.element', orderById: true);
        $register = getContent('register.content', true);
        $authPage = getContent('auth_page.content', true);
    @endphp

    <section class="account">
        <span class="account__shape"><img
                src="{{ getImage('assets/images/frontend/register/' . @$register->data_values->shape_one) }}"
                alt=""></span>
        <span class="account__shape two"><img
                src="{{ getImage('assets/images/frontend/register/' . @$register->data_values->shape_two) }}"
                alt=""></span>
        <div class="account__inner">
            <div class="account__left">
                <div class="top">
                    <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                            alt=""></a>
                    <p class="have-account d-sm-block d-none">@lang('Already have an account?') <a href="{{ route('user.login') }}"
                            class="have-account__link text--base">@lang('Sign In!')</a></p>
                </div>
                <div class="account__content">
                    <form action="{{ route('user.register') }}" method="POST" class="account__form verify-gcaptcha">
                        @csrf
                        <div class="account__form-heading text-center">
                            <h2 class="title">{{ __(@$register->data_values->heading) }}</h2>
                            <span class="tagline">{{ __(@$register->data_values->subheading) }}</span>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form--control checkUser" id="username" name="username"
                                        placeholder="Username" value="{{ old('username') }}" required>
                                        <small class="text--danger usernameExist"></small>
                                </div>
                            
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form--control checkUser"  name="email"
                                         placeholder="Email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select class="form--control select" id="country" name="country" required>
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $key }}">
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code "></span>
                                        <input class="form-control form--control checkUser" type="number" name="mobile"
                                            value="{{ old('mobile') }}" placeholder="Mobile">
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <input id="your-password" placeholder="@lang('Password')" type="password"
                                            class="form-control form--control " name="password">
                                        <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash"
                                            id="#password"></span>
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
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <input id="your-password2" placeholder="@lang('Confirm Password')"
                                            name="password_confirmation" type="password" class="form-control form--control">
                                        <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash"
                                            id="#password_confirmation"></span>
                                    </div>
                                </div>
                            </div>

                            <x-captcha />

                            @if ($general->agree)
                                <div class="col-12">
                                    <div class="form-group">
                                        <input class="me-1" id="agree" name="agree" type="checkbox"
                                            @checked(old('agree')) required>
                                        <label for="agree" class="form-check-label">@lang('I agree with ')</label>
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
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn--base w-100">@lang('Create Account')</button>
                                    <p class="have-account d-sm-none d-block">@lang('Already have an account?') <a
                                            href="{{ route('user.login') }}"
                                            class="have-account__link text--base">@lang('Sign In!')</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                <button class="btn btn-dark btn--sm" data-bs-dismiss="modal"
                                    type="button">@lang('Close')</button>
                                <a class="btn btn--base btn--sm" href="{{ route('user.login') }}">@lang('Login')</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="account__right">
                <div class="account__thumb">
                    <img src="{{ getImage('assets/images/frontend/register/' . @$register->data_values->right_side_image) }}"
                        alt="">
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
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('.mobile-code').text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            }).change();


            $('.checkUser').on('focusout', function(e) {
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
                $.post(url, data, function(response) {
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
