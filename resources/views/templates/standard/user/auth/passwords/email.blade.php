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
                    <a class="account-section__close" href="{{ route('home') }}"> <i class="las la-times"></i></a>
                    <div class="account-thumb text-center" style="background-image: url('{{ getImage('assets/images/frontend/auth_page/' . $authPage->data_values->image, '1920x1280') }}');">
                        <h3 class="text-white">{{ __($pageTitle) }}</h3>
                        <p class="text-white">@lang('To recover your account please provide your email or username to find your account.')</p>
                    </div>
                    <div class="verify-gcaptcha account-content">
                        <form method="POST" action="{{ route('user.password.email') }}" class="verify-gcaptcha">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">@lang('Email or Username')</label>
                                <input class="form-control form--control" name="value" type="text" value="{{ old('value') }}" required autofocus="off">
                            </div>
                            <x-captcha />
                            <button class="btn btn--gradient w-100" type="submit">@lang('Submit')</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection


